<?php
function cadastrarUsuario($conexao, $nome, $email, $senha)
{
    $sqlCheck = "SELECT id FROM usuarios WHERE email=?";
    $stmtCheck = mysqli_prepare($conexao, $sqlCheck);
    $tipo = "cliente";

    if ($stmtCheck) {
        mysqli_stmt_bind_param($stmtCheck, "s", $email);
        mysqli_stmt_execute($stmtCheck);

        $resultadoCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resultadoCheck) > 0) {
            $_SESSION['mensagem'] = "Erro: email já cadastrado!";
            mysqli_stmt_close($stmtCheck);
            return false;
        }
    }

    mysqli_stmt_close($stmtCheck);


    $sql = "INSERT INTO usuarios (nome, tipo, email, senha) values (?,?,?,?)";

    $stmt = mysqli_prepare($conexao, $sql);

    if (!$stmt) {
        $_SESSION['mensagem'] = "Erro ao preparar
            o cadastro: " . mysqli_error($conexao);
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $nome,
        $tipo,
        $email,
        $senha
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    }

    $_SESSION['mensagem'] = "Erro ao cadastrar o 
        usuário" . mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);
    return false;
}

function buscarUsuarioPorEmail($conexao, $email)
{

    $sql = "SELECT * FROM usuarios WHERE email=?";
    $stmt = mysqli_prepare($conexao, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);

        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);

        return $usuario;
    }

    return null;
}

function listarUsuarios($conexao, $limite = 10, $excluirId = 0){
    $sql = "SELECT id, nome, tipo, email FROM usuarios WHERE id <> ? ORDER BY id DESC LIMIT ?";

    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, "ii", $excluirId, $limite);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $lista = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    return $lista;
}

function atualizarUsuario($conexao, $id, $nome, $email, $tipo, $senhaHash = null)
{
    if ($senhaHash !== null) {
        $stmt = mysqli_prepare($conexao,
            "UPDATE usuarios SET nome = ?, email = ?, tipo = ?, senha = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $email, $tipo, $senhaHash, $id);
    } else {
        $stmt = mysqli_prepare($conexao,
            "UPDATE usuarios SET nome = ?, email = ?, tipo = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $nome, $email, $tipo, $id);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function excluirUsuario($conexao, $id)
{
    $stmt = mysqli_prepare($conexao, "DELETE FROM usuarios WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}