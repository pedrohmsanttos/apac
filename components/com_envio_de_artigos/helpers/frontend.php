<?php
/**
 * @version     1.0.0
 * @package     com_envio_de_artigos_1.0.0
 * @copyright   Copyright (C) 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Matheus Felipe <matheus.felipe@inhalt.com.br> - https://www.developer-url.com
 */

defined('_JEXEC') or die;

/**
 * Envio_de_artigos helper
 */
class Envio_de_artigosHelpersFrontend
{
    /**
     * Build the query for search from the search columns
     *
     * @param	string		$searchWord		Search for this text

     * @param	string		$searchColumns	The columns in the DB to search for
     *
     * @return	string		$query			Append the search to this query
     */
    public static function buildSearchQuery($searchWord, $searchColumns, $query)
    {
        $db = JFactory::getDbo();

        $where = array();

        foreach ($searchColumns as $i => $searchColumn)
        {
            $where[] = $db->qn($searchColumn) . ' LIKE ' . $db->q('%' . $db->escape($searchWord, true) . '%');
        }

        if (!empty($where))
        {
            $query->where(implode(' OR ', $where));
        }

        return $query;
    }
}
