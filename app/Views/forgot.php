<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>

<?php echo $this->extend('layouts/main'); ?>

<?php echo $this->section('content'); ?>


<div class="container py-5" style="max-width: 700px">

    <?php if ($message && !$success): ?>
        <div class="alert alert-danger text-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <h4 class="alert-heading">Erro!</h4>
            <hr>
            <p class="mb-0"><?= $message ?>
            </p>
        </div>
    <?php elseif ($message && $success): ?>
        <div class="alert alert-success text-center" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <h4 class="alert-heading">Sucesso!</h4>
            <hr>
            <p class="mb-0"><?= $message ?></p>
        </div>
    <?php endif; ?>

    <h1 class="display-4 fw-bold text-primary text-center">Esqueci a senha</h1>
    <p class="lead text-secondary text-center mb-4">Insira seu endereço de e-mail e lhe enviaremos as instruções para redefinir sua
        senha.</p>

    <form action="<?= url_to('forgot.send') ?>" method="post" class="row g-2 mx-auto justify-content-center"
        style="max-width: 700px">
        <?= csrf_field() ?>

        <div class="col-md-8 w-100">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" name="email" id="email" placeholder="Digite seu e-mail"
                value="<?= esc(old('email')) ?>"
                class="form-control <?php echo isset($invalidArgs['email']) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback">
                <?php echo $invalidArgs['email'] ?? ''; ?>
            </span>
        </div>

        <div class="col-12 text-center mt-3">

            <button class="btn btn-primary w-100" type="submit">Continuar</button>

            <div class="mt-2">
                <a href="<?php echo url_to('login'); ?>"
                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Voltar
                    para login</a>
            </div>
        </div>
    </form>
</div>


<?php echo $this->endSection('content'); ?>