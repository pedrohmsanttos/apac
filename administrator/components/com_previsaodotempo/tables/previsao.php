	<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
	// No direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
/**
 * previsao Table class
 *
 * @since  1.6
 */
class PrevisaodotempoTableprevisao extends JTable
{

	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		JObserverMapper::addObserverClassToClass('JTableObserverContenthistory', 'PrevisaodotempoTableprevisao', array('typeAlias' => 'com_previsaodotempo.previsao'));
		parent::__construct('#__previsaodotempo_previsao', 'id', $db);
	}

	public function checkOut($userId, $pk = null){
		return true;
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param   array  $array   Named array
	 * @param   mixed  $ignore  Optional array or list of parameters to ignore
	 *
	 * @return  null|string  null is operation was satisfactory, otherwise returns an error
	 *
	 * @see     JTable:bind
	 * @since   1.5
	 */
	public function bind($array, $ignore = '')
	{
		date_default_timezone_set('America/Recife');

		$date = JFactory::getDate();
		$task = JFactory::getApplication()->input->get('task');

		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');

		// montar a mesorregioes
		$array['mesorregioes'] = json_encode(
			array(
				'IntensidadeDoVento' => $input->get('IntensidadeDoVento', '', 'ARRAY'),
				'mesorregiao' => $input->get('mesorregioes', '', 'ARRAY'),
				'RotaDoVento' => $input->get('RotaDoVento', '', 'ARRAY'),
				'nebulosidade' => $input->get('nebulosidade', '', 'ARRAY'),
				'TiposDeChuva' => $input->get('TiposDeChuva', '', 'ARRAY'),
				'DistribuicaoDaChuva' => $input->get('DistribuicaoDaChuva', '', 'ARRAY'),
				'PeriodoDaChuva' => $input->get('PeriodoDaChuva', '', 'ARRAY'),
				'IntensidadeDaChuva' => $input->get('IntensidadeDaChuva', '', 'ARRAY'),
				'icone' => $input->get('icone', '', 'ARRAY'),
				'temMin' => $input->get('temMin', '', 'ARRAY'),
				'temMax' => $input->get('temMax', '', 'ARRAY'),
				'umiMin' => $input->get('umiMin', '', 'ARRAY'),
				'umiMax' => $input->get('umiMax', '', 'ARRAY')
			)
		);

		$array['valores'] = json_encode(explode(',', $input->get('valores', '', 'RAW')));

		if ($array['id'] == 0 && empty($array['created_by'])) {
			$array['created_by'] = JFactory::getUser()->id;
		}

		if ($array['id'] == 0 && $task != 'save2copy') {
			$valida = self::getPrevisaoDia($array['tipo'], $array['datavlida']);
			if (count($valida) > 0) {
				$url = JRoute::_('index.php?option=com_previsaodotempo&view=previsao&layout=edit');
				JError::raiseError(500, 'Previsão já cadastrada!');
				JFactory::getApplication()->redirect($url);
			}
			$array['checked_out_time'] = 'NOW()';
		}

		if ($task == 'save2copy' && $array['id'] == 0) {
			$array['state'] = 0;
			$array['checked_update_time'] = 'NOW()';
		}

		if ($array['id'] == 0 && empty($array['modified_by'])) {
			$array['modified_by'] = JFactory::getUser()->id;
		}

		if ($task == 'apply' || $task == 'save') {
			$array['modified_by'] = JFactory::getUser()->id;
		}
			
			// Support for empty date field: datavlida
		if ($array['datavlida'] == '0000-00-00' || $array['datavlida'] == '') {
			$array['datavlida'] = '';
		} else {
			$arrData = explode('-', $array['datavlida']);
				//var_dump($array['datavlida']);die();
			if (count($arrData) <= 0) {
					//$array['datavlida'] = DateTime::createFromFormat('d/m/Y', $array['datavlida'])->format('Y-m-d');
					//$array['datavlida'] = date("Y-m-d", strtotime(str_replace("/", "-", $array['datavlida'])));
			} else {
					//$array['datavlida'] = DateTime::createFromFormat('d/m/Y', $array['datavlida'])->format('Y-m-d');
			}
		}

			// Support for multiple field: tipo
		if (isset($array['tipo'])) {
			if (is_array($array['tipo'])) {
				$array['tipo'] = implode(',', $array['tipo']);
			} elseif (strpos($array['tipo'], ',') != false) {
				$array['tipo'] = explode(',', $array['tipo']);
			} elseif (strlen($array['tipo']) == 0) {
				$array['tipo'] = '';
			}
		} else {
			$array['tipo'] = '';
		}

		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry;
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata'])) {
			$registry = new JRegistry;
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string)$registry;
		}

		if (!JFactory::getUser()->authorise('core.admin', 'com_previsaodotempo.previsao.' . $array['id'])) {
			$actions = JAccess::getActionsFromFile(
				JPATH_ADMINISTRATOR . '/components/com_previsaodotempo/access.xml',
				"/access/section[@name='previsao']/"
			);
			$default_actions = JAccess::getAssetRules('com_previsaodotempo.previsao.' . $array['id'])->getData();
			$array_jaccess = array();

			foreach ($actions as $action) {
				if (key_exists($action->name, $default_actions)) {
					$array_jaccess[$action->name] = $default_actions[$action->name];
				}
			}

			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}

			// Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules'])) {
			$this->setRules($array['rules']);
		}

		$array['checked_out'] = JFactory::getUser()->id;
		$array['checked_update_time'] = 'NOW()';
		
		//return parent::bind($array, $ignore);
	}

	public static function getPrevisaoDia($tipo, $data)
	{
			// DB
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_previsao'));
		$query->where('tipo = ' . $db->quote($tipo));
		$query->where('state = 1');
		$query->where('datavlida = ' . $db->quote($data));

		$db->setQuery($query);

		$results = $db->loadObjectList();

		return $results;
	}

	/**
	 * This function convert an array of JAccessRule objects into an rules array.
	 *
	 * @param   array  $jaccessrules  An array of JAccessRule objects.
	 *
	 * @return  array
	 */
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();

		foreach ($jaccessrules as $action => $jaccess) {
			$actions = array();

			if ($jaccess) {
				foreach ($jaccess->getData() as $group => $allow) {
					$actions[$group] = ((bool)$allow);
				}
			}

			$rules[$action] = $actions;
		}

		return $rules;
	}

	/**
	 * Overloaded check function
	 *
	 * @return bool
	 */
	public function check()
	{
			// If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0) {
			$this->ordering = self::getNextOrder();
		}

		return parent::check();
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param   mixed    $pks     An optional array of primary key values to update.  If not
	 *                            set the instance property value is used.
	 * @param   integer  $state   The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param   integer  $userId  The user id of the user performing the operation.
	 *
	 * @return   boolean  True on success.
	 *
	 * @since    1.0.4
	 *
	 * @throws Exception
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
			// Initialise variables.
		$k = $this->_tbl_key;

			// Sanitize input.
		ArrayHelper::toInteger($pks);
		$userId = (int)$userId;
		$state = (int)$state;

			// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks)) {
			if ($this->$k) {
				$pks = array($this->$k);
			}
				// Nothing to set publishing state on, return false.
			else {
				throw new Exception(500, JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
			}
		}

			// Build the WHERE clause for the primary keys.
		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

			// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time')) {
			$checkin = '';
		} else {
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int)$userId . ')';
		}

			// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE ' . $this->_tbl . '' .
				' SET state = ' . (int)$state .
				' WHERE (' . $where . ')' .
				$checkin
		);
		$this->_db->execute();

			// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows())) {
				// Checkin each row.
			foreach ($pks as $pk) {
				$this->checkin($pk);
			}
		}

			// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks)) {
			$this->state = $state;
		}

		return true;
	}

	/**
	 * Define a namespaced asset name for inclusion in the #__assets table
	 *
	 * @return string The asset name
	 *
	 * @see JTable::_getAssetName
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_previsaodotempo.previsao.' . (int)$this->$k;
	}

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @param   JTable   $table  Table name
	 * @param   integer  $id     Id
	 *
	 * @see JTable::_getAssetParentId
	 *
	 * @return mixed The id on success, false on failure.
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
			// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');

			// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();

			// The item has the component as asset-parent
		$assetParent->loadByName('com_previsaodotempo');

			// Return the found asset-parent-id
		if ($assetParent->id) {
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	/**
	 * Delete a record by id
	 *
	 * @param   mixed  $pk  Primary key value to delete. Optional
	 *
	 * @return bool
	 */
	public function delete($pk = null)
	{
		$this->load($pk);
		$result = parent::delete($pk);

		return $result;
	}
}
