<!--------- MODAL --------->
<div class="modal" id="zoomEstabModal" tabindex="-1" role="dialog" aria-labelledby="zoomEstabModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Busca Estabelecimentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 d-flex gap-2">
                                    <input type="text" placeholder="Digite o codigo do estabelecimento"
                                        class="form-control ts-input" id="buscaEstab" name="buscaEstab">
                                        <button class="btn btn btn-success" type="button" id="buscarETB">Buscar</i></button>
                                </div>
                            </div>

                        </div>
                        <div class="container-fluid mb-2">
                            <div class="table mt-4 ts-tableFiltros text-center">
                                <table class="table table-sm table-hover ts-tablecenter">
                                    <thead class="ts-headertabelafixo">
                                        <tr class="ts-headerTabelaLinhaCima">
                                            <th>etbcod</th>
                                            <th>Nome</th>
                                            <th>Municipio</th>
                                        </tr>
                                    </thead>

                                    <tbody id='dadosEstab' class="fonteCorpo">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container text-center my-1">
                            <button id="etbPrevPage" class="btn btn-primary mr-2" style="display:none;">Anterior</button>
                            <button id="etbNextPage" class="btn btn-primary" style="display:none;">Proximo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- LOCAL PARA COLOCAR OS JS -->

<?php include_once ROOT . "/vendor/footer_js.php"; ?>

<script>  
    var etbqtdParam = 10;
    var etbprilinha = null;
    var etbultlinha = null;

    $(document).on('click', '.ts-acionaZoomEstab', function() {
        event.preventDefault(); 
        $("#zoomEstabModal").modal('show');
        buscarEstab(null, null, null);
    });


    function buscarEstab(buscaEstab, etblinhaParam, etbbotao) {
     
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "<?php echo URLROOT ?>/cadastros/database/estab.php?operacao=buscar",
            data: {
                etbcod: buscaEstab,
                linha: etblinhaParam,
                qtd: etbqtdParam,
                botao: etbbotao
            },
            async: false,
            success: function (msg) {
                //alert(msg)
                var json = JSON.parse(msg);
                if (json === null) {
                    $("#dadosEstab").html("Erro ao buscar");
                    return;
                }
                if (json.status === 400) {
                    alert("Nenhum estabelecimento foi encontrado");
                    $("#etbNextPage").hide();
                    return;
                }
                var estab = json.estab;
                var linha = "";
                for (var $i = 0; $i < estab.length; $i++) {
                    var object = estab[$i];

                    linha = linha + "<tr>";
                    linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "' data-munic='" + object.munic + "'>" + object.etbcod + "</td>";
                    linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "' data-munic='" + object.munic + "'>" + object.etbnom + "</td>";
                    linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "' data-munic='" + object.munic + "'>" + object.munic + "</td>";
                    linha = linha + "</tr>";
                }
                $("#dadosEstab").html(linha);

                $("#etbPrevPage, #etbNextPage").show();
                etbprilinha = estab[0].linha;
                etbultlinha = estab[estab.length - 1].linha;

                if (etblinhaParam == null) {
                    $("#etbPrevPage").hide();
                }
                if (estab.length < etbqtdParam) {
                    $("#etbNextPage").hide();
                }
                
                if (etbprilinha == 1) {
                    etbprilinha = null;
                    $("#etbPrevPage").hide();
                }
            }
        });
    }

    $("#buscarETB").click(function () {
        buscarEstab($("#buscaEstab").val(), null, null);
    })

    /*
    document.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            buscarEstab($("#buscaEstab").val(), null, null);
        }
    }); */

    $("#etbPrevPage").click(function () {
        buscarEstab($("#buscaEstab").val(), etbultlinha, "prev");
    });

    $("#etbNextPage").click(function () {
        buscarEstab($("#buscaEstab").val(), etbultlinha, "next");
    });

</script>


<!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>