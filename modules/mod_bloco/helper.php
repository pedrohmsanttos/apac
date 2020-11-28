<?php defined('_JEXEC') or die;
class ModBlocoHelper
{
	 public static function getArquivosByCatId($catid)
	{
			if(empty($catid)) return '';

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('*');
	    $query->from($db->quoteName('#__arquivo'));
	    $query->where("catid = $catid");
	    $query->where("published = 1");

	    $db->setQuery($query);

	    $results = $db->loadObjectList();
	    return $results;
	}

	public static function getFiletypeNameByIdType($id){
		$out = "";
		switch ($id) {
			case '1':
				$out = 'Audio';
				break;

			case '2':
				$out = 'Video';
				break;

			case '3':
				$out = 'Imagem';
				break;

			case '4':
				$out = 'Documento';
				break;

			default:
				$out = 'Documento';
				break;
		}

		return $out;
	}

    public static function detectarFormatoDoArquivo($str)
	{
		if($str == '') return '';
		$str = strtolower($str);
		$formato = '';
		if (strpos($str, '.mp4') !== false) {

    		$formato = 'video';

		} elseif(strpos($str, '.mp3') !== false){
    		$formato = 'audio';

		} elseif(strpos($str, '.doc') !== false || strpos($str, '.docx') !== false){

    		$formato = 'documento';

		} elseif(strpos($str, '.pdf') !== false){

			$formato = 'documento';

		}elseif(strpos($str, '.jpg') !== false || strpos($str, '.png') !== false || strpos($str, '.jpeg') !== false) {

			$formato = 'imagem';

		}

		return $formato;

	}

	public static function htmlPeloFormato($nomeArq,$src,$titulo,$link,$formato)
	{

		$saida  = '';

		if(empty($formato)) $formato = self::detectarFormatoDoArquivo($nomeArq);
		// $formato = strtolower($formato);

		if(! empty($link)) {
			$src2 = $link;
		} else {
			$src2 = $src;
		}

		/*
		<option value="1">Audio</option>
		<option value="2">Video</option>
		<option value="3">Imagem</option>
		<option value="4">Documento</option>

		*/

		switch ($formato) {
			case '3':
						$saida .= '<div class="item-album item-audio total-height">
												<div class="item-content">
													<span class="icon icon-album"></span>
													<h2><a target="_blank" href="'.$src2.'" title="">'.$titulo.'</a></h2>
												</div>
															<a class="imageGallery" target="_blank"  href="'.$src2.'" title="'.$titulo.'">
													         <img src="'.$src.'" alt="">
															</a>
		                     </div>';
			break;
			case '1':
				$saida .= '<div class="item-audio">
                      <div class="item-content">
                          <span class="icon icon-audio"></span>
                          <h2><a target="_blank" href="'.$src2.'" title="">'.$titulo.'</a></h2>
                      </div>
                      <div class="item-footer">
                          <div class="player">';
															if(empty($link)):
																$saida .='
																	<audio controls style="width:100%">
																		 <source src="'.$src.'" type="audio/mpeg">
																	</audio> ';
															endif;
				$saida .='				</div>
                              <div class="download">
                                  <a target="_blank" href="'.$src2.'" title="'.$titulo.'">
                                      <i class="icon icon-mp3"></i> Download do áudio</a>
                              </div>
                          </div>
                        </div>';
			break;
			case '2': //video
				$saida .= '<div class="item-album item-audio height-85">
										<div class="item-content no-pad-top">
												<span class="icon icon-video"></span>
												<h2><a target="_blank" href="'.$src2.'" title="'.$titulo.'">'.$titulo.'</a></h2>
										</div> <div class="item-footer">
												<div>';

							if(! empty($link) && strpos($src2, 'youtube') !== false) {

								if(! strpos($src, 'embed')){
									$src2 = str_replace(".com", ".com/embed", $src2);
								}

								$saida .= '<iframe width="400" height="240"
												src="'.$src2.'">
												</iframe>';

							} elseif(!empty($src) && empty($link)) {

                           		$saida .='<video width="320" height="240" controls>
											<source src="'.$src.'" type="video/mp4">
										 </video>';
							}else {

								$saida .='
                                        	<span class="icon icon-video"></span>
                                        	<img alt="">
                                    	';
							}

								$saida .= "</div></div>";

               				$saida .='

                                </div>';
			break;
			case '4':
				$icone_documento = ' icon-doc ';

				if (strpos($src, '.pdf') !== false || strpos($src, '.PDF') !== false) {
    				$icone_documento = ' icon-pdf ';
				}

				$saida .= '<div class="item-download">
                                    <div class="item-content">
                                        <h2><a target="_blank" href="'.$src.'" title="">'.$titulo.'</a></h2>
                                        <div class="download">
                                            <a target="_blank" href="'.$src.'" title="">
                                                <i class="icon '.$icone_documento.'"></i> Download do arquivo</a>
                                        </div>
                                    </div>
                                </div>';
			break;

			default:

				$icone_documento = ' icon-doc ';

				if (strpos($src, '.pdf') !== false || strpos($src, '.PDF') !== false) {
    				$icone_documento = ' icon-pdf ';
				}

				$saida .= '<div class="item-download">
                                    <div class="item-content">
                                        <h2><a target="_blank" href="'.$src.'" title="">'.$titulo.'</a></h2>
                                        <div class="download">
                                            <a target="_blank" href="'.$src.'" title="">
                                                <i class="icon '.$icone_documento.'"></i> Download do arquivo</a>
                                        </div>
                                    </div>
                                </div>';

			break;
		}
	return $saida;
	}

	function getLink($artId)
	{
	    // exemplo: descubra-pernambuco/34-descubra-pernambuco/30-cultura
		$db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select(array('a.alias as article_alias', 'b.id as category_id', 'b.alias as category_alias','b.path as category_path'))
			    ->from($db->quoteName('#__content', 'a'))
			    ->join('INNER', $db->quoteName('#__categories', 'b') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('b.id') . ')')
			    ->where('a.catid = '.$artId);
	    $db->setQuery($query);

	    $articlesList = $db->loadObjectList();

	    return $articlesList[0]->category_alias.'/'.$articlesList[0]->category_id.'-'.$articlesList[0]->category_alias.'/'.$artId.'-'.$articlesList[0]->article_alias;
	}


}
