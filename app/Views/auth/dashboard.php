<?= $this->extend('layouts/main_auth'); ?>

<?= $this->section('content'); ?>

<form action="<?= url_to('logout') ?>" method="get">
    <h1>Dashboard</h1>
</form>

<?= $this->endSection('content'); ?>