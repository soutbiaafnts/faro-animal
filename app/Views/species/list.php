<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>

<!-- todo: colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?> 

<?= $this->extend('layouts/main_auth'); ?>

<?= $this->section('content'); ?>

<?= d($message) ?>
<?= d($species) ?>
<?= d($pager) ?>

<?= $this->endSection('content'); ?>