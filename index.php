<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asa Azul</title>
    <link rel="shortcut icon" href="imagens/arara_com_circulo.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/estilogeral.css">
    <link rel="stylesheet" type="text/css" href="css/estiloindex.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!--Icones: https://icons.getbootstrap.com/*/-->
</head>

<body>
    <?php
    $base = ''; //aqui, definimos o caminho até a origem da pasta, isso altera para cada arquivo
    $nav = "passagens";
    
    if (file_exists('componentes/header.php')) {
        include 'componentes/header.php';
    }

    if (file_exists('componentes/modallogin.php')) {
        include 'componentes/modallogin.php';
    }
    ?>

    <!-------------Hero Formulário----------------->
    <main>
        <section class="container-margem" id="hero">
            <h1>Descubra o Brasil<br>que você ainda não conhece</h1>
            <p>Voos nacionais para destinos famosos e destinos escondidos — tudo em um só lugar.</p>

            <div style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.25);
                border-radius:14px; padding:1.75rem 2rem; max-width:800px; margin:0 auto;">
                <p style="font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; color:rgba(255,255,255,0.7);
                 font-weight:600; margin-bottom:1rem;">Busca Rápida de Voos</p>

                <form method="GET" action="#">
                    <div
                        style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr auto; gap:0.75rem; align-items:end;">

                        <div>
                            <label
                                style="color:rgba(255,255,255,0.85); font-size:0.8rem; font-weight:600;">Origem</label>
                            <select name="origem"
                                style="background:rgba(255,255,255,0.95); color:#1E293B; border:none;">
                                <option value="">Selecione a cidade</option>
                                <option value="GRU">São Paulo (GRU)</option>
                                <option value="SDU">Rio de Janeiro (SDU)</option>
                                <option value="BSB">Brasília (BSB)</option>
                                <option value="FOR">Fortaleza (FOR)</option>
                                <option value="SSA">Salvador (SSA)</option>
                                <option value="BEL">Belém (BEL)</option>
                                <option value="CWB">Curitiba (CWB)</option>
                                <option value="MCP">Macapá (MCP)</option>
                            </select>
                        </div>

                        <div>
                            <label
                                style="color:rgba(255,255,255,0.85); font-size:0.8rem; font-weight:600;">Destino</label>
                            <select name="destino"
                                style="background:rgba(255,255,255,0.95); color:#1E293B; border:none;">
                                <option value="">Selecione o destino</option>
                                <option value="MAO">Manaus (MAO)</option>
                                <option value="NAT">Natal (NAT)</option>
                                <option value="FLN">Florianópolis (FLN)</option>
                                <option value="CGR">Campo Grande (CGR)</option>
                                <option value="PMW">Palmas (PMW)</option>
                                <option value="MCP">Macapá (MCP)</option>
                                <option value="PVH">Porto Velho (PVH)</option>
                                <option value="CGB">Cuiabá (CGB)</option>
                                <option value="THE">Teresina (THE)</option>
                            </select>
                        </div>

                        <div>
                            <label style="color:rgba(255,255,255,0.85); font-size:0.8rem; font-weight:600;">Ida</label>
                            <input type="date" name="data_ida"
                                style="background:rgba(255,255,255,0.95); color:#1E293B; border:none;">
                        </div>

                        <div>
                            <label
                                style="color:rgba(255,255,255,0.85); font-size:0.8rem; font-weight:600;">Volta</label>
                            <input type="date" name="data_volta"
                                style="background:rgba(255,255,255,0.95); color:#1E293B; border:none;">
                        </div>

                        <div>
                            <input type="submit" value="Buscar" style="background:#F9A825; color:#0D3B6E; font-weight:700;
                   padding:0.62rem 1.4rem; border-radius:7px; border:none; cursor:pointer; font-size:0.9rem;
                   font-family:'Montserrat',sans-serif; white-space:nowrap;">
                        </div>
                    </div>

                    <div style="display:flex; gap:1.5rem; margin-top:1rem; flex-wrap:wrap;">
                        <label
                            style="display:flex; align-items:center; gap:0.4rem; color:rgba(255,255,255,0.85); font-size:0.85rem; margin:0; font-weight:400; cursor:pointer;">
                            <input type="radio" name="tipo_viagem" value="ida_volta" checked
                                style="accent-color:#F9A825; width:16px; height:16px;">
                            Ida e volta
                        </label>
                        <label
                            style="display:flex; align-items:center; gap:0.4rem; color:rgba(255,255,255,0.85); font-size:0.85rem; margin:0; font-weight:400; cursor:pointer;">
                            <input type="radio" name="tipo_viagem" value="so_ida"
                                style="accent-color:#F9A825; width:16px; height:16px;">
                            Somente ida
                        </label>
                        <div style="display:flex; align-items:center; gap:0.6rem; margin-left:auto;">
                            <label
                                style="color:rgba(255,255,255,0.85); font-size:0.85rem; margin:0; font-weight:400;">Passageiros:</label>
                            <select name="passageiros"
                                style="background:rgba(255,255,255,0.95); color:#1E293B; border:none; width:70px; padding:0.35rem 0.5rem;">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6+</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!------Galeria 3 fotos (travando)----->
        <section id="galeria" class="container-margem  justify-content-center d-flex my-4">
            <div class="galeria">

                <div class="cardGaleria">
                    <img src="imagens/rio_de_janeiro.jpg" alt="Paisagem">
                    <div class="info">
                        <h2>Rio de Janeiro</h2>
                        <p>Conheça praias famosas, o Cristo Redentor
                            e uma das cidades mais bonitas do Brasil.</p>
                    </div>
                </div>

                <div class="cardGaleria">
                    <img src="imagens/florianopolis.jpg" alt="Paisagem">
                    <div class="info">
                        <h2>Florianópolis</h2>
                        <p>Descubra praias paradisíacas, gastronomia
                            e muita natureza.</p>
                    </div>
                </div>

                <div class="cardGaleria">
                    <img src="imagens/porto-seguro.png" alt="Paisagem">
                    <div class="info">
                        <h2>Porto Seguro</h2>
                        <p>História, cultura e praias incríveis para
                            toda a família.</p>
                    </div>
                </div>

            </div>
        </section>

        <!-------Top 4 viagens------->
        <section id="top" class="container-margem">
            <h2 class="titulo">Top 4 viagens preferidas da galera</h2>
            <div class="galeriaTop">

                <div class="cardTop">
                    <img src="imagens/foto5.jpg" alt="Viagem em destaque">
                </div>

                <div class="cardTop">
                    <img src="imagens/foto6.jpg" alt="Viagem em destaque">
                </div>

                <div class="cardTop">
                    <img src="imagens/foto7.jpg" alt="Viagem em destaque">
                </div>

                <div class="cardTop">
                    <img src="imagens/foto8.jpg" alt="Viagem em destaque">
                </div>

            </div>
        </section>

        
        

        <?php
        if(file_exists('componentes/carrossel.php')){
            include 'componentes/carrossel.php';
        }

        if (file_exists('componentes/faq.php')) {
            include 'componentes/faq.php';
        }
        ?>
    </main>

    <?php
    if (file_exists('componentes/footer.php')) {
        include 'componentes/footer.php';
    }
    ?>

    <script src="js/bootstrap.js"></script>
    <script src="js/jsindex.js"></script>
    <script src="js/jsgeral.js"></script>
</body>

</html>