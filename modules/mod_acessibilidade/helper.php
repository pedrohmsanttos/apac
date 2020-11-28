<?php 
// No direct access
defined('_JEXEC') or die;
class ModAcessibilidadeHelper
{ 
	function montaLinkAcessibilidade($categId,$categAlias,$artId,$artAlias)
	{
	    // exemplo: descubra-pernambuco/34-descubra-pernambuco/30-cultura
	    return $categAlias.'/'.$categId.'-'.$categAlias.'/'.$artId.'-'.$artAlias;
	}

	function getArticle($id)
	{
		if(empty($id)) return array();
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	     
	    $query->select($db->quoteName(array('id', 'title', 'introtext','catid','alias')));
	    $query->from($db->quoteName('#__content'));
	    $query->where('id='.$id);
	     
	    $db->setQuery($query);
	     
	    $articlesList = $db->loadObjectList();
	    return $articlesList[0];
	}

	function getCategory($id)
	{
		if(empty($id)) return array();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
			
		$query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
		$query->from($db->quoteName('#__categories'));
		$query->where('id='.$id);
			
		$db->setQuery($query);
			
		$categoryList = $db->loadObjectList();
		
		return $categoryList[0];
	}

	public static function getParamRedesSociais()
    {
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__modules'));

        $query->where('module = '.$db->quote('mod_redesociais').' ');
         
        $db->setQuery($query);
         
        $results = $db->loadObjectList();
        $params_object = json_decode($results[0]->params);

        return $params_object;
	}
	
	public static function getPrevisoes()
    {
		date_default_timezone_set('America/Recife');

		$previsoes    = []; 
		$previsaoDia  = [];
		$mesorregioes = self::getMesorregioes();
		$horaRecife   = date("H:i:s");

		$numPrevisoes = (int) self::CountPrevisaoDia();
		
		if($numPrevisoes > 0)
			$previsaoDia = self::getPrevisaoDia(true, 0);// Pega a ultima previsao do tipo hoje mamnhã/tarde
		

		if(count($previsaoDia) > 0)
		{
			if(count($previsaoDia) > 1 && $previsaoDia[0]->datavlida == date('Y-m-d'))
			{
				if($previsaoDia[0]->tipo == "hoje–tarde")
				{
					$hora_previsao = explode(':', $previsaoDia[0]->horario);
					$hora_atual    = explode(':', $horaRecife);
					if($hora_previsao[0] <= $hora_atual[0] && $hora_previsao[1] <= $hora_atual[1])
					{
						$mesorregiaoDia = json_decode($previsaoDia[0]->mesorregioes);
					}
					else
					{	
						$mesorregiaoDia = json_decode($previsaoDia[1]->mesorregioes);
					}
				}
				else
				{
					$hora_previsao = explode(':', $previsaoDia[1]->horario);
					$hora_atual    = explode(':', $horaRecife);
					if($hora_previsao[0] <= $hora_atual[0] && $hora_previsao[1] <= $hora_atual[1])
					{
						$mesorregiaoDia = json_decode($previsaoDia[1]->mesorregioes);
					}
					else
					{	
						$mesorregiaoDia = json_decode($previsaoDia[0]->mesorregioes);
					}
				}
			}else{
				$mesorregiaoDia = json_decode($previsaoDia[0]->mesorregioes);
			}
			
			// modelar
			foreach($mesorregioes as $mesoregiao)
			{
				$chave = array_search($mesoregiao->id, $mesorregiaoDia->mesorregiao);
				$objPrevisao = new \stdClass;
				$objPrevisao->messoregiao = $mesoregiao->nome;
				$objPrevisao->tempMin = $mesorregiaoDia->temMin[$chave];
				$objPrevisao->tempMax = $mesorregiaoDia->temMax[$chave];
				array_push($previsoes, $objPrevisao);
			}
		}
		
        return $previsoes;
	}

	public static function CountPrevisaoDia()
	{
		// DB
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select('count(*)');
        $query->from($db->quoteName('#__previsaodotempo_previsao'));
		$query->where('( tipo = '.$db->quote('hoje–manha').' OR tipo = '.$db->quote('hoje–tarde'). ')');
		$query->where('state = 1');
		
		$db->setQuery($query);
        
		$results = $db->loadObjectList();
		
		return $results[0]->count;
	}
	
	public static function getPrevisaoDia($hoje = true, $dias = 0)
	{
		if($dias > 7)
			return [];
		// DB
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__previsaodotempo_previsao'));
		
		if($hoje)
		{
			$query->where('( tipo = '.$db->quote('hoje–manha').' OR tipo = '.$db->quote('hoje–tarde'). ')');
			$query->where('datavlida <= '.$db->quote(date('Y-m-d')));
		}
		else
		{
			//$query->where('tipo = '.$db->quote('amanha'));
			$query->where('( tipo = '.$db->quote('hoje–manha').' OR tipo = '.$db->quote('hoje–tarde'). ')');
			$query->where('datavlida = '.$db->quote(date('Y-m-d', strtotime('-'.$dias.' days', strtotime(date('d-m-Y')) ))) );
		}
		$query->where('state = 1');
		$query->setLimit('10');
		$query->order('datavlida desc'); 
		
		$db->setQuery($query);
        
		$results = $db->loadObjectList();

		return $results;
	}

	public static function getMesorregioes($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_mesorregiao'));
		if($state)
		{
			$query->where($db->quoteName('state') . ' =  1');
		}
		
		$query->order('ordering ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		
		return $results;
	}
}