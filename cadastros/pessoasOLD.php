<?php
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once(__DIR__ . '/../header.php');

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

            <div class="col-6 col-lg-6">
                <h2 class="ts-tituloPrincipal">Pessoas</h2>
            </div>

            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaPessoa" placeholder="Buscar por cpf/cnpj">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirPessoaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>Cpf/Cnpj</th>
                        <th>Nome</th>
                        <th>Estado</th>
                        <th>regimetrib</th>
                        <th>CRT</th>
                        <th>caractrib</th>
                        <th>regime especial</th>
                        <th>cnae</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>


        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirPessoaModal" tabindex="-1" aria-labelledby="inserirPessoaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Pessoa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirPessoas">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label class="form-label ts-label">Tipo de Pessoa</label>
                                            <input type="text" class="form-control ts-input" disabled name="tipoPessoa">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label ts-label">Cpf/Cnpj</label>
                                            <input type="text" class="form-control ts-input" name="cpfCnpj">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Nome</label>
                                            <input type="text" class="form-control ts-input" disabled name="nomePessoa">
                                        </div>
                                    </div><!--fim row 1-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">codigoCidade</label>
                                            <input type="text" class="form-control ts-input" disabled name="codigoCidade">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">codigoEstado</label>
                                            <input type="text" class="form-control ts-input" disabled name="codigoEstado">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">CEP</label>
                                            <input type="text" class="form-control ts-input" disabled name="cep">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Bairro</label>
                                            <input type="text" class="form-control ts-input" disabled name="bairro">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Endereço</label>
                                            <input type="text" class="form-control ts-input" disabled name="endereco">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label ts-label">Numero</label>
                                            <input type="text" class="form-control ts-input" disabled name="endNumero">
                                        </div>
                                    </div><!--fim row 2-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Município</label>
                                            <input type="text" class="form-control ts-input" disabled name="municipio">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">IE</label>
                                            <input type="text" class="form-control ts-input" disabled name="IE">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">País</label>
                                            <input type="text" class="form-control ts-input" disabled name="pais">
                                        </div>
                                    </div><!--fim row 3-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Email</label>
                                            <input type="text" class="form-control ts-input" disabled name="email">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Telefone</label>
                                            <input type="text" class="form-control ts-input" disabled name="telefone">
                                        </div>
                                    </div><!--fim row 4-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">crt</label>
                                            <input type="text" class="form-control ts-input" disabled name="crt">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">regimeTrib</label>
                                            <input type="text" class="form-control ts-input" disabled name="regimeTrib">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">cnae</label>
                                            <input type="text" class="form-control ts-input" disabled name="cnae">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">regimeEspecial</label>
                                            <input type="text" class="form-control ts-input" disabled name="regimeEspecial">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">caracTrib</label>
                                            <input type="text" class="form-control ts-input" disabled name="caracTrib">
                                        </div>
                                    </div><!--fim row 5-->
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
        <div class="modal fade bd-example-modal-lg" id="alterarPessoaModal" tabindex="-1" aria-labelledby="alterarPessoaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Pessoa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarPessoas">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <label class="form-label ts-label">Tipo de Pessoa</label>
                                            <input type="text" class="form-control ts-input" disabled name="tipoPessoa" id="tipoPessoa">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label ts-label">Cpf/Cnpj</label>
                                            <input type="text" class="form-control ts-input" id="cpfCnpj" name="cpfCnpj" readonly>
                                            <input type="hidden" class="form-control ts-input" id="idPessoa" name="idPessoa">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Nome</label>
                                            <input type="text" class="form-control ts-input" disabled name="nomePessoa" id="nomePessoa">
                                        </div>
                                    </div><!--fim row 1-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">codigoCidade</label>
                                            <input type="text" class="form-control ts-input" id="codigoCidade" disabled name="codigoCidade">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">codigoEstado</label>
                                            <input type="text" class="form-control ts-input" id="codigoEstado" disabled name="codigoEstado">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">CEP</label>
                                            <input type="text" class="form-control ts-input" id="cep" disabled name="cep">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Bairro</label>
                                            <input type="text" class="form-control ts-input" id="bairro" disabled name="bairro">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Endereço</label>
                                            <input type="text" class="form-control ts-input" id="endereco" disabled name="endereco">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label ts-label">Numero</label>
                                            <input type="text" class="form-control ts-input" id="endNumero" disabled name="endNumero">
                                        </div>
                                    </div><!--fim row 2-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Município</label>
                                            <input type="text" class="form-control ts-input" id="municipio" disabled name="municipio">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">IE</label>
                                            <input type="text" class="form-control ts-input" id="IE" disabled name="IE">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">País</label>
                                            <input type="text" class="form-control ts-input" id="pais" disabled name="pais">
                                        </div>
                                    </div><!--fim row 3-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Email</label>
                                            <input type="text" class="form-control ts-input" id="email" name="email">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Telefone</label>
                                            <input type="text" class="form-control ts-input" id="telefone" name="telefone">
                                        </div>
                                    </div><!--fim row 4-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">crt</label>
                                            <input type="text" class="form-control ts-input" id="crt" disabled name="crt">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">regimeTrib</label>
                                            <input type="text" class="form-control ts-input" id="regimeTrib" disabled name="regimeTrib">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">cnae</label>
                                            <input type="text" class="form-control ts-input" id="cnae" name="cnae">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">regimeEspecial</label>
                                            <input type="text" class="form-control ts-input" id="regimeEspecial" disabled name="regimeEspecial">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">caracTrib</label>
                                            <select class="form-select ts-input" name="caracTrib" id="caracTrib">
                                                <option value="0">0 - Industrial</option>
                                                <option value="1">1 - Distribuidor</option>
                                                <option value="2">2 - Atacadista</option>
                                                <option value="3">3 - Varejista</option>
                                                <option value="4">4 - Produtor Rural Pessoa Juridica</option>
                                                <option value="6">6 - Produtor Rural Pessoa Fisica</option>
                                                <option value="7">7 - Pessoa Juridica n�o Contribuinte do ICMS</option>
                                                <option value="8">8 - Pessoa Fisica n�o Contribuinte do ICMS</option>
                                                <option value="9">9 - Armaz�m Geral</option>
                                            </select>
                                        </div>
                                    </div><!--fim row 5-->
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
        buscar($("#buscaPessoa").val());

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(buscaPessoa) {
            //alert (buscaPessoa);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/cadastros/database/pessoas.php?operacao=filtrar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaPessoa: buscaPessoa
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        vnomeFantasia = object.nomeFantasia
                        if (object.nomeFantasia == null) {
                            vnomeFantasia = object.nomePessoa
                        }

                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.cpfCnpj + "</td>";
                        linha = linha + "<td>" + vnomeFantasia + "</td>";

                        linha = linha + "<td>" + object.codigoEstado + "</td>";
                        linha = linha + "<td>" + object.regimeTrib + "</td>";
                        linha = linha + "<td>" + object.crt + "</td>";
                        linha = linha + "<td>" + object.caracTrib + "</td>";
                        linha = linha + "<td>" + object.regimeEspecial + "</td>";
                        linha = linha + "<td>" + object.cnae + "</td>";

                        linha = linha + "<td>" + "<button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#alterarPessoaModal' data-idPessoa='" + object.idPessoa + "'><i class='bi bi-eye'></i></button> "
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $("#buscar").click(function() {
            buscar($("#buscaPessoa").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaPessoa").val());
            }
        });

        $(document).on('click', 'button[data-bs-target="#alterarPessoaModal"]', function() {
            var idPessoa = $(this).attr("data-idPessoa");
            //alert(idPessoa)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/pessoas.php?operacao=buscar',
                data: {
                    idPessoa: idPessoa
                },
                success: function(data) {
                    $('#idPessoa').val(data.idPessoa);
                    $('#cpfCnpj').val(data.cpfCnpj);
                    $('#nomePessoa').val(data.nomePessoa);
                    $('#IE').val(data.IE);
                    $('#municipio').val(data.municipio);
                    $('#pais').val(data.pais);
                    $('#bairro').val(data.bairro);
                    $('#endereco').val(data.endereco);
                    $('#endNumero').val(data.endNumero);
                    $('#cep').val(data.cep);
                    $('#email').val(data.email);
                    if (data.email == null) {
                        $("#email").prop('readonly', false);
                    }else{
                        $("#email").prop('readonly', true);
                    }
                    $('#telefone').val(data.telefone);
                    if (data.telefone == null) {
                        $("#telefone").prop('readonly', false);
                    }else{
                        $("#telefone").prop('readonly', true);
                    }
                    $('#crt').val(data.crt);
                    $('#regimeTrib').val(data.regimeTrib);
                    $('#cnae').val(data.cnae);
                    if (data.cnae == null) {
                        $("#cnae").prop('readonly', false);
                    }else{
                        $("#cnae").prop('readonly', true);
                    }
                    $('#regimeEspecial').val(data.regimeEspecial);
                    $('#codigoCidade').val(data.codigoCidade);
                    $('#codigoEstado').val(data.codigoEstado);
                    $('#caracTrib').val(data.caracTrib);
                    if(data.caracTrib == null){
                        $('#caracTrib').removeClass('ts-displayDisable');
                    }else{
                        $('#caracTrib').addClass('ts-displayDisable')
                    }
                    $('#origem').val(data.origem);
                    if (data.tipoPessoa === 'J') {
                        $('#tipoPessoa').val('Juridica');
                    } else if (data.tipoPessoa === 'F') {
                        $('#tipoPessoa').val('Fisica');
                    }
                    $('#alterarPessoaModal').modal('show');
                }
            });
        });


        $(document).ready(function() {
            $("#form-inserirPessoas").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/pessoas.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-alterarPessoas").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/pessoas.php?operacao=alterar",
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

            $("input[name='cpfCnpj']").on("input", function() {
                var cpfCnpj = $(this).val();
                if (cpfCnpj.length >= 11) {
                    verificaCampoCNPJ(cpfCnpj);
                }
            });


            function verificaCampoCNPJ(cpfCnpj) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../database/pessoas.php?operacao=verificaCNPJ',
                    data: {
                        cpfCnpj: cpfCnpj
                    },
                    success: function(data) {
                        //alert(data)
                        if (data == 'LIBERADO') {
                            //alert('DEU CERTO');
                            //$('#btn-formInserir').show();
                        } else {
                            alert('CPF ou CNPJ já cadastrado!');
                            //$('#btn-formInserir').hide();
                        }
                    }
                });
            }
        });

        //Carregar a imagem na tela
        const inputFile = document.querySelector("#imgAplicativo");
        const pictureImage = document.querySelector(".picture__image");
        const pictureImageTxt = "Carregar imagem";
        pictureImage.innerHTML = pictureImageTxt;

        inputFile.addEventListener("change", function(e) {
            const inputTarget = e.target;
            const file = inputTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function(e) {
                    const readerTarget = e.target;

                    const img = document.createElement("img");
                    img.src = readerTarget.result;
                    img.classList.add("picture__img");

                    pictureImage.innerHTML = "";
                    pictureImage.appendChild(img);
                });

                reader.readAsDataURL(file);
            } else {
                pictureImage.innerHTML = pictureImageTxt;
            }
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>