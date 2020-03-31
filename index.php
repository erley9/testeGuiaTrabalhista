<?php 

require_once 'vendor/autoload.php';
use Guzzle\Http\Client;

$client = new GuzzleHttp\Client();

$buscaHtml = $client->request('GET', 'http://www.guiatrabalhista.com.br/guia/salario_minimo.htm');

$html= $buscaHtml->getBody();

$dom = new DOMDocument();
$dom->loadHTML($html);


$links = $dom->getElementsByTagName('table');

$listaFinal = array();


foreach ($links as $link) {
	
	
	$filhos = $link->getElementsByTagName('td');

	$contadorGeral = 0;

	$contador = 0;

	$newlinha = array();

	$titulos = array();

	foreach ($filhos as $filho) {

		

		if($contadorGeral >= 6){


			$newlinha[$titulos[$contador]] = str_replace(" ","",trim($filho->nodeValue));

			if($contador == 5){

				$listaFinal[] = $newlinha;

				$newlinha = array();

				$contador = 0;
			}else{
				$contador ++;
			}
			
		}else{

			$conversao = array('á' => 'a','à' => 'a','ã' => 'a','â' => 'a', 'é' => 'e',
			 'ê' => 'e', 'í' => 'i', 'ï'=>'i', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', "ö"=>"o",
			 'ú' => 'u', 'ü' => 'u', 'ç' => 'c', 'ñ'=>'n', 'Á' => 'A', 'À' => 'A', 'Ã' => 'A',
			 'Â' => 'A', 'É' => 'E', 'Ê' => 'E', 'Í' => 'I', 'Ï'=>'I', "Ö"=>"O", 'Ó' => 'O',
			 'Ô' => 'O', 'Õ' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ç' =>'C', 'Ñ'=>'N');

			$tiraAcentoDoTexto = trim(strtr($filho->nodeValue,$conversao));

			$titulos[] = strtolower(str_replace(" ","_",$tiraAcentoDoTexto));

		}

		

		$contadorGeral++;
	}

	break;
}

echo "<pre>";
print_r($listaFinal);
echo "</pre>";




?>