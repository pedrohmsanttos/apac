<?php defined('_JEXEC') or die;

class ModRedesSociasHelper
{
    public static function getParams()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__modules'));
        $query->where('module = '.$db->quote('mod_redesociais'));

        $db->setQuery($query);

        $results = $db->loadObjectList();
        $params_object = json_decode($results[0]->params);

        return $params_object;
    }

}
