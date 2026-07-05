<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>

<!-- todo: colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container py-5">

    <h2 class="text-center mb-4">Cadastre-se</h2>

    <form action="<?= url_to('user.register') ?>" method="post" class="row g-2 mx-auto" style="max-width: 700px">
        <div class="col-md-6">
            <?= csrf_field() ?>

            <label for="name" class="form-label">Nome</label>
            <input name="name" type="text" id="name" placeholder="Digite seu nome" value="<?= esc(old('name')) ?>" class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
            <span class="invalid-feedback">
                <?= $invalidArgs['name'] ?? '' ?>
            </span>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">E-mail</label>
            <input name="email" type="text" id="email" placeholder="exemplo@exemplo.com" value="<?= esc(old('email')) ?>" class="form-control <?= isset($invalidArgs['email']) ? 'is-invalid' : '' ?>">
            <span class="invalid-feedback">
                <?= $invalidArgs['email'] ?? '' ?>
            </span>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Senha</label>
            <input name="password" type="password" id="password" placeholder="Crie uma senha" class="form-control <?= isset($invalidArgs['password']) ? 'is-invalid' : '' ?>">
            <span class="invalid-feedback">
                <?= $invalidArgs['password'] ?? '' ?>
            </span>
        </div>
        <div class="col-md-6">
            <label for="confirmPassword" class="form-label">Confirme a senha</label>
            <input name="confirmPassword" type="password" id="confirmPassword" placeholder="Digite a senha novamente" class="form-control <?= isset($invalidArgs['confirmPassword']) ? 'is-invalid' : '' ?>">
            <span class="invalid-feedback">
                <?= $invalidArgs['confirmPassword'] ?? '' ?>
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