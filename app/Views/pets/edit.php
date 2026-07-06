<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php /**
 *  @var string $title 
 *  @var array $pet
 * */
?>

<div class="container py-5">

    <?php if ($message && !$success): ?>
        <div class="alert alert-danger text-center mx-auto" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <h4 class="alert-heading">Erro!</h4>
            <hr>
            <p class="mb-0">
                <?= $message ?>
            </p>
        </div>
    <?php elseif ($message && $success): ?>
        <div class="alert alert-success text-center mx-auto" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <h4 class="alert-heading">Sucesso!</h4>
            <hr>
            <p class="mb-0">
                <?= $message ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <form action="<?= url_to('pets.update', $pet['id']) ?>" method="post" class="row mx-auto gap-2 justify-content-center">
                <?= csrf_field() ?>

                <div class="col-md-4">
                    <label for="specie_id" class="form-label">Espécie</label>
                    <select name="species_id" id="specie_id" class="form-select <?= isset($invalidArgs['species_id']) ? 'is-invalid' : '' ?>" disabled>
                        <option selected value=""><?= esc(old('species_id', $pet['specie_name'])) ?></option>
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['species_id'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="breed_id" class="form-label">Raça</label>
                    <select name="breed_id" id="breed_id" class="form-select <?= isset($invalidArgs['breed_id']) ? 'is-invalid' : '' ?>" disabled>
                        <option selected value=""><?= esc(old('breed_name', $pet['breed_name'])) ?></option>
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['breed_id'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="name" class="form-label">Nome</label>
                    <input name="name" type="text" id="name" placeholder="Digite o nome do pet"
                        value="<?= esc(old('name', $pet['name'])) ?>"
                        class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['name'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="birth_date" class="form-label">Data de nascimento</label>
                    <input name="birth_date" type="date" id="birth_date" value="<?= esc(old('birth_date', $pet['birth_date'])) ?>"
                        class="form-control <?= isset($invalidArgs['birth_date']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['birth_date'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="weight" class="form-label">Peso</label>
                    <input name="weight" type="number" step="0.01" min="0.00" placeholder="0.01 kg" id="weight" value="<?= esc(old('weight', $pet['weight'])) ?>"
                        class="form-control <?= isset($invalidArgs['weight']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['weight'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="sex" class="form-label">Sexo</label>
                    <select name="sex" id="sex" class="form-select <?= isset($invalidArgs['sex']) ? 'is-invalid' : '' ?>">
                        <option selected value="<?= esc(old('sex', $pet['sex'])) ?>"><?= esc(old('sex', $pet['sex'] == 'F' ? "Fêmea" : "Macho")) ?></option>
                        <option value="F">Fêmea</option>
                        <option value="M">Macho</option>
                    </select>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['sex'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="owner_name" class="form-label">Nome do tutor</label>
                    <input name="owner_name" type="text" id="owner_name" placeholder="Digite o nome do tutor"
                        value="<?= esc(old('owner_name', $pet['owner_name'])) ?>"
                        class="form-control <?= isset($invalidArgs['owner_name']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['owner_name'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-4">
                    <label for="owner_phone" class="form-label">Contato do tutor</label>
                    <input name="owner_phone" type="text" id="owner_phone" placeholder="(00) 00000-0000"
                        value="<?= esc(old('owner_phone', $pet['owner_phone'])) ?>"
                        class="form-control <?= isset($invalidArgs['owner_phone']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['owner_phone'] ?? '' ?>
                    </span>
                </div>

                <div class="w-50">
                    <label for="notes" class="form-label">Anotações</label>
                    <textarea name="notes" type="text" maxlength="1000" placeholder="Faça as anotações..." id="notes" style="height: 200px" value=""
                        class="form-control <?= isset($invalidArgs['notes']) ? 'is-invalid' : '' ?>" /><?= esc(old('notes', $pet['notes'])) ?></textarea>
                    <div class="form-text"><span id="count">0</span> / 1000 caracteres</div>
                    <span class="invalid-feedback">
                        <?= $invalidArgs['notes'] ?? '' ?>
                    </span>
                </div>

                <div class="d-flew flex-col gap-2 mt-3 text-center">
                    <a href="<?= url_to('pets') ?>" class="btn btn-sm btn-secondary px-4">Voltar</a>
                    <button class="btn btn-sm btn-primary px-4" type="submit">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // - máscara para número de telefone
    document.getElementById('owner_phone').addEventListener('input', function(event) {
        let inputValue = event.target.value.replace(/\D/g, '');
        inputValue = inputValue.substring(0, 11);

        if (inputValue.length > 10) {
            inputValue = inputValue.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (inputValue.length > 6) {
            inputValue = inputValue.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if (inputValue.length > 2) {
            inputValue = inputValue.replace(/(\d{2})(\d{0,5})/, '($1) $2');
        }

        event.target.value = inputValue;
    });

    // - contador de caracteres da anotação
    const textarea = document.getElementById('notes');
    const count = document.getElementById('count');
    const maxLength = textarea.getAttribute('maxLength');

    textarea.addEventListener('input', () => {
        const currentLength = textarea.value.length;

        count.textContent = currentLength;
    });
</script>

<?= $this->endSection('content'); ?>