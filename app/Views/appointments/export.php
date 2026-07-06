<?php

/**
 * @var array @appointment
 */ ?>

<!DOCTYPE html>
<html>

<head>
    <title>Ficha de Consulta</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
            line-height: 1.5;
        }

        h1 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        h2 {
            background: #0d6efd;
            color: white;
            padding: 8px 12px;
            font-size: 15px;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 13px;
            color: #0d6efd;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        p {
            margin: 4px 0 10px;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 30%;
            background: #f2f2f2;
        }

        .content {
            border: 1px solid #ddd;
            padding: 10px;
            min-height: 50px;
            background: #fafafa;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <h1>Ficha de Consulta</h1>
    <p class="subtitle">Documento gerado pelo sistema Faro Animal</p>

    <h2>Dados da Consulta</h2>

    <table>
        <tr>
            <td class="label">Pet</td>
            <td><?= esc($appointment['pet_name']) ?></td>
        </tr>
        <tr>
            <td class="label">Tutor</td>
            <td><?= esc($appointment['owner_name']) ?></td>
        </tr>
        <tr>
            <td class="label">Veterinário</td>
            <td><?= esc($appointment['user_name']) ?></td>
        </tr>
        <tr>
            <td class="label">Data/Horário</td>
            <td><?= esc($appointment['appointment_date']) ?></td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td><?php if ($appointment['status'] == 'scheduled') {
                    echo 'Agendada';
                } elseif ($appointment['status'] == 'completed') {
                    echo 'Realizada';
                } else {
                    echo 'Cancelada';
                } ?></td>
        </tr>
    </table>

    <h2>Informações da Consulta</h2>

    <h3>Razão da consulta</h3>
    <div class="content">
        <?= nl2br(esc($appointment['reason'])) ?>
    </div>

    <h3>Diagnóstico</h3>
    <div class="content">
        <?= nl2br(esc($appointment['diagnosis'])) ?>
    </div>

    <h3>Prescrição</h3>
    <div class="content">
        <?= nl2br(esc($appointment['prescription'])) ?>
    </div>

    <h3>Anotações</h3>
    <div class="content">
        <?= nl2br(esc($appointment['notes'])) ?>
    </div>
</body>

</html>