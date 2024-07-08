<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "produtos_alterar";
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

if (isset($jsonEntrada['idProduto'])) {

    $idProduto = isset($jsonEntrada['idProduto']) && $jsonEntrada['idProduto'] !== "" ? "'" . $jsonEntrada['idProduto'] . "'" : "NULL";
    $idGeralProduto = isset($jsonEntrada['idGeralProduto']) && $jsonEntrada['idGeralProduto'] !== "" ? "'" . $jsonEntrada['idGeralProduto'] . "'" : "NULL";
    $idPessoaFornecedor = isset($jsonEntrada['idPessoaFornecedor']) && $jsonEntrada['idPessoaFornecedor'] !== "" ? "'" . $jsonEntrada['idPessoaFornecedor'] . "'" : "NULL";
    $refProduto = isset($jsonEntrada['refProduto']) && $jsonEntrada['refProduto'] !== "" ? "'" . $jsonEntrada['refProduto'] . "'" : "NULL";
    $nomeProduto = isset($jsonEntrada['nomeProduto']) && $jsonEntrada['nomeProduto'] !== "" ? "'" . $jsonEntrada['nomeProduto'] . "'" : "NULL";
    $valorCompra = isset($jsonEntrada['valorCompra']) && $jsonEntrada['valorCompra'] !== "" ? "'" . $jsonEntrada['valorCompra'] . "'" : "NULL";
    $substICMSempresa = isset($jsonEntrada['substICMSempresa']) && $jsonEntrada['substICMSempresa'] !== "" ? "'" . $jsonEntrada['substICMSempresa'] . "'" : "NULL";
    $substICMSFornecedor = isset($jsonEntrada['substICMSFornecedor']) && $jsonEntrada['substICMSFornecedor'] !== "" ? "'" . $jsonEntrada['substICMSFornecedor'] . "'" : "NULL";
    $codigoNcm = isset($jsonEntrada['codigoNcm']) && $jsonEntrada['codigoNcm'] !== "" ? "'" . $jsonEntrada['codigoNcm'] . "'" : "NULL";
    $codigoCest = isset($jsonEntrada['codigoCest']) && $jsonEntrada['codigoCest'] !== "" ? "'" . $jsonEntrada['codigoCest'] . "'" : "NULL";
   

    $sql = "UPDATE produtos SET idGeralProduto=$idGeralProduto,idPessoaFornecedor=$idPessoaFornecedor,refProduto=$refProduto,nomeProduto=$nomeProduto, valorCompra=$valorCompra,
                                substICMSempresa=$substICMSempresa,substICMSFornecedor=$substICMSFornecedor,codigoNcm=$codigoNcm,codigoCest=$codigoCest WHERE idProduto = $idProduto";

   
    //echo $sql;

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
