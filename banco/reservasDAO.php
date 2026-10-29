<?php
function criarReserva($conexao, array $r)
{
    $sql = "INSERT INTO reservas (
                viagem_id, usuario_id, ida, volta, 
                num_pessoas, num_criancas, idade_criancas, num_idosos, 
                estilo_viajante, nome, cpf, telefone, observacoes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "iissiisssssss",
        $r['viagem_id'],
        $r['usuario_id'],
        $r['ida'],
        $r['volta'],
        $r['num_pessoas'],
        $r['num_criancas'],
        $r['idade_criancas'],
        $r['num_idosos'],
        $r['estilo_viajante'],
        $r['nome'],
        $r['cpf'],
        $r['telefone'],
        $r['observacoes']
    );

    $resultado = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $resultado;
}

function listarReservasPorUsuario($conexao, $usuarioId)
{
    $sql = "SELECT r.*, v.nome AS nome_viagem, v.foto1, v.preco 
            FROM reservas r 
            JOIN viagens v ON r.viagem_id = v.id 
            WHERE r.usuario_id = ? 
            ORDER BY r.id DESC";

    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param($stmt, "i", $usuarioId);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $lista = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    return $lista;
}