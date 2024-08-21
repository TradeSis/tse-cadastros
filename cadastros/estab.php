<?php
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once (__DIR__ . '/../header.php');

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">

        <div class="row ">
            <BR> <!--MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR> BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-6 col-lg-6">
                <h2 class="ts-tituloPrincipal">Estabelecimentos</h2>
            </div>

            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" placeholder="Digite o codigo da filial" class="form-control ts-input"
                        id="buscaEstab" name="buscaEstab">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i
                            class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#inserirEstabModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-tableFiltros text-center">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Cod.</th>
                        <th>Nome</th>
                        <th>Municipio</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>


        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirEstabModal" tabindex="-1"
            aria-labelledby="inserirEstabModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Estab</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirEstab">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label class="form-label ts-label">etbcod</label>
                                            <input type="number" class="form-control ts-input" name="etbcod">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label ts-label">etbnom</label>
                                            <input type="text" class="form-control ts-input" name="etbnom">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">munic</label>
                                            <input type="text" class="form-control ts-input" name="munic">
                                        </div>
                                    </div><!--fim row 1-->
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn-formInserir">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarEstabModal" tabindex="-1"
            aria-labelledby="alterarEstabModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Estab</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarEstab">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label class="form-label ts-label">etbcod</label>
                                            <input type="number" class="form-control ts-input" readonly name="etbcod" id="etbcod">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label ts-label">etbnom</label>
                                            <input type="text" class="form-control ts-input" id="etbnom" name="etbnom">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">munic</label>
                                            <input type="text" class="form-control ts-input" name="munic" id="munic">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">supcod</label>
                                            <input type="text" class="form-control ts-input" name="supcod" id="supcod">
                                        </div>
                                    </div><!--fim row 1-->
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!--container-fluid-->
    <div class="container text-center my-1">
        <button id="prevPage" class="btn btn-primary mr-2" style="display:none;">Anterior</button>
        <button id="nextPage" class="btn btn-primary" style="display:none;">Proximo</button>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>

        var pagina = 0;

        buscar();

        function limpar() {
            buscar(null);
            window.location.reload();
        }

        function buscar(buscaEstab, pagina) {
            //alert (buscaEstab);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: "<?php echo URLROOT ?>/cadastros/database/estab.php?operacao=buscar",
                beforeSend: function () {
                    $("#dados").html("Carregando...");
                },
                data: {
                    etbcod: buscaEstab,
                    pagina: pagina,
                },
                async: false,
                success: function (msg) {
                    //console.log(msg);
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        linha = linha + "<tr>";
                        linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "'>" + object.etbcod + "</td>";
                        linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "'>" + object.etbnom + "</td>";
                        linha = linha + "<td class='ts-click' data-etbcod='" + object.etbcod + "'>" + object.munic + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarEstabModal' data-etbcod='" + object.etbcod + "'><i class='bi bi-pencil-square'></i></button> " + "</td>";
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);

                    $("#prevPage, #nextPage").show();
                    if (pagina == 0) {
                        $("#prevPage").hide();
                    }
                    if (json.length < 10) {
                        $("#nextPage").hide();
                    }
                }
            });
        }
        $("#buscar").click(function () {
            buscar($("#buscaEstab").val(), pagina);
        })

        document.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                buscar($("#buscaEstab").val(), pagina);
            }
        });

        $("#prevPage").click(function () {
            if (pagina > 0) {
                pagina -= 10;
                buscar($("#buscaEstab").val(), pagina);
            }
        });

        $("#nextPage").click(function () {
            pagina += 10;
            buscar($("#buscaEstab").val(), pagina);
        });

        $(document).on('click', 'button[data-bs-target="#alterarEstabModal"]', function () {
            var etbcod = $(this).attr("data-etbcod");
            //alert(etbcod)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/estab.php?operacao=buscar',
                data: {
                    etbcod: etbcod
                },
                success: function (data) {
                    var estab = data[0];
                    $('#etbcod').val(estab.etbcod);
                    $('#etbnom').val(estab.etbnom);
                    $('#munic').val(estab.munic);
                    $('#supcod').val(estab.supcod);

                    $('#alterarEstabModal').modal('show');
                }
            });
        });


        $(document).ready(function () {
            $("#form-inserirEstab").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/estab.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-alterarEstab").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/estab.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            function refreshPage() {
                window.location.reload();
            }

        });

    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>