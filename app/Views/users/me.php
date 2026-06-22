<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>
<?php $message = session()->getFlashdata('message') ?? [] ?>
<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main_auth'); ?>

<?= $this->section('content'); ?>

<div class="container py-4">
    <h2>Olá, <?= $user['name'] ?></h2>
    <div class="d-flex flex-col gap-2 w-100">
        <div class="card w-100">
            <div class="card-header">
                Dados do perfil
            </div>

            <div class="card-body">
                <form action="<?= url_to('me.update') ?>" method="post" class="">
                    <div class="">
                        <label for="name" class="form-label">Nome</label>
                        <input name="name" type="text" id="name" value="<?= old('name', $user['name']) ?>" class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
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

        <div class="card w-100">
            <div class="card-header">
                Alterar Senha
            </div>

            <div class="card-body">
                <form action="<?= url_to('me.password') ?>" method="post" class="g-2 mx-auto" style="max-width: 700px">
                    <div class="">
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
        
        <div class="card border-danger w-100">
            <div class="card-header bg-danger text-white">
                Zona de Perigo
            </div>

            <div class="card-body">
                <p>
                    Esta ação é irreversível. Todos os seus dados serão removidos.
                </p>

                <form action="<?= url_to('me.delete') ?>" method="post">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não poderá ser desfeita.')">
                        Excluir minha conta
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection('content'); ?>