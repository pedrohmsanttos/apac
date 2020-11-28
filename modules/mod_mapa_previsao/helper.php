<?php
defined('_JEXEC') or die;

class ModMapaPrevisaoHelper
{

	function getVariaveis($variaveis)
	{
		$todasVariaveis = json_decode($variaveis);
		$retornoVariaveis = array();

		if (!empty($todasVariaveis[0])) {
			foreach ($todasVariaveis as $var) {
				$varExplode = explode(";", $var);

				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('*');
				$query->from($db->quoteName('#__previsaodotempo_mesorregiao'));
				$query->where("nome = '" . $varExplode[0] . "'");
				$query->where('state = 1');
				$query->setLimit('1');

				$db->setQuery($query);
				$rows = $db->loadObjectList();

				$ret = array();
				$ret[$varExplode[1]] = $varExplode[2];

				$retornoVariaveis[$rows[0]->id][] = $ret;
			}
		}


		// var_dump($retornoVariaveis);die;
		return $retornoVariaveis;
	}

	function ordenaByOrdem($previsao)
	{
		$arrRetorno = array();
		$arrRetorno = $previsao;

		function comparaOrdem($a, $b)
		{
			return intval($a['mesoregiao']['ordem']) > intval($b['mesoregiao']['ordem']);
		}
		usort($arrRetorno, 'comparaOrdem');
		return $arrRetorno;
	}

	function getPrevisaoDiaHora()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('MAX(id)');
		$query->from($db->quoteName('#__previsaodotempo_previsao'));
		$query->where('state = 1');
		$query->where('( tipo = ' . $db->quote('hoje–manha') . ' OR tipo = ' . $db->quote('hoje–tarde') . ')');
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$id= $result[0]->max;
		
		if (empty($id)){throw new Exception('<center><h1>Mas Não existe previsões!</h1></center><br>');}
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('datavlida, horario');
		$query->from($db->quoteName('#__previsaodotempo_previsao'));
		
		$query->where('( id = ' . $id . ')');
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$texto= $result[0];
		return $texto;
	}

	function getPrevisaoDia($hoje = true, $getUltimo = null)
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_previsao'));

		if ($hoje) {
			$query->where('( tipo = ' . $db->quote('hoje–manha') . ' OR tipo = ' . $db->quote('hoje–tarde') . ')');

			if(is_null($getUltimo)){
				$query->where('datavlida = ' . $db->quote(date('Y-m-d')));
			}
			
		} else {
			$datetime = new DateTime('tomorrow');
			
			if(is_null($getUltimo)){
				$where .= " (tipo = " . $db->quote('amanha') . " AND datavlida = " . $db->quote($datetime->format('Y-m-d')) . " )";
			}else{
				$where .= " (tipo = " . $db->quote('amanha') . " )";
			}
			
			$query->where($where);
		}
		$query->where('state = 1');
		$query->setLimit('1');
		$query->order('id desc'); 

		// echo $query->__toString();die;
		
		$db->setQuery($query);

		$results = $db->loadObjectList();

		$erroGeoJSON = false;

		
		if (isset($results) && !empty($results)) {

			foreach ($results as $row) {
				$meso = json_decode($row->mesorregioes);

				

				if (!empty($meso->mesorregiao)) {

					foreach ($meso->mesorregiao as $chaveMeso => $m) {

						$queryMeso = $db->getQuery(true);
						$queryMeso->select('*');
						$queryMeso->from($db->quoteName('#__previsaodotempo_mesorregiao'));
						$queryMeso->where('id = ' . $m);
						// $queryMeso->where('state = 1');

						$db->setQuery($queryMeso);
						$rowsMeso = $db->loadObjectList();

						$dadosMesoregiao = array();
						foreach ($rowsMeso as $rMeso) {


							$dadosMesoregiao['nome'] = $rMeso->nome;
							$dadosMesoregiao['ordem'] = $rMeso->ordering;

							$geoJson = file_get_contents(JURI::root() . "uploads/" . $rMeso->geojson, 'UTF-8');

							if ($geoJson === false) {
								$erroGeoJSON = true;
								break;
							} else {
								$dadosMesoregiao['geojson'] = $geoJson;
							}

						}

						if ($erroGeoJSON) {
							break;
						}

						$prev = array();

						$prev['data_previsao'] = $row->datavlida . " " . $row->horario;
						$prev['IntensidadeDoVento'] = $meso->IntensidadeDoVento[$chaveMeso];
						$prev['RotaDoVento'] = $meso->RotaDoVento[$chaveMeso];
						$prev['nebulosidade'] = $meso->nebulosidade[$chaveMeso];
						$prev['TiposDeChuva'] = $meso->TiposDeChuva[$chaveMeso];
						$prev['DistribuicaoDaChuva'] = $meso->DistribuicaoDaChuva[$chaveMeso];
						$prev['PeriodoDaChuva'] = $meso->PeriodoDaChuva[$chaveMeso];
						$prev['IntensidadeDaChuva'] = $meso->IntensidadeDaChuva[$chaveMeso];
						$prev['icone'] = $meso->icone[$chaveMeso];
						$prev['temMin'] = $meso->temMin[$chaveMeso];
						$prev['temMax'] = $meso->temMax[$chaveMeso];
						$prev['umiMin'] = $meso->umiMin[$chaveMeso];
						$prev['umiMax'] = $meso->umiMax[$chaveMeso];
						$prev['icone'] = $meso->icone[$chaveMeso];

						$previsao[$m]['previsao'] = $prev;

						$variaveis = self::getVariaveis($row->valores);
						
						// foreach ($variaveis as $chaveVar => $var) {
						// 	$previsao[$chaveVar]['variaveis'] = $var;
						// }
						foreach ($variaveis as $chaveVar => $var) {
							if($chaveVar == $m){
								$previsao[$m]['variaveis'] = $var;
							}
						}

						if($rowsMeso[0]->state == 1){
							$previsao[$m]['mesoregiao'] = $dadosMesoregiao;
							
						}else{
							unset($previsao[$m]);
						}
						
					}

				}
			}

		}	
		
		if (!empty($previsao)) {
			$previsao = self::ordenaByOrdem($previsao);
		}

		if ($erroGeoJSON) {
			$previsao = array();
		}

		// var_dump($previsao);die;

		$retorno = array();
		$retorno['previsao'] = $previsao;

		if($erroGeoJSON){
			$retorno['erro'] = true;
		}else{
			$retorno['erro'] = false;
		}
		
		return $retorno;
	}


}