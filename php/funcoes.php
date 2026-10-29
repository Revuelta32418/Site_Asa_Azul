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
            $_SESSION['usuario_id'] = mysqli_insert_id($conexao);
            $_SESSION['usuario_nome'] = $nome;
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

    $id    = (int) $_POST['usuario_id'];
    $nome  = trim($_POST['editNome']);
    $email = trim($_POST['editEmail']);
    $tipo  = $_POST['editTipo'];
    $senha = $_POST['editSenha'];

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

    $id = (int) $_POST['usuario_id'];

    // proteção no servidor: o botão escondido não basta
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

        $topicosForm = [
            $_POST['topico1'] ?? '',
            $_POST['topico2'] ?? '',
            $_POST['topico3'] ?? '',
            $_POST['topico4'] ?? ''
        ];

        $viagem = [
            'nome'             => trim($_POST['nome_viagem']),
            'criado_por'       => $_SESSION['usuario_nome'] ?? null,
            'slug'             => gerarSlug($_POST['nome_viagem']),
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
            'impacto_topicos'  => array_filter(array_map('trim', $topicosForm)),
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

if (isset($_POST['atualizar_viagem'])) {
    try {
        $id = (int) $_POST['viagem_id'];
        $viagemAntiga = buscarViagemPorId($conexao, $id);

        // Se enviou foto nova, salva e usa o caminho novo.
        // Se não enviou, mantém a foto que já estava cadastrada.
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
                $manterFoto('foto1', $viagemAntiga['foto1'] ?? ''),
                $manterFoto('foto2', $viagemAntiga['foto2'] ?? ''),
                $manterFoto('foto3', $viagemAntiga['foto3'] ?? ''),
                $manterFoto('foto4', $viagemAntiga['foto4'] ?? ''),
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

    try {
        $id = (int) $_POST['viagem_id'];
        $v = buscarViagemPorId($conexao, $id);

        excluirViagem($conexao, $id);

        // só apaga os arquivos depois que o banco confirmou a exclusão
        if ($v) {
            $caminhos = [$v['foto1'], $v['foto2'], $v['foto3'], $v['foto4'], $v['impacto_foto']];
            foreach ($v['pontos'] as $p) {
                $caminhos[] = $p['foto'];
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

// Lógica de Processamento de Reserva
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