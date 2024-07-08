<?php
// Lucas 06102023 padrao novo
include_once('../header.php');

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Adicionar Serviço</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="servicos.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form class="mb-4" action="../database/servicos.php?operacao=inserir" method="post" enctype="multipart/form-data">

            <div class="row mt-3">
                <div class="col-sm-12">
                    <label class='form-label ts-label'>Nome do Serviço</label>
                    <input type="text" name="nomeServico" class="form-control ts-input" required autocomplete="off">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-6">
                    <label class='form-label ts-label'>Imagem do Serviço</label>
                    <label class="picture" for="foto" tabIndex="0">
                        <span class="picture__image"></span>
                    </label>
                    <input type="file" name="imgServico" id="foto">
                </div>
            </div>

            <div class="container-fluid p-0 mt-3">
                <div class="col">
                    <span class="tituloEditor">Descrição</span>
                </div>
                <div class="quill-textarea"></div>
                <textarea style="display: none" id="detail" name="descricaoServico"></textarea>
            </div>

            <div class="row mt-3">
                <div class="col-sm-8">
                    <label class='form-label ts-label'>Link Serviço</label>
                    <input type="text" name="linkServico" class="form-control ts-input" autocomplete="off">
                </div>

                <div class="col-sm-4 mt-4">
                    <div class="select-form-group">
                        <label class='form-label ts-label'>Destaque</label>
                        <label for="destaque">Não</label>
                        <input type="range" id="destaque" name="destaque" min="0" max="1" style="width: 15%;">
                        <label for="destaque">Sim</label>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
            </div>
        </form>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script src="<?php echo URLROOT ?>/sistema/js/quilljs.js"></script>
    <script>
        //Carregar a FOTO na tela
        const inputFile = document.querySelector("#foto");
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