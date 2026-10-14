<?php
function cadastrarViagem($conexao, array $v)
{
    mysqli_begin_transaction($conexao);

    try {
        // 1) viagem principal
        $sql = "INSERT INTO viagens
                (nome, foto1, foto2, foto3, foto4, preco, dias_sugeridos,
                 melhor_epoca, descricao, impacto_positivo, impacto_foto)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssdsssss",
            $v['nome'],
            $v['fotos'][0],
            $v['fotos'][1],
            $v['fotos'][2],
            $v['fotos'][3],
            $v['preco'],
            $v['dias_sugeridos'],
            $v['melhor_epoca'],
            $v['descricao'],
            $v['impacto_positivo'],
            $v['impacto_foto']
        );
        mysqli_stmt_execute($stmt);
        $viagemId = mysqli_insert_id($conexao);
        mysqli_stmt_close($stmt);

        // 2) pontos culturais (4)
        $sql = "INSERT INTO pontos_culturais
                (viagem_id, ordem, foto, categoria, titulo, descricao)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        foreach ($v['pontos'] as $i => $p) {
            $ordem = $i + 1;
            mysqli_stmt_bind_param(
                $stmt,
                "iissss",
                $viagemId,
                $ordem,
                $p['foto'],
                $p['categoria'],
                $p['titulo'],
                $p['descricao']
            );
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);

        // 3) tópicos de impacto
        $sql = "INSERT INTO impacto_topicos (viagem_id, topico) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        foreach ($v['impacto_topicos'] as $topico) {
            mysqli_stmt_bind_param($stmt, "is", $viagemId, $topico);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);

        mysqli_commit($conexao);
        return $viagemId;
    } catch (Exception $e) {
        mysqli_rollback($conexao); // desfaz tudo
        throw $e;                  // o funcoes.php mostra a mensagem
    }
}
?>