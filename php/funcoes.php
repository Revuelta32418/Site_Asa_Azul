<?php
session_start();

$base = "../";
require_once($base . "banco/conexao.php");
require_once($base . "banco/usuariosDAO.php");
require_once($base . "banco/viagensDAO.php");

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
function salvarImagem($campo, $base)
{
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $ext = strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
        throw new Exception("Formato de imagem inválido em $campo.");
    }
    $nome = uniqid('img_', true) . '.' . $ext;
    $destino = $base . 'imagens/viagens/' . $nome;
    move_uploaded_file($_FILES[$campo]['tmp_name'], $destino);
    return 'imagens/viagens/' . $nome; // caminho que vai pro banco
}

if (isset($_POST['cadastrar_viagem'])) {
    try {
        $pontos = [];
        for ($i = 1; $i <= 4; $i++) {
            $pontos[] = [
                'foto'      => salvarImagem("ponto{$i}_foto", $base),
                'categoria' => trim($_POST["ponto{$i}_categoria"] ?? ''),
                'titulo'    => trim($_POST["ponto{$i}_titulo"] ?? ''),
                'descricao' => trim($_POST["ponto{$i}_descricao"] ?? ''),
            ];
        }

        $viagem = [
            'nome'             => trim($_POST['nome_viagem']),
            'fotos'            => [
                salvarImagem('foto1', $base),
                salvarImagem('foto2', $base),
                salvarImagem('foto3', $base),
                salvarImagem('foto4', $base),
            ],
            'preco'            => (float) str_replace(',', '.', $_POST['preco']),
            'dias_sugeridos'   => trim($_POST['dias_sugeridos']),
            'melhor_epoca'     => trim($_POST['melhor_epoca']),
            'descricao'        => trim($_POST['descricao']),
            'pontos'           => $pontos,
            'impacto_positivo' => trim($_POST['impacto_positivo']),
            'impacto_foto'     => salvarImagem('impacto_foto', $base),
            'impacto_topicos'  => array_filter(array_map('trim', $_POST['impacto_topicos'] ?? [])),
        ];

        if ($viagem['nome'] === '') {
            $_SESSION['mensagem'] = "Informe o nome da viagem!";
            header("Location: " . $voltar);
            exit();
        }

        cadastrarViagem($conexao, $viagem);
        $_SESSION['mensagem'] = "Viagem cadastrada com sucesso!";
        $_SESSION['mensagem_tipo'] = 'success';
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao cadastrar a viagem. Tente novamente.";
    }

    header("Location: " . $voltar);
    exit();
}
?>