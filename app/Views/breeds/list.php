<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container py-4">

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <h5 class="card-title">Lista de <?= $title ?></h5>
            <p class="card-text">Aqui você pode criar, visualizar, editar e até deletar as raças!</p>
            <a href="<?= url_to('breeds.create') ?>" class="btn btn-primary px-4">Nova Raça</a>

            <hr>

            <table data-toggle="table" data-locale="pt-BR" data-pagination="true" data-search="true" data-page-size="5">
                <thead>
                    <tr>
                        <th data-field="id" class="text-center">#</th>
                        <th data-field="specie_name">Espécie</th>
                        <th data-field="name">Nome</th>
                        <th data-field="created_at">Data de Criação</th>
                        <th data-field="updated_at">Data de Atualização</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($breeds as $breed): ?>
                        <tr>
                            <th class="text-center"><?= $breed['id'] ?></th>
                            <td><?= $breed['specie_name'] ?></td>
                            <td><?= $breed['name'] ?></td>
                            <td><?= $breed['created_at'] ?></td>
                            <td><?= $breed['updated_at'] ?></td>
                            <td class="text-center">
                                <a href="<?= url_to('breeds.edit', $breed['id']) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="<?= url_to('breeds.delete', $breed['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>

                                    <input type="hidden" name="_method" value="DELETE">

                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir essa raça?')"><i class="bi bi-trash"></i></button>
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