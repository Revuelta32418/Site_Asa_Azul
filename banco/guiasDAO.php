<?php
function buscarPedidoPendente($conexao, $usuarioId)
{
    $stmt = mysqli_prepare(
        $conexao,
        "SELECT id FROM pedidos_guia WHERE usuario_id = ? AND status = 'pendente' LIMIT 1"
    );
    mysqli_stmt_bind_param($stmt, "i", $usuarioId);
    mysqli_stmt_execute($stmt);
    $linha = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $linha ?: null;
}

function criarPedidoGuia($conexao, $usuarioId, array $d)
{
    $stmt = mysqli_prepare(
        $conexao,
        "INSERT INTO pedidos_guia (usuario_id, telefone, regiao, especialidade, experiencia)
         VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param(
        $stmt, "issss",
        $usuarioId, $d['telefone'], $d['regiao'], $d['especialidade'], $d['experiencia']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Retorna todos os pedidos pendentes com dados do usuário
function listarPedidosGuia($conexao)
{
    $sql = "SELECT p.*, u.nome, u.email 
            FROM pedidos_guia p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            WHERE p.status = 'pendente' 
            ORDER BY p.id DESC";
            
    $resultado = mysqli_query($conexao, $sql);
    $pedidos = [];
    
    if ($resultado) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $pedidos[] = $linha;
        }
    }
    
    return $pedidos;
}

// Aprova o pedido e altera o tipo do usuário para 'guia'
function aprovarPedidoGuia($conexao, $pedidoId)
{
    mysqli_begin_transaction($conexao);

    try {
        // só mexe em pedidos que ainda estão pendentes
        $stmt = mysqli_prepare(
            $conexao,
            "SELECT usuario_id FROM pedidos_guia WHERE id = ? AND status = 'pendente'"
        );
        mysqli_stmt_bind_param($stmt, "i", $pedidoId);
        mysqli_stmt_execute($stmt);
        $pedido = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if (!$pedido) {
            mysqli_rollback($conexao);
            return false;
        }

        $stmt = mysqli_prepare($conexao, "UPDATE pedidos_guia SET status = 'aprovado' WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $pedidoId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // só promove quem ainda é cliente (nunca rebaixa um administrador)
        $stmt = mysqli_prepare($conexao, "UPDATE usuarios SET tipo = 'guia' WHERE id = ? AND tipo = 'cliente'");
        mysqli_stmt_bind_param($stmt, "i", $pedido['usuario_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_commit($conexao);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conexao);
        return false;
    }
}

function recusarPedidoGuia($conexao, $pedidoId)
{
    try {
        $stmt = mysqli_prepare(
            $conexao,
            "UPDATE pedidos_guia SET status = 'recusado' WHERE id = ? AND status = 'pendente'"
        );
        mysqli_stmt_bind_param($stmt, "i", $pedidoId);
        mysqli_stmt_execute($stmt);
        $alterou = mysqli_stmt_affected_rows($stmt) > 0;
        mysqli_stmt_close($stmt);
        return $alterou;
    } catch (Exception $e) {
        return false;
    }
}

function listarRoteirosPorGuia($conexao, $guiaNome)
{
    $stmt = mysqli_prepare(
        $conexao,
        "SELECT * FROM viagens WHERE criado_por = ? ORDER BY id DESC"
    );
    mysqli_stmt_bind_param($stmt, "s", $guiaNome);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    $roteiros = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $roteiros[] = $linha;
    }
    
    mysqli_stmt_close($stmt);
    return $roteiros;
}