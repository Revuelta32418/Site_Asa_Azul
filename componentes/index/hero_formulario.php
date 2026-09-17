<section class="container-margem py-5 text-center" id="hero">
    <h1 class="fw-bold">Descubra o Brasil<br>que você ainda não conhece</h1>
    <p class="mx-auto mb-5">Voos nacionais para destinos famosos e destinos escondidos — tudo em um só lugar.</p>

    <div class="caixa rounded mx-auto">
        <p class="mx-auto text-center fw-medium text-uppercase">Busca Rápida de Voos</p>

        <form>
            <div class="opcoes gap-3">
                <div>
                    <label>Origem</label>
                    <select name="origem">
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
                    <label>Destino</label>
                    <select name="destino">
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
                    <label>Ida</label>
                    <input type="date" name="data_ida">
                </div>

                <div>
                    <label>Volta</label>
                    <input type="date" name="data_volta">
                </div>

                <div>
                    <label>Passageiros</label>
                    <select name="passageiros">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6+</option>
                    </select>
                </div>

                <div>
                    <input type="submit" value="Buscar" class="btn-buscar fw-semibold">
                </div>
            </div>

            <div class="tipo-viagem">
                <label class="opcao-radio">
                    <input type="radio" name="tipo_viagem" value="ida_volta" checked>
                    Ida e volta
                </label>
                <label class="opcao-radio">
                    <input type="radio" name="tipo_viagem" value="so_ida">
                    Somente ida
                </label>
            </div>
        </form>
    </div>
</section>