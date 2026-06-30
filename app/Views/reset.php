<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>

<!-- todo: colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container py-5">

    <h2 class="text-center mb-4">Crie uma nova senha</h2>

    <form action="<?= url_to('forgot.update', $token) ?>" method="post" class="row g-2 mx-auto" style="max-width: 700px">
        <div class="col-md-6">
            <label for="password" class="form-label">Nova senha</label>
            <input name="password" type="password" id="password" placeholder="Crie uma senha"
                class="form-control <?= isset($invalidArgs['password']) ? 'is-invalid' : '' ?>">
            <span class="invalid-feedback">
                <?= $invalidArgs['password'] ?? '' ?>
            </span>
        </div>

        <div class="col-12 text-center mt-3">
            <button class="btn btn-primary w-100" type="submit">Salvar</button>
        </div>
    </form>
</div>

<?= $this->endSection('content'); ?>