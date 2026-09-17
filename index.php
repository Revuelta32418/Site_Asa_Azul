<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul</title>
    <link rel="shortcut icon" href="imagens/arara_com_circulo.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/estilogeral.css">
    <link rel="stylesheet" type="text/css" href="css/estiloindex.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!--Icones: https://icons.getbootstrap.com/*/-->
</head>

<body>
    <?php
    $base = ''; //aqui, definimos o caminho até a origem da pasta, isso altera para cada arquivo
    $nav = "passagens";
    
    if (file_exists('componentes/header.php')) {
        include 'componentes/header.php';
    }

    if (file_exists('componentes/modallogin.php')) {
        include 'componentes/modallogin.php';
    }
    ?>

    <main>
        <?php
        if (file_exists('componentes/index/hero_formulario.php')) {
            include 'componentes/index/hero_formulario.php';
        }

        if(file_exists('componentes/index/fotos_expandiveis.php')) {
            include 'componentes/index/fotos_expandiveis.php';
        }

        if(file_exists('componentes/index/fotos_em_pe.php')) {
            include 'componentes/index/fotos_em_pe.php';
        }

        if(file_exists('componentes/carrossel.php')){
            include 'componentes/carrossel.php';
        }

        if (file_exists('componentes/faq.php')) {
            include 'componentes/faq.php';
        }
        ?>
    </main>

    <?php
    if (file_exists('componentes/footer.php')) {
        include 'componentes/footer.php';
    }
    ?>

    <script src="js/bootstrap.js"></script>
    <script src="js/jsindex.js"></script>
    <script src="js/jsgeral.js"></script>
</body>

</html>