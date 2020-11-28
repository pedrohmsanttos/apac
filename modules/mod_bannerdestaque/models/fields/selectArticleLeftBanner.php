<?php
defined('_JEXEC') or die('Restricted access'); 
jimport('joomla.form.formfield');

if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
require_once dirname(dirname(dirname(__FILE__))).DS.'helper.php';


class JFormFieldSelectArticleLeftBanner extends JFormField {
 
	//The field class must know its own type through the variable $type.
	protected $type   = 'selectArticleLeftBanner';
	public    $modal  = '';
 
	public function getLabel() {
		return '<span>Selecione o artigo</span>';
	}
 
	public function getInput() {
		require_once('selectArticle_helper.php');
		
		$articlesList = modBannerDestaqueHelper::getArticles();
		$params 	  = modBannerDestaqueHelper::getParams();


		$left_banner_article_id = @$params->left_banner_article;//evitando warning se ele estiver vazio

		if(! empty($left_banner_article_id)) :
			$left_banner_article_title = modBannerDestaqueHelper::getArticle($left_banner_article_id)->title;
		endif;

		/* Botão abridor do modal */ 
		
		$custom_form = '';	
		$custom_form .= '<div class="input-append">';
		
		$custom_form .= '<input name="jform[params][left_banner_article]" id="jform[params][left_banner_article]" value="'.$left_banner_article_id.'" data-type-banner="left_banner_article" class="input-small hasTooltip field-media-input" data-original-title="" title="" aria-invalid="false" type="hidden">';

		if(! empty($left_banner_article_title)){
			$custom_form .= '<input name="left_banner_article_title" id="left_banner_article_title" value="'.$left_banner_article_title.'" readonly="readonly" class="input-small hasTooltip field-media-input" data-original-title="" title="" aria-invalid="false" type="text">';

		} else {
			$custom_form .= '<input name="left_banner_article_title" id="left_banner_article_title" value=""  class="input-small hasTooltip field-media-input" data-original-title="" title="" aria-invalid="false" type="text">';
		}

		$custom_form .= '<a id="basic-modal-selecionar-artigo-left-banner" class="btn add-on button-select">Escolher</a>';
		$custom_form .= '<a class="btn icon-remove hasTooltip add-on button-clear" title="" data-original-title="Limpar"></a>';
		$custom_form .= '</div>';

		/* Conteúdo do modal */
		$custom_form .='<div class="basic-modal" id="basic-modal-selecionar-artigo-content-left-banner">';
		$custom_form .='
			<h1>Escolher Artigo</h1>
			<div class="controls">
				<input type="text" id="busca_artigo" placeholder="Buscar..." />
		  		<button class="btn btn-big bt-mar-botn"><span class="icon-search"></span>Buscar</button>
			</div><br/>

			<div class="msg-ok">
				Artigo escolhido com sucesso!
			</div>

			<table class="table lista_artigos">
				<tbody class="list">

					<tr>
						<th>Artigo</th>
						<th>Escolher</th>
					</tr>';

	foreach ($articlesList as $article ) :
		if($left_banner_article_id != $article->id){
			$custom_form .='<tr>
							<td class="article_title id-artigo-left_banner_article-'.$article->id.'">'.$article->title.'</td>
							<td>
								<button id="escolhe-artigo-'.$article->id.'" data-id="'.$article->id.'" data-acao="escolhe" data-type-banner="left_banner_article"  class="escolhe-artigo btn btn-small btn-success">
										Escolher
								</button>
							</td>
						</tr>';

		} else {
			$custom_form .='<tr class="bg-selected">
						<td class="article_title id-artigo-left_banner_article-'.$article->id.'">'.$article->title.'</td>
						<td>
							<button id="-'.$article->id.'" data-id="'.$article->id.'" data-acao="escolhe" class="btn btn-small btn-default disabled">
									Escolhido
							</button>
						</td>
					</tr>';

		}

	endforeach;
					
	$custom_form .='</tbody></table></div>';

		return $custom_form;
	}
}

