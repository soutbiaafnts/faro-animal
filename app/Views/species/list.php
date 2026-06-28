<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? [] ?>

<!-- todo: colocar alerta para as mensagens de erro -->
<?php $errors = session()->getFlashdata('errors') ?? [] ?> 

<?= $this->extend('layouts/main_auth'); ?>

<?= $this->section('content'); ?>

<div class="container py-4">

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <h5 class="card-title">Lista de <?= $title ?></h5>
            <p class="card-text">Aqui você pode criar, visualizar, editar e até deletar as espécies!</p>
            <a href="<?=url_to('species.create')?>" class="btn btn-primary px-4">Nova Espécie</a>
            
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