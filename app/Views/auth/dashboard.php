<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<form action="<?= url_to('logout') ?>" method="get">
    <h1>Dashboard</h1>
</form>

<?= $this->endSection('content'); ?>