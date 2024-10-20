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
    var paginaZoomEstab = 0;

    $(document).on('click', '.ts-acionaZoomEstab', function() {
        event.preventDefault(); 
        $("#zoomEstabModal").modal('show');
        buscarEstab(null, 0);
    });


    function buscarEstab(buscaEstab, paginaZoomEstab) {
     
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "<?php echo URLROOT ?>/cadastros/database/estab.php?operacao=buscar",
            beforeSend: function () {
                $("#dadosEstab").html("Carregando...");
            },
            data: {
                etbcod: buscaEstab,
                pagina: paginaZoomEstab
            },
            async: false,
            success: function (msg) {
                //alert(msg)
                var json = JSON.parse(msg);
                var linha = "";
                if (json === null) {
                        $("#dadosEstab").html("Erro ao buscar");
                } 
                if (json.status === 400) {
                        $("#dadosEstab").html("Nenhum estabelecimento foi encontrado");
                } else {
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
                    if (paginaZoomEstab == 0) {
                        $("#prevPage").hide();
                    }
                    if (json.length < 10) {
                        $("#nextPage").hide();
                    }
                }
            }
        });
    }
    $("#buscar").click(function () {
        paginaZoomEstab = 0;
        buscarEstab($("#buscaEstab").val(), 0);
    })

    document.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            paginaZoomEstab = 0;
            buscarEstab($("#buscaEstab").val(), 0);
        }
    });

    $("#prevPage").click(function () {
        if (paginaZoomEstab > 0) {
            paginaZoomEstab -= 10;
            buscarEstab($("#buscaEstab").val(), paginaZoomEstab);
        }
    });

    $("#nextPage").click(function () {
        paginaZoomEstab += 10;
        buscarEstab($("#buscaEstab").val(), paginaZoomEstab);
    });

</script>


<!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>