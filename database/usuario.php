<?php
// helio 21032023 - compatibilidade chamada chamaApi
// Lucas 08032023 alterado buscaUsuarios(nomeUsuario=null) para buscaUsuarios($idUsuario=null)
// gabriel 06022023 adicionado função busca atendente
// helio 01022023 consertado operacao inserir
// helio 01022023 altereado para include_once, usando funcao conectaMysql
// helio 26012023 16:16

//include_once('../conexao.php');
include_once __DIR__ . "/../conexao.php";

function buscaUsuarios($idUsuario=null,$idLogin=null)
{

	$usuario = array();	

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	
	$apiEntrada = array(
		'idUsuario' => $idUsuario,
		'idLogin' => $idLogin,
		'idEmpresa' => $idEmpresa
	);	
	$usuario = chamaAPI(null, '/cadastros/usuario', json_encode($apiEntrada), 'GET');
	return $usuario;
}

function buscaAtendente($idUsuario=null)
{
	$atendente = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	
	$apiEntrada = array(
		'idUsuario' => $idUsuario,
		'idEmpresa' => $idEmpresa
	);
	$atendente = chamaAPI(null, '/cadastros/atendente', json_encode($apiEntrada), 'GET');
	return $atendente;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'nomeUsuario' => $_POST['nomeUsuario'],
			'email' => $_POST['email'],
			'idCliente' => $_POST['idCliente']
			
		);
		$usuario = chamaAPI(null, '/cadastros/usuario', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao == "alterar") {

		
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario'],
			'nomeUsuario' => $_POST['nomeUsuario'],
			'email' => $_POST['email'],
			'idCliente' => $_POST['idCliente'],
			'statusUsuario' => $_POST['statusUsuario']
		);
		
		$usuario = chamaAPI(null, '/cadastros/usuario', json_encode($apiEntrada), 'POST');
	}

	if ($operacao == "excluir") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idUsuario' => $_POST['idUsuario']
		);
		$usuario = chamaAPI(null, '/cadastros/usuario', json_encode($apiEntrada), 'DELETE');
	}
	
	
	header('Location: ../configuracao/?tab=configuracao&stab=usuario');

}

?>
