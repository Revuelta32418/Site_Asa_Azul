<?php
session_start();

$base = "../";
require_once($base . "banco/conexao.php");
require_once($base . "banco/usuariosDAO.php");

// Para onde voltar: a página onde a pessoa estava
$voltar = $_SERVER['HTTP_REFERER'] ?? ($base . 'index.php');

/* --------- Usuários --------- */
if (isset($_POST['cadastrar_usuario'])) {
    $nome = trim($_POST['cadNome']);
    $email = trim($_POST['cadEmail']);
    $senha = $_POST['cadSenha'];
    $confirmarSenha = $_POST['cadConfirmarSenha'];

    $_SESSION['abrir_modal'] = 'cadastro'; // se der erro, reabre no formulário de cadastro

    if ($senha !== $confirmarSenha) {
        $_SESSION['mensagem'] = "As senhas não coincidem!";
        header("Location: " . $voltar);
        exit();
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        if (cadastrarUsuario($conexao, $nome, $email, $senhaHash)) {
            $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
            $_SESSION['mensagem_tipo'] = 'success';
            unset($_SESSION['abrir_modal']);
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = "Erro ao cadastrar. Tente novamente.";
    }

    header("Location: " . $voltar);
    exit();
}

if (isset($_POST['login_usuario'])) {
    $email = trim($_POST['loginEmail']);
    $senha = $_POST['loginSenha'];

    $usuario = buscarUsuarioPorEmail($conexao, $email);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['mensagem'] = "Login realizado com sucesso!";
        $_SESSION['mensagem_tipo'] = 'success';
        header("Location: " . $voltar);
        exit();
    }

    $_SESSION['mensagem'] = "E-mail ou senha incorretos.";
    $_SESSION['abrir_modal'] = 'login';
    header("Location: " . $voltar);
    exit();
}

/* --------- Viagens --------- */