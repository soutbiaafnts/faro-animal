<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container py-5">

    <h1 class="display-6 fw-bold text-primary text-center">Olá, <?= esc($user['name']) ?></h1>
    <p class="lead text-secondary text-center mb-4">Gerencie seu perfil.</p>

    <?php if ($message && !$success): ?>
        <div class="alert alert-danger text-center mx-auto" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <h4 class="alert-heading">Erro!</h4>
            <hr>
            <p class="mb-0">
                <?= $message ?>
            </p>
        </div>
    <?php elseif ($message && $success): ?>
        <div class="alert alert-success text-center mx-auto" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <h4 class="alert-heading">Sucesso!</h4>
            <hr>
            <p class="mb-0">
                <?= $message ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="d-flex flex-column flex-lg-row justify-content-center gap-4">

        <div class="card w-100 w-lg-100">
            <div class="card-header">
                Dados do perfil
            </div>

            <div class="card-body">
                <form action="<?= url_to('me.update') ?>" method="post" class="">
                    <div class="">
                        <?= csrf_field() ?>

                        <label for="name" class="form-label">Nome</label>
                        <input name="name" type="text" id="name" value="<?= esc(old('name', $user['name'])) ?>" class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
                        <span class="invalid-feedback">
                            <?= $invalidArgs['name'] ?? '' ?>
                        </span>
                    </div>
                    <div class="">
                        <label for="email" class="form-label">E-mail</label>
                        <input name="email" type="text" id="email" value="<?= esc($user['email']) ?>" class="form-control readonly" readonly>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary w-100" type="submit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card w-100 w-lg-100">
            <div class="card-header">
                Alterar Senha
            </div>

            <div class="card-body">
                <form action="<?= url_to('me.password') ?>" method="post" class="g-2 mx-auto">
                    <div class="">
                        <?= csrf_field() ?>

                        <label for="currentPassword" class="form-label">Senha atual</label>
                        <input name="currentPassword" type="password" id="currentPassword" placeholder="Informe a senha atual"
                            class="form-control <?= isset($invalidArgs['currentPassword']) ? 'is-invalid' : '' ?>">
                        <span class="invalid-feedback">
                            <?= $invalidArgs['currentPassword'] ?? '' ?>
                        </span>
                    </div>
                    <div class="">
                        <label for="newPassword" class="form-label">Nova senha</label>
                        <input name="newPassword" type="password" id="newPassword" placeholder="Informe a nova senha"
                            class="form-control <?= isset($invalidArgs['newPassword']) ? 'is-invalid' : '' ?>">
                        <span class="invalid-feedback">
                            <?= $invalidArgs['newPassword'] ?? '' ?>
                        </span>
                    </div>
                    <div class="">
                        <label for="confirmNewPassword" class="form-label">Confirme a senha</label>
                        <input name="confirmNewPassword" type="password" id="confirmNewPassword" placeholder="Digite a nova senha novamente"
                            class="form-control <?= isset($invalidArgs['confirmNewPassword']) ? 'is-invalid' : '' ?>">
                        <span class="invalid-feedback">
                            <?= $invalidArgs['confirmNewPassword'] ?? '' ?>
                        </span>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary w-100" type="submit">Salvar</button>
                    </div>
                </form>
            </div>

        </div>

        <div class="card w-100 w-lg-100 border-danger">
            <div class="card-header bg-danger text-white">
                Zona de Perigo
            </div>

            <div class="card-body">
                <p>
                    Esta ação é irreversível. Todos os seus dados serão removidos.
                </p>

                <form action="<?= url_to('me.delete') ?>" method="post">
                    <?= csrf_field() ?>

                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não poderá ser desfeita.')">
                        Excluir minha conta
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection('content'); ?>