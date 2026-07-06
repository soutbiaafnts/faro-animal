<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

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
            <h5 class="card-title">Lista de <?= $title ?></h5>
            <p class="card-text">Aqui você pode criar, visualizar, editar e até deletar as espécies!</p>
            <a href="<?= url_to('species.create') ?>" class="btn btn-primary px-4">Nova Espécie</a>

            <hr>

            <table data-toggle="table" data-locale="pt-BR" data-pagination="true" data-search="true" data-page-size="5">
                <thead>
                    <tr>
                        <th data-field="id" class="text-center">#</th>
                        <th data-field="specie_name">Nome</th>
                        <th data-field="created_at">Data de Criação</th>
                        <th data-field="updated_at">Data de Atualização</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($species as $specie): ?>
                        <tr>
                            <th class="text-center">
                                <?= $specie['id'] ?>
                            </th>
                            <td>
                                <?= $specie['name'] ?>
                            </td>
                            <td>
                                <?= $specie['created_at'] ?>
                            </td>
                            <td>
                                <?= $specie['updated_at'] ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= url_to('species.edit', $specie['id']) ?>" class="btn btn-outline-primary btn-sm"><i
                                        class="bi bi-pencil"></i></a>
                                <form action="<?= url_to('species.delete', $specie['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>

                                    <input type="hidden" name="_method" value="DELETE">

                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir essa raça?')"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>