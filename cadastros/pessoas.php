<?php
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once(__DIR__ . '/../header.php');
include_once(ROOT . '/impostos/database/caracTrib.php');

$caracTribs = buscaCaracTrib();
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
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#verificaPessoaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
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


        <!--------- VERIFICA --------->
        <div class="modal fade" id="verificaPessoaModal" tabindex="-1" aria-labelledby="verificaPessoaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Consultar CPF ou CNPJ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning d-none" id="alertaCadastroExistente" role="alert">
                            Cpf/Cnpj j� cadastrado
                        </div>

                        <form method="post" id="form-verificaPessoas">
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label ts-label">Tipo Pessoa</label>
                                    <select class="form-select ts-input tipoPessoa" name="tipoPessoa" id="tipoPessoa_formEntrada">
                                        <option value="F">Física</option>
                                        <option value="J">Jurídica</option>
                                    </select>
                                </div>
                                <div class="col mt-4">
                                    <input type="text" class="form-control ts-input cpfCnpj" name="cpfCnpj" id="cpf_formEntrada" placeholder="Digite seu CPF" autocomplete="none">
                                    <input type="text" class="form-control ts-input d-none cpfCnpj" name="cpfCnpj" id="cnpj_formEntrada" disabled placeholder="Digite seu CNPJ" autocomplete="none">
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="consultarPessoa-btn">Consultar
                            <span class="spinner-border-sm span-load" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- INSERIR DADOS COMPLEMENTARES --------->
        <div class="modal fade bd-example-modal-lg" id="inserirPessoaModal" tabindex="-1" aria-labelledby="inserirPessoaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Pessoa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pt-2">

                        <ul class="nav nav-tabs gap-1" id="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal active" id="tabInserir1-tab" data-bs-toggle="tab" href="#tabInserir1" role="tab" aria-controls="tabInserir1" aria-selected="true">Dados Pessoais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal" id="tabInserir2-tab" data-bs-toggle="tab" href="#tabInserir2" role="tab" aria-controls="tabInserir2" aria-selected="false">Endereço</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal" id="tabInserir3-tab" data-bs-toggle="tab" href="#tabInserir3" role="tab" aria-controls="tabInserir3" aria-selected="false">Dados Tributarios</a>
                            </li>
                        </ul>
                        <form method="post" id="form-inserirPessoas">
                            <div class="tab-content" id="myTabsContent">
                                <div class="tab-pane fade show active" id="tabInserir1" role="tabpanel" aria-labelledby="tabInserir1-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label class="form-label ts-label">Tipo Pessoa<span class="text-danger"> * </span></label>
                                                <select class="form-select ts-input <?php if ($_SESSION['administradora'] != 1) {
                                                                                        echo "ts-displayDisable";
                                                                                    } ?> " name="tipoPessoa" id="tipoPessoa_complementar" required>
                                                    <option value="J">Jurídica</option>
                                                    <option value="F">Física</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label ts-label">Cpf/Cnpj<span class="text-danger"> * </span></label>
                                                <input type="text" class="form-control ts-input" name="cpfCnpj" id="cpfCnpj_complementar" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                                echo "readonly";
                                                                                                                                            } ?> required>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Nome<span class="text-danger"> * </span></label>
                                                <input type="text" class="form-control ts-input" name="nomePessoa" id="nomePessoa_complementar" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                                    echo "readonly";
                                                                                                                                                } ?> required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Nome Fantasia</label>
                                                <input type="text" class="form-control ts-input" name="nomeFantasia" id="nomeFantasia_complementar" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                                        echo "readonly";
                                                                                                                                                    } ?>>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Email</label>
                                                <input type="text" class="form-control ts-input" name="email" id="email_complementar">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Telefone</label>
                                                <input type="text" class="form-control ts-input" name="telefone" id="telefone_complementar">
                                            </div>
                                        </div>
                                    </div><!-- container 1 -->
                                </div><!-- tab-pane 1 -->

                                <div class="tab-pane fade" id="tabInserir2" role="tabpanel" aria-labelledby="tabInserir2-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">codigoCidade</label>
                                                <input type="text" class="form-control ts-input" name="codigoCidade" id="codigoCidade_complementar" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                                        echo "readonly";
                                                                                                                                                    } ?>>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">codigoEstado</label>
                                                <input type="text" class="form-control ts-input" name="codigoEstado" id="codigoEstado_complementar" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                                        echo "readonly";
                                                                                                                                                    } ?>>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">CEP</label>
                                                <input type="text" class="form-control ts-input" name="cep" id="cep_complementar">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Bairro</label>
                                                <input type="text" class="form-control ts-input" name="bairro" id="bairro_complementar">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Endereço</label>
                                                <input type="text" class="form-control ts-input" name="endereco" id="endereco_complementar">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label ts-label">Numero</label>
                                                <input type="text" class="form-control ts-input" name="endNumero" id="endNumero_complementar">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Município</label>
                                                <input type="text" class="form-control ts-input" name="municipio" id="municipio_complementar">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">IE</label>
                                                <input type="text" class="form-control ts-input" name="IE" id="IE_complementar">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">País</label>
                                                <input type="text" class="form-control ts-input" name="pais" id="pais_complementar">
                                            </div>
                                        </div>
                                    </div><!-- container 2 -->
                                </div><!-- tab-pane3 -->

                                <div class="tab-pane fade" id="tabInserir3" role="tabpanel" aria-labelledby="tabInserir3-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">regimeTrib</label>
                                                <select class="form-select ts-input" name="regimeTrib" id="regimeTrib_complementar">
                                                    <option value="">Selecione</option>
                                                    <option value="SN" value="SN">SN - Simples Nacional</option>
                                                    <option value="LR">LR - Lucro Real</option>
                                                    <option value="LP">LP - Lucro Presumido</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">crt</label>
                                                <select class="form-select ts-input" name="crt" id="crt_complementar">
                                                    <option value="">Selecione</option>
                                                    <option data-datacrt="SN" value="1">1 - Simples Nacional</option>
                                                    <option data-datacrt="SN" value="2">2 - SN com excesso sublimite de receita bruta</option>

                                                    <option data-datacrt="LR" value="3">3 - Regime Normal. (v2.0)</option>
                                                    <option data-datacrt="LP" value="3">3 - Regime Normal. (v2.0)</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">regimeEspecial</label>
                                                <input type="text" class="form-control ts-input" name="regimeEspecial" id="regimeEspecial_complementar">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">cnae</label>
                                                <div class="input-group" style="margin-top: -6px;">
                                                    <input type="text" class="form-control ts-input" name="cnae" id="cnae_complementar" style="height: 35px; margin-top:1px">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="consultaCnpjComplementar()" title="Consultar Cnae">
                                                        <i class="bi bi-search" id="lupaCnaeComplementar"></i>
                                                        <span class="spinner-border-sm span-load" role="status" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md" style="margin-top: 2px;">
                                                <label class="form-label ts-label">caracTrib</label>
                                               

                                                <select class="form-select ts-input" name="caracTrib" id="caracTrib_complementar">
                                                    <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                                    <?php foreach ($caracTribs as $caracTrib) { ?>
                                                    <option value="<?php echo $caracTrib['caracTrib'] ?>"><?php echo $caracTrib['caracTrib'] ?> - <?php echo $caracTrib['descricaoCaracTrib'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- container 3 -->

                                </div><!-- tab-pane3 -->

                            </div><!-- tab-content -->
                    </div><!--modal body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn_formInserirComplementar">Cadastrar</button>
                    </div>
                    </form>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->

        <!--------- INSERIR GERAL--------->
        <div class="modal fade bd-example-modal-lg" id="inserirGeralModal" tabindex="-1" aria-labelledby="inserirGeralModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Pessoa*</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pt-2">

                        <ul class="nav nav-tabs gap-1" id="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal active" id="tabInserirGeral1-tab" data-bs-toggle="tab" href="#tabInserirGeral1" role="tab" aria-controls="tabInserirGeral1" aria-selected="true">Dados Pessoais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal" id="tabInserirGeral2-tab" data-bs-toggle="tab" href="#tabInserirGeral2" role="tab" aria-controls="tabInserirGeral2" aria-selected="false">Endereço</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal" id="tabInserirGeral3-tab" data-bs-toggle="tab" href="#tabInserirGeral3" role="tab" aria-controls="tabInserirGeral3" aria-selected="false">Dados Tributarios</a>
                            </li>
                        </ul>
                        <form method="post" id="form-inserirGeral">
                            <div class="tab-content" id="myTabsContent">
                                <div class="tab-pane fade show active" id="tabInserirGeral1" role="tabpanel" aria-labelledby="tabInserirGeral1-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label class="form-label ts-label">Tipo Pessoa<span class="text-danger"> * </span></label>
                                                <select class="form-select ts-input ts-displayDisable" name="tipoPessoa" id="tipoPessoa_inserirgeral" required>
                                                    <option value="J">Jurídica</option>
                                                    <option value="F">Física</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label ts-label">Cpf/Cnpj<span class="text-danger"> * </span></label>
                                                <input type="text" class="form-control ts-input" name="cpfCnpj" id="cpfCnpj_inserirgeral" readonly required>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Nome<span class="text-danger"> * </span></label>
                                                <input type="text" class="form-control ts-input" name="nomePessoa" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Nome Fantasia</label>
                                                <input type="text" class="form-control ts-input" name="nomeFantasia">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Email</label>
                                                <input type="text" class="form-control ts-input" name="email">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Telefone</label>
                                                <input type="text" class="form-control ts-input" name="telefone">
                                            </div>
                                        </div>
                                    </div><!-- container 1 -->
                                </div><!-- tab-pane 1 -->

                                <div class="tab-pane fade" id="tabInserirGeral2" role="tabpanel" aria-labelledby="tabInserirGeral2-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col">
                                                <label class="form-label ts-label">codigoCidade</label>
                                                <input type="text" class="form-control ts-input" name="codigoCidade">
                                            </div>
                                            <div class="col">
                                                <label class="form-label ts-label">codigoEstado</label>
                                                <input type="text" class="form-control ts-input" name="codigoEstado">
                                            </div>
                                            <div class="col">
                                                <label class="form-label ts-label">CEP</label>
                                                <input type="text" class="form-control ts-input" name="cep">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Bairro</label>
                                                <input type="text" class="form-control ts-input" name="bairro">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Endereço</label>
                                                <input type="text" class="form-control ts-input" name="endereco">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label ts-label">Numero</label>
                                                <input type="text" class="form-control ts-input" name="endNumero">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Município</label>
                                                <input type="text" class="form-control ts-input" name="municipio">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">IE</label>
                                                <input type="text" class="form-control ts-input" name="IE">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">País</label>
                                                <input type="text" class="form-control ts-input" name="pais">
                                            </div>
                                        </div>
                                    </div><!-- container 2 -->
                                </div><!-- tab-pane3 -->

                                <div class="tab-pane fade" id="tabInserirGeral3" role="tabpanel" aria-labelledby="tabInserirGeral3-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <!-- lucas 04042024 - Alterado para select: crt, regimeTrib e caracTrib -->
                                            <div class="col-md">
                                                <label class="form-label ts-label">regimeTrib</label>
                                                <select class="form-select ts-input" name="regimeTrib">
                                                    <option value="">Selecione</option>
                                                    <option value="SN" value="SN">SN - Simples Nacional</option>
                                                    <option value="LR">LR - Lucro Real</option>
                                                    <option value="LP">LP - Lucro Presumido</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">crt</label>
                                                <select class="form-select ts-input" name="crt">
                                                    <option value="">Selecione</option>
                                                    <option data-datacrt="SN" value="1">1 - Simples Nacional</option>
                                                    <option data-datacrt="SN" value="2">2 - SN com excesso sublimite de receita bruta</option>

                                                    <option data-datacrt="LR" value="3">3 - Regime Normal. (v2.0)</option>
                                                    <option data-datacrt="LP" value="3">3 - Regime Normal. (v2.0)</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">regimeEspecial</label>
                                                <input type="text" class="form-control ts-input" name="regimeEspecial">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">cnae</label>
                                                <div class="input-group" style="margin-top: -6px;">
                                                    <input type="text" class="form-control ts-input" name="cnae" id="cnae_inserirgeral" style="height: 35px; margin-top:1px">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="consultaCnpj()" title="Consultar Cnae">
                                                        <i class="bi bi-search" id="lupaCnae"></i>
                                                        <span class="spinner-border-sm span-load" role="status" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md" style="margin-top: 2px;">
                                                <label class="form-label ts-label">caracTrib</label>
                                                <select class="form-select ts-input" name="caracTrib" id="caracTrib_inserirgeral">
                                                    <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                                    <?php foreach ($caracTribs as $caracTrib) { ?>
                                                    <option value="<?php echo $caracTrib['caracTrib'] ?>"><?php echo $caracTrib['caracTrib'] ?> - <?php echo $caracTrib['descricaoCaracTrib'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- container 3 -->
                                </div><!-- tab-pane3 -->

                            </div><!-- tab-content -->

                    </div><!--modal body-->
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-success" id="btn_formInserir">Cadastrar</button>
                    </div>
                    </form>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->


        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarPessoaModal" tabindex="-1" aria-labelledby="alterarPessoaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alterar Pessoa: </h5>
                        <h5 class="modal-title" id="titulomodalalterar"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pt-2">

                        <ul class="nav nav-tabs gap-1" id="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal active" id="tabAlterar1-tab" data-bs-toggle="tab" href="#tabAlterar1" role="tab" aria-controls="tabAlterar1" aria-selected="true">Dados Pessoais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal" id="tabAlterar2-tab" data-bs-toggle="tab" href="#tabAlterar2" role="tab" aria-controls="tabAlterar2" aria-selected="false">Endereço</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ts-tabModal" id="tabAlterar3-tab" data-bs-toggle="tab" href="#tabAlterar3" role="tab" aria-controls="tabAlterar3" aria-selected="false">Dados Tributarios</a>
                            </li>
                        </ul>
                        <form method="post" id="form-alterarPessoas">
                            <div class="tab-content" id="myTabsContent">
                                <div class="tab-pane fade show active" id="tabAlterar1" role="tabpanel" aria-labelledby="tabAlterar1-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <label class="form-label ts-label">Tipo Pessoa<span class="text-danger"> * </span></label>
                                                <select class="form-select ts-input <?php if ($_SESSION['administradora'] != 1) {
                                                                                        echo "ts-displayDisable";
                                                                                    } ?> " name="tipoPessoa" id="tipoPessoa" required>
                                                    <option value="J">Jurídica</option>
                                                    <option value="F">Física</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label ts-label">Cpf/Cnpj<span class="text-danger"> * </span></label>
                                                <input type="text" class="form-control ts-input" id="cpfCnpj" name="cpfCnpj" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                    echo "readonly";
                                                                                                                                } ?> required>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Nome<span class="text-danger"> * </span></label>
                                                <input type="text" class="form-control ts-input" name="nomePessoa" id="nomePessoa" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                        echo "readonly";
                                                                                                                                    } ?> required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Nome Fantasia</label>
                                                <input type="text" class="form-control ts-input" name="nomeFantasia" id="nomeFantasia" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                            echo "readonly";
                                                                                                                                        } ?> >
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Email</label>
                                                <input type="text" class="form-control ts-input" id="email" name="email">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Telefone</label>
                                                <input type="text" class="form-control ts-input" id="telefone" name="telefone">
                                            </div>
                                        </div>
                                    </div><!-- container 1 -->
                                </div><!-- tab-pane 1 -->

                                <div class="tab-pane fade" id="tabAlterar2" role="tabpanel" aria-labelledby="tabAlterar2-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">codigoCidade</label>
                                                <input type="text" class="form-control ts-input" id="codigoCidade" name="codigoCidade" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                            echo "readonly";
                                                                                                                                        } ?> >
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">codigoEstado</label>
                                                <input type="text" class="form-control ts-input" id="codigoEstado" name="codigoEstado" <?php if ($_SESSION['administradora'] != 1) {
                                                                                                                                            echo "readonly";
                                                                                                                                        } ?> >
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">CEP</label>
                                                <input type="text" class="form-control ts-input" id="cep" name="cep">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Bairro</label>
                                                <input type="text" class="form-control ts-input" id="bairro" name="bairro">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">Endereço</label>
                                                <input type="text" class="form-control ts-input" id="endereco" name="endereco">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label ts-label">Numero</label>
                                                <input type="text" class="form-control ts-input" id="endNumero" name="endNumero">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">Município</label>
                                                <input type="text" class="form-control ts-input" id="municipio" name="municipio">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">IE</label>
                                                <input type="text" class="form-control ts-input" id="IE" name="IE">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">País</label>
                                                <input type="text" class="form-control ts-input" id="pais" name="pais">
                                            </div>
                                        </div>
                                    </div><!-- container 2 -->
                                </div><!-- tab-pane3 -->

                                <div class="tab-pane fade" id="tabAlterar3" role="tabpanel" aria-labelledby="tabAlterar3-tab">
                                    <div class="container">
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">regimeTrib</label>
                                                <select class="form-select ts-input" name="regimeTrib" id="regimeTrib">
                                                    <option value="">Selecione</option>
                                                    <option value="SN" value="SN">SN - Simples Nacional</option>
                                                    <option value="LR">LR - Lucro Real</option>
                                                    <option value="LP">LP - Lucro Presumido</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">crt</label>
                                                <select class="form-select ts-input" name="crt" id="crt">
                                                    <option value="">Selecione</option>
                                                    <option data-datacrt="SN" value="1">1 - Simples Nacional</option>
                                                    <option data-datacrt="SN" value="2">2 - SN com excesso sublimite de receita bruta</option>

                                                    <option data-datacrt="LR" value="3">3 - Regime Normal. (v2.0)</option>
                                                    <option data-datacrt="LP" value="3">3 - Regime Normal. (v2.0)</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">regimeEspecial</label>
                                                <input type="text" class="form-control ts-input" id="regimeEspecial" name="regimeEspecial">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md">
                                                <label class="form-label ts-label">cnae</label>
                                                <div class="input-group" style="margin-top: -6px;">
                                                    <input type="text" class="form-control ts-input" name="cnae" id="cnae" style="height: 35px; margin-top:1px">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="consultaCnpjAlterar()" title="Consultar Cnae">
                                                        <i class="bi bi-search" id="lupaCnaeAlterar"></i>
                                                        <span class="spinner-border-sm span-load" role="status" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label ts-label">caracTrib</label>
                                                <select class="form-select ts-input <?php if ($_SESSION['administradora'] != 1) {
                                                                                        echo "ts-displayDisable";
                                                                                    } ?>" name="caracTrib" id="caracTrib">
                                                    <option value="<?php echo null ?>"><?php echo "Selecione" ?></option>
                                                    <?php foreach ($caracTribs as $caracTrib) { ?>
                                                    <option value="<?php echo $caracTrib['caracTrib'] ?>"><?php echo $caracTrib['caracTrib'] ?> - <?php echo $caracTrib['descricaoCaracTrib'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- container 3 -->
                                </div><!-- tab-pane3 -->

                            </div><!-- tab-content -->

                    </div><!--modal body-->
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-success" id="btn_formAlterar">Salvar</button>
                    </div>
                    </form>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->




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
                    $('#tipoPessoa').val(data.tipoPessoa);
                    if(data.tipoPessoa == "F"){
                        $('#tabAlterar3-tab').addClass('d-none');
                        $('#tabAlterar3').addClass('d-none');
                    }else{
                        $('#tabAlterar3-tab').removeClass('d-none');
                        $('#tabAlterar3').removeClass('d-none'); 
                    }
                    $('#cpfCnpj').val(data.cpfCnpj);
                    $('#nomePessoa').val(data.nomePessoa);
                    $('#nomeFantasia').val(data.nomeFantasia);

                    //titulo modal alterar
                    var texto = $("#titulomodalalterar");
                    texto.html(' &nbsp ' + data.nomeFantasia);

                    $('#email').val(data.email);
                    $('#telefone').val(data.telefone);
                    $('#codigoCidade').val(data.codigoCidade);
                    $('#codigoEstado').val(data.codigoEstado);
                    $('#cep').val(data.cep);
                    $('#bairro').val(data.bairro);
                    $('#endereco').val(data.endereco);
                    $('#endNumero').val(data.endNumero);
                    $('#municipio').val(data.municipio);
                    $('#IE').val(data.IE);
                    $('#pais').val(data.pais);
                    $('#regimeTrib').val(data.regimeTrib);
                    $('#crt').val(data.crt);
                    $('#caracTrib').val(data.caracTrib);
                    $('#regimeEspecial').val(data.regimeEspecial);
                    $('#cnae').val(data.cnae);

                    <?php if ($_SESSION['administradora'] != 1) { ?>
                        (data.email == null || data.email == '' ? $("#email").prop('readonly', false) : $("#email").prop('readonly', true));
                        (data.telefone == null || data.telefone == '' ? $("#telefone").prop('readonly', false) : $("#telefone").prop('readonly', true));
                        (data.codigoCidade == null || data.codigoCidade == '' || data.codigoCidade == 0 ? $("#codigoCidade").prop('readonly', false) : $("#codigoCidade").prop('readonly', true));
                        (data.codigoEstado == null || data.codigoEstado == '' ? $("#codigoEstado").prop('readonly', false) : $("#codigoEstado").prop('readonly', true));
                        (data.cep == null || data.cep == '' ? $("#cep").prop('readonly', false) : $("#cep").prop('readonly', true));
                        (data.bairro == null || data.bairro == '' ? $("#bairro").prop('readonly', false) : $("#bairro").prop('readonly', true));
                        (data.endereco == null || data.endereco == '' ? $("#endereco").prop('readonly', false) : $("#endereco").prop('readonly', true));
                        (data.endNumero == null || data.endNumero == 0 ? $("#endNumero").prop('readonly', false) : $("#endNumero").prop('readonly', true));
                        (data.municipio == null || data.municipio == '' ? $("#municipio").prop('readonly', false) : $("#municipio").prop('readonly', true));
                        (data.IE == null || data.IE == '' ? $("#IE").prop('readonly', false) : $("#IE").prop('readonly', true));
                        (data.pais == null || data.pais == '' ? $("#pais").prop('readonly', false) : $("#pais").prop('readonly', true));
                        (data.regimeTrib == null || data.regimeTrib == '' ? $("#regimeTrib").removeClass('ts-displayDisable') : $("#regimeTrib").addClass('ts-displayDisable'));
                        (data.crt == null || data.crt == '' ? $("#crt").removeClass('ts-displayDisable') : $("#crt").addClass('ts-displayDisable'));
                        //(data.caracTrib == null || data.caracTrib == '' ? $("#caracTrib").removeClass('ts-displayDisable') : $("#caracTrib").addClass('ts-displayDisable'));
                        (data.regimeEspecial == null || data.regimeEspecial == '' ? $("#regimeEspecial").prop('readonly', false) : $("#regimeEspecial").prop('readonly', true));
                        (data.cnae == null || data.cnae == '' ? $("#cnae").prop('readonly', false) : $("#cnae").prop('readonly', true));
                    <?php } ?>

                    $('#alterarPessoaModal').modal('show');
                }
            });
        });

        function consultaCnpj() {
            cpfCnpj_formEntrada = $("#cnpj_formEntrada").val();

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/consulta_cnpj.php?operacao=buscar',
                beforeSend: function() {
                    setTimeout(function() {
                        $(".span-load").addClass(" spinner-border");
                        $("#lupaCnae").hide();
                        $('#btn_formInserir').hide();
                    }, 300);
                },
                data: {
                    cnpj: cpfCnpj_formEntrada
                },
                success: function(msg) {
                    $(".span-load").removeClass("spinner-border");
                    $("#lupaCnae").show();
                    $('#btn_formInserir').show();
                    var json = JSON.parse(msg);

                    $('#cnae_inserirgeral').val(json.cnae);
                    $('#cnae_inserirgeral').prop('readonly', true);

                    // CHAMA API DE CNAE CLASSE
                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: '<?php echo URLROOT ?>/impostos/database/cnae.php?operacao=buscaClasse',
                        data: {
                            cnaeID: json.cnae
                        },
                        success: function(msg) {
                            var json = JSON.parse(msg);

                            $('#caracTrib_inserirgeral').val(json.caracTrib);
                            $('#caracTrib_inserirgeral').addClass('ts-displayDisable');

                        }
                    });

                }
            });
        }

        function consultaCnpjComplementar() {
            cpfCnpj_formEntrada = $("#cnpj_formEntrada").val();

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/consulta_cnpj.php?operacao=buscar',
                beforeSend: function() {
                    setTimeout(function() {
                        $(".span-load").addClass(" spinner-border");
                        $("#lupaCnaeComplementar").hide();
                        $('#btn_formInserirComplementar').hide();
                    }, 300);
                },
                data: {
                    cnpj: cpfCnpj_formEntrada
                },
                success: function(msg) {
                    $(".span-load").removeClass("spinner-border");
                    $("#lupaCnaeComplementar").show();
                    $('#btn_formInserirComplementar').show();
                    var json = JSON.parse(msg);

                    $('#cnae_complementar').val(json.cnae);
                    $('#cnae_complementar').prop('readonly', true);

                    // CHAMA API DE CNAE CLASSE
                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: '<?php echo URLROOT ?>/impostos/database/cnae.php?operacao=buscaClasse',
                        data: {
                            cnaeID: json.cnae
                        },
                        success: function(msg) {
                            var json = JSON.parse(msg);

                            $('#caracTrib_complementar').val(json.caracTrib);
                            $('#caracTrib_complementar').addClass('ts-displayDisable');

                        }
                    });

                }
            });
        }

        function consultaCnpjAlterar() {
            cpfCnpj_formEntrada = $("#cpfCnpj").val();

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/consulta_cnpj.php?operacao=buscar',
                beforeSend: function() {
                    setTimeout(function() {
                        $(".span-load").addClass(" spinner-border");
                        $("#lupaCnaeAlterar").hide();
                        $('#btn_formAlterar').hide();
                    }, 300);
                },
                data: {
                    cnpj: cpfCnpj_formEntrada
                },
                success: function(msg) {
                    $(".span-load").removeClass("spinner-border");
                    $("#lupaCnaeAlterar").show();
                    $('#btn_formAlterar').show();
                    var json = JSON.parse(msg);

                    $('#cnae').val(json.cnae);
                    $('#cnae').prop('readonly', true);

                    // CHAMA API DE CNAE CLASSE
                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: '<?php echo URLROOT ?>/impostos/database/cnae.php?operacao=buscaClasse',
                        data: {
                            cnaeID: json.cnae
                        },
                        success: function(msg) {
                            var json = JSON.parse(msg);

                            $('#caracTrib').val(json.caracTrib);
                            $('#caracTrib').addClass('ts-displayDisable');

                        }
                    });

                }
            });
        }

        $(document).ready(function() {
            $("#form-verificaPessoas").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                if ($("#cnpj_formEntrada").val() != '') {
                    cpfCnpj_formEntrada = $("#cnpj_formEntrada").val();
                }
                if ($("#cpf_formEntrada").val() != '') {
                    cpfCnpj_formEntrada = $("#cpf_formEntrada").val();

                    $('#tabInserirGeral3-tab').hide();
                    $('#tabInserirGeral3').hide();

                    $('#tabInserir3-tab').hide();
                    $('#tabInserir3').hide();
                }

                tipoPessoa_formEntrada = $(".tipoPessoa").val();

                $.ajax({
                    url: "../database/pessoas.php?operacao=processar",
                    beforeSend: function() {
                        setTimeout(function() {
                            $("#consultarPessoa-btn").prop('disabled', true);
                            $(".span-load").addClass("spinner-border");

                        }, 300);
                    },
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(msg) {
                        $("#consultarPessoa-btn").prop('disabled', false);
                        $(".span-load").removeClass("spinner-border");
                        //console.log(JSON.stringify(msg, null, 2));
                        var json = JSON.parse(msg);

                        if (json.descricao == "cadastro existente") {
                            $('#alertaCadastroExistente').removeClass('d-none');
                        } else if (json.descricao == "criar pessoas") {
                            $('#cpfCnpj_geralPessoas').val(cpfCnpj_formEntrada);

                            $.ajax({
                                type: 'POST',
                                dataType: 'html',
                                url: '<?php echo URLROOT ?>/admin/database/geral.php?operacao=buscarGeralPessoas',
                                data: {
                                    cpfCnpj: cpfCnpj_formEntrada,
                                    acao: "filtrar"
                                },
                                success: function(msg) {
                                    //alert(msg);
                                    var json = JSON.parse(msg);

                                    var linha = "";
                                    for (var $i = 0; $i < json.length; $i++) {
                                        var object = json[$i];
                                        //alert(object.caracTrib)

                                        $('#tipoPessoa_complementar').val(object.tipoPessoa);
                                        $('#cpfCnpj_complementar').val(object.cpfCnpj);
                                        $('#nomePessoa_complementar').val(object.nomePessoa);
                                        $('#nomeFantasia_complementar').val(object.nomeFantasia);

                                        $('#email_complementar').val(object.email);
                                        $('#telefone_complementar').val(object.telefone);
                                        $('#codigoCidade_complementar').val(object.codigoCidade);
                                        $('#codigoEstado_complementar').val(object.codigoEstado);
                                        $('#cep_complementar').val(object.cep);
                                        $('#bairro_complementar').val(object.bairro);
                                        $('#endereco_complementar').val(object.endereco);
                                        $('#endNumero_complementar').val(object.endNumero);
                                        $('#municipio_complementar').val(object.municipio);
                                        $('#IE_complementar').val(object.IE);
                                        $('#pais_complementar').val(object.pais);
                                        $('#regimeTrib_complementar').val(object.regimeTrib);
                                        $('#crt_complementar').val(object.crt);
                                        $('#caracTrib_complementar').val(object.caracTrib);
                                        $('#regimeEspecial_complementar').val(object.regimeEspecial);
                                        $('#cnae_complementar').val(object.cnae);

                                        <?php if ($_SESSION['administradora'] != 1) { ?>
                                            (object.email == null || object.email == '' ? $("#email_complementar").prop('readonly', false) : $("#email_complementar").prop('readonly', true));
                                            (object.telefone == null || object.telefone == '' ? $("#telefone_complementar").prop('readonly', false) : $("#telefone_complementar").prop('readonly', true));
                                            (object.cep == null || object.cep == '' ? $("#cep_complementar").prop('readonly', false) : $("#cep_complementar").prop('readonly', true));
                                            (object.bairro == null || object.bairro == '' ? $("#bairro_complementar").prop('readonly', false) : $("#bairro_complementar").prop('readonly', true));
                                            (object.endereco == null || object.endereco == '' ? $("#endereco_complementar").prop('readonly', false) : $("#endereco_complementar").prop('readonly', true));
                                            (object.endNumero == null || object.endNumero == 0 ? $("#endNumero_complementar").prop('readonly', false) : $("#endNumero_complementar").prop('readonly', true));
                                            (object.municipio == null || object.municipio == '' ? $("#municipio_complementar").prop('readonly', false) : $("#municipio_complementar").prop('readonly', true));
                                            (object.IE == null || object.IE == '' ? $("#IE_complementar").prop('readonly', false) : $("#IE_complementar").prop('readonly', true));
                                            (object.pais == null || object.pais == '' ? $("#pais_complementar").prop('readonly', false) : $("#pais_complementar").prop('readonly', true));
                                            (object.regimeTrib == null || object.regimeTrib == '' ? $("#regimeTrib_complementar").removeClass('ts-displayDisable') : $("#regimeTrib_complementar").addClass('ts-displayDisable'));
                                            (object.crt == null || object.crt == '' ? $("#crt_complementar").removeClass('ts-displayDisable') : $("#crt_complementar").addClass('ts-displayDisable'));
                                            (object.caracTrib == null || object.caracTrib == '' ? $("#caracTrib_complementar").removeClass('ts-displayDisable') : $("#caracTrib_complementar").addClass('ts-displayDisable'));
                                            (object.regimeEspecial == null || object.regimeEspecial == '' ? $("#regimeEspecial_complementar").prop('readonly', false) : $("#regimeEspecial_complementar").prop('readonly', true));
                                            (object.cnae == null || object.cnae == '' ? $("#cnae_complementar").prop('readonly', false) : $("#cnae_complementar").prop('readonly', true));
                                        <?php } ?>

                                    }

                                }
                            });

                            $('#verificaPessoaModal').modal('hide');
                            $('#inserirPessoaModal').modal('show');
                        } else if (json.descricao == "cria pessoas geralpessoas") {

                            $('#cpfCnpj_inserirgeral').val(cpfCnpj_formEntrada);
                            $('#tipoPessoa_inserirgeral').val(tipoPessoa_formEntrada);

                            $('#verificaPessoaModal').modal('hide');
                            $('#inserirGeralModal').modal('show');
                        }

                    }
                }); // ajax


            }); //form-verificaPessoas

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

                $.ajax({
                    url: "<?php echo URLROOT ?>/admin/database/geral.php?operacao=geralpessoasAlterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-inserirGeral").submit(function(event) {
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

                $.ajax({
                    url: "<?php echo URLROOT ?>/admin/database/geral.php?operacao=geralpessoasInserir",
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
                    url: "<?php echo URLROOT ?>/admin/database/geral.php?operacao=geralpessoasAlterar",
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

        // lucas 04042024 - Select inserir de crt e regimeTrib
        var vcrt = $('select[name="crt"] option');
        $('select[name="regimeTrib"]').on('change', function() {
            var regimeTrib = this.value;
            var novoSelect = vcrt.filter(function() {
                return $(this).data('datacrt') == regimeTrib;
            });
            $('select[name="crt"]').html(novoSelect);
        });

        //SELECAO DE INPUT TIPO PESSOA
        $("#tipoPessoa_formEntrada").change(function() {
            vtipoPessoa_entrada = $("#tipoPessoa_formEntrada").val()
            if (vtipoPessoa_entrada == "F") {
                $("#cpf_formEntrada").prop('disabled', false);
                $("#cpf_formEntrada").removeClass('d-none');
                $("#cnpj_formEntrada").prop('disabled', true);
                $("#cnpj_formEntrada").addClass('d-none');
                $("#cnpj_formEntrada").val('');
            }
            if (vtipoPessoa_entrada == "J") {
                $("#cnpj_formEntrada").prop('disabled', false);
                $("#cnpj_formEntrada").removeClass('d-none');
                $("#cpf_formEntrada").prop('disabled', true);
                $("#cpf_formEntrada").addClass('d-none');
                $("#cpf_formEntrada").val('');
            }
        })


        document.addEventListener("DOMContentLoaded", function() {
            // INPUT CPF
            var input_cpf = document.getElementById('cpf_formEntrada');
            var placeholder_cpf = '00000000000';

            input_cpf.addEventListener('input', function(event) {
                var value = this.value.replace(/\D/g, '');
                var newValue = '';
                var j = value.length - 1;
                for (var i = placeholder_cpf.length - 1; i >= 0; i--) {
                    if (placeholder_cpf[i] === '0' && value[j]) {
                        newValue = value[j--] + newValue;
                    } else {
                        newValue = placeholder_cpf[i] + newValue;
                    }
                }
                this.value = newValue;
            });

            // INPUT CNPJ
            var input_cnpj = document.getElementById('cnpj_formEntrada');
            var placeholder_cnpj = '00000000000000';

            input_cnpj.addEventListener('input', function(event) {
                var value = this.value.replace(/\D/g, '');
                var newValue = '';
                var j = value.length - 1;
                for (var i = placeholder_cnpj.length - 1; i >= 0; i--) {
                    if (placeholder_cnpj[i] === '0' && value[j]) {
                        newValue = value[j--] + newValue;
                    } else {
                        newValue = placeholder_cnpj[i] + newValue;
                    }
                }
                this.value = newValue;
            });

            //LIMPA INPUT
            input.addEventListener('keydown', function(event) {
                if (event.key === 'Backspace') {
                    var currentValue = this.value.replace(/\D/g, '');
                    if (currentValue.length > 0) {
                        currentValue = currentValue.slice(0, -1);
                        var newValue = '';
                        var j = currentValue.length - 1;
                        for (var i = placeholder.length - 1; i >= 0; i--) {
                            if (placeholder[i] === '0' && currentValue[j]) {
                                newValue = currentValue[j--] + newValue;
                            } else {
                                newValue = placeholder[i] + newValue;
                            }
                        }
                        this.value = newValue;
                    }
                    event.preventDefault();
                }
            });
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>