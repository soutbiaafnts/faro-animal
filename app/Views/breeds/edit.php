<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>

<!-- todo: colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container py-4">

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <form action="<?= url_to('breeds.update', $breed['id']) ?>" method="post" class="row g-2 mx-auto">
                <?= csrf_field() ?>

                <input type="hidden" name="species_id" value="<?= esc($breed['species_id']) ?>">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <input name="name" value="<?= esc(old('name', $breed['name'])) ?>" type="text" id="name" placeholder="Digite o nome da raça" class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['name'] ?? '' ?>
                    </span>
                </div>

                <div class="col-md-6">
                    <label for="specie_id" class="form-label">Espécie</label>
                    <select name="specie" id="specie_id" class="form-select" disabled>
                        <option selected value=""><?= esc($breed['specie_name']) ?></option>
                    </select>
                </div>

                <div class="d-flew flex-col gap-2 mt-3">
                    <a href="<?= url_to('breeds') ?>" class="btn btn-sm btn-secondary px-4">Voltar</a>
                    <button class="btn btn-sm btn-primary px-4" type="submit">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>