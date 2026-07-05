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
            <form action="<?= url_to('species.update', $specie['id']) ?>" method="post" class="row g2 mx-auto">
                <div class="col-md-6">
                    <?= csrf_field() ?>

                    <label for="name" class="form-label">Nome</label>
                    <input name="name" type="text" id="name" placeholder="Digite o nome da espécie"
                        value="<?= esc(old('name', $specie['name'])) ?>"
                        class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['name'] ?? '' ?>
                    </span>
                </div>

                <div class="d-flew flex-col gap-2 mt-3">
                    <a href="<?= url_to('species') ?>" class="btn btn-sm btn-secondary px-4">Voltar</a>
                    <button class="btn btn-sm btn-primary px-4" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>