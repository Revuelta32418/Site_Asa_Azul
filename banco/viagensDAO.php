<?php
function cadastrarViagem($conexao, array $v){
    mysqli_begin_transaction($conexao);

    try {
        $status    = $v['status'] ?? 'aprovado';

        //1 Principais dados da viagem
        $sql = "INSERT INTO viagens
                (nome, slug, criado_por, foto1, foto2, foto3, foto4, preco, dias_sugeridos,
                 melhor_epoca, descricao, impacto_positivo, impacto_foto, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssdssssss",
            $v['nome'],
            $v['slug'],      
            $v['criado_por'],
            $v['fotos'][0],
            $v['fotos'][1],
            $v['fotos'][2],
            $v['fotos'][3],
            $v['preco'],
            $v['dias_sugeridos'],
            $v['melhor_epoca'],
            $v['descricao'],
            $v['impacto_positivo'],
            $v['impacto_foto'],
            $status
        );
        mysqli_stmt_execute($stmt);
        $viagemId = mysqli_insert_id($conexao);
        mysqli_stmt_close($stmt);

        // 2) pontos culturais
        $stmt = mysqli_prepare(
            $conexao,
            "INSERT INTO pontos_culturais (viagem_id, ordem, foto, categoria, titulo, descricao)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        foreach ($v['pontos'] as $i => $p) {
            $ordem = $i + 1;
            mysqli_stmt_bind_param(
                $stmt, "iissss",
                $viagemId, $ordem, $p['foto'], $p['categoria'], $p['titulo'], $p['descricao']
            );
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);

    //3 Impacto Tópicos
    $stmt = mysqli_prepare($conexao, "INSERT INTO impacto_topicos (viagem_id, topico) VALUES (?, ?)");
        foreach ($v['impacto_topicos'] as $topico) {
            mysqli_stmt_bind_param($stmt, "is", $viagemId, $topico);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);

        mysqli_commit($conexao);
        return $viagemId;
    } catch (Exception $e) {
        mysqli_rollback($conexao);
        throw $e;
    }
}
// Aprovar roteiros pelo Admin
function aprovarRoteiroViagem($conexao, $idViagem) 
{
    $sql = "UPDATE viagens SET status = 'aprovado' WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idViagem);
    $res = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $res;
}

function recusarRoteiroViagem($conexao, $idViagem) 
{
    $sql = "UPDATE viagens SET status = 'recusado' WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idViagem);
    $res = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $res;
}

// Listar apenas viagens que aguardam aprovação de Admin
function listarRoteirosPendentes($conexao) 
{
    $sql = "SELECT * FROM viagens WHERE status = 'pendente' ORDER BY id DESC";
    $res = mysqli_query($conexao, $sql);
    if (!$res) {
        return [];
    }
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// Listar apenas viagens aprovadas para a Home e Aba de Viagens Ativas
function listarViagens($conexao, $limite = null, $excluirId = 0)
{
    $sql = "SELECT id, nome, slug, criado_por, foto1, preco, dias_sugeridos, descricao 
            FROM viagens 
            WHERE (status = 'aprovado' OR status IS NULL) AND id <> ? 
            ORDER BY id DESC";

    if ($limite !== null) {
        $sql .= " LIMIT ?";
    }

    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) return [];

    if ($limite !== null) {
        mysqli_stmt_bind_param($stmt, "ii", $excluirId, $limite);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $excluirId);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $lista = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    return $lista;
}

function buscarViagemPorId($conexao, $id)
{
    $sql = "SELECT * FROM viagens WHERE id=?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $viagem = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if ($viagem) {
        // Mapeia fotos no array 'fotos' para garantir compatibilidade
        $viagem['fotos'] = [
            $viagem['foto1'] ?? '',
            $viagem['foto2'] ?? '',
            $viagem['foto3'] ?? '',
            $viagem['foto4'] ?? ''
        ];

        // Buscar pontos culturais
        $sqlPontos = "SELECT * FROM pontos_culturais WHERE viagem_id=? ORDER BY ordem";
        $stmtPontos = mysqli_prepare($conexao, $sqlPontos);
        mysqli_stmt_bind_param($stmtPontos, "i", $id);
        mysqli_stmt_execute($stmtPontos);
        $resultadoPontos = mysqli_stmt_get_result($stmtPontos);
        $viagem['pontos'] = mysqli_fetch_all($resultadoPontos, MYSQLI_ASSOC);
        mysqli_stmt_close($stmtPontos);

        // Buscar tópicos de impacto
        $sqlTopicos = "SELECT topico FROM impacto_topicos WHERE viagem_id=?";
        $stmtTopicos = mysqli_prepare($conexao, $sqlTopicos);
        mysqli_stmt_bind_param($stmtTopicos, "i", $id);
        mysqli_stmt_execute($stmtTopicos);
        $resultadoTopicos = mysqli_stmt_get_result($stmtTopicos);
        $viagem['impacto_topicos'] = array_column(mysqli_fetch_all($resultadoTopicos, MYSQLI_ASSOC), 'topico');
        mysqli_stmt_close($stmtTopicos);
    }

    return $viagem;
}

function buscarViagemPorSlug($conexao, $slug)
{
    $sql = "SELECT * FROM viagens WHERE slug=?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $viagem = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if ($viagem) {
        $viagem['fotos'] = [
            $viagem['foto1'] ?? '',
            $viagem['foto2'] ?? '',
            $viagem['foto3'] ?? '',
            $viagem['foto4'] ?? ''
        ];

        $sqlPontos = "SELECT * FROM pontos_culturais WHERE viagem_id=? ORDER BY ordem";
        $stmtPontos = mysqli_prepare($conexao, $sqlPontos);
        mysqli_stmt_bind_param($stmtPontos, "i", $viagem['id']);
        mysqli_stmt_execute($stmtPontos);
        $resultadoPontos = mysqli_stmt_get_result($stmtPontos);
        $viagem['pontos'] = mysqli_fetch_all($resultadoPontos, MYSQLI_ASSOC);
        mysqli_stmt_close($stmtPontos);

        $sqlTopicos = "SELECT topico FROM impacto_topicos WHERE viagem_id=?";
        $stmtTopicos = mysqli_prepare($conexao, $sqlTopicos);
        mysqli_stmt_bind_param($stmtTopicos, "i", $viagem['id']);
        mysqli_stmt_execute($stmtTopicos);
        $resultadoTopicos = mysqli_stmt_get_result($stmtTopicos);
        $viagem['impacto_topicos'] = array_column(mysqli_fetch_all($resultadoTopicos, MYSQLI_ASSOC), 'topico');
        mysqli_stmt_close($stmtTopicos);
    }

    return $viagem;
}

function gerarSlug($texto)
{
    $texto = strtolower(trim($texto));
    $texto = strtr($texto, [
        'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c',
    ]);
    return trim(preg_replace('/[^a-z0-9]+/', '-', $texto), '-');
}

function atualizarViagem($conexao, array $v)
{
    mysqli_begin_transaction($conexao);

    try {
        $sql = "UPDATE viagens SET
                    nome = ?, foto1 = ?, foto2 = ?, foto3 = ?, foto4 = ?,
                    preco = ?, dias_sugeridos = ?, melhor_epoca = ?,
                    descricao = ?, impacto_positivo = ?, impacto_foto = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssdsssssi",
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
            $v['impacto_foto'],
            $v['id']
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($conexao, "DELETE FROM pontos_culturais WHERE viagem_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $v['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if (!empty($v['pontos'])) {
            $stmt = mysqli_prepare(
                $conexao,
                "INSERT INTO pontos_culturais (viagem_id, ordem, foto, categoria, titulo, descricao)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            foreach ($v['pontos'] as $i => $p) {
                $ordem = $i + 1;
                mysqli_stmt_bind_param(
                    $stmt,
                    "iissss",
                    $v['id'],
                    $ordem,
                    $p['foto'],
                    $p['categoria'],
                    $p['titulo'],
                    $p['descricao']
                );
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }

        $stmt = mysqli_prepare($conexao, "DELETE FROM impacto_topicos WHERE viagem_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $v['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if (!empty($v['impacto_topicos'])) {
            $stmt = mysqli_prepare($conexao, "INSERT INTO impacto_topicos (viagem_id, topico) VALUES (?, ?)");
            foreach ($v['impacto_topicos'] as $topico) {
                mysqli_stmt_bind_param($stmt, "is", $v['id'], $topico);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }

        mysqli_commit($conexao);
    } catch (Exception $e) {
        mysqli_rollback($conexao);
        throw $e;
    }
}

function excluirViagem($conexao, $id)
{
    mysqli_begin_transaction($conexao);

    try {
        foreach (['pontos_culturais', 'impacto_topicos'] as $tabela) {
            $stmt = mysqli_prepare($conexao, "DELETE FROM $tabela WHERE viagem_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $stmt = mysqli_prepare($conexao, "DELETE FROM viagens WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_commit($conexao);
    } catch (Exception $e) {
        mysqli_rollback($conexao);
        throw $e;
    }
}