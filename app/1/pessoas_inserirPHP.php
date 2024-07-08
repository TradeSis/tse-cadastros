<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "pessoa_inserir";
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

$conexaogeral = conectaMysql(null);

if (isset($jsonEntrada['cpfCnpj'])) {

    $cpfCnpj = isset($jsonEntrada['cpfCnpj']) && $jsonEntrada['cpfCnpj'] !== "" ? "'" . $jsonEntrada['cpfCnpj'] . "'" : "NULL";
    
    
    $buscaPessoa = "SELECT * FROM geralpessoas WHERE cpfCnpj = $cpfCnpj";
    $buscar = mysqli_query($conexaogeral, $buscaPessoa);
    $dadosPessoa = mysqli_fetch_array($buscar, MYSQLI_ASSOC);
    if (mysqli_num_rows($buscar) == 0) {
        
        $pessoasEntrada = array(
            'cpfCnpj' => $jsonEntrada['cpfCnpj']
        );

        $pessoasRetorno = chamaAPI(null, '/sistema/geralpessoas', json_encode($pessoasEntrada), 'PUT');

    } 


    $sql = "INSERT INTO pessoas(cpfCnpj) VALUES ($cpfCnpj)";
    

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
        
        $idPessoaInserido = mysqli_insert_id($conexao);
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok",
            "idPessoa" => $idPessoaInserido
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
