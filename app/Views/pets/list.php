<?php $invalidArgs = session()->getFlashdata('invalidArgs') ?? []; ?>
<?php $message = session()->getFlashdata('message') ?? ''; ?>
<?php $success = session()->getFlashdata('success'); ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php /**
 *  @var string $title 
 *  @var array $pets
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
            <p class="card-text">Aqui você pode criar, visualizar, editar e até deletar os pets!</p>
            <a href="<?= url_to('pets.create') ?>" class="btn btn-primary px-4">Novo Pet</a>

            <hr>

            <table data-toggle="table" data-locale="pt-BR" data-pagination="true" data-search="true" data-page-size="5">
                <thead>
                    <tr>
                        <th data-field="id">#</th>
                        <th data-field="name">Nome</th>
                        <th data-field="breed_id">Raça</th>
                        <th data-field="sex">Sexo</th>
                        <th data-field="birth_date">Nascimento</th>
                        <th data-field="weight">Peso</th>
                        <th data-field="owner_name">Nome do tutor</th>
                        <th data-field="owner_phone">Telefone do tutor</th>
                        <th data-field="notes">Anotações</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pets as $pet): ?>
                        <tr>
                            <th>
                                <?= $pet['id'] ?>
                            </th>
                            <td><?= $pet['name'] ?></td>
                            <td><?= $pet['breed_name'] ?></td>
                            <td><?= $pet['sex'] ?></td>
                            <td><?= $pet['birth_date'] ?></td>
                            <td><?= $pet['weight'] ?></td>
                            <td><?= $pet['owner_name'] ?></td>
                            <td><?= $pet['owner_phone'] ?></td>
                            <td><?= $pet['notes'] ?></td>
                            <td class="text-center">
                                <a href="<?= url_to('pets.edit', $pet['id']) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="<?= url_to('pets.delete', $pet['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>

                                    <input type="hidden" name="_method" value="DELETE">

                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esse pet?')"><i class="bi bi-trash"></i></button>
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