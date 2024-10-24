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
                                        <button class="btn btn btn-success" type="button" id="buscar">Buscar</i></button>
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
                            <button id="prevPage" class="btn btn-primary mr-2" style="display:none;">Anterior</button>
                            <button id="nextPage" class="btn btn-primary" style="display:none;">Proximo</button>
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
    var qtdParam = 10;
    var prilinha = null;
    var ultlinha = null;

    $(document).on('click', '.ts-acionaZoomEstab', function() {
        event.preventDefault(); 
        $("#zoomEstabModal").modal('show');
        buscarEstab(null, null, null);
    });


    function buscarEstab(buscaEstab, linhaParam, botao) {
     
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "<?php echo URLROOT ?>/cadastros/database/estab.php?operacao=buscar",
            data: {
                etbcod: buscaEstab,
                linha: linhaParam,
                qtd: qtdParam,
                botao: botao
            },
            async: false,
            success: function (msg) {
                //alert(msg)
                var json = JSON.parse(msg);
                var linha = "";
                if (json === null) {
                    $("#dadosEstab").html("Erro ao buscar");
                    return;
                }

                if (json.status === 400) {
                    alert("Nenhum estabelecimento foi encontrado");
                    $("#nextPage").hide();
                    return;
                }

                for (var $i = 0; $i < json.length; $i++) {
                    var object = json[$i];

                    linha = linha + "<tr>";
                    linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "' data-munic='" + object.munic + "'>" + object.etbcod + "</td>";
                    linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "' data-munic='" + object.munic + "'>" + object.etbnom + "</td>";
                    linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "' data-munic='" + object.munic + "'>" + object.munic + "</td>";
                    linha = linha + "</tr>";
                }
                $("#dadosEstab").html(linha);

                $("#prevPage, #nextPage").show();
                if (linhaParam == null) {
                    $("#prevPage").hide();
                }
                if (json.length < qtdParam) {
                    $("#nextPage").hide();
                }

                if (json.length > 0) {
                    prilinha = json[0].linha;
                    ultlinha = json[json.length - 1].linha;
                }
                if (json[0].prilinha == 1) {
                    prilinha = null;
                    $("#prevPage").hide();
                }
            }
        });
    }
    $("#buscar").click(function () {
        buscarEstab($("#buscaEstab").val(), null, null);
    })

    document.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            buscarEstab($("#buscaEstab").val(), null, null);
        }
    });

    $("#prevPage").click(function () {
        buscarEstab($("#buscaEstab").val(), prilinha, "prev");
    });

    $("#nextPage").click(function () {
        buscarEstab($("#buscaEstab").val(), ultlinha, "next");
    });

</script>


<!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>