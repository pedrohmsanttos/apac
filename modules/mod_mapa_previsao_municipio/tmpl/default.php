<?php
defined('_JEXEC') or die;
// JHtml::_('jquery');
// echo "Mapa Previsão Município";

$ip_webservice      = $params->get('ip_webservice');
$porta_webservice   = $params->get('porta_webservice');
// echo $ip_webservice . ":" . $porta_webservice;die;

$previsoes = $dados;
$existePrevisao = true;

	if( empty($previsoes->metadados->datas) ){
		$existePrevisao = false;
	}
?>


	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<?php $doc->addStyleSheet(JURI::root()."modules/mod_mapa_previsao/assets/css/leaflet/leaflet.css"); ?>
	<?php $doc->addScript(JURI::root()."modules/mod_mapa_previsao/assets/js/leaflet/leaflet.js"); ?>
	<?php $doc->addScript(JURI::root()."modules/mod_mapa_previsao/assets/js/maps.js"); ?>

    <style>
		html, body {
			height: 100%;
			margin: 0;
		}
		#map {
			width: 100%;
			height: 250px;
		}
	
		.contentMapa {width: 800px; height: 250px;}
		
		
		.info { padding: 6px 8px; font: 14px/16px Arial, Helvetica, sans-serif; background: white; background: rgba(255,255,255,0.8); box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; } 

		.info h4 { margin: 0 0 5px; color: #777; }
		
		.legend { text-align: left; line-height: 18px; color: #555; } .legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7; }

		.prevDesc{font-size: 12px !important}

		/*.dadosInicioMeso table, tr,td,th{
			border: 1px solid;
		}*/

		.dadosPrevisaoMeso{
			margin-top: 20px;
		}

		.dadosInicioMeso{
			width: 50%;
		}

		.previsaoMeso{
			margin-top: 20px;
			/*background-color: #e8dfdf;*/
		}

		.dispNone {display: none;}
		.dispBlock {display: block;}
		.slice-itens{float: right;}
		.slice-it{padding: 10px; color: black}

		.form-control {
		    display: block;
		    width: 100%;
		    height: 34px;
		    padding: 6px 12px;
		    font-size: 14px;
		    line-height: 1.42857143;
		    color: #555;
		    background-color: #fff;
		    background-image: none;
		    border: 1px solid #ccc;
		    border-radius: 4px;
		    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		}

		.select-form-control {
		    font-family: inherit;
		    font-size: inherit;
		    line-height: inherit;
		    width: 300px;
		    margin: auto; 
		}
		/*.slice-it{color: black}*/
	</style>

    <div class="mobile-four twelve columns" style="margin-bottom: 20px;">
		
        <?php if( $existePrevisao ): ?>
            <div class="mobile-four four columns" style="width: 33%">
                <?php $aux = 0; ?>
                
                    <select style="" class="form-control select-form-control selectMeso">
                        <option value="">Selecione um município</option>
                        <?php foreach ($previsoes->previsao_municipios as $prev): ?>
                            <option value="<?php echo $aux ?>"><?php echo $prev->nome ?></option>
                            <?php $aux++; ?>
                        <?php endforeach; ?>
                    </select>
            </div>
                
            <div class="mobile-four four columns" style="width: 33%">
                <div class="slice-itens">
                    <a href="javascript:void(0)" class="voltar slice-it"><i class="fas fa-step-backward"></i></a>
                    <a href="javascript:void(0)" class="pausar slice-it"><i class="fas fa-pause"></i></a>
                    <a href="javascript:void(0)" class="play slice-it"><i class="fas fa-play"></i></a>
                    <a href="javascript:void(0)" class="proximo slice-it"><i class="fas fa-step-forward"></i></a>	
                </div>
            </div>
        <?php endif; ?>
    </div>
    <br>

    <div id='map'></div>

    <script type="text/javascript">
		const proximo = document.querySelector(".proximo");
		proximo.addEventListener('click', function (event) {
			nextItem();
		});
		
		// const selectMeso = document.querySelector(".selectMeso");
		// selectMeso.addEventListener('change', function (event) {
		// 	clearInterval(slice);
		// 	 console.log(selectMeso.value);
		// 	removeItemByDiffId(selectMeso.value);
		// });

		// $("#e15").on("change", function() { $("#e15_val").html($("#e15").val());});
		
		const voltar = document.querySelector(".voltar");
		voltar.addEventListener('click', function (event) {
			backItem();
		});


		const pausar = document.querySelector(".pausar");
		pausar.addEventListener('click', function (event) {
			clearInterval(slice);
		});

		const play = document.querySelector(".play");
		play.addEventListener('click', function (event) {
			slice = setInterval(nextItem, 6000);
		});


		function nextItem(){
			var novoValor = parseInt(document.getElementById('indcAtual').value) + 1; 
			var valorTotal = document.getElementById('indcTotal').value;

			if(novoValor >= valorTotal){
				novoValor = 0; 
			}
			removeItemByDiffId(novoValor);
			document.getElementById('indcAtual').value = novoValor;

			jQuery("#content-25 div:nth-child(1)").show();
		}

		function backItem(){
			var novoValor = parseInt(document.getElementById('indcAtual').value) - 1; 
			var valorTotal = document.getElementById('indcTotal').value;

			if(novoValor < 0){
				novoValor = (valorTotal - 1); 
			}

			removeItemByDiffId(novoValor);
			document.getElementById('indcAtual').value = novoValor;

			jQuery("#content-25 div:nth-child(1)").show();
		}

		function removeItemMapaByDiffId(id){
			for(i = 0; i < document.getElementsByTagName("path").length; i++){
				if(i != id){
					document.getElementsByTagName("path")[i].style = "display:none";
				}
			}
			document.getElementsByTagName("path")[id].style = "display:block";
		}

		function removeItemMesoregiaoByDiffId(id){
			for(i = 0; i < document.getElementsByClassName("previsaoMeso").length; i++){
				if(i != id){
					document.getElementsByClassName("previsaoMeso")[i].style = "display:none";
				}
			}
			document.getElementsByClassName("previsaoMeso")[id].style = "display:block";
		}

		function removeItemByDiffId(id){
			removeItemMapaByDiffId(id);
			removeItemMesoregiaoByDiffId(id);
		}
	</script>

    <script type="text/javascript">

    var map = L.map('map', { zoomControl:false,scrollWheelZoom: false}).setView([-8.4, -37.8733352], 7);

    map._handlers.forEach(function(handler) {
        handler.disable();
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
			maxZoom: 18,
			attribution : ' <a href="http://www.inhalt.com.br/" target="_blank">Inhalt</a> | <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);


    function removeToId(id,layerGroup){
        layerGroup.eachLayer(function (layer) {
            if(id == L.stamp(layer)){
                layerGroup.removeLayer(layer);
            }
        });
    }


    // get color depending on population density value
    function getColor(d) {
        return d > 1000 ? '#800026' :
                d > 500  ? '#BD0026' :
                d > 200  ? '#E31A1C' :
                d > 100  ? '#FC4E2A' :
                d > 50   ? '#FD8D3C' :
                d > 20   ? '#FEB24C' :
                d > 10   ? '#FED976' :
                            '#FFEDA0';
    }

    function style(feature) {
        return {
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7,
            // fillColor: getColor(feature.properties.density)
            fillColor: '#af2310'
        };
    }

    function highlightFeature(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }

        // info.update(layer.feature.properties);
    }

    var geojson;

    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        // info.update();
    }

    // function zoomToFeature(e) {
    // 	map.fitBounds(e.target.getBounds());
    // }

    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            // click: zoomToFeature
        });

    }

    var markerGroup = L.layerGroup().addTo(map);

    var mesoRegiao;


    var skullIcon = L.icon({
        iconUrl: 'https://img.icons8.com/metro/1600/rain.png',
        iconSize: [30,30],
        popupAnchor: [-10, -30],
    });

	<?php $aux = 0; ?>
	<?php const CONDICAO_PARADA = 0; ?>


	<?php if($existePrevisao): ?>
		<?php if( isset($previsoes) && !empty($previsoes)): ?>
			<?php foreach ($previsoes->previsao_municipios as $prev): ?>
				<?php if(!empty($prev->geoJson)): ?>

					<?php //if($aux == CONDICAO_PARADA):?>
						mesoRegiao = <?php echo json_encode( $prev->geoJson ) ?>;
						geojson = L.geoJson(mesoRegiao, {
							style: style,
							onEachFeature: onEachFeature
						}).addTo(markerGroup);
						
						mesoregiao = null;
						<?php $aux++; ?>
					<?php //endif;?>

				<?php endif; ?>
				
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endif; ?>

    </script>

    <style type="text/css">
		/*a {
		    color: #007bff !important;
		    text-decoration: none !important;
		    background-color: transparent !important;
		    -webkit-text-decoration-skip: objects !important;
		}*/
		.btn-outline-warning {
		    color: #ffc107 !important;
		    background-color: transparent !important;
		    background-image: none !important;
		    border-color: #ffc107 !important;
		}
		.btn {
		    display: inline-block !important;
		    font-weight: 400 !important;
		    text-align: center !important;
		    white-space: nowrap !important;
		    vertical-align: middle !important;
		    -webkit-user-select: none !important;
		    -moz-user-select: none !important;
		    -ms-user-select: none !important;
		    user-select: none !important;
		    border: 1px solid transparent !important;
		    padding: .375rem .75rem !important;
		    font-size: 1rem !important;
		    line-height: 1.5 !important;
		    border-radius: .25rem !important;
		    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
		}
	</style>

	<style type="text/css">
		.tabela-nova{ border: 1px solid #0a0a0a !important; }

	.TabControl{
        width:100%;
        overflow:hidden;
        height:470px
    }
    
    .TabControl .headerAbas{
        width:100%;
        overflow:hidden;
        cursor:pointer
    }
    
    .TabControl .conteudoAba{
        /* width:100%;
        border: solid 1px #27408B;
        overflow:hidden;
        height:100%;  */
	
	}
    
    .TabControl .abas{display:inline;}
    
    .TabControl .abas li{float:left}
    
    .abas{
        list-style:none;
    }

	
    .aba{
        width:200px;
        height:40px;
        border:solid 1px;
        border-radius:5px 5px 0 0;
        text-align:center;
        padding-top:5px;
        background: #e7bb03;
        border-bottom-color:#695608
	}
    
	 
    .ativa{
        width:200px;
        height:40px;
        border:solid 1px #e7bb03;
        border-radius:5px 5px 0 0;
        text-align:center;
        padding-top:5px;
    }


 
    .ativa span, .selecionada span{color:#fff}
 
    /* .TabControl .conteudoAba{background:#27408B} */
 
	
		
    /* .TabControl .conteudo{
        width:100%;
        background:#27408B;
        display:none;
        height:100%;
       
    } */

	
 
    .selecionada{
        width:200px;
        height:40px;
        border:solid 1px #27408B;
        border-radius:5px 5px 0 0;
        text-align:center;
        padding-top:5px;
        background:#695608;
		font-weight: bold;
    } 

	.iconePrevisao {
		width: 25px;
		height: 25px;
	}
	</style>

    <?php $auxPrev = 0; ?>

	<?php //var_dump($previsoes);die;  ?> 

	<?php if( $existePrevisao ): ?>

	<?php 
		$conteudoPrev = ""; 
		$conteudoPrev = $previsoes->metadados->mensagem;

			
	?>

	<?php foreach ($previsoes->previsao_municipios as $prev): ?>
		<?php $prev->previsao = (array)$prev->previsao;  ?>
		<?php //var_dump($prev->previsao);die;  ?>
	

		<?php if( !empty( json_encode($prev->geoJson) ) ): ?>

		<div class="previsaoMeso " data-ordem="<?php echo $auxPrev; ?>">
			
			<?php $dataHora =  str_replace("-", "/", $previsao['0']['0']); ?>
			
			<div class="dadosPrevisaoMeso">
				<div class="TabControl">
					<div id="municipio-<?php echo $prev->codigo ?>" class="municipioPrev">
						
						<div id="header-<?php echo $prev->codigo ?>" class="headerAbas">
							<ul class="abas">
								<?php $totalPrev = count($prev->previsao);?>
								<?php for($i = 0; $i < $totalPrev; $i++): ?>
									<li>
										<div class="aba" data-content="content-<?php echo $prev->codigo ?>">
											<?php 
												$prev->previsao[$i] = (array)$prev->previsao[$i];
												$diasemana_numero = date('w', strtotime($prev->previsao[$i]['0']['0']));
											?>
											<?php if($i == 0): ?>
												<span><?php echo "Hoje - " . $diasemana[$diasemana_numero] ?></span>     
											<?php else: ?>
												<span><?php echo $diasemana[$diasemana_numero] ?></span>
											<?php endif; ?>
										</div>
									</li>
								<?php endfor;?>
							</ul>
						</div> <!-- END - header -->

						<div id="content-<?php echo $prev->codigo ?>" class="conteudoAba">
							<?php if($prev->previsao['0']['0'] == "null"): ?>
								<div class="conteudo">
									<table class="table tabela-nova">
										<thead>
											<tr>
												<th colspan="2" class="bg-warning" style="color: #745e01; background-color: #E7BB03; font-weight: bold;"><?php echo $prev->nome ?> </th>
											</tr>
										</thead>
										
										<tr>
											<td colspan="2" >Não existem previsões cadastradas!</td>
										</tr>
									</table>
								</div>
							<?php else: ?>
								<?php foreach($prev->previsao as $previsao): ?>
								<?php 
									$auxPrevisao = json_encode($previsao);
									$previsao = json_decode($auxPrevisao);
									$previsao = (array)$previsao;

									$retornoPrevisao = array();
									foreach($previsao as $key => $novaPrev){
										$retornoPrevisao[$key] = (array)$novaPrev;
									}
									//  var_dump($retornoPrevisao['icone']);die; 	
								?>
									<div class="conteudo">
										<table class="table tabela-nova">
											<thead>
												<tr>
													<th colspan="2" class="bg-warning" style="color: #745e01; background-color: #E7BB03; font-weight: bold;"><?php echo $prev->nome ?> </th>
												</tr>
											</thead>
											
											<tr>
												<td class="prevDesc" style="width: 60%;">Previsão consultada em <?php echo date('d/m/Y H:i:s') ?></td>
												<td style="float: right;width: 101%;"><img src="<?php echo $retornoPrevisao['icone']['0'] ?> " height="50" width="50"></td>
											</tr>

											<tr>
												<td style="width: 40%;"><i class="fas fa-map-marked"></i> Latitude: <?php echo  $prev->latitude ?></td>
												<td style="width: 60%;"><i class="fas fa-map-marked"></i> Longitude: <?php echo  $prev->longitude ?></td></td>
											</tr>
											
											<tr>
												<td style="width: 40%;"><img src="<?php echo  $retornoPrevisao['1']['icone'] ?>" class="iconePrevisao"><?php echo  $retornoPrevisao['1']['titulo']  . ": " . $retornoPrevisao['1']['valor'] ?></td>
												<td style="width: 60%;"><img src="<?php echo  $retornoPrevisao['2']['icone'] ?>" class="iconePrevisao"><?php echo  $retornoPrevisao['2']['titulo']  . ": " . $retornoPrevisao['2']['valor'] ?></td>
											</tr>
											
											<tr>
												<td style="width: 40%;"> <img src="<?php echo  $retornoPrevisao['3']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['3']['titulo']  . ": " . $retornoPrevisao['3']['valor'] ?></td>
												<td style="width: 60%;"><img src="<?php echo  $retornoPrevisao['4']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['4']['titulo']  . ": " . $retornoPrevisao['4']['valor'] ?></td>
											</tr>

											<tr>
												<td style="width: 40%;"><img src="<?php echo  $retornoPrevisao['5']['icone'] ?>" class="iconePrevisao"><?php echo  $retornoPrevisao['5']['titulo']  . ": " . $retornoPrevisao['5']['valor'] ?></td>
												<td style="width: 60%;"><img src="<?php echo  $retornoPrevisao['6']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['6']['titulo']  . ": " . $retornoPrevisao['6']['valor'] ?></td>
											</tr>

											<tr>
												<td style="width: 40%;"><img src="<?php echo  $retornoPrevisao['7']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['7']['titulo']  . ": " . $retornoPrevisao['7']['valor'] ?></td>
												<td style="width: 60%;"><img src="<?php echo  $retornoPrevisao['8']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['8']['titulo']  . ": " . $retornoPrevisao['8']['valor'] ?></td>
											</tr>

											<tr>
												<td style="width: 40%;"><img src="<?php echo  $retornoPrevisao['9']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['9']['titulo']  . ": " . $retornoPrevisao['9']['valor'] ?></td>
												<td style="width: 60%;"><img src="<?php echo  $retornoPrevisao['10']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['10']['titulo']  . ": " . $retornoPrevisao['10']['valor'] ?></td>
											</tr>

											<tr>
												<td style="width: 40%;"><img src="<?php echo  $retornoPrevisao['11']['icone'] ?>" class="iconePrevisao"> <?php echo  $retornoPrevisao['11']['titulo']  . ": " . $retornoPrevisao['11']['valor'] ?></td>
												<td style="width: 60%;"></td>
											</tr>

											<tr>
												<td colspan="2" style="color: red"><strong><?php echo $conteudoPrev; ?></strong></td>
											</tr>
										</table>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>							
							
							
						</div> <!-- END - conteudoAba -->

					</div> <!-- END - municipioPrev -->

				</div> <!-- END - TabControl -->
				
			</div>	<!-- END - dadosPrevisaoMeso --> 

		</div> <!-- END - previsaoMeso -->
		
		<?php $auxPrev++; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php else: ?>
		<p><strong>Não existem previsões cadastradas!</strong></p>
	<?php endif; ?>


	<input type="hidden" name="indcAtual" id="indcAtual" value="0">
	<input type="hidden" name="indcTotal" id="indcTotal" value="<?php echo $auxPrev; ?>">

	<script type="text/javascript">
		// jQuery(".selectMeso").val('184');
		removeItemByDiffId(184); // Recife

		var slice = setInterval(nextItem, 6000);

		jQuery.noConflict();
		(function( $ ) {
			$(function() {
			
				jQuery(".selectMeso").select2();

				jQuery(".selectMeso").on("change", function() { 
					if(jQuery(this).val() != ""){
						clearInterval(slice);
						removeItemByDiffId(jQuery(this).val());
						jQuery("#content-25 div:nth-child(1)").show();
					}	
				});

				jQuery("#content-25 div:nth-child(1)").show();
				jQuery(".abas li:first div").addClass("selecionada");

				jQuery(".aba").hover(
					function(){jQuery(this).addClass("ativa")},
					function(){jQuery(this).removeClass("ativa")}
				);

			
				jQuery(".aba").click(function(){
					console.log($(this).data("municipio"));
					jQuery(".aba").removeClass("selecionada");
					jQuery(this).addClass("selecionada");

					
					var indice = jQuery(this).parent().index();
					indice++;
					
					console.log("INDICE ::: " +indice);
					var id = "#" + jQuery(this).data("content") + " div";
					jQuery(id).hide();

					id = id + ":nth-child("+indice+")";
					jQuery(id).show();
				});

			});
		})(jQuery);
    	

	</script>