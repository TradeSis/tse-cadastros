<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "marcas_inserir";
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
if (isset($jsonEntrada['nomeMarca'])) {

    $slug = $jsonEntrada['slug'];
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


    $sql = "INSERT INTO marcas (`slug`,`nomeMarca`,`imgMarca`,`bannerMarca`,`descricaoMarca`,`cidadeMarca`,`estado`,`urlMarca`,`ativoMarca`,`catalogo`,`lojasEspecializadas`) VALUES ('$slug','$nomeMarca','$imgMarca','$bannerMarca','$descricaoMarca','$cidadeMarca','$estado','$urlMarca','$ativoMarca','$catalogo','$lojasEspecializadas')";

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
