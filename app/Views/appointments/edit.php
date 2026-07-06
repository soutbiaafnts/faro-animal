<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>

<!-- // [] colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php /**
 *  @var string $title 
 *  @var array $appointment
 * */
?>

<div class="container py-5">

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <form action="<?= url_to('appointments.update', $appointment['id']) ?>" method="post" class="row mx-auto gap-2 justify-content-center">
                <?= csrf_field() ?>

                <div class="col-md-3">
                    <label for="pet_id" class="form-label">Pet</label>
                    <select name="pet_id" id="pet_id" class="form-select <?= isset($invalidArgs['pet_id']) ? 'is-invalid' : '' ?>" disabled>
                        <option selected value=""><?= esc(old('pet_id', $appointment['pet_name'])) ?></option>
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['pet_id'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-3">
                    <label for="appointment_date" class="form-label">Data da consulta</label>
                    <input name="appointment_date" type="datetime-local" id="appointment_date" value="<?= esc(old('appointment_date', $appointment['appointment_date'])) ?>"
                        class="form-control <?= isset($invalidArgs['appointment_date']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['appointment_date'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select <?= isset($invalidArgs['status']) ? 'is-invalid' : '' ?>">
                        <option value="scheduled" <?= esc(old('status', $appointment['status']) === 'scheduled' ? 'selected' : '') ?>>
                            Agendada
                        </option>

                        <option value="completed" <?= esc(old('status', $appointment['status']) === 'completed' ? 'selected' : '') ?>>
                            Realizada
                        </option>

                        <option value="cancelled" <?= esc(old('status', $appointment['status']) === 'cancelled' ? 'selected' : '') ?>>
                            Cancelada
                        </option>
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['status'] ?? '' ?>
                    </span>
                </div>

                <div class="w-75">
                    <label for="reason" class="form-label">Razão</label>
                    <textarea name="reason" type="text" maxlength="255" placeholder="Descreva a razão da consulta..." id="reason" style="height: 200px" value=""
                        class="form-control <?= isset($invalidArgs['reason']) ? 'is-invalid' : '' ?>" /><?= esc(old('reason', $appointment['reason'])) ?></textarea>
                    <div class="form-text"><span class="char-count">0</span> / 255 caracteres</div>
                    <span class="invalid-feedback ">
                        <?= $invalidArgs['reason'] ?? '' ?>
                    </span>
                </div>

                <div class="w-75">
                    <label for="diagnosis" class="form-label">Diagnóstico</label>
                    <textarea name="diagnosis" type="text" maxlength="1000" placeholder="Faça as anotações..." id="diagnosis" style="height: 200px" value=""
                        class="form-control <?= isset($invalidArgs['diagnosis']) ? 'is-invalid' : '' ?>" /><?= esc(old('diagnosis', $appointment['diagnosis'])) ?></textarea>
                    <div class="form-text"><span class="char-count">0</span> / 1000 caracteres</div>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['diagnosis'] ?? '' ?>
                    </span>
                </div>

                <div class="w-75">
                    <label for="prescription" class="form-label">Prescrição</label>
                    <textarea name="prescription" type="text" maxlength="1000" placeholder="Faça as anotações..." id="prescription" style="height: 200px" value=""
                        class="form-control <?= isset($invalidArgs['prescription']) ? 'is-invalid' : '' ?>" /><?= esc(old('prescription', $appointment['prescription'])) ?></textarea>
                    <div class="form-text"><span class="char-count">0</span> / 1000 caracteres</div>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['prescription'] ?? '' ?>
                    </span>
                </div>

                <div class="w-75">
                    <label for="notes" class="form-label">Anotações</label>
                    <textarea name="notes" type="text" maxlength="1000" placeholder="Faça as anotações..." id="notes" style="height: 200px" value=""
                        class="form-control <?= isset($invalidArgs['notes']) ? 'is-invalid' : '' ?>" /><?= esc(old('notes', $appointment['notes'])) ?></textarea>
                    <div class="form-text"><span class="char-count">0</span> / 1000 caracteres</div>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['notes'] ?? '' ?>
                    </span>
                </div>

                <div class="d-flew flex-col gap-2 mt-3 text-center">
                    <a href="<?= url_to('appointments') ?>" class="btn btn-sm btn-secondary px-4">Voltar</a>
                    <button class="btn btn-sm btn-primary px-4" type="submit">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // note: contador de caracteres
    document.querySelectorAll('textarea[maxlength]').forEach(textarea => {
        const count = textarea.parentElement.querySelector('.char-count');

        function updateCount() {
            count.textContent = textarea.value.length;
        }

        textarea.addEventListener('input', updateCount);

        // note: atualiza ao carregar a página (caso haja old())
        updateCount();
    });
</script>

<?= $this->endSection('content'); ?>