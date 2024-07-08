<?php
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/produtos.php');
include_once(__DIR__ . '/../database/pessoas.php');
include_once(__DIR__ . '/../database/marcas.php');

$produtos = buscarProdutos();
$pessoas = buscarPessoa();
$marcas = buscaMarcas();
//echo json_encode($produtos);
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link rel="stylesheet" href="../css/emoji.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        
        <div class="row align-items-center"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3 text-start">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Produtos</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <button type="button" class="btn btn-success mr-4" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Ativo</th>
                        <th>Foto</th>
                        <th>Produto</th>
                        <th>Emitente</th>
                        <th>Valor</th>
                        <th>Ncm</th>
                        <th>Cest</th>
                        <th width="5%">Propaganda</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <?php
                foreach ($produtos as $produto) {
                    ?>
                    <tr>
                        <td class="ativoEmoji_<?php echo $produto['ativoProduto'] ?>">
                            <p><i class="emojiAtivo bi bi-emoji-smile-fill"></i><i class="emojiNaoAtivo bi bi-emoji-frown-fill"></i></i></p>
                        </td>
                        <td><img src="<?php echo $produto['imgProduto'] ?>" width="60px" height="60px" alt=""></td>
                        <td> <?php echo $produto['nomeProduto'] ?> </td>
                        <td> <?php echo $produto['nome'] ?> </td>
                        <td> <?php echo number_format($produto['valorCompra'], 2, ',', '.'); ?> </td>
                        <td> <?php echo $produto['codigoNcm'] ?> </td>
                        <td> <?php echo $produto['codigoCest'] ?> </td>
                        <td class="ativo_<?php echo $produto['propagandaProduto'] ?>">
                            <p><?php echo $produto['propagandaProduto'] ?></p>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#alterarmodal" data-idProduto="<?php echo $produto['idProduto'] ?>"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#excluirmodal" data-idProduto="<?php echo $produto['idProduto'] ?>"><i class="bi bi-trash3"></i></button>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>


    </div>

        <!--------- INSERIR --------->
        <div class="modal" id="inserirModal" tabindex="-1" aria-labelledby="inserirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inserir Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="inserirForm">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Produto</label>
                                            <input type="text" class="form-control ts-input" name="refProduto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Nome</label>
                                            <input type="text" class="form-control ts-input" name="nomeProduto">
                                            <input type="hidden" class="form-control ts-input" name="idProduto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Emitente</label>
                                            <select class="form-select ts-input" name="idPessoaEmitente">
                                                <option value="<?php echo NULL ?>"></option>
                                                <?php
                                                foreach ($pessoas as $pessoa) {
                                                ?>
                                                    <option value="<?php echo $pessoa['idPessoa'] ?>"><?php echo $pessoa['nomePessoa']  ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </div><!--fim row 1-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Valor</label>
                                            <input type="number" step="any" class="form-control ts-input" name="valorCompra">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Ncm</label>
                                            <input type="text" class="form-control ts-input" name="codigoNcm">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Cest</label>
                                            <input type="text" class="form-control ts-input" name="codigoCest">
                                        </div>
                                    </div><!--fim row 2-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Preço</label>
                                            <input type="number" step="any" class="form-control ts-input" name="precoProduto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Marca</label>
                                            <select class="form-select ts-input" name="idMarca">
                                                <?php
                                                foreach ($marcas as $marca) {
                                                ?>
                                                    <option value="<?php echo $marca['idMarca'] ?>"><?php echo $marca['nomeMarca']  ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label class='form-label ts-label'>Ativo</label>
                                            <select class="form-control ts-input" name="ativoProduto">
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label class='form-label ts-label'>Propaganda</label>
                                            <select class="form-control ts-input" name="propagandaProduto">
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>
                                            </select>
                                        </div>
                                    </div><!--fim row 3-->
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class='form-label ts-label'>Imagem do Produto</label>
                                            <label class="picture" for="fotoInserir" tabIndex="0">
                                                <span class="picture__image" id="inserir"></span>
                                            </label>
                                            <input type="file" name="imgProdutoInserir" class="fotoInput" id="fotoInserir" hidden>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="container-fluid p-0">
                                                <div class="col">
                                                    <span class="tituloEditor">Descrição</span>
                                                </div>
                                                <div class="quill-produtoinserir" style="height:20vh !important"></div>
                                                <textarea style="display: none" id="quill-produtoinserir" name="descricaoProduto"></textarea>
                                            </div>
                                        </div>
                                    </div><!--fim row 4-->
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
        <div class="modal" id="alterarmodal" tabindex="-1" aria-labelledby="alterarmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="alterarForm">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Produto</label>
                                            <input type="text" class="form-control ts-input" id="refProduto" name="refProduto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Nome</label>
                                            <input type="text" class="form-control ts-input" name="nomeProduto" id="nomeProduto">
                                            <input type="hidden" class="form-control ts-input" name="idProduto" id="idProduto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Emitente</label>
                                            <select class="form-select ts-input" name="idPessoaEmitente" id="idPessoaEmitente">
                                                <?php
                                                foreach ($pessoas as $pessoa) {
                                                ?>
                                                    <option value="<?php echo $pessoa['idPessoa'] ?>"><?php echo $pessoa['nome']  ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </div><!--fim row 1-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Valor</label>
                                            <input type="number" step="any" class="form-control ts-input" id="valorCompra" name="valorCompra">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Ncm</label>
                                            <input type="text" class="form-control ts-input" id="codigoNcm" name="codigoNcm">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Cest</label>
                                            <input type="text" class="form-control ts-input" id="codigoCest" name="codigoCest">
                                        </div>
                                    </div><!--fim row 2-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Preço</label>
                                            <input type="number" step="any" class="form-control ts-input" id="precoProduto" name="precoProduto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Marca</label>
                                            <select class="form-select ts-input" id="idMarca" name="idMarca">
                                                <option value="<?php echo NULL ?>"></option>
                                                <?php
                                                foreach ($marcas as $marca) {
                                                ?>
                                                    <option value="<?php echo $marca['idMarca'] ?>"><?php echo $marca['nomeMarca']  ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label class='form-label ts-label'>Ativo</label>
                                            <select class="form-control ts-input" id="ativoProduto" name="ativoProduto">
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label class='form-label ts-label'>Propaganda</label>
                                            <select class="form-control ts-input" id="propagandaProduto" name="propagandaProduto">
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>
                                            </select>
                                        </div>
                                    </div><!--fim row 3-->
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class='form-label ts-label'>Imagem do Produto</label>
                                            <label class="picture" for="fotoAlterar" tabIndex="0">
                                                <span class="picture__image" id="alterar"></span>
                                            </label>
                                            <input type="file" name="imgProdutoAlterar" class="fotoInput" id="fotoAlterar" hidden>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="container-fluid p-0">
                                                <div class="col">
                                                    <span class="tituloEditor">Descrição</span>
                                                </div>
                                                <div class="quill-produtoalterar" style="height:20vh !important"></div>
                                                <textarea style="display: none" id="quill-produtoalterar" id="descricao" name="descricaoProduto"></textarea>
                                            </div>
                                        </div>
                                    </div><!--fim row 4-->
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

        <!--------- EXCLUIR --------->
        <div class="modal" id="excluirmodal" tabindex="-1" aria-labelledby="excluirmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Excluir Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="excluirForm">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Produto</label>
                                            <input type="text" class="form-control ts-input" id="EXCrefProduto" name="refProduto" readonly>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Nome</label>
                                            <input type="text" class="form-control ts-input" name="nomeProduto" id="EXCnomeProduto" readonly>
                                            <input type="hidden" class="form-control ts-input" name="idProduto" id="EXCidProduto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Emitente</label>
                                            <select class="form-select ts-input" name="idPessoaEmitente" id="EXCidPessoaEmitente" disabled>
                                                <option value="<?php echo NULL ?>"></option>
                                                <?php
                                                foreach ($pessoas as $pessoa) {
                                                ?>
                                                    <option value="<?php echo $pessoa['idPessoa'] ?>"><?php echo $pessoa['nome']  ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </div><!--fim row 1-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Valor</label>
                                            <input type="number" step="any" class="form-control ts-input" id="EXCvalorCompra" name="valorCompra" readonly>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Ncm</label>
                                            <input type="text" class="form-control ts-input" id="EXCcodigoNcm" name="codigoNcm" readonly>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Cest</label>
                                            <input type="text" class="form-control ts-input" id="EXCcodigoCest" name="codigoCest" readonly>
                                        </div>
                                    </div><!--fim row 2-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">Preço</label>
                                            <input type="number" step="any" class="form-control ts-input" id="EXCprecoProduto" name="precoProduto" readonly>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">Marca</label>
                                            <select class="form-select ts-input" id="EXCidMarca" name="idMarca" disabled>
                                                <?php
                                                foreach ($marcas as $marca) {
                                                ?>
                                                    <option value="<?php echo $marca['idMarca'] ?>"><?php echo $marca['nomeMarca']  ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label class='form-label ts-label'>Ativo</label>
                                            <select class="form-control ts-input" id="EXCativoProduto" name="ativoProduto" readonly>
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label class='form-label ts-label'>Propaganda</label>
                                            <select class="form-control ts-input" id="EXCpropagandaProduto" name="propagandaProduto" readonly>
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>
                                            </select>
                                        </div>
                                    </div><!--fim row 3-->
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class='form-label ts-label'>Imagem do Produto</label>
                                            <label class="picture" for="fotoExcluir" tabIndex="0">
                                                <span class="picture__image" id="excluir"></span>
                                            </label>
                                            <input type="file" class="fotoInput" id="fotoExcluir" hidden>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="container-fluid p-0">
                                                <div class="col">
                                                    <span class="tituloEditor">Descrição</span>
                                                </div>
                                                <div class="quill-produtoexcluir" style="height:20vh !important"></div>
                                                <textarea style="display: none" id="quill-produtoexcluir" id="EXCdescricao" name="descricaoProduto"></textarea>
                                            </div>
                                        </div>
                                    </div><!--fim row 4-->
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> 
    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <script>
        
        $(document).ready(function() {

            $(document).on('click', 'button[data-bs-target="#alterarmodal"]', function() {
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
                        produtoalterar.root.innerHTML = data.descricaoProduto;
                        $('#idMarca').val(data.idMarca);
                        $('#ativoProduto').val(data.ativoProduto);
                        $('#propagandaProduto').val(data.propagandaProduto);
                        $('#idProduto').val(data.idProduto);
                        $('#nomeProduto').val(data.nomeProduto);
                        $('#refProduto').val(data.refProduto);
                        $('#idPessoaEmitente').val(data.idPessoaEmitente);
                        $('#nome').val(data.nome);
                        $('#valorCompra').val(data.valorCompra);
                        $('#codigoNcm').val(data.codigoNcm);
                        $('#codigoCest').val(data.codigoCest);
                        $('#precoProduto').val(data.precoProduto);
                        $('#imgProduto').val(data.imgProduto);
                        $('#alterarmodal').modal('show');
                    }
                });
            });

            $(document).on('click', 'button[data-bs-target="#excluirmodal"]', function() {
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
                        produtoexcluir.root.innerHTML = data.descricaoProduto;
                        $('#EXCidMarca').val(data.idMarca);
                        $('#EXCativoProduto').val(data.ativoProduto);
                        $('#EXCpropagandaProduto').val(data.propagandaProduto);
                        $('#EXCidProduto').val(data.idProduto);
                        $('#EXCnomeProduto').val(data.nomeProduto);
                        $('#EXCrefProduto').val(data.refProduto);
                        $('#EXCidPessoaEmitente').val(data.idPessoaEmitente);
                        $('#EXCnomePessoa').val(data.nomePessoa);
                        $('#EXCvalorCompra').val(data.valorCompra);
                        $('#EXCcodigoNcm').val(data.codigoNcm);
                        $('#EXCcodigoCest').val(data.codigoCest);
                        $('#EXCprecoProduto').val(data.precoProduto);
                        $('#EXCimgProduto').val(data.imgProduto);
                        $('#excluirmodal').modal('show');
                    }
                });
            });

            $("#inserirForm").submit(function(event) {
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

            $("#alterarForm").submit(function(event) {
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

            $("#excluirForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/produtos.php?operacao=excluir",
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

        //Carregar a FOTO na tela
        const fotoInputs = document.querySelectorAll(".fotoInput");

        fotoInputs.forEach((input, index) => {
            const pictureImage = document.querySelectorAll(".picture__image")[index];
            const pictureImageTxt = "Carregar imagem";
            pictureImage.innerHTML = pictureImageTxt;

            input.addEventListener("change", function (e) {
                const inputTarget = e.target;
                const file = inputTarget.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.addEventListener("load", function (e) {
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
        });


    var produtoinserir = new Quill('.quill-produtoinserir', {
      theme: 'snow'
    });
    var produtoalterar = new Quill('.quill-produtoalterar', {
      theme: 'snow'
    });
    var produtoexcluir = new Quill('.quill-produtoexcluir', {
      theme: 'snow'
    });

    produtoinserir.on('text-change', function(delta, oldDelta, source) {
      $('#quill-produtoinserir').val(produtoinserir.container.firstChild.innerHTML);
    });
    produtoalterar.on('text-change', function(delta, oldDelta, source) {
      $('#quill-produtoalterar').val(produtoalterar.container.firstChild.innerHTML);
    });
    produtoexcluir.on('text-change', function(delta, oldDelta, source) {
      $('#quill-produtoexcluir').val(produtoexcluir.container.firstChild.innerHTML);
    });
  </script>

    

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>