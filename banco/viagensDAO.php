<?php
function cadastrarViagem($conexao, array $v)
{
    mysqli_begin_transaction($conexao);

    try {
        // 1) viagem principal
        $sql = "INSERT INTO viagens
                (nome, criado_por, slug, foto1, foto2, foto3, foto4, preco, dias_sugeridos,
                 melhor_epoca, descricao, impacto_positivo, impacto_foto)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssdsssss",
            $v['nome'],
            $v['criado_por'],
            $v['slug'],
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

        // 2) pontos culturais
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

function buscarViagemPorSlug($conexao, $slug){
    $sql = "SELECT * FROM viagens WHERE slug=?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $viagem = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if ($viagem) {
        // Organiza as fotos principais num array
        $viagem['fotos'] = [
            $viagem['foto1'],
            $viagem['foto2'],
            $viagem['foto3'],
            $viagem['foto4']
        ];

        // Buscar pontos culturais
        $sqlPontos = "SELECT * FROM pontos_culturais WHERE viagem_id=? ORDER BY ordem";
        $stmtPontos = mysqli_prepare($conexao, $sqlPontos);
        mysqli_stmt_bind_param($stmtPontos, "i", $viagem['id']);
        mysqli_stmt_execute($stmtPontos);
        $resultadoPontos = mysqli_stmt_get_result($stmtPontos);
        $viagem['pontos'] = mysqli_fetch_all($resultadoPontos, MYSQLI_ASSOC);
        mysqli_stmt_close($stmtPontos);

        // Buscar tópicos de impacto
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

function listarViagens($conexao, $limite = 10, $excluirId = 0)
{
    $sql = "SELECT id, nome, slug, foto1, preco, descricao FROM viagens WHERE id <> ? ORDER BY id DESC LIMIT ?";

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

function gerarSlug($texto) //é o nome da viagem, mas de forma amigável para URL, sem acentos e espaços
{
    $texto = strtolower(trim($texto));
    $texto = strtr($texto, [
        'á' => 'a',
        'à' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'é' => 'e',
        'è' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'í' => 'i',
        'ì' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ó' => 'o',
        'ò' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ú' => 'u',
        'ù' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'ç' => 'c',
    ]);
    return trim(preg_replace('/[^a-z0-9]+/', '-', $texto), '-');
}
