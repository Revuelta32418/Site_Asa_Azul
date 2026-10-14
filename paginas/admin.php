<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=], initial-scale=1.0">
    <title>Asa Azul</title>
    <link rel="stylesheet" href="../css/estilogeral.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php
    $base = '../';

    if (file_exists('../componentes/header.php')) {
        $hideHeader = true;
        include '../componentes/header.php';
    }
    ?>

    <main>
        <section class="container-margem py-4">
            <h1 class="titulo">Área do Administrador</h1>
            <a href="cadastrar.php" style="background-color: red;text-decoration: none;color: white;padding: 5px;border-radius: 3px;">Cadastrar viagem</a>
        </section>
    </main>


</body>

</html>