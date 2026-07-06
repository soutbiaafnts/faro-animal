<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>
<?php /** @var string $token */ ?>
<!-- todo: colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container py-5" style="max-width: 700px">

    <?php if ($message && !$success): ?>
        <div class="alert alert-danger text-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <h4 class="alert-heading">Erro!</h4>
            <hr>
            <p class="mb-0">
                <?= $message ?>
            </p>
        </div>
    <?php elseif ($message && $success): ?>
        <div class="alert alert-success text-center" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <h4 class="alert-heading">Sucesso!</h4>
            <hr>
            <p class="mb-0">
                <?= $message ?>
            </p>
        </div>
    <?php endif; ?>

    <h1 class="display-4 fw-bold text-primary text-center">Crie uma nova senha</h1>
    <p class="lead text-secondary text-center mb-4">Defina uma nova senha para a sua conta.</p>


    <form action="<?= url_to('forgot.update', $token) ?>" method="post" class="row g-2 mx-auto"
        style="max-width: 700px">
        <?= csrf_field() ?>

        <div class="col-md-8 w-100">
            <label for="password" class="form-label">Nova senha</label>
            <input name="password" type="password" id="password" placeholder="Crie uma senha"
                class="form-control <?= isset($invalidArgs['password']) ? 'is-invalid' : '' ?>">
            <span class="invalid-feedback">
                <?= $invalidArgs['password'] ?? '' ?>
            </span>
        </div>
        <div class="col-md-8 w-100">
            <label for="confirmPass" class="form-label">Nova senha</label>
            <input name="confirmPass" type="password" id="confirmPass" placeholder="Crie uma senha"
                class="form-control <?= isset($invalidArgs['confirmPass']) ? 'is-invalid' : '' ?>">
            <span class="invalid-feedback">
                <?= $invalidArgs['confirmPass'] ?? '' ?>
            </span>
        </div>

        <div class="col-12 text-center mt-3">
            <button class="btn btn-primary w-100" type="submit">Salvar</button>
        </div>
    </form>
</div>

<?= $this->endSection('content'); ?>