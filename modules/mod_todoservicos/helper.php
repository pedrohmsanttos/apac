<?php
class ModServicosHelper
{
    public static function getParams()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__modules'));
        $query->where('module = ' .$db->quote("mod_todoservicos"));

        $db->setQuery($query);

        $results = $db->loadObjectList();
        $params_object = json_decode($results[0]->params);

        return $params_object;
    }

     public static function getCategoriasPorServicosAtivas()
    {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__categories'));
        $query->where("extension = ".$db->quote('com_servico'));

        $db->setQuery($query);

        $categoriasDeServicos = $db->loadObjectList();

        if(! empty($categoriasDeServicos)){
            foreach ($categoriasDeServicos as $catServico) {
                $catServico->itens = self::getServicosPelaCategoria($catServico->id);
            }
        }
        return $categoriasDeServicos;
    }


    public static function getServicosPelaCategoria($catid)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__servico'));
        $db->setQuery($query);
        $query->where("catid = $catid");
        $servicos = $db->loadObjectList();

        return $servicos;
    }

    public static function getParamVal($param_title)
    {
        $params = self::getParams();
        $prm = (array) $params;
        return (! empty($prm["$param_title"])) ? $prm["$param_title"] : '';
    }

    public static function getItens()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext')));
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1');

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList;
    }
    public static function getArticle($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext','catid')));
        $query->from($db->quoteName('#__content'));
        $query->where('id='.$id);

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList[0];
    }

    public static function getCategory($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','description')));
        $query->from($db->quoteName('#__categories'));
        $query->where('id='.$id);

        $db->setQuery($query);

        $categoryList = $db->loadObjectList();
        return $categoryList[0];
    }
     public static function getLink($id_artigo)
    {
        $categId = self::getArticle($id_artigo)->catid;
        return 'index.php?option=com_content&view=article&id='.$id_artigo.'&catid='.$categId;
    }

    public static function getServiceItens()
    {
        $abas = array();
        $params_arr = (array) self::getParams();

        $itens_separados = explode("*", $params_arr["selectServiceItem_a"]);
        $abas["aba_a"]["links"]   = explode("|", $itens_separados[1]);
        $abas["aba_a"]["titulos"] = explode("|", $itens_separados[0]);

        $itens_separados = explode("*", $params_arr["selectServiceItem_b"]);
        $abas["aba_b"]["links"]   = explode("|", $itens_separados[1]);
        $abas["aba_b"]["titulos"] = explode("|", $itens_separados[0]);

        $itens_separados = explode("*", $params_arr["selectServiceItem_c"]);
        $abas["aba_c"]["links"]   = explode("|", $itens_separados[1]);
        $abas["aba_c"]["titulos"] = explode("|", $itens_separados[0]);

        $itens_separados = explode("*", $params_arr["selectServiceItem_d"]);
        $abas["aba_d"]["links"]   = explode("|", $itens_separados[1]);
        $abas["aba_d"]["titulos"] = explode("|", $itens_separados[0]);

        return $abas;

    }

    public static function getModal($aba_selecionada){
        $params_arr = (array) self::getParams();

        if(empty($params_arr["$aba_selecionada"])) :

            $modal_content = '';
            $modal_content .= '<div class="esconde-modal" id="'.$aba_selecionada.'-modal-content">';
            $modal_content .= '
                    <h1>Cadastre os ítens de serviços</h1><br/>
                    <p class="pull-right botoes-modal">

                        <button id="salva-aba-'.$aba_selecionada.'" data-aba="'.$aba_selecionada.'" class="btn btn-small btn-success salva-itens">
                            <span class="icon-apply icon-white"></span>
                        Salvar</button>

                        <button class="btn btn-small btn-danger cancela-edicao">
                            <span class="icon-apply icon-white"></span>
                        cancelar</button>

                    </p><p>&nbsp;</p>
                    <table class="table">';

                    for ($i=1; $i <=10 ; $i++) {

                        $modal_content .=
                                '<tr>
                                <td>
                                    <div class="form-group">
                                        <label for="titulo">Título:</label>
                                        <input type="text" class="form-control" id="titulo_'.$aba_selecionada.'-'.$i.'">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="link">Link:</label>
                                        <input type="text" class="form-control" id="link_'.$aba_selecionada.'-'.$i.'">
                                    </div>
                                </td>
                            </tr>';

                    }

            $modal_content .= '</table>';
            $modal_content .=  '</div>';
        else:
            $itens_separados = explode("*", $params_arr["$aba_selecionada"]);
            $itens_titulo    = explode("|", $itens_separados[0]);
            $itens_link      = explode("|", $itens_separados[1]);
            $modal_content   = '';
            $registros = count($itens_titulo);
            echo "$registros encontrados";
            //$modal_content .= '<div class="basic-modal" id="'.$aba_selecionada.'-modal-content">';
            $modal_content .= '<div class="esconde-modal" id="'.$aba_selecionada.'-modal-content">';
            $modal_content .= '
                    <h1>Edite os ítens de serviços</h1><br/>
                    <p class="pull-right">

                        <button id="salva-aba-'.$aba_selecionada.'" data-aba="'.$aba_selecionada.'" class="btn btn-small btn-success salva-itens">
                            <span class="icon-apply icon-white"></span>
                        Salvar</button>

                        <button class="btn btn-small btn-danger cancela-edicao">
                            <span class="icon-apply icon-white"></span>
                        cancelar</button>

                    </p><p>&nbsp;</p>
                    <table class="table">';
            //foreach ($itens_titulo as $key => $item_titulo) :
            for ($i=$registros; $i >= ($registros - 12) ; $i--) :

                $modal_content .='<tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="titulo">Título:</label>
                                            <input type="text"
                                                   class="form-control"
                                                   value="'. $itens_titulo[$i].'"
                                                   id="titulo_'.$aba_selecionada.'-'.$i.'">
                                        </div>
                                    </td>';

                $modal_content .= '
                                    <td>
                                        <div class="form-group">
                                            <label for="link">Link:</label>
                                            <input type="text"
                                                   class="form-control"
                                                   value="'.urldecode($itens_link[$i]).'"
                                                   id="link_'.$aba_selecionada.'-'.$i.'">
                                        </div>
                                    </td>
                                </tr>';
                //if($i == count($itens_titulo) - 2) break;
                //if($key == 9) break;
            endfor;

            $modal_content .='</table>';
            $modal_content .=  '</div>';

        endif;
        return $modal_content;
    }
}
