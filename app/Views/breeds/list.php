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
            <p class="card-text">Aqui você pode criar, visualizar, editar e até deletar as raças!</p>
            <a href="<?= url_to('breeds.create') ?>" class="btn btn-primary px-4">Nova Raça</a>

            <hr>
            
            <table class="table table-sm table-striped table-bordered w-100">
                <thead class="table-light">
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Espécie</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Data de Criação</th>
                        <th scope="col">Data de Atualização</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($breeds as $breed): ?>
                            <tr class="align-middle text-center">
                                <th scope="row">
                                    <?= $breed['id'] ?>
                                </th>
                                <td>
                                    <?= $breed['specie_name'] ?>
                                </td>
                                <td>
                                    <?= $breed['name'] ?>
                                </td>
                                <td>
                                    <?= $breed['created_at'] ?>
                                </td>
                                <td>
                                    <?= $breed['updated_at'] ?>
                                </td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="<?= url_to('breeds.edit', $breed['id']) ?>" class="btn btn-sm btn-secondary px-4">Editar</a>
                                
                                    <form action="<?= url_to('breeds.delete', $breed['id']) ?>" method="post">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button 
                                            type="submit" 
                                            class="btn btn-sm btn-danger px-4" 
                                            onclick="return confirm('Tem certeza que deseja excluir essa raça? Esta ação não poderá ser desfeita.')">Deletar</button>
                                    </form>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="container d-flex justify-content-center">
                <ul class="pagination">
                    <?= $pager->links('default') ?>
                </ul>
            </div>
        </div>
    </div>

    

</div>

<?= $this->endSection('content'); ?>