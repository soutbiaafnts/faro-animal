<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>

<?php echo $this->extend('layouts/main'); ?>

<?php echo $this->section('content'); ?>

<div class="container py-5">

    <h2 class="text-center mb-4">Faça o login</h2>

    <form action="<?php echo url_to('auth'); ?>" method="post" class="row g-2 mx-auto justify-content-center"
        style="max-width: 700px">
        <?= csrf_field() ?>

        <div class="col-md-8 w-100">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" name="email" id="email" placeholder="Digite seu e-mail" value="<?= esc(old('email')) ?>"
                class="form-control <?php echo isset($invalidArgs['email']) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback">
                <?php echo $invalidArgs['email'] ?? ''; ?>
            </span>
        </div>
        <div class="col-md-8 w-100">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha"
                class="form-control <?php echo isset($invalidArgs['password']) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback">
                <?php echo $invalidArgs['password'] ?? ''; ?>
            </span>
        </div>

        <div class="col-12 text-center mt-3">
            <button class="btn btn-primary w-100" type="submit">Entrar</button>

            <div class="mt-2">
                <a href="<?php echo url_to('forgot'); ?>"
                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Esqueceu
                    a senha?</a>
            </div>
        </div>
    </form>
</div>

<?php echo $this->endSection('content'); ?>