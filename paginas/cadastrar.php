<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul | Cadastrar Viagem</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilogeral.css">
    <link rel="stylesheet" href="../css/estilocadastrar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    $base = '../';

    if (file_exists('../componentes/header.php')) {
        $hideHeader = true;
        include '../componentes/header.php';
    }
    ?>

    <main>
        <section class="container-margem pagina-cadastro">
            <h1 class="titulo">Cadastrar Viagem</h1>

            <form class="form-cadastro mx-auto rounded-4 p-5" method="POST" action="BDviagem.php" enctype="multipart/form-data">

                <div class="bloco-form">
                    <h2>Nome da viagem</h2>
                    <div class="campo-grupo">
                        <input type="text" name="nome_viagem" id="nome_viagem" placeholder="Ex: Rio de Janeiro" required>
                    </div>
                </div>

                <!-- Fotos da viagem -->
                <div class="bloco-form">
                    <h2>4 principais fotos da viagem</h2>
                    <div class="grid-fotos">
                        <div class="campo-foto">
                            <label for="foto1">Foto 1</label>
                            <input type="file" name="foto1" id="foto1" accept="image/*" required>
                        </div>
                        <div class="campo-foto">
                            <label for="foto2">Foto 2</label>
                            <input type="file" name="foto2" id="foto2" accept="image/*">
                        </div>
                        <div class="campo-foto">
                            <label for="foto3">Foto 3</label>
                            <input type="file" name="foto3" id="foto3" accept="image/*">
                        </div>
                        <div class="campo-foto">
                            <label for="foto4">Foto 4</label>
                            <input type="file" name="foto4" id="foto4" accept="image/*">
                        </div>
                    </div>
                </div>

                <!-- Preço, dias, época -->
                <div class="bloco-form">
                    <h2>Preço, dias e época</h2>
                    <div class="linha-3">
                        <div class="campo-grupo">
                            <label for="preco">Preço (R$)</label>
                            <input type="number" step="0.01" name="preco" id="preco" placeholder="Ex: 890.00" required>
                        </div>
                        <div class="campo-grupo">
                            <label for="dias_sugeridos">Dias sugeridos</label>
                            <input type="number" name="dias_sugeridos" id="dias_sugeridos" placeholder="Ex: 4">
                        </div>
                        <div class="campo-grupo">
                            <label for="melhor_epoca">Melhor época</label>
                            <input type="text" name="melhor_epoca" id="melhor_epoca" placeholder="Ex: Set a Mar">
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="bloco-form">
                    <h2>Descrição da viagem</h2>
                    <div class="campo-grupo">
                        <label for="descricao">Texto de apresentação</label>
                        <textarea name="descricao" id="descricao" placeholder="Descreva o destino, o que o torna especial..."></textarea>
                    </div>
                </div>

                <!-- Turistando -->
                <div class="bloco-form">
                    <h2 class="mb-3">Turistando</h2>

                    <div class="grid-turistando">

                        <div class="card-turistando-form">
                            <span class="card-turistando-numero">1</span>

                            <div class="campo-grupo">
                                <label for="ponto1_foto">Foto</label>
                                <input type="file" name="ponto1_foto" id="ponto1_foto" accept="image/*">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto1_categoria">Categoria</label>
                                <select name="ponto1_categoria" id="ponto1_categoria">
                                    <option value="historico">Patrimônio histórico</option>
                                    <option value="musical">Tradição musical</option>
                                    <option value="artesanato">Artesanato local</option>
                                    <option value="gastronomia">Gastronomia</option>
                                    <option value="natureza">Natureza</option>
                                    <option value="espiritualidade">Espiritualidade</option>
                                </select>
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto1_titulo">Título</label>
                                <input type="text" name="ponto1_titulo" id="ponto1_titulo" placeholder="Ex: Cristo Redentor">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto1_descricao">Descrição curta</label>
                                <textarea name="ponto1_descricao" id="ponto1_descricao" placeholder="Uma frase sobre esse ponto..." class="textarea-pequena"></textarea>
                            </div>
                        </div>

                        <div class="card-turistando-form">
                            <span class="card-turistando-numero">2</span>

                            <div class="campo-grupo">
                                <label for="ponto2_foto">Foto</label>
                                <input type="file" name="ponto2_foto" id="ponto2_foto" accept="image/*">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto2_categoria">Categoria</label>
                                <select name="ponto2_categoria" id="ponto2_categoria">
                                    <option value="historico">Patrimônio histórico</option>
                                    <option value="musical">Tradição musical</option>
                                    <option value="artesanato">Artesanato local</option>
                                    <option value="gastronomia">Gastronomia</option>
                                    <option value="natureza">Natureza</option>
                                    <option value="espiritualidade">Espiritualidade</option>
                                </select>
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto2_titulo">Título</label>
                                <input type="text" name="ponto2_titulo" id="ponto2_titulo" placeholder="Ex: Rodas de samba na Lapa">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto2_descricao">Descrição curta</label>
                                <textarea name="ponto2_descricao" id="ponto2_descricao" placeholder="Uma frase sobre esse ponto..." class="textarea-pequena"></textarea>
                            </div>
                        </div>

                        <div class="card-turistando-form">
                            <span class="card-turistando-numero">3</span>

                            <div class="campo-grupo">
                                <label for="ponto3_foto">Foto</label>
                                <input type="file" name="ponto3_foto" id="ponto3_foto" accept="image/*">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto3_categoria">Categoria</label>
                                <select name="ponto3_categoria" id="ponto3_categoria">
                                    <option value="historico">Patrimônio histórico</option>
                                    <option value="musical">Tradição musical</option>
                                    <option value="artesanato">Artesanato local</option>
                                    <option value="gastronomia">Gastronomia</option>
                                    <option value="natureza">Natureza</option>
                                    <option value="espiritualidade">Espiritualidade</option>
                                </select>
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto3_titulo">Título</label>
                                <input type="text" name="ponto3_titulo" id="ponto3_titulo" placeholder="Ex: Feira de Ipanema">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto3_descricao">Descrição curta</label>
                                <textarea name="ponto3_descricao" id="ponto3_descricao" placeholder="Uma frase sobre esse ponto..." class="textarea-pequena"></textarea>
                            </div>
                        </div>

                        <div class="card-turistando-form">
                            <span class="card-turistando-numero">4</span>

                            <div class="campo-grupo">
                                <label for="ponto4_foto">Foto</label>
                                <input type="file" name="ponto4_foto" id="ponto4_foto" accept="image/*">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto4_categoria">Categoria</label>
                                <select name="ponto4_categoria" id="ponto4_categoria">
                                    <option value="historico">Patrimônio histórico</option>
                                    <option value="musical">Tradição musical</option>
                                    <option value="artesanato">Artesanato local</option>
                                    <option value="gastronomia">Gastronomia</option>
                                    <option value="natureza">Natureza</option>
                                    <option value="espiritualidade">Espiritualidade</option>
                                </select>
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto4_titulo">Título</label>
                                <input type="text" name="ponto4_titulo" id="ponto4_titulo" placeholder="Ex: Culinária carioca">
                            </div>

                            <div class="campo-grupo">
                                <label for="ponto4_descricao">Descrição curta</label>
                                <textarea name="ponto4_descricao" id="ponto4_descricao" placeholder="Uma frase sobre esse ponto..." class="textarea-pequena"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bloco-form">
                    <h2>Impacto Positivo</h2>
                    <div class="campo-grupo">
                        <label for="impacto_positivo">Texto de impacto positivo</label>
                        <textarea name="impacto_positivo" id="impacto_positivo" placeholder="Descreva como essa viagem contribui para a comunidade local, preservação ambiental ou outros aspectos positivos..."></textarea>
                    </div>
                    <div class="campo-grupo">
                        <label for="impacto_foto">Foto de impacto positivo</label>
                        <input type="file" name="impacto_foto" id="impacto_foto" accept="image/*">
                    </div>
                    <div class="campo-grupo topicos">
                        <label for="todos-topicos">Tópicos de impacto positivo</label>
                        <div id="todos-topicos">
                            <input type="text" name="topico1" id="topico1" placeholder="Ex: Parceria com artesãos da Feira de Ipanema" required>
                            <input type="text" name="topico2" id="topico2" placeholder="Ex: Guias locais especializados em história carioca" required>
                            <input type="text" name="topico3" id="topico3">
                            <input type="text" name="topico4" id="topico4">
                        </div>
                    </div>
                </div>

                <div class="form-cadastro-acoes">
                    <button type="submit" class="btn-cadastro" name="cadastrar_viagem">
                        Cadastrar viagem
                    </button>
                </div>
            </form>
        </section>
    </main>

    <?php
    if (file_exists('../../componentes/footer.php')) {
        include '../../componentes/footer.php';
    }
    ?>

</body>

</html>