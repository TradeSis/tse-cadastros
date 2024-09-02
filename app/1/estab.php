<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "estab";
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

$dados = array();

$progr = new chamaprogress();

// PASSANDO idEmpresa PARA PROGRESS
if (isset($jsonEntrada['idEmpresa'])) {
   $progr->setempresa($jsonEntrada['idEmpresa']);
}

$retorno = $progr->executarprogress("cadastros/app/1/estab", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$dados = json_decode($retorno, true);
if (isset($dados["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
    $dados = $dados["conteudoSaida"][0];
} else {
    if((!isset($jsonEntrada['dadosEntrada'][0])) && ($jsonEntrada['dadosEntrada'][0]['etbcod'] != null)){
        $dados = $dados['estab'][0];
    }else{
        $dados = $dados["estab"];
    }

}



$jsonSaida = $dados;


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

fclose($arquivo);

?>