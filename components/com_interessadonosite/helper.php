<?php 
// No direct access
defined('_JEXEC') or die;
class InteressadoHelper
{	
	protected $dias  = [];
	protected $meses = [];

	public function getAvisosMeteorologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_avisometeorologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
		
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return $results;
	}

	public function verificacao($email)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id');
		$query->from($db->quoteName('#__cadastrointeressado'));
		$query->where('email = ' . $db->q($email));
    	
		
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return empty($results);
	}

	public function getAvisosHidrologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_avisohidrologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
				
		
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		//var_dump($results);die;
		
		return $results;
	}

	public function getInformesMeteorologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_informemeteorologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
	
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return $results;
	}

	public function getInformesHidrologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_informehidrologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
	
	
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return $results;
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

	public function getInteressado($id)
	{

		$db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select('*');
		$query->from($db->quoteName('#__cadastrointeressado'));
		$query->where($db->quoteName('id') . '='.$id);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		return $results;

	}
}