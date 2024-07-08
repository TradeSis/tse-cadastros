<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "marcas_alterar";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "cadastros_" . date("dmY") . ".log", "a");
        }
    }
}
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idMarca'])) {

    $idMarca = $jsonEntrada['idMarca'];
    $nomeMarca = $jsonEntrada['nomeMarca'];
    $imgMarca = $jsonEntrada['imgMarca'];
    $bannerMarca = $jsonEntrada['bannerMarca'];
    $descricaoMarca = $jsonEntrada['descricaoMarca'];
    $cidadeMarca = $jsonEntrada['cidadeMarca'];
    $estado = $jsonEntrada['estado'];
    $urlMarca = $jsonEntrada['urlMarca'];
    $ativoMarca = $jsonEntrada['ativoMarca'];
    $catalogo = $jsonEntrada['catalogo'];
    $lojasEspecializadas = $jsonEntrada['lojasEspecializadas'];

    if (($imgMarca == 'null') && ($bannerMarca == 'null')) {
        $sql = "UPDATE marcas SET nomeMarca ='$nomeMarca', descricaoMarca ='$descricaoMarca', cidadeMarca ='$cidadeMarca', estado ='$estado', urlMarca ='$urlMarca', ativoMarca ='$ativoMarca', catalogo ='$catalogo', lojasEspecializadas ='$lojasEspecializadas' WHERE idMarca = $idMarca ";
    } elseif ($imgMarca == 'null') {
        $sql = "UPDATE marcas SET nomeMarca ='$nomeMarca', bannerMarca ='$bannerMarca', descricaoMarca ='$descricaoMarca', cidadeMarca ='$cidadeMarca', estado ='$estado', urlMarca ='$urlMarca', ativoMarca ='$ativoMarca', catalogo ='$catalogo', lojasEspecializadas ='$lojasEspecializadas' WHERE idMarca = $idMarca ";
    } elseif ($bannerMarca == 'null') {
        $sql = "UPDATE marcas SET nomeMarca ='$nomeMarca', imgMarca ='$imgMarca', descricaoMarca ='$descricaoMarca', cidadeMarca ='$cidadeMarca', estado ='$estado', urlMarca ='$urlMarca', ativoMarca ='$ativoMarca', catalogo ='$catalogo', lojasEspecializadas ='$lojasEspecializadas' WHERE idMarca = $idMarca ";
    } else {
        $sql = "UPDATE marcas SET nomeMarca ='$nomeMarca', imgMarca ='$imgMarca', bannerMarca ='$bannerMarca', descricaoMarca ='$descricaoMarca', cidadeMarca ='$cidadeMarca', estado ='$estado', urlMarca ='$urlMarca', ativoMarca ='$ativoMarca', catalogo ='$catalogo', lojasEspecializadas ='$lojasEspecializadas' WHERE idMarca = $idMarca ";
    }


    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } catch (Exception $e) {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL >= 1) {
            fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
        }
    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH


} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
