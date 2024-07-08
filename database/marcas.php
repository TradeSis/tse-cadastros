<?php
include_once __DIR__ . "/../conexao.php";

function buscaMarcasSlug($slug)
{
	
	$autor = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'slug' => $slug,
		'idEmpresa' => $idEmpresa
	);

	$autor = chamaAPI(null, '/cadastros/marcas_slug', json_encode($apiEntrada), 'GET');
	return $autor;
}

function buscaMarcas($idMarca=null)
{
	
	$autor = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idMarca' => $idMarca,
		'idEmpresa' => $idEmpresa
	);

	$autor = chamaAPI(null, '/cadastros/marcas', json_encode($apiEntrada), 'GET');
	return $autor;
}

function buscaMarcasAtiva($estado=null, $lojasEspecializadas=null)
{
	
	$autor = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'estado' => $estado,
		'lojasEspecializadas' => $lojasEspecializadas,
		'idEmpresa' => $idEmpresa
	);

	$autor = chamaAPI(null, '/cadastros/marcas', json_encode($apiEntrada), 'GET');
	return $autor;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

    if ($operacao=="inserir") {

		$imgMarca = $_FILES['imgMarca'];

		if($imgMarca !== null) {
			preg_match("/\.(png|jpg|jpeg|svg){1}$/i", $imgMarca["name"],$ext);
		
			if($ext == true) {
				$pasta = ROOT . "/img/";
				$novoNomeImg = $_POST['nomeMarca']. "_" .$imgMarca["name"];
				$pathImg = 'http://' . $_SERVER["HTTP_HOST"] .'/img/' . $novoNomeImg;
				move_uploaded_file($imgMarca['tmp_name'], $pasta.$novoNomeImg);
		
			}else{
				$novoNomeImg = "Sem_imagem";
			}
	
		}

		$bannerMarca = $_FILES['bannerMarca'];

		if($bannerMarca !== null) {
			preg_match("/\.(png|jpg|jpeg|svg){1}$/i", $bannerMarca["name"],$ext);
		
			if($ext == true) {
				$pasta = ROOT . "/img/";
				$novoNomeBanner = $_POST['nomeMarca']. "_" .$bannerMarca["name"];
				$pathBanner = 'http://' . $_SERVER["HTTP_HOST"] .'/img/' . $novoNomeBanner;
				move_uploaded_file($bannerMarca['tmp_name'], $pasta.$novoNomeBanner);
		
			}else{
				$novoNomeBanner = "Sem_imagem";
			}
	
		}

		$apiEntrada = array(
			'slug' => $_POST['slug'],
			'nomeMarca' => $_POST['nomeMarca'],
            'imgMarca' => $pathImg,
            'bannerMarca' => $pathBanner,
			'descricaoMarca' => $_POST['descricaoMarca'],
			'cidadeMarca' => $_POST['cidadeMarca'],
			'estado' => $_POST['estado'],
			'urlMarca' => $_POST['urlMarca'],
			'ativoMarca' => $_POST['ativoMarca'],
			'catalogo' => $_POST['catalogo'],
			'lojasEspecializadas' => $_POST['lojasEspecializadas'],
			'idEmpresa' => $_SESSION['idEmpresa']
			
		);/* 
		echo json_encode($apiEntrada);
		return; */
		$marca = chamaAPI(null, '/cadastros/marcas', json_encode($apiEntrada), 'PUT');
		
	}

	$operacao = $_GET['operacao'];

    if ($operacao=="alterar") {

		$imgMarca = $_FILES['imgMarca'];

		if($imgMarca !== null) {
			preg_match("/\.(png|jpg|jpeg|svg){1}$/i", $imgMarca["name"],$ext);
		
			if($ext == true) {
				$pasta = ROOT . "/img/";
				$novoNomeImg = $_POST['nomeMarca']. "_" .$imgMarca["name"];
				$pathImg = 'http://' . $_SERVER["HTTP_HOST"] .'/img/' . $novoNomeImg;
				move_uploaded_file($imgMarca['tmp_name'], $pasta.$novoNomeImg);
		
			}else{
				$pathImg = "null";
			}
		}

		$bannerMarca = $_FILES['bannerMarca'];

		if($bannerMarca !== null) {
			preg_match("/\.(png|jpg|jpeg|svg){1}$/i", $bannerMarca["name"],$ext);
		
			if($ext == true) {
				$pasta = ROOT . "/img/";
				$novoNomeBanner = $_POST['nomeMarca']. "_" .$bannerMarca["name"];
				$pathBanner= 'http://' . $_SERVER["HTTP_HOST"] .'/img/' . $novoNomeBanner;
				move_uploaded_file($bannerMarca['tmp_name'], $pasta.$novoNomeBanner);
		
			}else{
				$pathBanner = "null";
			}
	
		}
	
			$apiEntrada = array(

				'idMarca' => $_POST['idMarca'],
				'nomeMarca' => $_POST['nomeMarca'],
				'descricaoMarca' => $_POST['descricaoMarca'],
				'cidadeMarca' => $_POST['cidadeMarca'],
				'imgMarca'=> $pathImg,
				'bannerMarca'=> $pathBanner,
				'estado' => $_POST['estado'],
				'urlMarca' => $_POST['urlMarca'],
				'ativoMarca' => $_POST['ativoMarca'],
				'catalogo' => $_POST['catalogo'],
				'lojasEspecializadas' => $_POST['lojasEspecializadas'],
				'idEmpresa' => $_SESSION['idEmpresa']
				
			);
	
		$marca = chamaAPI(null, '/cadastros/marcas', json_encode($apiEntrada), 'POST');
		
	}

	

	
	if ($operacao=="excluir") {

		$apiEntrada = array(
			'idMarca' => $_POST['idMarca'],
			'idEmpresa' => $_SESSION['idEmpresa']
		);

		if(!empty($_POST['imgMarca'])){
			$pasta = ROOT . "/img/";
			$imagem = $pasta . $_POST['imgMarca'];
			
			if(file_exists($imagem)){
				unlink($imagem);
			}

		}

		if(!empty($_POST['bannerMarca'])){
			$pasta = ROOT . "/img/";
			$imagem2 = $pasta . $_POST['bannerMarca'];
			
			if(file_exists($imagem2)){
				unlink($imagem2);
			}

		}

		$marca = chamaAPI(null, '/cadastros/marcas', json_encode($apiEntrada), 'DELETE');
	}


	header('Location: ../cadastros/marcas.php');	
	
}

?>