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

    private function validateCreateData(array $data): array
    {
        $validation = service('validation');

        $validation->setRules([
            'pet_id' => 'required',
            'user_id' => 'required',
            'appointment_date' => 'required|valid_date',
            'reason' => 'max_length[255]',
            'diagnosis' => 'max_length[1000]',
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
                'message' => 'Verifique os campos',
                'invalidArgs' => $validation->getErrors(),
                'errors' => null,
            ];
        }

        $userFound = $this->userService->getUserById($data['user_id']);
        if (!$userFound) {
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
            ->where('pet_id', $petFound['id'])
            ->where('appointment_date', $data['appointment_date'])
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'message' => 'Já existe uma consulta neste horário para esse pet.',
                'invalidArgs' => [],
                'errors' => null,
            ];
        }

        return [
            'success' => true,
        ];
    }

    public function createAppointment(array $data)
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
                'message' => 'Erro ao criar pet: ',
                'invalidArgs' => [],
                'errors' => $e->getMessage(),
            ];
        }
    }
}
