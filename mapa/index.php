<!DOCTYPE html>
<html>
<head>
	<title>Mapa Apac</title>
	
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/leaflet/leaflet.js"></script>
	<script type="text/javascript" src="js/maps.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>


	<?php 
	    include("consultas.php");

	    $tipo = "1";
	    if(isset($_GET['tipo'])){
	    	$tipo = $_GET['tipo'];
	    }

	    if($tipo == "1"){
	    	$previsao = getPrevisaoDia();
	    }else{
	    	$previsao = getPrevisaoDia(false);
	    }
	      // echo(json_encode( $previsao ) );die;
	?>

</head>
<body style="background-color: #fbfbfb">
	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		#map {
			width: 600px;
			height: 400px;
		}
	
		.content {width: 800px; height: 250px;}
		
		#map { width: 800px; height: 250px; }
		
		.info { padding: 6px 8px; font: 14px/16px Arial, Helvetica, sans-serif; background: white; background: rgba(255,255,255,0.8); box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; } 

		.info h4 { margin: 0 0 5px; color: #777; }
		
		.legend { text-align: left; line-height: 18px; color: #555; } .legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7; }

		.prevDesc{font-size: 12px}

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
		/*.slice-it{color: black}*/
	</style>
</head>
<body>

<div class="content">
	<div>
		<div class="buttons">

			<a href="index.php?tipo=1" class="btn btn<?php echo ($tipo == '2') ? '-outline' : '' ?>-warning">Hoje</a>
			<a href="index.php?tipo=2"  class="btn btn<?php echo ($tipo == '1') ? '-outline' : '' ?>-warning">Amanhã</a>
		</div>
		<div class="slice-itens">
			<a href="javascript:void(0)" class="voltar slice-it"><i class="fas fa-step-backward"></i></a>
			<a href="javascript:void(0)" class="pausar slice-it"><i class="fas fa-pause"></i></a>
			<a href="javascript:void(0)" class="play slice-it"><i class="fas fa-play"></i></a>
			<a href="javascript:void(0)" class="proximo slice-it"><i class="fas fa-step-forward"></i></a>	
		</div>
	</div>
	<div id='map'></div>


	<script type="text/javascript">
		const proximo = document.querySelector(".proximo");
		proximo.addEventListener('click', function (event) {
			nextItem();
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
			slice = setInterval(nextItem, 3000);
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

		var map = L.map('map', { zoomControl:false }).setView([-8.4, -37.8733352], 7);

		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
				'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox.light'
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

		function zoomToFeature(e) {
			map.fitBounds(e.target.getBounds());
		}

		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: zoomToFeature
			});

		}

		var markerGroup = L.layerGroup().addTo(map);
		
		var mesoRegiao;


		<?php foreach ($previsao as $prev): ?>

			mesoRegiao = <?php echo $prev['mesoregiao']['geojson'] ?>;
			geojson = L.geoJson(mesoRegiao, {
				style: style,
				onEachFeature: onEachFeature
			}).addTo(markerGroup);
			
			mesoregiao = null;

		<?php endforeach; ?>

	</script>

	<?php $auxPrev = 0; ?>

	<?php if(!empty($previsao)): ?>

	<?php foreach ($previsao as $prev): ?>

		<div class="previsaoMeso " data-ordem="<?php echo $auxPrev; ?>">
			<div class="dadosInicioMeso">
				<table class="table table-bordered">
					<thead>
					<tr>
						<th colspan="2" class="bg-warning" style="color: white"><?php echo $prev['mesoregiao']['nome'] ?></th>
					</tr>
						
					</thead>
					<tr>
						<td colspan="2" style="text-align: center;">Temperatura</td>
					</tr>
					<tr>
						<td><i class="fas fa-temperature-high"></i> <?php echo $prev['previsao']['temMax'] ?>° C</td>
						<td><i class="fas fa-temperature-low"></i> <?php echo $prev['previsao']['temMin'] ?>° C</td>
					</tr>
				</table>
			</div>

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

				$data = date("d/m/Y", strtotime( str_replace("-","/", $prev['previsao']['data_previsao'])));
				$horas = strtotime($prev['previsao']['data_previsao']);
				$horas =  date('H:i:s', $horas);
				if ($data == '01/01/1970'){$data = " - ";}
				$dataHora = $data . " às " . $horas;

			?>

			<div class="dadosPrevisaoMeso">
				<table class="table table-bordered">
					<tr>
						<td colspan="2" class="prevDesc">Previsão atualizada em <?php echo $dataHora ?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo $conteudoPrev; ?></td>
					</tr>
					<tr>
						<td> <i class="fas fa-tint"></i> Umidade Máxima: <?php echo $prev['previsao']['umiMax'] ?>%</td>
						<td><i class="fas fa-tint"></i> Umidade Mínima: <?php echo $prev['previsao']['umiMin'] ?>%</td>
					</tr>
					<tr>
						<td><i class="fas fa-wind"></i> Vento (m/s): <?php echo $prev['previsao']['IntensidadeDoVento'] ?></td>
						<td><i class="fas fa-wind"></i> Vendo Direção: <?php echo $prev['previsao']['RotaDoVento'] ?></td>
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
	<?php endforeach; ?>
	<?php else: ?>
		<p><strong>Não existem previsões cadastradas</strong></p>
	<?php endif; ?>


	<input type="hidden" name="indcAtual" id="indcAtual" value="0">
	<input type="hidden" name="indcTotal" id="indcTotal" value="<?php echo $auxPrev; ?>">

	<script type="text/javascript">
		removeItemByDiffId(0);
		var slice = setInterval(nextItem, 3000);
	</script>
</div>

</body>
</html>