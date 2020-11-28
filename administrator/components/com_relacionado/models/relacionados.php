<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class RelacionadoModelRelacionados extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'titulo'
			);
		}
 
		parent::__construct($config);
	}
 
	protected function getListQuery()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
				->from($db->quoteName('#__relacionado'));
				
		$search = $this->getState('filter.search');
 
		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('titulo LIKE ' . $like);
		}
 
			
		$published = $this->getState('filter.published');
		
		if (is_numeric($published))
		{
			$query->where('published = ' . (int) $published);
		}
		else if($published != '*')
		{
			$query->where('(published IN (0, 1))');
		}

		// filtro artigos
		$artigos = $this->getState('filter.artigos');
		
		if (!empty($artigos))
		{
			$indexCount = 0;
			arsort($artigos);
			$liker = '';
			foreach($artigos as $index => $value){
				if($indexCount == 0){
					$liker .= "'%".$value."%";
				}else{
					$liker .= $value."%";
				}
				$indexCount++;
			}
			$liker .= "'";
			$query->where('artigos LIKE ' . $liker, 'AND');
		}

		// Filter: autor
		$autor = $this->getState('filter.autor');
 
		if (!empty($autor))
		{
			$query->where('user_id = ' . (int) $autor , 'AND');
		}

		// Filter: date
		$inicio = $this->getState('filter.dta_ini');
		$fim = $this->getState('filter.dta_end');
		$agora_date = new DateTime();
		$agora_date = $agora_date->format('Y-m-d');
		$fim_date   = new DateTime($fim);
		$fim_date->add(new DateInterval('P1D'));
		$ini_date   = new DateTime($inicio);

		if($inicio == '' && $fim != ''){
			$query->where("created < '".$fim."'");
		} else if( (strtotime($agora_date) < strtotime($fim_date)) || (strtotime($fim_date) < strtotime($ini_date)) ) {
			// data fora do range
			$fim = $agora_date->format('Y-m-d');
			$inicio = $inicio;
			$query->where("created between  '". $ini_date->format('Y-m-d')  ."' and '" . $fim ."'");
		} else if($inicio != '' && $fim != '') {
			$fim    = $this->manipulaData($fim, 1);
			$inicio = $inicio;
			$query->where("created between  '". $ini_date->format('Y-m-d') ."' and '" . $fim_date->format('Y-m-d') ."'");
		}
 
		$orderCol	= $this->state->get('list.ordering', 'id');
		$orderDirn 	= $this->state->get('list.direction', 'asc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		
		return $query;
	}

	public function manipulaData($str, $dias = 0)
	{
			if(empty($str)) return '';
			$pieces = explode("-", $str);
			return $pieces[2] + $dias.'-'.$pieces[1].'-'.$pieces[0];
	}
}