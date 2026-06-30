<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>

<?php echo $this->extend('layouts/main'); ?>

<?php echo $this->section('content'); ?>


<div class="container py-5">

    <h2 class="text-center mb-4">Esqueci a senha</h2>

    <p class="caption text-center">Insira seu endereço de e-mail e lhe enviaremos as instruções para redefinir sua
        senha.</p>



    <form action="<?= url_to('forgot.send') ?>" method="post" class="row g-2 mx-auto justify-content-center" style="max-width: 700px">
        <div class="col-md-8 w-100">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" name="email" id="email" placeholder="Digite seu e-mail"
                value="<?php echo old('email'); ?>"
                class="form-control <?php echo isset($invalidArgs['email']) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback">
                <?php echo $invalidArgs['email'] ?? ''; ?>
            </span>
        </div>

        <div class="col-12 text-center mt-3">
            <p><?php echo session()->getFlashdata('message'); ?></p>
            <?php if (session()->has('error')) { ?>
                <div class="alert alert-danger mt-2" role="alert">
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php } ?>

            <?php if (session()->has('forgot_sent')) { ?>
                <div class="alert alert-success mt-2" role="alert">
                    <?php echo session()->getFlashdata('forgot_sent'); ?>
                </div>
            <?php } ?>

            <?php if (session()->has('forgot_not_sent')) { ?>
                <div class="alert alert-success mt-2" role="alert">
                    <?php echo session()->getFlashdata('forgot_not_sent'); ?>
                </div>
            <?php } ?>
            
            <?php if (session()->has('token_not_found')) { ?>
            <div class="alert alert-danger mt-2" role="alert">
                <?php echo session()->getFlashdata('token_not_found'); ?>
            </div>
            <?php } ?>
            
            <?php if (session()->has('updated')) { ?>
                <div class="alert alert-success mt-2" role="alert">
                    <?php echo session()->getFlashdata('updated'); ?>
                </div>
            <?php } ?>

            <?php if (session()->has('not_updated')) { ?>
                <div class="alert alert-success mt-2" role="alert">
                    <?php echo session()->getFlashdata('not_updated'); ?>
                </div>
            <?php } ?>
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