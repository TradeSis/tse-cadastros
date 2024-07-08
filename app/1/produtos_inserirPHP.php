<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "produtos_inserir";
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

if (isset($jsonEntrada['nomeProduto'])) {

    
    $eanProduto = isset($jsonEntrada['eanProduto']) && $jsonEntrada['eanProduto'] !== "" ? "'" . $jsonEntrada['eanProduto'] . "'" : "NULL";
    $nomeProduto = isset($jsonEntrada['nomeProduto']) && $jsonEntrada['nomeProduto'] !== "" ? "'" . $jsonEntrada['nomeProduto'] . "'" : "NULL";
    
    $buscaProduto = "SELECT * FROM geralprodutos WHERE nomeProduto = $nomeProduto";
    $buscar = mysqli_query($conexaogeral, $buscaProduto);
    $dadosProduto = mysqli_fetch_array($buscar, MYSQLI_ASSOC);
    if (mysqli_num_rows($buscar) == 0) {
        
        $geralProdutosEntrada = array(
			'eanProduto' => $jsonEntrada['eanProduto'],
			'nomeProduto' => $jsonEntrada['nomeProduto']
		);

        $geralProdutosRetorno = chamaAPI(null, '/cadastros/geralprodutos', json_encode($geralProdutosEntrada), 'PUT');
        $idGeralProduto = $geralProdutosRetorno['idGeralProduto'];
    } else {
        $idGeralProduto = $dadosProduto['idGeralProduto'];
    }

    $idPessoaFornecedor = isset($jsonEntrada['idPessoaFornecedor']) && $jsonEntrada['idPessoaFornecedor'] !== "" ? "'" . $jsonEntrada['idPessoaFornecedor'] . "'" : "NULL";
    $refProduto = isset($jsonEntrada['refProduto']) && $jsonEntrada['refProduto'] !== "" && $jsonEntrada['refProduto'] !== "NULL" ? "'" . $jsonEntrada['refProduto'] . "'" : "NULL";
    $valorCompra = isset($jsonEntrada['valorCompra']) && $jsonEntrada['valorCompra'] !== "" ? "'" . $jsonEntrada['valorCompra'] . "'" : "NULL";
    $substICMSempresa = isset($jsonEntrada['substICMSempresa']) && $jsonEntrada['substICMSempresa'] !== "" ? "'" . $jsonEntrada['substICMSempresa'] . "'" : "'N'";
    $substICMSFornecedor = isset($jsonEntrada['substICMSFornecedor']) && $jsonEntrada['substICMSFornecedor'] !== "" ? "'" . $jsonEntrada['substICMSFornecedor'] . "'" : "'N'";
    $codigoNcm = isset($jsonEntrada['codigoNcm']) && $jsonEntrada['codigoNcm'] !== "" ? "'" . $jsonEntrada['codigoNcm'] . "'" : "NULL";
    $codigoCest = isset($jsonEntrada['codigoCest']) && $jsonEntrada['codigoCest'] !== "" ? "'" . $jsonEntrada['codigoCest'] . "'" : "NULL";
   
    $sql = "INSERT INTO produtos (idGeralProduto, idPessoaFornecedor, refProduto, nomeProduto, valorCompra, substICMSempresa, substICMSFornecedor, codigoNcm, codigoCest) 
            VALUES ($idGeralProduto, $idPessoaFornecedor, $refProduto, $nomeProduto, $valorCompra, $substICMSempresa, $substICMSFornecedor, $codigoNcm, $codigoCest)";


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

        $idProdutoInserido = mysqli_insert_id($conexao);
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok",
            "idProduto" => $idProdutoInserido
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
