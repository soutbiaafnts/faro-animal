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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <h1>Ficha de Consulta</h1>

    <hr>

    <h2>Dados</h2>
    <p>Nome do pet: <?= esc($appointment['pet_name']) ?> | Nome do tutor: <?= esc($appointment['owner_name']) ?></p>
    <p>Nome do veterinário: <?= esc($appointment['user_name']) ?> | Data/Horário: <?= esc($appointment['appointment_date']) ?></p>
    <p>Status: <?= esc($appointment['status']) ?></p>

    <hr>

    <h2>Informações</h2>
    <h3>Razão da consulta:</h3>
    <p><?= esc($appointment['reason']) ?></p>

    <h3>Diagnóstico:</h3>
    <p><?= esc($appointment['diagnosis']) ?></p> 
    
    <h3>Prescrição:</h3>
    <p><?= esc($appointment['prescription']) ?></p>
    
    <h3>Anotações:</h3>
    <p><?= esc($appointment['notes']) ?></p>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/locale/bootstrap-table-pt-BR.min.js"></script>
</body>

</html>