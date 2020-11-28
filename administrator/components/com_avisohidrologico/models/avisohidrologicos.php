<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisohidrologicoModelAvisohidrologicos extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'titulo',
				'identificador',
				'ordering',
				'published'
			);
		}
		parent::__construct($config);
	}

	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$sqlRegiao = '(select array_to_string(array_agg("r"."title"), \',\') AS "regioes" FROM ' . $db->quoteName('#__regioes', 'r') . ' where r.id = any(string_to_array(a.regioes, \',\')::int[]) ) as "regioes"';
		
		// Create the base select statement.
		$query->select('MAX(a.published) as "published", MAX(a.id) as "rg", MAX(a.titulo) as "titulo", MAX(a.regioes) as "regioes", MAX(a.inicio) as "inicio", MAX(a.validade) as "validade", MAX(a.identificador) as "identificador"')
			->from($db->quoteName('#__avisohidrologico', 'a'));

		$query->select($sqlRegiao);
		
		$query->select('MAX("c"."title") AS "category_title"')
			->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = a.tipo');

		$query->select('MAX("u"."name") AS "author"')
			->join('LEFT', $db->quoteName('#__users', 'u') . ' ON u.id = a.user_id');

		$query->select('array_to_string(array_agg("t"."title"), \',\') AS "tag_title"')
			->join('LEFT', $db->quoteName('#__tags', 't') . ' ON t.id = any(string_to_array(a.tags, \',\')::int[])');

		$query->join('LEFT', $db->quoteName('#__regioes', 'r') . ' ON r.id = any(string_to_array(a.regioes, \',\')::int[])');

		$query->select(' le.enviado AS "enviado"')
			->join('LEFT', $db->quoteName('lista_emails', 'le') . ' ON a.id = le.id_item');
		
		$query->group($db->quoteName('a.id'));
		$query->group($db->quoteName('le.enviado'));


		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('titulo LIKE ' . $like);
		}

		// Filter by published state
		$published = $this->getState('filter.published');
		
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		else if($published != '*')
		{
			$query->where('(a.published IN (0, 1))');
		}

		//print_r($query->__toString());die();
		// Filter by status
		$tipo = $this->getState('filter.tipo');
 
		if (is_numeric($tipo))
		{
			$query->where('a.tipo = ' . (int) $tipo, 'AND');
		}

		// Filter by regiões
		$regioes = $this->getState('filter.regioes');
		
		if (!empty($regioes))
		{
			$liker = '';
			foreach($regioes as $index => $value){
				if($index == 0){
					$liker .= "'%".$value."%";
				}else{
					$liker .= $value."%";
				}
			}
			$liker .= "'";
			$query->where('a.regioes LIKE ' . $liker, 'AND');
		}

		// Filter: like / tags
		$tags = $this->getState('filter.tags');
		
		if (!empty($tags))
		{
			$like = '';
			foreach($tags as $index => $value){
				if($index == 0){
					$like .= "'%".$value."%";
				}else{
					$like .= $value."%";
				}
			}
			$like .= "'";
			$query->where('a.tags LIKE ' . $like, 'AND');
		}

		// Filter: autor
		$autor = $this->getState('filter.autor');
 
		if (!empty($autor))
		{
			$query->where('a.user_id = ' . (int) $autor , 'AND');
		}

		$enviado = $this->getState('filter.enviado');

		if (!empty($enviado) && trim($enviado) == 's')
		{
			$query->where('le.enviado = 1');
			
		}else if (!empty($enviado) && trim($enviado) == 'n')
		{
			$query->where('(le.enviado is null OR le.enviado = 0)');
		
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
			$query->where("a.validade < '".$fim."'");
		} else if( (strtotime($agora_date) < strtotime($fim_date)) || (strtotime($fim_date) < strtotime($ini_date)) ) {
			// data fora do range
			$fim = $agora_date->format('Y-m-d');
			$inicio = $inicio;
			$query->where("a.validade between  '". $ini_date->format('Y-m-d')  ."' and '" . $fim ."'");
		} else if($inicio != '' && $fim != '') {
			$fim    = $this->manipulaData($fim, 1);
			$inicio = $inicio;
			$query->where("a.validade between  '". $ini_date->format('Y-m-d') ."' and '" . $fim_date->format('Y-m-d') ."'");
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'ordering');
		$orderDirn 	= $this->state->get('list.direction', 'asc');

		$saveOrder = $listOrder == 'a.ordering';
		
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		if ($saveOrder)
		{
		    $saveOrderingUrl = 'index.php?option=com_avisohidrologico&task=avisohidrologico.saveOrderAjax&tmpl=component';
		    JHtml::_('sortablelist.sortable', 'itemList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
		}
		
		return $query;
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState('ordering', 'ASC');
	}

	public function manipulaData($str, $dias = 0)
	{
			if(empty($str)) return '';
			$pieces = explode("-", $str);
			return $pieces[2] + $dias.'-'.$pieces[1].'-'.$pieces[0];
	}
	  
	protected function getSortFields()
	{
		return array(
			'a.ordering'     => JText::_('JGRID_HEADING_ORDERING'),
			'a.state'        => JText::_('JSTATUS'),
			'a.title'        => JText::_('JGLOBAL_TITLE'),
			'category_title' => JText::_('JCATEGORY'),
			'access_level'   => JText::_('JGRID_HEADING_ACCESS'),
			'a.created_by'   => JText::_('JAUTHOR'),
			'language'       => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.created'      => JText::_('JDATE'),
			'a.id'           => JText::_('JGRID_HEADING_ID'),
			'a.featured'     => JText::_('JFEATURED')
		);
	}
}
