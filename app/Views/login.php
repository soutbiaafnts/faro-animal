<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container py-5">

    <h2 class="text-center mb-4">Faça o login</h2>

    <form action="<?= url_to('auth') ?>" method="post" class="row g-2 mx-auto justify-content-center" style="max-width: 700px">
        <div class="col-md-8 w-100">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" name="email" id="email" placeholder="Digite seu e-mail" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" >
            <span class="invalid-feedback">
                <?= $errors['email'] ?? '' ?>
            </span>
        </div>
        <div class="col-md-8 w-100">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" >
            <span class="invalid-feedback">
                <?= $errors['password'] ?? '' ?>
            </span>
        </div>

        <div class="col-12 text-center mt-3">
            <button class="btn btn-primary w-100" type="submit">Entrar</button>

            <div class="mt-2">
                <a href="#" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Esqueceu a senha?</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection('content'); ?>