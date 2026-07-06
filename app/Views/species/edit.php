<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php /**
 *  @var string $title 
 *  @var array $specie
 * */
?>

<div class="container py-5">

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

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <form action="<?= url_to('species.update', $specie['id']) ?>" method="post" class="row g2 mx-auto">
                <div class="col-md-6">
                    <?= csrf_field() ?>

                    <label for="name" class="form-label">Nome</label>
                    <input name="name" type="text" id="name" placeholder="Digite o nome da espécie"
                        value="<?= esc(old('name', $specie['name'])) ?>"
                        class="form-control <?= isset($invalidArgs['name']) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback">
                        <?= $invalidArgs['name'] ?? '' ?>
                    </span>
                </div>

                <div class="d-flew flex-col gap-2 mt-3">
                    <a href="<?= url_to('species') ?>" class="btn btn-sm btn-secondary px-4">Voltar</a>
                    <button class="btn btn-sm btn-primary px-4" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>