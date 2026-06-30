<?php

/** @var string $name */
/** @var string $token */ 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de senha</title>
</head>

<body>
    <h1>Olá, <?php echo $name ?>!</h1>
    <p>Para criar uma nova senha, clique no link abaixo. Este link é válido por 5 minutos!</p>
    <a href="<?php echo site_url("reset/{$token}"); ?>">Clique aqui para criar uma nova senha</a>
</body>

</html>