<?php
session_start();

$base = "../";
require_once($base . "banco/conexao.php");
require_once($base . "banco/usuariosDAO.php");
require_once($base . "banco/viagensDAO.php");
require_once($base . "banco/guiasDAO.php");

// Para onde voltar: a página onde a pessoa estava
$voltar = $_SERVER['HTTP_REFERER'] ?? ($base . 'index.php');

function exigirAdmin($voltar)
{
    if (($_SESSION['usuario_tipo'] ?? '') !== 'administrador') {
        $_SESSION['mensagem'] = "Acesso restrito a administradores.";
        header("Location: " . $voltar);
        exit();
    }
}

function exigirAdminOuGuia($voltar)
{
    if (!in_array($_SESSION['usuario_tipo'] ?? '', ['administrador', 'guia'])) {
        $_SESSION['mensagem'] = "Você não tem permissão para acessar esta página.";
        header("Location: " . $voltar);
        exit();
    }
}

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
            $_SESSION['usuario_id'] = mysqli_insert_id($conexao);
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_tipo'] = 'cliente';
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
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
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

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . $voltar);
    exit();
}

if (isset($_POST['editar_usuario'])) {
    exigirAdmin($voltar);

    $id    = (int) $_POST['usuario_id'];
    $nome  = trim($_POST['editNome']);
    $email = trim($_POST['editEmail']);
    $tipo  = $_POST['editTipo'] ?? 'cliente';
    $senha = $_POST['editSenha'] ?? '';

    if (!in_array($tipo, ['cliente', 'guia', 'administrador'])) {
        $tipo = 'cliente';
    }

    $senhaHash = ($senha !== '') ? password_hash($senha, PASSWORD_DEFAULT) : null;

    try {
        atualizarUsuario($conexao, $id, $nome, $email, $tipo, $senhaHash);
        $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
        $_SESSION['mensagem_tipo'] = 'success';
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = "Erro ao atualizar. O e-mail pode já estar em uso.";
    }

    header("Location: " . $voltar);
    exit();
}

if (isset($_POST['excluir_usuario'])) {
    exigirAdmin($voltar);

    $id = (int) $_POST['usuario_id'];

    if ($id === (int) ($_SESSION['usuario_id'] ?? 0)) {
        $_SESSION['mensagem'] = "Você não pode excluir a sua própria conta.";
        header("Location: " . $voltar);
        exit();
    }

    try {
        excluirUsuario($conexao, $id);
        $_SESSION['mensagem'] = "Usuário excluído.";
        $_SESSION['mensagem_tipo'] = 'success';
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = "Erro ao excluir o usuário.";
    }

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
    return 'imagens/viagens/' . $nome;
}

if (isset($_POST['cadastrar_viagem'])) {
    exigirAdminOuGuia($voltar);

    try {
        $usuarioTipo  = $_SESSION['usuario_tipo'] ?? 'cliente';
        // Se for Guia fica 'pendente', se for Administrador vai direto para 'aprovado'
        $statusViagem = ($usuarioTipo === 'guia') ? 'pendente' : 'aprovado';

        $pontos = [];
        for ($i = 1; $i <= 4; $i++) {
            $pontos[] = [
                'foto'      => salvarImagem("ponto{$i}_foto", $base),
                'categoria' => trim($_POST["ponto{$i}_categoria"] ?? ''),
                'titulo'    => trim($_POST["ponto{$i}_titulo"] ?? ''),
                'descricao' => trim($_POST["ponto{$i}_descricao"] ?? ''),
            ];
        }

        $topicosForm = [
            $_POST['topico1'] ?? '',
            $_POST['topico2'] ?? '',
            $_POST['topico3'] ?? '',
            $_POST['topico4'] ?? ''
        ];

        $viagem = [
            'nome'             => trim($_POST['nome_viagem']),
            'criado_por'       => $_SESSION['usuario_nome'] ?? 'Guia',
            'usuario_id'       => $_SESSION['usuario_id'] ?? null,
            'slug'             => gerarSlug($_POST['nome_viagem']),
            'status'           => $statusViagem,
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
            'impacto_positivo' => trim($_POST['impacto_positivo'] ?? ''),
            'impacto_foto'     => salvarImagem('impacto_foto', $base),
            'impacto_topicos'  => array_filter(array_map('trim', $topicosForm)),
        ];

        if ($viagem['nome'] === '') {
            $_SESSION['mensagem'] = "Informe o nome da viagem!";
            header("Location: " . $voltar);
            exit();
        }

        cadastrarViagem($conexao, $viagem);

        if ($usuarioTipo === 'guia') {
            $_SESSION['mensagem'] = "Roteiro enviado para aprovação do administrador!";
            $_SESSION['mensagem_tipo'] = 'success';
            header("Location: " . $base . "paginas/minhasviagens.php");
        } else {
            $_SESSION['mensagem'] = "Viagem cadastrada com sucesso!";
            $_SESSION['mensagem_tipo'] = 'success';
            header("Location: " . $base . "paginas/admin.php");
        }
        exit();
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao cadastrar a viagem: " . $e->getMessage();
        header("Location: " . $voltar);
        exit();
    }
}

if (isset($_POST['atualizar_viagem'])) {
    exigirAdmin($voltar);

    try {
        $id = (int) $_POST['viagem_id'];
        $viagemAntiga = buscarViagemPorId($conexao, $id);

        $manterFoto = function ($campo, $fotoAntiga) use ($base) {
            if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === UPLOAD_ERR_OK) {
                return salvarImagem($campo, $base);
            }
            return $fotoAntiga;
        };

        $topicosForm = [
            $_POST['topico1'] ?? '',
            $_POST['topico2'] ?? '',
            $_POST['topico3'] ?? '',
            $_POST['topico4'] ?? ''
        ];

        $pontos = [];
        for ($i = 1; $i <= 4; $i++) {
            $antigo = $viagemAntiga['pontos'][$i - 1] ?? [];
            $pontos[] = [
                'foto'      => $manterFoto("ponto{$i}_foto", $antigo['foto'] ?? ''),
                'categoria' => trim($_POST["ponto{$i}_categoria"] ?? ''),
                'titulo'    => trim($_POST["ponto{$i}_titulo"] ?? ''),
                'descricao' => trim($_POST["ponto{$i}_descricao"] ?? ''),
            ];
        }

        $viagem = [
            'id'               => $id,
            'nome'             => trim($_POST['nome_viagem']),
            'fotos'            => [
                $manterFoto('foto1', $viagemAntiga['foto1'] ?? ($viagemAntiga['fotos'][0] ?? '')),
                $manterFoto('foto2', $viagemAntiga['foto2'] ?? ($viagemAntiga['fotos'][1] ?? '')),
                $manterFoto('foto3', $viagemAntiga['foto3'] ?? ($viagemAntiga['fotos'][2] ?? '')),
                $manterFoto('foto4', $viagemAntiga['foto4'] ?? ($viagemAntiga['fotos'][3] ?? '')),
            ],
            'preco'            => (float) str_replace(',', '.', $_POST['preco']),
            'dias_sugeridos'   => trim($_POST['dias_sugeridos']),
            'melhor_epoca'     => trim($_POST['melhor_epoca']),
            'descricao'        => trim($_POST['descricao']),
            'impacto_positivo' => trim($_POST['impacto_positivo'] ?? ''),
            'pontos'           => $pontos,
            'impacto_foto'     => $manterFoto('impacto_foto', $viagemAntiga['impacto_foto'] ?? ''),
            'impacto_topicos'  => array_filter(array_map('trim', $topicosForm)),
        ];

        atualizarViagem($conexao, $viagem);
        $_SESSION['mensagem'] = "Viagem atualizada com sucesso!";
        $_SESSION['mensagem_tipo'] = 'success';
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao atualizar a viagem.";
    }

    header("Location: " . $base . "paginas/admin.php");
    exit();
}

if (isset($_POST['excluir_viagem'])) {
    exigirAdmin($voltar);

    try {
        $id = (int) $_POST['viagem_id'];
        $v = buscarViagemPorId($conexao, $id);

        excluirViagem($conexao, $id);

        if ($v) {
            $caminhos = [$v['foto1'] ?? '', $v['foto2'] ?? '', $v['foto3'] ?? '', $v['foto4'] ?? '', $v['impacto_foto'] ?? ''];
            if (!empty($v['pontos'])) {
                foreach ($v['pontos'] as $p) {
                    $caminhos[] = $p['foto'] ?? '';
                }
            }
            foreach ($caminhos as $c) {
                if (!empty($c) && file_exists($base . $c)) {
                    unlink($base . $c);
                }
            }
        }

        $_SESSION['mensagem'] = "Viagem excluída com sucesso!";
        $_SESSION['mensagem_tipo'] = 'success';
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao excluir a viagem.";
    }

    header("Location: " . $voltar);
    exit();
}

/* ------------- Reservas ----------- */
require_once(__DIR__ . "/../banco/reservasDAO.php");

if (isset($_POST['confirmar_reserva'])) {
    $viagemId = (int)($_POST['viagem_id'] ?? 0);
    $voltar = $_SERVER['HTTP_REFERER'] ?? ($base . 'index.php');

    if ($viagemId <= 0) {
        $_SESSION['mensagem'] = "Viagem inválida para reserva.";
        $_SESSION['mensagem_tipo'] = 'danger';
        header("Location: " . $voltar);
        exit();
    }

    $reserva = [
        'viagem_id'       => $viagemId,
        'usuario_id'      => $_SESSION['usuario_id'] ?? null,
        'ida'             => $_POST['ida'],
        'volta'           => $_POST['volta'],
        'num_pessoas'     => (int)($_POST['num_pessoas'] ?? 1),
        'num_criancas'    => (int)($_POST['num_criancas'] ?? 0),
        'idade_criancas'  => trim($_POST['idade_criancas'] ?? ''),
        'num_idosos'      => (int)($_POST['num_idosos'] ?? 0),
        'estilo_viajante' => trim($_POST['estilo_viajante'] ?? ''),
        'nome'            => trim($_POST['nome'] ?? ''),
        'cpf'             => trim($_POST['cpf'] ?? ''),
        'telefone'        => trim($_POST['telefone'] ?? ''),
        'observacoes'     => trim($_POST['observacoes'] ?? '')
    ];

    if (criarReserva($conexao, $reserva)) {
        $_SESSION['mensagem'] = "Reserva realizada com sucesso! Entraremos em contato em breve.";
        $_SESSION['mensagem_tipo'] = 'success';
    } else {
        $_SESSION['mensagem'] = "Erro ao registrar reserva. Tente novamente.";
        $_SESSION['mensagem_tipo'] = 'danger';
    }

    header("Location: " . $voltar);
    exit();
}

/*-------------- guia ---------------*/
if (isset($_POST['enviar_pedido_guia'])) {
    $usuarioId = (int) ($_SESSION['usuario_id'] ?? 0);

    if ($usuarioId === 0) {
        $_SESSION['mensagem'] = "Entre na sua conta para pedir para ser guia.";
        $_SESSION['abrir_modal'] = 'login';
        header("Location: " . $voltar);
        exit();
    }

    if (($_SESSION['usuario_tipo'] ?? 'cliente') !== 'cliente') {
        $_SESSION['mensagem'] = "Sua conta já tem acesso de guia ou administrador.";
        $_SESSION['mensagem_tipo'] = 'warning';
        header("Location: " . $voltar);
        exit();
    }

    if (buscarPedidoPendente($conexao, $usuarioId)) {
        $_SESSION['mensagem'] = "Você já tem um pedido em análise. Aguarde a resposta.";
        $_SESSION['mensagem_tipo'] = 'warning';
        header("Location: " . $voltar);
        exit();
    }

    $dados = [
        'telefone'      => trim($_POST['guiaTelefone'] ?? ''),
        'regiao'        => trim($_POST['guiaRegiao'] ?? ''),
        'especialidade' => trim($_POST['guiaEspecialidade'] ?? ''),
        'experiencia'   => trim($_POST['guiaExperiencia'] ?? ''),
    ];

    if ($dados['regiao'] === '' || $dados['especialidade'] === '' || $dados['experiencia'] === '') {
        $_SESSION['mensagem'] = "Preencha todos os campos do pedido.";
        header("Location: " . $voltar);
        exit();
    }

    try {
        criarPedidoGuia($conexao, $usuarioId, $dados);
        $_SESSION['mensagem'] = "Pedido enviado! Em breve nossa equipe vai analisar.";
        $_SESSION['mensagem_tipo'] = 'success';
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensagem'] = "Erro ao enviar o pedido. Tente novamente.";
    }

    header("Location: " . $voltar);
    exit();
}

if (isset($_POST['aprovar_pedido_guia'])) {
    exigirAdmin($voltar);

    $pedidoId = (int) ($_POST['pedido_id'] ?? 0);

    if ($pedidoId > 0 && aprovarPedidoGuia($conexao, $pedidoId)) {
        $_SESSION['mensagem'] = "Pedido aprovado! O usuário agora é um guia.";
        $_SESSION['mensagem_tipo'] = 'success';
    } else {
        $_SESSION['mensagem'] = "Não foi possível aprovar. O pedido pode já ter sido respondido.";
        $_SESSION['mensagem_tipo'] = 'danger';
    }

    header("Location: " . $voltar);
    exit();
}

if (isset($_POST['recusar_pedido_guia'])) {
    exigirAdmin($voltar);

    $pedidoId = (int) ($_POST['pedido_id'] ?? 0);

    if ($pedidoId > 0 && recusarPedidoGuia($conexao, $pedidoId)) {
        $_SESSION['mensagem'] = "Pedido recusado.";
        $_SESSION['mensagem_tipo'] = 'success';
    } else {
        $_SESSION['mensagem'] = "Não foi possível recusar. O pedido pode já ter sido respondido.";
        $_SESSION['mensagem_tipo'] = 'danger';
    }

    header("Location: " . $voltar);
    exit();
}

if (isset($_POST['aprovar_roteiro'])) {
    exigirAdmin($voltar);

    $viagemId = (int) ($_POST['viagem_id'] ?? 0);

    try {
        if ($viagemId > 0 && aprovarRoteiroViagem($conexao, $viagemId)) {
            $_SESSION['mensagem'] = "Roteiro aprovado e publicado com sucesso!";
            $_SESSION['mensagem_tipo'] = 'success';
        } else {
            $_SESSION['mensagem'] = "Erro ao aprovar roteiro.";
            $_SESSION['mensagem_tipo'] = 'danger';
        }
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao aprovar roteiro.";
        $_SESSION['mensagem_tipo'] = 'danger';
    }

    header("Location: " . $voltar);
    exit();
}

if (isset($_POST['recusar_roteiro'])) {
    exigirAdmin($voltar);

    $viagemId = (int) ($_POST['viagem_id'] ?? 0);

    try {
        if ($viagemId <= 0) {
            throw new Exception("Id inválido.");
        }

        $v = buscarViagemPorId($conexao, $viagemId);
        recusarRoteiroViagem($conexao, $viagemId);


        $_SESSION['mensagem'] = "Roteiro recusado.";
        $_SESSION['mensagem_tipo'] = 'success';
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao recusar roteiro.";
        $_SESSION['mensagem_tipo'] = 'danger';
    }

    header("Location: " . $voltar);
    exit();
}
