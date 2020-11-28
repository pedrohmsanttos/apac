<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ContatoModelContatos extends JModelList
{

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'nome',
				'assunto',
				'mensagem',
				'published'
			);
		}
 
		parent::__construct($config);
	}

	public function manipulaData($str, $dias = 0)
	{
			if(empty($str)) return '';
			$pieces = explode("-", $str);
			return $pieces[2] + $dias.'-'.$pieces[1].'-'.$pieces[0];
	}
 
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
 
		// Create the base select statement.
		$query->select('*')
                ->from($db->quoteName('#__contato'));
 
 
 		// Filter: like / search
		$search = $this->getState('filter.search');
 
		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('nome LIKE ' . $like);
		}
 
		// Filter by published state
		$published = $this->getState('filter.published');
		
		if (is_numeric($published))
		{	
			$query->where('published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(published IN (0, 1))');
		}

		// Filter by status
		$status = $this->getState('filter.status');
 
		if (is_numeric($status))
		{
			$query->where('status = ' . (int) $status);
		}

		// Filter: like / setor
		$setor = $this->getState('filter.setor');
 
		if (!empty($setor))
		{
			$like = $db->quote('%' . $setor . '%');
			$query->where('setor LIKE ' . $like);
		}

		// Filter: date
		$inicio = $this->getState('filter.dta_ini');
		$fim = $this->getState('filter.dta_end');
		$agora_date = new DateTime();
		$agora_date = $agora_date->format('Y-m-d H:i:s');
		$fim_date   = new DateTime($fim);
		$fim_date->add(new DateInterval('P1D'));
		$ini_date   = new DateTime($inicio);

		if($inicio == '' && $fim != ''){
			$query->where("created < '".$fim."'");
		} else if( (strtotime($agora_date) < strtotime($fim_date)) || (strtotime($fim_date) < strtotime($ini_date)) ) {
			// data fora do range
			$fim = $agora_date->format('Y-m-d H:i:s');
			$inicio = $inicio;
			$query->where("created between  '". $inicio ."' and '" . $fim ."'");
		} else if($inicio != '' && $fim != '') {
			$fim    = $this->manipulaData($fim, 1);
			$inicio = $inicio;
			$query->where("created between  '". $inicio ."' and '" . $fim ."'");
		}
 
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'created');
		$orderDirn 	= $this->state->get('list.direction', 'desc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
 
		return $query;
	}

}