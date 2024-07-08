<?php
//Lucas 27122023 - id747 cadastros, alterado estrutura do programa
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/marcas.php');
$marcas = buscaMarcas();
//echo json_encode($marcas);

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>


<body>
    <div class="container-fluid">

        <div class="row ">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR> BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-3 col-lg-3">
                <h2 class="ts-tituloPrincipal">Produtos</h2>
            </div>

            <div class="col-3">
                <form id="form-atualizaFornecimento" method="post">
                    <div class="col-md-3">
                        <input type="hidden" class="form-control ts-input" name="idFornecimento"  value="null">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning" id="atualizaFornecimento-btn">Atualizar Produtos
                        <span class="spinner-border-sm span-load"  role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaProduto" placeholder="Buscar por nome ou eanProduto">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirPessoaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>ID</th>
                        <th>eanProduto</th>
                        <th>nomeProduto</th>
                        <th>Marca</th>
                        <th>Imendes</th>
                        <th>idGrupo</th>
                        <th>nomeGrupo</th>
                        <th>prodZFM</th>
                        <th>Att trib.</th>
                        <th colspan="2">AÃ§Ã£o</th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>

        <!--------- VISUALIZAR FORNECIMENTO --------->
        <div class="modal fade bd-example-modal-lg" id="visualizarFornecedorModal" tabindex="-1" aria-labelledby="visualizarFornecedorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Fornecimento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md">
                                <label class="form-label ts-label">Cnpj</label>
                                <input type="text" class="form-control ts-input" name="Cnpj" id="viewForn_Cnpj" disabled>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">Fornecedor</label>
                                <input type="text" class="form-control ts-input" name="nomePessoa" id="viewForn_nomePessoa" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <label class="form-label ts-label">IdGeralProduto</label>
                                <input type="text" class="form-control ts-input" name="idGeralProduto" id="viewForn_idGeralProdutoFOR" disabled>
                                <input type="hidden" class="form-control ts-input" name="idFornecimento" id="viewForn_idFornecimento">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">Produto</label>
                                <input type="text" class="form-control ts-input" name="nomeProduto" id="viewForn_nomeProdutoFOR" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">refProduto</label>
                                <input type="text" class="form-control ts-input" name="refProduto" id="viewForn_refProdutoFOR" disabled>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">eanProduto</label>
                                <input type="text" class="form-control ts-input" name="eanProduto" id="viewForn_eanProdutoFOR" disabled>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">valorCompra</label>
                                <input type="text" class="form-control ts-input" name="valorCompra" id="viewForn_valorCompra" disabled>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">Att Trib.</label>
                                <input type="text" class="form-control ts-input" name="dataAtualizacaoTributaria" id="viewForn_dataAtualizacaoTributaria" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">Origem</label>
                                <select class="form-select ts-input ts-displayDisable" name="origem" id="viewForn_origem">
                                    <option value="0">0 - Nacional, exceto as indicadas nos códigos 3 a 5</option>
                                    <option value="1">1 - Estrangeira - Importação direta, exceto a indicada no código 6</option>
                                    <option value="2">2- Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
                                    <option value="3" title="mercadoria ou bem com Conteúdo de Importação superior a 40%">3 - Nacional, superior a 40%..</option>
                                    <option value="4" title="cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o
Decreto-Lei no 288/1967 , e as Leis nos 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007">4 - Nacional, processos produtivos</option>
                                    <option value="5" title="mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%">5 - Nacional, inferior ou igual a 40%</option>
                                    <option value="6" title="Importação direta, sem similar nacional, constante em lista de Resolução Camex e gás natural">6- Estrangeira - Importação direta</option>
                                    <option value="7" title="Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução Camex
e gás natural">7 - Estrangeira - Adquirida no mercado interno</option>
                                    <option value="8" title="mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)">8 - Nacional, superior a 70% (setenta por cento)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label ts-label">cfop</label>
                                <input type="text" class="form-control ts-input" name="cfop" id="viewForn_cfop" disabled>
                            </div>
                        </div>
                    </div><!--body-->

                </div>
            </div>
        </div>

        <!--------- VISUALIZAR PRODUTO --------->
        <div class="modal fade bd-example-modal-lg" id="visualizarProdutoModal" tabindex="-1" aria-labelledby="visualizarProdutoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Produto: <span id=txtnomeproduto></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <form method="post" action="../database/produtos.php?operacao=alterar"> <!-- id="form-alterarProdutos" -->
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label ts-label">idProduto</label>
                                    <input type="text" class="form-control ts-input" name="idProduto" id="viewProd_idProduto" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label ts-label">idGeralProduto</label>
                                    <input type="text" class="form-control ts-input" name="idGeralProduto" id="viewProd_idGeralProduto" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label ts-label">eanProduto</label>
                                    <input type="text" class="form-control ts-input" name="eanProduto" id="viewProd_eanProduto" readonly>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label ts-label">nomeProduto</label>
                                    <input type="text" class="form-control ts-input" name="nomeProduto" id="viewProd_nomeProduto" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <label class="form-label ts-label">valorCompra</label>
                                    <input type="text" class="form-control ts-input" name="valorCompra" id="viewProd_valorCompra" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label ts-label">idFornecedor</label>
                                    <input type="text" class="form-control ts-input" name="idPessoaFornecedor" id="viewProd_idPessoaFornecedor" readonly>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoNcm</label>
                                    <input type="text" class="form-control ts-input" name="codigoNcm" id="viewProd_codigoNcm"readonly>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoCest</label>
                                    <input type="text" class="form-control ts-input" name="codigoCest" id="viewProd_codigoCest" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">refProduto</label>
                                    <input type="text" class="form-control ts-input" name="refProduto" id="viewProd_refProduto" readonly>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">dataAtualizacaoTributaria</label>
                                    <input type="textw" class="form-control ts-input" name="dataAtualizacaoTributaria" id="viewProd_dataAtualizacaoTributaria" readonly>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codImendes</label>
                                    <input type="text" class="form-control ts-input" name="codImendes" id="viewProd_codImendes" readonly>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">idGrupo</label>
                                    <input type="text" class="form-control ts-input" name="idGrupo" id="viewProd_idGrupo" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">substICMSempresa</label>
                                    <input type="text" class="form-control ts-input" name="substICMSempresa" id="viewProd_substICMSempresa" readonly>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">substICMSFornecedor</label>
                                    <input type="text" class="form-control ts-input" name="substICMSFornecedor" id="viewProd_substICMSFornecedor" readonly>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">prodZFM</label>
                                    <input type="text" class="form-control ts-input" name="prodZFM" id="viewProd_prodZFM" readonly>
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <div class="col align-self-start pl-0">
                            <button type='button' class='btn btn-warning' id="btnatualizaproduto" data-bs-toggle='modal' data-bs-target='#atualizaFornecedorModal' data-id="idFornecedorAtualiza">Atualizar Produto</button>
                        </div>
                       
                        <button type="button" class="btn btn-warning" id="btnalterar">Alterar</button>
                        <div id="btnauxiliares" style="display: none;">
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <button type="button" class="btn btn-danger" id="btncancelar">Cancelar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirPessoaModal" tabindex="-1" aria-labelledby="inserirPessoaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Produtos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirProdutos">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label ts-label">eanProduto</label>
                                    <input type="text" class="form-control ts-input" name="eanProduto">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label ts-label">nomeProduto</label>
                                    <input type="text" class="form-control ts-input" name="nomeProduto">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label ts-label">valorCompra</label>
                                    <input type="text" class="form-control ts-input" name="valorCompra">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoNcm</label>
                                    <input type="text" class="form-control ts-input" name="codigoNcm">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoCest</label>
                                    <input type="text" class="form-control ts-input" name="codigoCest">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">idPessoaFornecedor</label>
                                    <input type="text" class="form-control ts-input" name="idPessoaFornecedor">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">refProduto</label>
                                    <input type="text" class="form-control ts-input" name="refProduto">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">dataAtualizacaoTributaria</label>
                                    <input type="datetime-local" class="form-control ts-input" name="dataAtualizacaoTributaria">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codImendes</label>
                                    <input type="text" class="form-control ts-input" name="codImendes">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoGrupo</label>
                                    <input type="text" class="form-control ts-input" name="codigoGrupo">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">substICMSempresa</label>
                                    <input type="text" class="form-control ts-input" name="substICMSempresa">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">substICMSFornecedor</label>
                                    <input type="text" class="form-control ts-input" name="substICMSFornecedor">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">prodZFM</label>
                                    <input type="text" class="form-control ts-input" name="prodZFM">
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarProdutoModal" tabindex="-1" aria-labelledby="alterarProdutoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarProdutos">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label ts-label">eanProduto</label>
                                    <input type="text" class="form-control ts-input" name="eanProduto" id="eanProduto">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label ts-label">nomeProduto</label>
                                    <input type="text" class="form-control ts-input" name="nomeProduto" id="nomeProduto">
                                    <input type="hidden" class="form-control ts-input" name="idProduto" id="idProduto">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label ts-label">valorCompra</label>
                                    <input type="text" class="form-control ts-input" name="valorCompra" id="valorCompra">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label ts-label">idFornecedor</label>
                                    <input type="text" class="form-control ts-input" name="idPessoaFornecedor" id="idPessoaFornecedor">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoNcm</label>
                                    <input type="text" class="form-control ts-input" name="codigoNcm" id="codigoNcm">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoCest</label>
                                    <input type="text" class="form-control ts-input" name="codigoCest" id="codigoCest">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">refProduto</label>
                                    <input type="text" class="form-control ts-input" name="refProduto" id="refProduto">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">dataAtualizacaoTributaria</label>
                                    <input type="textw" class="form-control ts-input" name="dataAtualizacaoTributaria" id="dataAtualizacaoTributaria" disabled>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codImendes</label>
                                    <input type="text" class="form-control ts-input" name="codImendes" id="codImendes" disabled>
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">idGrupo</label>
                                    <input type="text" class="form-control ts-input" name="idGrupo" id="idGrupo" disabled>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">substICMSempresa</label>
                                    <input type="text" class="form-control ts-input" name="substICMSempresa" id="substICMSempresa">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">substICMSFornecedor</label>
                                    <input type="text" class="form-control ts-input" name="substICMSFornecedor" id="substICMSFornecedor">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">prodZFM</label>
                                    <input type="text" class="form-control ts-input" name="prodZFM" id="prodZFM">
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

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        $(document).on('click', '#btnalterar', function() {
            //alert("ok")
            $('#btnauxiliares').css('display','block');
            $('#btnalterar').css('display','none');
            $('#viewProd_idGeralProduto').prop('readonly',false);
            
        });

        $(document).on('click', '#btncancelar', function() {
            //alert("ok")
            $('#btnauxiliares').css('display','none');
            $('#btnalterar').css('display','block');
            $('#viewProd_idGeralProduto').prop('readonly',true)
        });

        buscar($("#buscaProduto").val());

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(buscaProduto) {
            //alert(buscaProduto);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/cadastros/database/produtos.php?operacao=filtrar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaProduto: buscaProduto
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        
                        linha = linha + "<tr>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.idProduto ? object.idProduto : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.EanProduto ? object.EanProduto : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.nomeProduto ? object.nomeProduto : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.idMarca ? object.idMarca : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.codImendes ? object.codImendes : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.idGrupo ? object.idGrupo : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.nomeGrupo ? object.nomeGrupo : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.prodZFM ? object.prodZFM : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.dataAtualizacaoTributaria ? formatarData(object.dataAtualizacaoTributaria) : "--") + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-info btn-sm' title='visualizar' data-bs-toggle='modal' data-bs-target='#visualizarProdutoModal' data-idProduto='" + object.idProduto + "'><i class='bi bi-eye'></i></button> "
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $(document).on('click', '.ts-click', function() {
            var idGeralProduto = $(this).attr("data-idGeralProduto");

            var collapseId = 'collapse_' + idGeralProduto;

            var conteudoCollapse = "<tr class='collapse-row bg-light'><td colspan='15'><div class='collapse show' id='" + collapseId + "'>" +
                "<table class='table table-sm table-hover table-warning ts-tablecenter'>" +
                "<thead>" +
                "<tr>" +
                "<th>Cnpj</th>" +
                "<th>Fornecedor</th>" +
                "<th>idProduto</th>" +
                "<th>refProduto</th>" +
                "<th>Valor</th>" +
                "<th>cfop</th>" +
                "<th>origem</th>" +
                "<th>Att Trib.</th>" +
                "<th>AÃ§Ã£o</th>" +
                "</tr>" +
                "</thead>" +
                "<tbody id='produto_" + idGeralProduto + "' class='fonteCorpo'></tbody>" +
                "</table>" +
                "</div></td></tr>";

            if ($('#' + collapseId).length === 0) {
                $('.collapse-row').remove();
                $(this).closest('tr').after(conteudoCollapse);


                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo URLROOT ?>/admin/database/geral.php?operacao=buscarGeralFornecimento',
                    data: {
                        idGeralProduto: idGeralProduto,
                    },
                    success: function(data) {
                        var linha = "";
                        for (var i = 0; i < data.length; i++) {
                            var object = data[i];

                            vnomeFantasia = object.nomeFantasia
                            if (object.nomeFantasia == null) {
                                vnomeFantasia = object.nomePessoa
                            }

                            linha = linha + "<tr>";
                            linha = linha + "<td>" + object.Cnpj + "</td>";
                            linha = linha + "<td>" + vnomeFantasia + "</td>";
                            linha = linha + "<td>" + object.idGeralProduto + "</td>";
                            linha = linha + "<td>" + object.refProduto + "</td>";
                            linha = linha + "<td>" + object.valorCompra + "</td>";
                            linha = linha + "<td>" + object.cfop + "</td>";
                            linha = linha + "<td>" + object.origem + "</td>";
                            linha = linha + "<td>" + (object.dataAtualizacaoTributaria ? formatarData(object.dataAtualizacaoTributaria) : "--") + "</td>";
                            linha = linha + "<td>" + "<button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#visualizarFornecedorModal' data-idFornecimento='" + object.idFornecimento + "'><i class='bi bi-eye'></i></button> "
                            linha = linha + "</tr>";
                        }
                        $("#produto_" + idGeralProduto).html(linha);
                    }
                });
            } else {
                $('#' + collapseId).collapse('toggle');
                $(this).closest('tr').nextAll('.collapse-row').remove();
            }
        });

        $("#buscar").click(function() {
            buscar($("#buscaProduto").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaProduto").val());
            }
        });

        function formatarData(data) {
            var d = new Date(data);
            var dia = d.getDate().toString().padStart(2, '0');
            var mes = (d.getMonth() + 1).toString().padStart(2, '0');
            var ano = d.getFullYear();
            var hora = d.getHours().toString().padStart(2, '0');
            var minutos = d.getMinutes().toString().padStart(2, '0');
            return dia + '/' + mes + '/' + ano + ' ' + hora + ':' + minutos;
        }

        $(document).on('click', 'button[data-bs-target="#atualizaProdutoModal"]', function() {

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/produtos.php?operacao=atualizar',
                data: {
                    idProduto: idProdutoAtualiza
                },
                success: function(data) {
                    console.log(data.retorno)
                    if (data.mensagem == true) {
                        alert("Nenhum produto retornado.")
                    }

                },

                error: function(xhr, status, error) {
                    alert("ERRO=" + JSON.stringify(error));
                }
            });
            window.location.reload();

        });

        $(document).on('click', 'button[data-bs-target="#atualizaFornecedorModal"]', function() {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/admin/database/geral.php?operacao=atualizar',
                data: {
                    idFornecimento: idFornecedorAtualiza
                }
            });
            window.location.reload();
        });

        $(document).on('click', 'button[data-bs-target="#visualizarProdutoModal"]', function() {
            var idProduto = $(this).attr("data-idProduto");
            //alert(idProduto)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/produtos.php?operacao=buscar',
                data: {
                    idProduto: idProduto
                },
                success: function(data) {
                    $('#viewProd_idProduto').val(data.idProduto);
                    idProdutoAtualiza = data.idProduto;
                    $('#viewProd_idGeralProduto').val(data.idGeralProduto)
                    $('#viewProd_eanProduto').val(data.EanProduto);
                    if(data.EanProduto == null){
                        $("#btnatualizaproduto").css('display','none');
                    }else{
                        $("#btnatualizaproduto").css('display','block');
                    }
                    $('#viewProd_nomeProduto').val(data.nomeProduto);
                    $vnomeproduto = data.nomeProduto;
                    var texto = $("#txtnomeproduto");
                    texto.html($vnomeproduto);
                    $('#viewProd_valorCompra').val(data.valorCompra);
                    $('#viewProd_codigoNcm').val(data.codigoNcm);
                    $('#viewProd_codigoCest').val(data.codigoCest);
                    $('#viewProd_idPessoaFornecedor').val(data.idPessoaFornecedor);
                    $('#viewProd_refProduto').val(data.refProduto);

                    if (data.dataAtualizacaoTributaria == null) {
                        vAtt_trib = '';
                    } else {
                        vAtt_trib = formatarData(data.dataAtualizacaoTributaria);
                    }

                    $('#viewProd_dataAtualizacaoTributaria').val(vAtt_trib);
                    $('#viewProd_codImendes').val(data.codImendes);
                    $('#viewProd_idGrupo').val(data.idGrupo);
                    $('#viewProd_substICMSempresa').val(data.substICMSempresa);
                    $('#viewProd_substICMSFornecedor').val(data.substICMSFornecedor);
                    $('#viewProd_prodZFM').val(data.prodZFM);
                    $('#idFornecimento').val(data.idFornecimento);
                        idFornecedorAtualiza = data.idFornecimento;

                    $('#visualizarProdutoModal').modal('show');
                }

            });
        });


        $(document).on('click', 'button[data-bs-target="#visualizarFornecedorModal"]', function() {
            var idFornecimento = $(this).attr("data-idFornecimento");
            //alert(idFornecimento)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/admin/database/geral.php?operacao=buscarGeralFornecimento',
                data: {
                    idFornecimento: idFornecimento
                },
                success: function(data) {
                    $('#viewForn_idFornecimento').val(data.idFornecimento);
                    $('#viewForn_Cnpj').val(data.Cnpj);
                    $('#viewForn_refProdutoFOR').val(data.refProduto);
                    $('#viewForn_idGeralProdutoFOR').val(data.idGeralProduto);
                    $('#viewForn_valorCompra').val(data.valorCompra);
                    $('#viewForn_nomePessoa').val(data.nomePessoa);
                    $('#viewForn_nomeProdutoFOR').val(data.nomeProduto);
                    $('#viewForn_eanProdutoFOR').val(data.eanProduto);
                    $('#viewForn_origem').val(data.origem);
                    $('#viewForn_cfop').val(data.cfop);
                    vdataFormatada = (data.dataAtualizacaoTributaria ? formatarData(data.dataAtualizacaoTributaria) : "");
                    $('#viewForn_dataAtualizacaoTributaria').val(vdataFormatada);

                    $('#visualizarFornecedorModal').modal('show');
                }
            });
        });

        $(document).ready(function() {
            $("#form-inserirProdutos").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/produtos.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-alterarProdutos").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/produtos.php?operacao=alterar",
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

            $("input[name='eanProduto']").on("input", function() {
                var eanProduto = $(this).val();
                if (eanProduto.length === 13) {
                    verificaCampoEanProduto(eanProduto);
                }
            });


            function verificaCampoEanProduto(eanProduto) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../database/produtos.php?operacao=verificaEanProduto',
                    data: {
                        eanProduto: eanProduto
                    },
                    success: function(data) {
                        //alert(data)
                        if (data == 'LIBERADO') {} else {
                            alert('eanProduto jÃ¡ cadastrado!');
                        }
                    }
                });
            }

            $("#form-atualizaFornecimento").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "<?php echo URLROOT?>/admin/database/geral.php?operacao=atualizarGeralFornecimento",
                    beforeSend: function() {
                        setTimeout(function(){
                            $("#atualizaFornecimento-btn").prop('disabled', true);
                            $(".span-load").addClass("spinner-border");
                            
                        },500);
                    },
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

        });
        
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>