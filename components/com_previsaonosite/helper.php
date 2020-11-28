<?php 
// No direct access
defined('_JEXEC') or die;
class PrevisaoHelper
{	
	protected $dias  = [];
	protected $meses = [];

	public static function getPrevisoes($mesoregioes)
    {
		date_default_timezone_set('America/Recife');

		$previsoes    = []; 
		$mesorregiaoAmanha = [];
		$mesorregioes = self::getMesorregioes(true, $mesoregioes);
		$horaRecife   = date("H:i:s");

		$previsaoDia = self::getPrevisaoDia(true,true);// Pega a previsão do dia
		$previsaoDia[] = self::getPrevisaoDia(false,true);
		$diaTexto = self::getPrevisaoDiaHora();
		if(count($previsaoDia) > 0)
		{
			if(count($previsaoDia) > 2)
			{
				if($previsaoDia[0]->tipo == "hoje–tarde" || $previsaoDia[0]->tipo == "hoje–manha")
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
					$hora_previsao  = explode(':', $previsaoDia[0]->horario);
					$hora_atual     = explode(':', $horaRecife);
					$mesorregiaoDia = json_decode($previsaoDia[0]->mesorregioes);
				}
			}else{
				$mesorregiaoDia = json_decode($previsaoDia[0]->mesorregioes);
			}

			$arrTmp            = end($previsaoDia);
			if($arrTmp[0]->tipo == 'amanha'){
				$mesorregiaoAmanha = json_decode($arrTmp[0]->mesorregioes);
			}
			
			// Nebulosidade, Tipos de Chuva, Distribuição da chuva, Periodo da chuva e intensidade da chuva
			foreach($mesorregioes as $mesoregiao)
			{
				$chave       = array_search($mesoregiao->id, $mesorregiaoDia->mesorregiao);
				$chaveAmanha = array_search($mesoregiao->id, $mesorregiaoAmanha->mesorregiao);
				
				$objPrevisao = new \stdClass;
				$objPrevisao->id		  = $mesoregiao->id;
				$objPrevisao->messoregiao = $mesoregiao->nome;
				$objPrevisao->tempMin     = $mesorregiaoDia->temMin[$chave].'º';
				$objPrevisao->tempMax     = $mesorregiaoDia->temMax[$chave].'º';
				$objPrevisao->amaTempMin  = $mesorregiaoAmanha->temMin[$chaveAmanha].'º';
				$objPrevisao->amaTempMax  = $mesorregiaoAmanha->temMax[$chaveAmanha].'º';
				$objPrevisao->frase       = $mesorregiaoDia->nebulosidade[$chave].' '.$mesorregiaoDia->TiposDeChuva[$chave].' '.$mesorregiaoDia->DistribuicaoDaChuva[$chave].' '.$mesorregiaoDia->PeriodoDaChuva[$chave].' '.$mesorregiaoDia->IntensidadeDaChuva[$chave];
				$objPrevisao->icone       = $mesorregiaoDia->icone[$chave];
				$objPrevisao->amaIcone    = $mesorregiaoAmanha->icone[$chaveAmanha];
				$objPrevisao->diaTexto	  = $diaTexto->datavlida;
				array_push($previsoes, $objPrevisao);
			}
		}
        return $previsoes;
	}
	
	public static function getPrevisaoDia($hoje = true, $getUltimo = null)
	{
		// DB
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__previsaodotempo_previsao'));
		
		if($hoje)
		{
			$query->where('( tipo = '.$db->quote('hoje–manha').' OR tipo = '.$db->quote('hoje–tarde'). ')');
			if(is_null($getUltimo)){
				$query->where('datavlida = ' . $db->quote(date('Y-m-d')));
			}
		}
		else {
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
		
		$db->setQuery($query);
         
		$results = $db->loadObjectList();
		
		return $results;
	}

	public static function getMesorregioes($state = true, $ids)
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

		if(count(explode(',', $ids)) > 0)
		{
			$query->where($db->quoteName('id') . ' IN ('.$ids.')');
		}

		$query->order('ordering ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		return $results;
	}

	public function getDia($diaTexto)
	{
		$this->meses = array(
			1 => 'Jan',
			'Fev',
			'Mar',
			'Abr',
			'Mai',
			'Jun',
			'Jul',
			'Ago',
			'Set',
			'Out',
			'Nov',
			'Dez'
		);

		$this->dias = array(
			'Domingo',
			'Segunda-Feira',
			'Terça-Feira',
			'Quarta-Feira',
			'Quinta-Feira',
			'Sexta-Feira',
			'Sábado'
		); 
		$data = new DateTime($diaTexto);
		$dia = $data->format('d').'/'.$this->meses[$data->format('n')].'/'.$data->format('Y ').' '.$this->dias[$data->format('w')];

		return $dia;		
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
}