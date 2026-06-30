<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>

<?php echo $this->extend('layouts/main'); ?>

<?php echo $this->section('content'); ?>



<?php echo $this->endSection('content'); ?>