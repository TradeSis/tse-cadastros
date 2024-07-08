<?php
// helio 21032023 - compatibilidade chamada chamaApi
// helio 01022023 alterado para include_once
// helio 31012023 - eliminado funcao buscaCliente, ficou apenas buscaClientes,
//					o parametro mudou para o idCliente, e não mais string(where)
//					colocado chamada chamaAPI					
// helio 26012023 - function buscasClientes - Retirado mysql e Colocado CURL (API)
// helio 26012023 16:16

//include_once('../conexao.php');
include_once __DIR__ . "/../conexao.php";

function buscaClientes($idCliente=null)
{
	
	$clientes = array();
	
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	

	$apiEntrada = array(
		'idCliente' => $idCliente,
		'idEmpresa' => $idEmpresa
	);
	
	$clientes = chamaAPI(null, '/cadastros/clientes', json_encode($apiEntrada), 'GET');

	return $clientes;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'nomeCliente' => $_POST['nomeCliente']
		);
		$clientes = chamaAPI(null, '/cadastros/clientes', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCliente' => $_POST['idCliente'],
			'nomeCliente' => $_POST['nomeCliente']
		);
		$clientes = chamaAPI(null, '/cadastros/clientes', json_encode($apiEntrada), 'POST');
	}
	
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCliente' => $_POST['idCliente']
		);
		$clientes = chamaAPI(null, '/cadastros/clientes', json_encode($apiEntrada), 'DELETE');
	}

	header('Location: ../cadastros/clientes.php');
	
}

?>

