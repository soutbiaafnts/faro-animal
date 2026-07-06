<?php

/** @var string $name */
/** @var string $token */
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Recuperação de senha</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 100%;
            padding: 40px 0;
        }

        .card {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        h1 {
            color: #0d6efd;
            margin-top: 0;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            margin-top: 24px;
            padding: 14px 28px;
            background: #0d6efd;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">

            <h1>Olá, <?= esc($name) ?>!</h1>

            <p>Recebemos uma solicitação para redefinir a senha da sua conta.</p>

            <p>Clique no botão abaixo para criar uma nova senha. Este link é válido por apenas <strong>5 minutos</strong>.</p>

            <a class="button" href="<?= site_url("reset/{$token}") ?>">
                Redefinir senha
            </a>

            <p class="footer">
                Se você não solicitou esta alteração, basta ignorar este e-mail.
            </p>

        </div>
    </div>

</body>

</html>