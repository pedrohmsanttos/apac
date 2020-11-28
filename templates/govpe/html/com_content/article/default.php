<?php
  defined('_JEXEC') or die;
  require_once ('helper.php');
  


  JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');   
  // Create shortcuts to some parameters.
  $params  = $this->item->params;
  $images  = json_decode($this->item->images);
  $urls    = json_decode($this->item->urls);
  $canEdit = $params->get('access-edit');
  $user    = JFactory::getUser();
  $info    = $params->get('info_block_position', 0);
   
  // Check if associations are implemented. If they are, define the parameter.
  $assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));
  JHtml::_('behavior.caption');
  
  $isBlogArticle = false;
  $hasModuleAtRightSidebar = false;
  
  if(! empty(getArticleFromBlogCategory($this->item->id)))
  {
    $isBlogArticle = true;
  }
  
  $newArticleList = getArticlesFromBlogCategory();
  $relacionado_id = getRelacionadoIdByArticleId($this->item->id);

  if(!empty($relacionado_id))
  {
    $temRelacionada = true;
  }
  else
  {
    $temRelacionada = false;
  }

  if(!empty($temRelacionada)) :
    // relacionado
    $config =& JFactory::getConfig(); 

    define("HOST", $config['host']);
    define("BASE_DADOS", $config['db']);
    define("USER", $config['user']);
    define("PASS", $config['password']);

    global $servidor_cabure,$usuario_cabure,$senha_cabure,$bd_cabure,$StringConnection;

    $GLOBALS['servidor_cabure']=HOST;
    $GLOBALS['usuario_cabure']=USER;
    $GLOBALS['senha_cabure']=PASS;
    $GLOBALS['bd_cabure']=BASE_DADOS;

    $StringConnection="host=".$GLOBALS['servidor_cabure']."   dbname=".$GLOBALS['bd_cabure']."   user=".$GLOBALS['usuario_cabure']."    password=".$GLOBALS['senha_cabure']."";
    $GLOBALS['StringConnection']=$StringConnection;

    $conn = pg_connect($GLOBALS['StringConnection']) or die(pg_last_error());

    $arrRelacionados = explode(',', $relacionado_id);
    $arrItensRelacio = array();
    
    for($index = 0; $index < count($arrRelacionados); ++$index)
    {
      $_sqlstr="SELECT  id, titulo, ordering ";
      $_sqlstr=$_sqlstr."FROM public.j27a9_relacionado ";
      $_sqlstr=$_sqlstr." WHERE published = 1 ";
      $_sqlstr=$_sqlstr." AND id = ".$arrRelacionados[$index]." ";
      $_sqlstr=$_sqlstr." ORDER BY ordering DESC ";
      //var_dump($_sqlstr);die();
      $_data   = pg_query($conn,$_sqlstr) or die ('Error _database: ');
      $_rows   = pg_num_rows($_data);
      $arrObj = [];

      if($_rows > 0){
        $id       = pg_result($_data,0,'id');
        $titulo   = pg_result($_data,0,'titulo');
        $ordering = pg_result($_data,0,'ordering');
        $stdObj = new stdClass();
        $sqlstr=" SELECT  id , arquivo,titulo , created ,  id_relacionado,
        id_user,  tipo,parent_id,level_id,level_parent
        FROM public.j27a9_relacionado_anexo ";
        $sqlstr=$sqlstr." where 1 = 1 ";
        $sqlstr=$sqlstr." and public.j27a9_relacionado_anexo.id_relacionado =".$id ."";
        $sqlstr=$sqlstr." order by id asc ";
        
        $data = pg_query($conn,$sqlstr) or die ('Error database: ');
        $rows = pg_num_rows($data);
        
        for($w = 0; $w < $rows; ++$w)
        {
          $ojjTmp  = new stdClass();
          $ojjTmp->id = pg_result($data, $w, 'id');
          $ojjTmp->arquivo = pg_result($data, $w, 'arquivo');
          $ojjTmp->titulo = pg_result($data, $w, 'titulo');
          $ojjTmp->id_relacionado = pg_result($data, $w, 'id_relacionado');
          $ojjTmp->tipo = pg_result($data, $w, 'tipo');
          $ojjTmp->parent_id = pg_result($data, $w, 'parent_id');
          $ojjTmp->level_id = pg_result($data, $w, 'level_id');
          $ojjTmp->level_parent = pg_result($data, $w, 'level_parent');
          $ojjTmp->print = true;
          $arrTemp = $ojjTmp;
          array_push($arrObj, $arrTemp);
        }
        $stdObj->titulo    = $titulo;
        $stdObj->itens     = $arrObj;
        $stdObj->ordering  = $ordering;
        array_push($arrItensRelacio, $stdObj);
      }
      
    }
    if(count($arrRelacionados) > 0){
      usort($arrItensRelacio, "ordenar");
    }
    
  endif;

  $infomes = JHtml::_('content.prepare', '{loadposition informes}');
  
  if($isBlogArticle || !empty($temRelacionada) || $infomes != '')
  {  
    $left_div_class = 'eight';
    $hasItens = true;
    echo '<link rel="stylesheet" href="templates/govpe/css/bootstrap.css">';
  }
  else
  {
    $left_div_class = 'twelve';
  }   
?>

<link rel="stylesheet" href="http://maxazan.github.io/jquery-treegrid/css/jquery.treegrid.css">
<link rel="stylesheet" href="templates/govpe/css/style.css">
<div class="row" style="background-color: rgba(255,255,255,0.5)">
   <div class="mobile-four <?php echo $left_div_class ?>  columns">
      <?php if($isBlogArticle) : ?>
      <div class="addthis_inline_share_toolbox">
         <div id="fb-root"></div>
         <div class="row">
            <div class="mobile-four six columns">
               <div class="fb-like"
                  data-href="index.php?option=com_content&view=article&id=<?php echo $this->item->catid; ?>"
                  data-layout="standard"
                  data-action="like"
                  data-show-faces="true">
               </div>
            </div>
            <div>
            </div>
            <div class="mobile-four three columns nomargin">
               <div class="fb-share-button"
                  data-href="index.php?option=com_content&view=article&id=<?php echo $this->item->catid; ?>"
                  data-layout="button_count">
               </div>
            </div>
            <div></div>
            <div class="mobile-four two columns nomargin">
               <div class="g-plus" data-action="share" data-height="24" data-href="index.php?option=com_content&view=article&id=<?php echo $this->item->catid; ?>"></div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- Fim Área Social -->
      <?php /* if(!empty($this->item->metadesc)): ?>
      <header class="info-header">
         <span class="icon info-header-span">
         <i class="fa fa-exclamation-triangle"></i>
         </span>
         <?php 	echo $this->item->metadesc; ?>
      </header>
      <?php endif; */?>
      <div class="page-content post item-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
         <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
         <?php if ($this->params->get('show_page_heading')) : ?>
         <div class="page-header">
            <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
         </div>
         <?php endif;
            if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
            {
            	echo $this->item->pagination;
            }
            ?>
         <?php // Todo Not that elegant would be nice to group the params ?>
         <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
            || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>
         <?php if (!$useDefList && $this->print) : ?>
         <div id="pop-print" class="btn hidden-print">
            <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
         </div>
         <div class="clearfix"> </div>
         <?php endif; ?>
         <?php if ($params->get('show_title') || $params->get('show_author')) : ?>
         <div class="page-header post-header">
            <?php if ($params->get('show_title')) : ?>
            <h2 itemprop="headline">
               <?php echo $this->escape($this->item->title); ?>
            </h2>
            <small class="categories">
            <a href="index.php?option=com_content&view=category&id=<?php echo $this->item->catid; ?>" title="">
            <?php echo $this->item->category_title; ?>
            </a>
            </small>
            <?php endif; ?>
            <?php if ($this->item->state == 0) : ?>
            <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
            <?php endif; ?>
            <?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
            <span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
            <?php endif; ?>
            <?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate()) : ?>
            <span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
            <?php endif; ?>
         </div>
         <?php endif; ?>
         <?php if (!$this->print) : ?>
         <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
         <?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
         <?php endif; ?>
         <?php else : ?>
         <?php if ($useDefList) : ?>
         <div id="pop-print" class="btn hidden-print">
            <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
         </div>
         <?php endif; ?>
         <?php endif; ?>
         <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
         <?php echo $this->item->event->afterDisplayTitle; ?>
         <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
         <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
         <?php //echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
         <?php
            function str2dataArr($str)
            {
            	if(empty($str)) return '';
            
            	$arrStr = explode(" ", $str);
            	$hora = str_replace(":", "h", $arrStr[1]);
            	$hora = substr($hora, 0, 5);
            	$data = explode('-', $arrStr[0]);
            
            	return array("$data[2]/$data[1]/$data[0]", "$hora");
            }
            
            $data_hora = str2dataArr($this->item->created);
            ?>
         <div class="post-footer">
            <ul class="datetime">
               <li>
                  <i class="icon icon-calendar"></i> <?php echo $data_hora[0]; ?>
               </li>
               <li>
                  <i class="icon icon-time"></i> <?php echo $data_hora[1]; ?>
               </li>
            </ul>
         </div>
         <?php endif; ?>
         <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
         <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
         <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
         <?php endif; ?>
         <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
         <?php echo $this->item->event->beforeDisplayContent; ?>
         <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position)))
            || (empty($urls->urls_position) && (!$params->get('urls_position')))) : ?>
         <?php echo $this->loadTemplate('links'); ?>
         <?php endif; ?>
         <?php if ($params->get('access-view')) : ?>
         <figure class="row">
            <?php echo JLayoutHelper::render('joomla.content.full_image', $this->item); ?>
         </figure>
         <?php
            if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
            	echo $this->item->pagination;
            endif;
            ?>
         <?php if (isset ($this->item->toc)) :
            echo $this->item->toc;
            endif; ?>
         <div class="row">
            <div itemprop="articleBody">
               <?php echo $this->item->text; ?>
            </div>
         </div>
         <br/><br/>
         <?php if ($info == 1 || $info == 2) : ?>
         <?php if ($useDefList) : ?>
         <?php // Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block ?>
         <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
         <?php endif; ?>
         <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
         <?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
         <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
         <?php endif; ?>
         <?php endif; ?>
         <?php
            if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative) :
            	echo $this->item->pagination;
            ?>
         <?php endif; ?>
         <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
         <?php echo $this->loadTemplate('links'); ?>
         <?php endif; ?>
         <?php // Optional teaser intro text for guests ?>
         <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
         <?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
         <?php echo JHtml::_('content.prepare', $this->item->introtext); ?>
         <?php // Optional link to let them register to see the whole article. ?>
         <?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
         <?php $menu = JFactory::getApplication()->getMenu(); ?>
         <?php $active = $menu->getActive(); ?>
         <?php $itemId = $active->id; ?>
         <?php $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
         <?php $link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language))); ?>
         <p class="readmore">
            <a href="<?php echo $link; ?>" class="register">
            <?php $attribs = json_decode($this->item->attribs); ?>
            <?php
               if ($attribs->alternative_readmore == null) :
               	echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
               elseif ($readmore = $attribs->alternative_readmore) :
               	echo $readmore;
               	if ($params->get('show_readmore_title', 0) != 0) :
               		echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
               	endif;
               elseif ($params->get('show_readmore_title', 0) == 0) :
               	echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
               else :
               	echo JText::_('COM_CONTENT_READ_MORE');
               	echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
               endif; ?>
            </a>
         </p>
         <?php endif; ?>
         <?php endif; ?>
         <?php
            if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
            	echo $this->item->pagination;
            ?>
         <?php endif; ?>
         <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
         <?php echo $this->item->event->afterDisplayContent; ?>
      </div>
   </div>
   <?php
      $hasItens = false;
       if(! empty($this->item->introtext)){
      
      		$arqHlp = new ArquivosHelper;
      		$parametros_modulo = $arqHlp::get_string_between($this->item->introtext,'{','}');
      
      		$str_1 = explode(',',$parametros_modulo);
      		$nome_do_modulo = strstr($str_1[0], ' ');
      
      		if(trim($nome_do_modulo) == 'mod_itensrelacionados') {
      
      			$module_right_sidebar = $arqHlp::getModuleByTitle($str_1[1]);
      			$cat_arq    = json_decode($module_right_sidebar->params)->categoria;
      			$arqItens_arquivo = $arqHlp::getArquivoItems($cat_arq);
      			$arqItens_aviso   = $arqHlp::getAvisoItems($cat_arq);
      			$arqItens_artigos = $arqHlp::getArticlesItems($cat_arq);
      
      			if(!empty($arqItens_arquivo) ||
      				 !empty($arqItens_aviso) ||
      				 !empty($arqItens_artigos)) {$hasItens = true;};
      
      		}
      
      	}
      ?>
   <div class="four  columns">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <?php if($infomes != ''): ?>
      <div class="right-sidebar" >
        <?php echo $infomes;//JHtml::_('content.prepare', '{loadposition informes}'); ?>
      </div>
      <?php endif;?>

      <?php if(! empty($relacionado_id)) $hasItens = true ?>
      <div class="right-sidebar" style="<?php if($hasItens == false) echo 'display:none !important' ?>">

      <?php if($hasItens): ?>

         <?php if($temRelacionada): ?>
          <?php
            foreach ($arrItensRelacio as $relacionado):
          ?>
  		    <div class="sidebar-box">
            <h3 class="title"><?php echo($relacionado->titulo); ?></h3>
            <div class="content">
              <table class="tree table table-bordered table-condensed">
                <tbody>
                <?php 
                  foreach($relacionado->itens as $item):
                ?>
                  <!-- Mol -->
                  <?php if($item->level_parent == 0) : ?>
                    <?php if($item->level_id == 0) $item->level_id =1; ?>
                    <tr class="expanded treegrid-<?php echo $item->level_id?> ">
                  <?php else : ?>
                    <tr class="expanded treegrid-<?php echo $item->level_id?> treegrid-parent-<?php echo $item->level_parent?>">
                  <?php endif; ?>
                      <td>
                              <?php 
                                if(!empty($item->arquivo) && trim($item->arquivo) != 'Sem arquivo'){
                                  $currUrl = $item->arquivo;
                                  if($item->tipo == 1){
                                    $currUrl = 'images/media/'.$item->arquivo;
                                  }
                                  $href = 'href="'.$currUrl.'"';
                                } else{
                                  $href = "";
                                }
                                $item->print = false;
                              ?>
                              <a <?php echo $href ?>  style="word-break: break-word;"><span class="typcn typcn-folder"></span> <?php echo $item->titulo; ?></a>
                          </td>
                     </tr>
                  <?php
                    endforeach;
                  ?>
        
                  </tbody>
               </table>
            </div>
 
           </div>
        <?php 
          endforeach; 
        endif; 
        ?>

         <?php if(!empty($arqItens_aviso)): ?>
         <div class="sidebar-box">
            <h3 class="title">Avisos</h3>
            <div class="content">
               <ul>
                  <?php foreach ($arqItens_aviso as $arqItens_aviso_item) :?>
                  <li>
                     <h3>
                        <a href="<?php echo JRoute::_('index.php?option=com_aviso&id='.$arqItens_aviso_item->id.'&catid='.$arqItens_aviso_item->tipo); ?>" title="">
                        <?php echo $arqItens_aviso_item->titulo ?>
                        </a>
                     </h3>
                  </li>
                  <?php endforeach; ?>
               </ul>
            </div>
         </div>
         <?php endif; ?>
         <?php if(!empty($arqItens_arquivo)): ?>
         <div class="sidebar-box">
            <h3 class="title">Arquivos</h3>
            <div class="content">
               <ul>
                  <?php foreach ($arqItens_arquivo as $arqItens_arquivo_item) :?>
                  <li>
                     <h3>
                        <?php if(!$arqItens_arquivo_item->linkonly): ?>
                        <a href="images/media/<?php echo $arqItens_arquivo_item->arquivo; ?>" title="">
                        <?php else: ?>
                        <a href="<?php echo $arqItens_arquivo_item->link; ?>" title="">
                        <?php endif; ?>
                        <?php echo $arqItens_arquivo_item->title ?>
                        </a>
                     </h3>
                  </li>
                  <?php endforeach; ?>
               </ul>
            </div>
         </div>
         <?php endif; ?>
         <?php if(!empty($arqItens_artigos)): ?>
         <div class="sidebar-box">
            <h3 class="title">Artigos</h3>
            <div class="content">
               <ul>
                  <?php foreach ($arqItens_artigos as $arqItens_artigo_item) :?>
                  <li>
                     <h3>
                        <a href="<?php echo JRoute::_('index.php?option=com_content&view=article&id='.$arqItens_artigo_item->id.'&catid='.$arqItens_artigo_item->catid); ?>" title="">
                        <?php echo $arqItens_artigo_item->title ?>
                        </a>
                     </h3>
                  </li>
                  <?php endforeach; ?>
               </ul>
            </div>
         </div>
         <?php endif; ?>
         <?php endif; ?>
         <?php if($isBlogArticle == true) : ?>
         <script src="https://apis.google.com/js/platform.js" async defer>
            {lang: 'pt-BR'}
         </script>
         <div class="sidebar-box">
            <h3 class="title">Últimas Notícias</h3>
            <div class="content">
               <ul>
                  <?php foreach ($newArticleList as $newArticle) :?>
                  <li>
                     <h3>
                        <a href="<?php echo JRoute::_('index.php?view=article&id='.$newArticle->id.'&catid='.$newArticle->catid); ?>" title="">
                        <?php echo $newArticle->title ?>
                        </a>
                     </h3>
                  </li>
                  <?php endforeach; ?>
               </ul>
               <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured'); ?>" class="btn btn-more">Acesse mais notícias</a>
            </div>
         </div>
         <?php endif; ?>
      </div>
   </div>
</div>
