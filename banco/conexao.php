<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    define('HOST', '127.0.0.1');
    define('USUARIO', 'root');
    define('SENHA', '');
    define('DB', 'asa_azul');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        $conexao = mysqli_connect(HOST, USUARIO, SENHA, DB);
        mysqli_set_charset($conexao, "utf8mb4");
        //echo "Conexão bem sucedida!";
    }catch (mysqli_sql_exception $e){
        echo "<p>";
        echo "Erro ao conectar ao banco de dados: ";
        echo $e->getCode(). "- ". $e->getMessage();
        echo "</p>";

    }

?>