<?php $invalidArg = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main_public'); ?>

<?= $this->section('content'); ?>

<div class="container py-5">

    <h2 class="text-center mb-4">Cadastre-se</h2>

    <form action="" method="post" class="row g-2 mx-auto" style="max-width: 700px">
        <div class="col-md-6">
            <label for="name" class="form-label">Nome</label>
            <input name="" type="text" id="name" placeholder="Digite seu nome" class="form-control" >
            <span class="invalid-feedback">
                <?= session()->getFlashdata('')[''] ?? '' ?>
            </span>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">E-mail</label>
            <input name="" type="email" id="email" placeholder="exemplo@exemplo.com" class="form-control" >
            <span class="invalid-feedback">
                <?= session()->getFlashdata('')[''] ?? '' ?>
            </span>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Senha</label>
            <input name="" type="password" id="password" placeholder="Crie uma senha" class="form-control" >
            <span class="invalid-feedback">
                <?= session()->getFlashdata('')[''] ?? '' ?>
            </span>
        </div>
        <div class="col-md-6">
            <label for="confirmPassword" class="form-label">Confirme a senha</label>
            <input name="" type="password" id="confirmPassword" placeholder="Digite a senha novamente" class="form-control" >
            <span class="invalid-feedback">
                <?= session()->getFlashdata('')[''] ?? '' ?>
            </span>
        </div>

        <div class="col-12 text-center mt-3">
            <button class="btn btn-primary w-100" type="submit">Cadastrar</button>

            <div class="mt-2">
                <a href="<?= url_to('login') ?>" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Já tenho uma conta.</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection('content'); ?>