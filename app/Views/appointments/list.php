<?php $errors = session()->getFlashdata('errors') ?? [] ?>

<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php /**
 * @var string $title
 * @var array $appointments
 */ ?>

<div class="container py-5">

    <div class="card">
        <h5 class="card-header">
            <?= $title ?>
        </h5>
        <div class="card-body">
            <h5 class="card-title">Lista de <?= $title ?></h5>
            <p class="card-text">Aqui você pode criar, visualizar, editar e até deletar as consultas!</p>
            <a href="<?= url_to('appointments.create') ?>" class="btn btn-primary px-4">Novo Consulta</a>

            <hr>

            <table data-toggle="table" data-locale="pt-BR" data-pagination="true" data-search="true" data-page-size="5">
                <thead>
                    <tr>
                        <th data-field="id">#</th>
                        <th data-field="pet_name">Pet</th>
                        <th data-field="user_name">Veterinário</th>
                        <th data-field="appointment_date">Data da consulta</th>
                        <th data-field="status">Status</th>
                        <th data-field="reason">Razão</th>
                        <th data-field="diagnosis">Diagnóstico</th>
                        <th data-field="prescription">Prescrição</th>
                        <th data-field="notes">Anotações</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <th>
                                <?= $appointment['id'] ?>
                            </th>
                            <td><?= $appointment['pet_name'] ?></td>
                            <td><?= $appointment['user_name'] ?></td>
                            <td><?= $appointment['appointment_date'] ?></td>
                            <td><?php if ($appointment['status'] == 'scheduled') {
                                    echo 'Agendada';
                                } elseif ($appointment['status'] == 'completed') {
                                    echo 'Realizada';
                                } else {
                                    echo 'Cancelada';
                                } ?></td>
                            <td><?= $appointment['reason'] ?></td>
                            <td><?= $appointment['diagnosis'] ?></td>
                            <td><?= $appointment['prescription'] ?></td>
                            <td><?= $appointment['notes'] ?></td>
                            <td class="text-center">
                                <a target="_blank" href="<?= url_to('appointments.export', $appointment['id']) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer-fill"></i></a>
                                <a href="<?= url_to('appointments.edit', $appointment['id']) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="<?= url_to('appointments.delete', $appointment['id']) ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>

                                    <input type="hidden" name="_method" value="DELETE">

                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir essa consulta?')"><i class="bi bi-trash"></i></button>
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