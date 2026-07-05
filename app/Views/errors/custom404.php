<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5 text-center">


    <h1 class="display-1 fw-bold text-primary">404 :(</h1>

    <h3>Oops... Parece que esse pet saiu para passear...!</h3>

    <p class="text-muted">
        A página que você procura não existe ou foi movida.
    </p>

    <a href="<?= url_to('home') ?>" class="btn btn-primary mt-3">
        Voltar para a página inicial
    </a>

</div>

<?= $this->endSection() ?>