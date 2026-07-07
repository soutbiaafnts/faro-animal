<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php /**
 *  @var string $title 
 *  @var array $breeds
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
            <h5 class="card-title">Lista de <?= $title ?></h5>
            <p class="card-text">Aqui você pode criar, visualizar, editar e até deletar as raças!</p>
            <a href="<?= url_to('breeds.create') ?>" class="btn btn-primary px-4">Nova Raça</a>

            <hr>

            <table data-toggle="table" data-locale="pt-BR" data-pagination="true" data-search="true" data-page-size="5">
                <thead>
                    <tr>
                        <th data-field="id" class="text-center">#</th>
                        <th data-field="name">Nome</th>
                        <th data-field="specie_name">Espécie</th>
                        <th data-field="created_at">Data de Criação</th>
                        <th data-field="updated_at">Data de Atualização</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($breeds as $breed): ?>
                        <tr>
                            <th class="text-center"><?= esc($breed['id']) ?></th>
                            <td><?= esc($breed['name']) ?></td>
                            <td><?= esc($breed['specie_name']) ?></td>
                            <td><?= esc($breed['created_at']) ?></td>
                            <td><?= esc($breed['updated_at']) ?></td>
                            <td class="text-center">
                                <a href="<?= url_to('breeds.edit', esc($breed['id'])) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="<?= url_to('breeds.delete', esc($breed['id'])) ?>" method="post" class="d-inline">
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