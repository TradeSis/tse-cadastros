<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
    $idEmpresa = $jsonEntrada["idEmpresa"];
}
$conexao = conectaMysql($idEmpresa);
$dadosCEP = array();


if (isset($jsonEntrada["cep"])) {
    $cep = $jsonEntrada['cep'];
}

//Busca parametros nota
$sql_parametros = "SELECT * FROM notasparametros where idEmpresa = $idEmpresa";
$buscar_parametros = mysqli_query($conexao, $sql_parametros);
$parametros = mysqli_fetch_array($buscar_parametros, MYSQLI_ASSOC);

//Chamar Function para emitir nota nuvemFiscal
$config = NuvemFiscal\Configuration::getDefaultConfiguration()
    ->setApiKey('Authorization', 'Bearer')
    ->setAccessToken($parametros['access_token']);
$apiInstance = new NuvemFiscal\Api\CepApi(
    new GuzzleHttp\Client(),
    $config
);
$dadosCEP = $apiInstance->consultarCep($cep);

$jsonSaida = $dadosCEP;


