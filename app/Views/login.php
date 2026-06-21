<?= $this->extend('layouts/main_public'); ?>

<?= $this->section('content'); ?>

<form action="<?= url_to('auth') ?>" method="post">
    <label for="email">E-mail:</label>
    <input type="text" name="email" id="email">
    <span><?= session()->getFlashdata('errors')['email'] ?? '' ?></span>
    
    <br>

    <label for="password">Senha:</label>
    <input type="password" name="password" id="password">
    <span><?= session()->getFlashdata('errors')['password'] ?? '' ?></span>
    
    <br>
    
    <button type="submit">Entrar</button>
</form>

<?= session()->getFlashdata('error'); ?>

<?= $this->endSection('content'); ?>