<?php

namespace App\Services;

use App\Models\AppointmentModel;

class AppointmentService
{
    protected AppointmentModel $appointmentModel;
    private UserService $userService;
    private PetService $petService;


    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->userService = service('user');
        $this->petService = service('pet');
    }

    // NOTE: Validações

    /**
     * Summary validateCreateData
     *
     * @param array $data
     * @return array
     */
    private function validateCreateData(array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'pet_id' => 'required',
            'user_id' => 'required',
            'appointment_date' => 'required|valid_date',
            'reason' => 'max_length[255]',
            'diagnosis' => 'max_length[1000]',
            'prescription' => 'max_length[100]',
            'notes' => 'max_length[1000]',
            'status' => 'required|in_list[scheduled,completed,cancelled]',
        ], [
            'pet_id' => [
                'required' => 'Este campo é obrigatório.',
            ],
            'user_id' => [
                'user_id' => 'O id do usuário é obrigatório.',
            ],
            'appointment_date' => [
                'required' => 'Este campo é obrigatório.',
                'valid_date' => 'Informe uma data válida.'
            ],
            'reason' => [
                'max_length' => 'Este campo deve possuir no máximo 255 caracteres.',
            ],
            'diagnosis' => [
                'max_length' => 'Este campo deve possuir no máximo 1000 caracteres.',
            ],
            'prescription' => [
                'max_length' => 'Este campo deve possuir no máximo 1000 caracteres.',
            ],
            'notes' => [
                'max_length' => 'Este campo deve possuir no máximo 1000 caracteres.',
            ],
            'status' => [
                'required' => 'Este campo é obrigatório.',
                'in_list' => 'Status inválido, escolha um da lista',
            ],
        ]);

        if (!$validation->run($data)) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => $validation->getErrors(),
                'errors' => null,
            ];
        }

        $userFound = $this->userService->getUserById($data['user_id']);
        if (!$userFound['success']) {
            return [
                'success' => false,
                'message' => 'Usuário não encontrado.',
                'invalidArgs' => [],
                'errors' => null,
            ];
        }

        $petFound = $this->petService->getPetById($data['pet_id']);

        if (!$petFound['success']) {
            return [
                'success' => false,
                'message' => 'Pet não encontrado.',
                'invalidArgs' => [],
                'errors' => null,
            ];
        }

        $existing = $this->appointmentModel
            ->where('user_id', $data['user_id'])
            ->where('appointment_date', $data['appointment_date'])
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'appointment_date' => 'Você já tem uma consulta para esse horário.'
                ],
                'errors' => null,
            ];
        }

        return [
            'success' => true,
        ];
    }

    /**
     * Summary validateUpdateData
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    private function validateUpdateData(int $id, array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'appointment_date' => 'required|valid_date',
            'reason' => 'max_length[255]',
            'diagnosis' => 'max_length[1000]',
            'prescription' => 'max_length[100]',
            'notes' => 'max_length[1000]',
            'status' => 'required|in_list[scheduled,completed,cancelled]',
        ], [
            'appointment_date' => [
                'required' => 'Este campo é obrigatório.',
                'valid_date' => 'Informe uma data válida.'
            ],
            'reason' => [
                'max_length' => 'Este campo deve possuir no máximo 255 caracteres.',
            ],
            'diagnosis' => [
                'max_length' => 'Este campo deve possuir no máximo 1000 caracteres.',
            ],
            'prescription' => [
                'max_length' => 'Este campo deve possuir no máximo 1000 caracteres.',
            ],
            'notes' => [
                'max_length' => 'Este campo deve possuir no máximo 1000 caracteres.',
            ],
            'status' => [
                'required' => 'Este campo é obrigatório.',
                'in_list' => 'Status inválido, escolha um da lista',
            ],
        ]);

        if (!$validation->run($data)) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => $validation->getErrors(),
                'errors' => null,
            ];
        }

        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            return [
                'success' => false,
                'message' => 'Consulta não encontrada.',
                'invalidArgs' => [],
                'errors' => null,
            ];
        }

        $userId = $appointment['user_id'];
        $petId = $appointment['pet_id'];

        $userFound = $this->userService->getUserById($userId);

        if (!$userFound['success']) {
            return [
                'success' => false,
                'message' => 'Usuário não encontrado.',
                'invalidArgs' => [],
                'errors' => null,
            ];
        }

        $petFound = $this->petService->getPetById($petId);

        if (!$petFound['success']) {
            return [
                'success' => false,
                'message' => 'Pet não encontrado.',
                'invalidArgs' => [],
                'errors' => null,
            ];
        }

        $existing = $this->appointmentModel
            ->where('user_id', $userId)
            ->where('appointment_date', $data['appointment_date'])
            ->where('id !=', $id)
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => 'Verifique os campos.',
                'invalidArgs' => [
                    'appointment_date' => 'Você já tem uma consulta para esse horário.'
                ],
                'errors' => null,
            ];
        }

        return [
            'success' => true,
        ];
    }

    // NOTE: CRUD

    public function getAllAppointments()
    {
        try {
            $appointments = $this->appointmentModel
                ->select('appointments.*, pets.name  AS pet_name, users.name AS user_name')
                ->join('pets', 'pets.id = appointments.pet_id', 'left')
                ->join('users', 'users.id = appointments.user_id', 'left')
                ->findAll();

            return [
                'success' => true,
                'message' => 'Busca realizada com sucesso!',
                'data' => $appointments,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar pets:',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary getAppointmentById
     *
     * @param integer $id
     * @return array
     */
    public function getAppointmentById(int $id): array
    {
        try {
            $appointmentFound = $this->appointmentModel
                ->select('
                appointments.*,
                pets.name AS pet_name,
                users.name AS user_name,
                ')
                ->join('pets', 'pets.id = appointments.pet_id')
                ->join('users', 'users.id = appointments.user_id')
                ->where('appointments.id', $id)
                ->first();

            if (!$appointmentFound) {
                return [
                    'success' => false,
                    'message' => 'Consulta não encontrada.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            return [
                'success' => true,
                'data' => $appointmentFound,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao buscar consulta: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary createAppointment
     *
     * @param array $data
     * @return array
     */
    public function createAppointment(array $data): array
    {
        try {
            $validation = $this->validateCreateData($data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->appointmentModel->insert($data);

            return [
                'success' => true,
                'message' => 'Consulta criada com sucesso!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao criar consulta: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary updateAppointment
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function updateAppointment(int $id, array $data): array
    {
        try {
            $validation = $this->validateUpdateData($id, $data);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'invalidArgs' => $validation['invalidArgs'],
                    'errors' => $validation['errors'],
                ];
            }

            $this->appointmentModel->update($id, [
                'appointment_date' => $data['appointment_date'],
                'reason' => $data['reason'],
                'diagnosis' => $data['diagnosis'],
                'prescription' => $data['prescription'],
                'notes' => $data['notes'],
                'status' => $data['status'],
            ]);

            return [
                'success' => true,
                'message' => 'Consulta editada com sucesso!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao editar raça:',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }

    /**
     * Summary deleteAppointment
     *
     * @param integer $id
     * @return array
     */
    public function deleteAppointment(int $id): array
    {
        try {
            $appointment = $this->appointmentModel->find($id);

            if (!$appointment) {
                return [
                    'success' => false,
                    'message' => 'Consulta não encontrada.',
                    'invalidArgs' => [],
                    'errors' => null,
                ];
            }

            $this->appointmentModel->delete($id);

            return [
                'success' => true,
                'message' => 'Consulta excluída com sucesso!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao excluir consulta',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}
