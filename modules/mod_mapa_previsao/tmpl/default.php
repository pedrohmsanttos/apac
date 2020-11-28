<?php
defined('_JEXEC') or die;

?>

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<?php $doc->addStyleSheet(JURI::root()."modules/mod_mapa_previsao/assets/css/leaflet/leaflet.css"); ?>
	<?php $doc->addScript(JURI::root()."modules/mod_mapa_previsao/assets/js/leaflet/leaflet.js"); ?>
	<?php $doc->addScript(JURI::root()."modules/mod_mapa_previsao/assets/js/maps.js"); ?>

	<!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
	<!-- <script type="text/javascript" src="js/leaflet/leaflet.js"></script> -->
	<!-- <script type="text/javascript" src="js/maps.js"></script> -->
	
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
	
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->


	<?php


		
	 ?>

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
		
			<div class="mobile-four four columns" style="width: 33%">
				<a href="<?php echo $url ?>?tipo=1" class="btn btn<?php echo ($tipo == '2') ? '-outline' : '' ?>-warning">Hoje</a>
				<a href="<?php echo $url ?>?tipo=2"  class="btn btn<?php echo ($tipo == '1') ? '-outline' : '' ?>-warning">Amanhã</a>
			</div>
			
			<?php if( isset($previsoes) && !empty($previsoes)): ?>
				<div class="mobile-four four columns" style="width: 33%">
					<?php $aux = 0; ?>
					
						<select style="" class="form-control select-form-control selectMeso">
							<option value="">Selecione a mesorregião</option>
							<?php foreach ($previsoes as $prev): ?>
								<option value="<?php echo $aux ?>"><?php echo $prev['mesoregiao']['nome'] ?></option>
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
		
		const selectMeso = document.querySelector(".selectMeso");
		selectMeso.addEventListener('change', function (event) {
			clearInterval(slice);
			// console.log(selectMeso.value);
			removeItemByDiffId(selectMeso.value);
		});
		
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
		}

		function backItem(){
			var novoValor = parseInt(document.getElementById('indcAtual').value) - 1; 
			var valorTotal = document.getElementById('indcTotal').value;

			if(novoValor < 0){
				novoValor = (valorTotal - 1); 
			}

			removeItemByDiffId(novoValor);
			document.getElementById('indcAtual').value = novoValor;
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
		<?php if( isset($previsoes) && !empty($previsoes)): ?>
			<?php foreach ($previsoes as $prev): ?>
				<?php if($prev['mesoregiao']['geojson'] != "{}"): ?>

					mesoRegiao = <?php echo $prev['mesoregiao']['geojson'] ?>;
					geojson = L.geoJson(mesoRegiao, {
						style: style,
						onEachFeature: onEachFeature
					}).addTo(markerGroup);
					
					mesoregiao = null;

				<?php endif; ?>
			<?php endforeach; ?>
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

	<?php $auxPrev = 0; ?>

	<?php //var_dump($previsoes);die;  ?> 

	<?php if(!$erroPrevisao && !empty($previsoes)): ?>

	<?php foreach ($previsoes as $prev): ?>

		<?php if($prev['mesoregiao']['geojson'] != "{}"): ?>

		<div class="previsaoMeso " data-ordem="<?php echo $auxPrev; ?>">
			
			<?php 
				$conteudoPrev = $prev['previsao']['nebulosidade']; 
				$conteudoPrev .= " ".$prev['previsao']['TiposDeChuva']; 
				$conteudoPrev .= " ".$prev['previsao']['DistribuicaoDaChuva']; 
				$conteudoPrev .= " ".$prev['previsao']['PeriodoDaChuva']; 
				if ($prev['previsao']['IntensidadeDaChuva'] == "nenhuma"){
					$conteudoPrev .= ".";
				}else{
					$conteudoPrev .= " ".$prev['previsao']['IntensidadeDaChuva'].".";
				}
				
				
				if($hoje){
					$data = date("d/m/Y", strtotime( str_replace("-","/", $prev['previsao']['data_previsao'])));
					$horas = strtotime($prev['previsao']['data_previsao']);
					$horas =  date('H:i:s', $horas);
					if ($data == '01/01/1970'){$data = " - ";}
					
					$dataHora = $data . " às " . $horas;
				}else{

					try {
						$data = date("d/m/Y", strtotime( str_replace("-","/",$idUltimoPrevisao->datavlida)));
					if ($data == '01/01/1970'){$data = " - ";}
					$dataHora =  $data . " às " . $idUltimoPrevisao->horario;
					} catch (Exception $e) {
						echo '<center><h1>Desculpe!</h1></center><br>',  $e->getMessage(), "\n";
					}

					
					//$data = date('d/m/Y');
				}

				// $horas = strtotime($prev['previsao']['data_previsao']);
				// $horas =  date('H:i:s', $horas);

				// $dataHora = $data . " às " . $horas;

			?>
			<style type="text/css">
				.tabela-nova{
					border: 1px solid #0a0a0a !important;
				}

			</style>
			<div class="dadosPrevisaoMeso">
				<table class="table tabela-nova">
					<thead>
						<tr>
							<th colspan="2" class="bg-warning" style="color: #745e01; background-color: #E7BB03; font-weight: bold;"><?php echo $prev['mesoregiao']['nome'] ?> </th>
							<!-- <th><img src="<?php echo $prev['previsao']['icone'] ?> " height="50" width="50"></th> -->
						</tr>
						
					</thead>
					<tr>
						<td class="prevDesc" style="width: 70%;">Previsão atualizada em <?php echo $dataHora ?></td>
						<td style="float: right;width: 101%;"><img src="<?php echo $prev['previsao']['icone'] ?> " height="50" width="50"></td>
					</tr>
					<tr>
						<td colspan="2"><strong> <?php echo $conteudoPrev; ?> </strong> </td>
					</tr>
					<tr>
						<td style="width: 50%;"><i class="fas fa-temperature-high"></i>Temperatura Máxima: <?php echo $prev['previsao']['temMax'] ?>° C</td>
						<td style="width: 50%;"><i class="fas fa-temperature-low"></i>Temperatura Mínima: <?php echo $prev['previsao']['temMin'] ?>° C</td>
					</tr>
					<tr>
						<td style="width: 50%;"> <i class="fas fa-tint"></i> Umidade Máxima: <?php echo $prev['previsao']['umiMax'] ?>%</td>
						<td style="width: 50%;"><i class="fas fa-tint"></i> Umidade Mínima: <?php echo $prev['previsao']['umiMin'] ?>%</td>
					</tr>
					<tr>
						<td style="width: 50%;"><i class="fas fa-wind"></i> Vento (m/s): <?php echo $prev['previsao']['IntensidadeDoVento'] ?></td>
						<td style="width: 50%;"><i class="fas fa-wind"></i> Vento Direção: <?php echo $prev['previsao']['RotaDoVento'] ?></td>
					</tr>
					<?php $aux = 1; ?>
					<?php if($prev['variaveis'] != null): ?>
						<?php foreach ($prev['variaveis'] as $item => $valor):?>
							<?php if(count($prev['variaveis']) == 1): ?>
								<tr>
									<td><i class="fas fa-asterisk"></i> <?php echo key( $valor ) ?>: <?php echo $valor[key( $valor)] ?></td>
								</tr>
							<?php else: ?>
								
								<?php foreach ($valor as $chave => $val):?>
									<?php if($aux == 1): ?>
										<tr>
									<?php endif; ?>
										<td><i class="fas fa-asterisk"></i> <?php echo $chave ?>: <?php echo $val ?></td>
									<?php if($aux == 2): ?>
										</tr>
									<?php $aux = 1; ?>
									<?php else: ?>
										<?php $aux++;?>
									<?php endif; ?>
								<?php endforeach;?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</table>
			</div>	
		</div>
		
		<?php $auxPrev++; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php else: ?>
		<p><strong>Erro ao carregar dados das mesoregiões!</strong></p>
	<?php endif; ?>


	<input type="hidden" name="indcAtual" id="indcAtual" value="0">
	<input type="hidden" name="indcTotal" id="indcTotal" value="<?php echo $auxPrev; ?>">

	<script type="text/javascript">
		removeItemByDiffId(0);
		var slice = setInterval(nextItem, 6000);
	</script>
<!-- </div> -->