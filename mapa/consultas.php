<?php

include("../configuration.php");

$config = new JConfig(); 
		
define("HOST", $config->host);
define("BASE_DADOS", $config->db);
define("USER", $config->user);
define("PASS", $config->password);
define("PREFIX", $config->dbprefix);

$stringConnection="host=".HOST."   dbname=".BASE_DADOS."   user=".USER."    password=".PASS."";

function getVariaveis($variaveis){
	$todasVariaveis = json_decode($variaveis);
	$retornoVariaveis = array();

	if(!empty( $todasVariaveis[0] )){
		foreach ($todasVariaveis as $var) {
			$varExplode = explode(";", $var);

			$stringConnection="host=".HOST."   dbname=".BASE_DADOS."   user=".USER."    password=".PASS."";
			$conn = pg_connect($stringConnection) or die(pg_last_error());

			$query = "SELECT * FROM public." . PREFIX . "previsaodotempo_mesorregiao WHERE nome = '" . $varExplode[0] . "' and state = 1 LIMIT 1;";

			// echo $query . "<br>";

			$data   = pg_query($conn,$query) or die ('Error database: ' . pg_last_error());
			$rows 	= pg_fetch_all($data);

			$ret = array();
			$ret[$varExplode[1]] = $varExplode[2];

			$retornoVariaveis[$rows[0]['id']][] = $ret;
		}
	}

	return $retornoVariaveis;
}

// $conn = pg_connect($stringConnection) or die(pg_last_error());

function getPrevisaoDia($hoje = true)
{
	$stringConnection="host=".HOST."   dbname=".BASE_DADOS."   user=".USER."    password=".PASS."";
	$conn = pg_connect($stringConnection) or die(pg_last_error());

	$query = "SELECT * FROM public." . PREFIX . "previsaodotempo_previsao WHERE";

	if($hoje)
	{
		$query.= " ( tipo = 'hoje–manha' OR tipo = 'hoje–tarde')";
		$query.= " AND datavlida <= '" . date('Y-m-d') . "' AND ";
	}
	else
	{
		$query.= " ( tipo = 'amanha')";
		$query.= " AND datavlida = '" . date('Y-m-d', strtotime('-1 days', strtotime(date('d-m-Y')) )) . "' AND";
	}

	$query.= " state = 1 ORDER BY id desc LIMIT 1";

	  // echo $query;die;

	$data   = pg_query($conn,$query) or die ('Error database: ' . pg_last_error());
	$rows 	= pg_fetch_all($data);

	
	$previsao = array();

	if(isset($rows) && !empty($rows)){

		foreach ($rows as $row) {
			$meso = json_decode( $row['mesorregioes'] );
			 // var_dump($row);die;

			if(!empty($meso->mesorregiao)){

				foreach ($meso->mesorregiao as $chaveMeso => $m) {

					$queryMeso 	= "SELECT * FROM public." . PREFIX . "previsaodotempo_mesorregiao";
					$queryMeso .= " WHERE id = " . $m . " AND state = 1";

					$dataMeso   = pg_query($conn,$queryMeso) or die ('Error database: ' . pg_last_error());
					$rowsMeso 	= pg_fetch_all($dataMeso);

					$dadosMesoregiao = array();
					foreach ($rowsMeso as $rMeso) {
						$dadosMesoregiao['nome'] 	= $rMeso['nome'];
						$dadosMesoregiao['ordem'] 	= $rMeso['ordering'];
						$dadosMesoregiao['geojson'] = $rMeso['geojson'];
					}

					$previsao[$m]['mesoregiao'] = $dadosMesoregiao;

					$prev = array();
					$prev['data_previsao'] 			= $row['checked_out_time'];
					$prev['IntensidadeDoVento'] 	= $meso->IntensidadeDoVento[$chaveMeso];
					$prev['RotaDoVento'] 			= $meso->RotaDoVento[$chaveMeso];
					$prev['nebulosidade'] 			= $meso->nebulosidade[$chaveMeso];
					$prev['TiposDeChuva'] 			= $meso->TiposDeChuva[$chaveMeso];
					$prev['DistribuicaoDaChuva'] 	= $meso->DistribuicaoDaChuva[$chaveMeso];
					$prev['PeriodoDaChuva'] 		= $meso->PeriodoDaChuva[$chaveMeso];
					$prev['IntensidadeDaChuva'] 	= $meso->IntensidadeDaChuva[$chaveMeso];
					$prev['icone'] 					= $meso->icone[$chaveMeso];
					$prev['temMin'] 				= $meso->temMin[$chaveMeso];
					$prev['temMax'] 				= $meso->temMax[$chaveMeso];
					$prev['umiMin'] 				= $meso->umiMin[$chaveMeso];
					$prev['umiMax'] 				= $meso->umiMax[$chaveMeso];

					$previsao[$m]['previsao'] = $prev;

					$variaveis = getVariaveis($row['valores']);

					// var_dump($variaveis);

					foreach ($variaveis as $chaveVar => $var) {
						$previsao[$chaveVar]['variaveis'] = $var;
					}
				}

			}
		}

	}
	// die;
	return $previsao;
}