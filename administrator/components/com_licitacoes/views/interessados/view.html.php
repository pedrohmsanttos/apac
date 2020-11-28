<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 *
 * @since  1.6
 */

class LicitacoesViewInteressados extends JViewLegacy
{

   public function display($tpl = null)
    {
         
        
        $requests = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $id = $_REQUEST['id'];
        $doc = $_REQUEST['doc'];
        $nome = $_REQUEST['nome'];
        $tipo = $_REQUEST['tipo'];

        $query->select('a.documento_usuario, a.nome_razao, a.tipo_users, a.telefone_users');
        $query->from('#__relatorio_licitacao as a');
        $query->join('INNER', '#__users AS u ON u.id = a.id_users');
        $query->where("a.id_licitacao = '" . $id . "'", "AND");
        if (!empty($doc)) {
            $query->where("a.documento_usuario = '" . $doc . "'", "AND");
        }
        if(!empty($nome)) {
            $query->where("a.nome_razao Like '%" . $nome . "%'", "AND");
        }
       if (!empty($tipo)){
            $query->where("a.tipo_users = '". $tipo . "'");
        }

        $query->order('a.id');
        $db->setQuery($query);

        $results = $db->loadObjectList();

       if (count($errors = $this->get('Errors')))
        {
           throw new Exception(implode("\n", $errors));
        }

        echo(json_encode($results));die;
    }
}
