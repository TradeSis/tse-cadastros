<?php
//Gabriel 28042023

/* include_once('../conexao.php'); */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . "/../conexao.php";

$idEmpresa = null;
if (isset($_SESSION['idEmpresa'])) {
	$idEmpresa = $_SESSION['idEmpresa'];
}

function buscaEstabelecimento($etbcod = null, $pagina = null)
{

	$estab = array();
    $idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'idEmpresa' => $idEmpresa,
					'etbcod' => $etbcod,
					'pagina' => $pagina
				)
			)
		);
	$estab = chamaAPI(null, '/cadastros/estab', json_encode($apiEntrada), 'GET');
	return $estab;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$idEmpresa = null;
		if (isset($_SESSION['idEmpresa'])) {
			$idEmpresa = $_SESSION['idEmpresa'];
		}

		$apiEntrada = 
		array(
			"estab" => array(
				array(
					'etbcod' => $_POST['etbcod'],
					'etbnom' => $_POST['etbnom'],
					'munic' => $_POST['munic'],
					'idEmpresa' => $idEmpresa
				)
			)
		);

		$estab = chamaAPI(null, '/cadastros/estab', json_encode($apiEntrada), 'PUT');

	}

	if ($operacao == "alterar") {

		$idEmpresa = null;
		if (isset($_SESSION['idEmpresa'])) {
			$idEmpresa = $_SESSION['idEmpresa'];
		}

		$apiEntrada = 
		array(
			"estab" => array(
				array(
					'etbcod' => $_POST['etbcod'],
					'etbnom' => $_POST['etbnom'],
					'munic' => $_POST['munic'],
					'supcod' => $_POST['supcod'],
					'idEmpresa' => $idEmpresa
				)
			)
		);

		$estab = chamaAPI(null, '/cadastros/estab', json_encode($apiEntrada), 'POST');
		echo json_encode($estab);
		return $estab;
	}

	if ($operacao == "buscar") {

		$etbcod = isset($_POST["etbcod"])  && $_POST["etbcod"] !== "" && $_POST["etbcod"] !== "null" ? $_POST["etbcod"]  : null;
		$pagina = isset($_POST["pagina"])  && $_POST["pagina"] !== "" && $_POST["pagina"] !== "null" ? $_POST["pagina"]  : 0;
	
		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'idEmpresa' => $idEmpresa,
					'etbcod' => $etbcod,
					'pagina' => $pagina
				)
			)
		);
		$estab = chamaAPI(null, '/cadastros/estab', json_encode($apiEntrada), 'GET');

		echo json_encode($estab);
		return $estab;
	}

	header('Location: ../cadastros/estab.php');

}