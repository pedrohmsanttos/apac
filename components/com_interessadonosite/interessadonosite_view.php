<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>APAC - Previsão do Tempo para o Estado de Pernambuco - www.apac.pe.gov.br</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body marginwidth="0" marginheight="0">
	<form action="<?php echo JRoute::_('') ?>" method="post" enctype="multipart/form-data" name="adminForm" id="interessado-form" class="form-validate">
		<input type="hidden" name="data_criacao" value="<?php echo $getInteressado->data_criacao; ?>" />	
		<?php if(!empty($idInteressado) || $idInteressado > 0): $boletim = json_decode($getInteressado->boletim);?>
			<div class="card">
				<div class="card-header">
					<center><h4>Boletim de Publicação da APAC</h4></center>
					<br>
					<h4>Interessado(a): <?php echo ($getInteressado->nome); ?> </h4>
				</div>

				<div class="card" style="margin-top: 20px;">
					<div class="card-header">
						<h4>  Dados do Interessado</h4>
					</div>
					<div class="card-body">
						<div class="row-fluid">
							<div class="span6" style="margin-left: 2px;">
								Receber Email:
								<input type="radio" id="radio1" name="situacao" value="1" <?php if ($getInteressado->situacao == 1){ echo "checked";}?>>
								
								<label for="radio1">Sim</label>
								<input type="radio" id="radio2" name="situacao"value="0"<?php if ($getInteressado->situacao == 0){ echo "checked";}?>>
								<label for="radio2">Não</label>
							</div>
							<br>
							<div class="span6" style="margin-left: 2px;">
							Nome: <input type="text" name="nome" id="nome"  style="height: 25px; width: 25rem;"  class="required" placeholder="Nome" required="required" aria-required="true" aria-invalid="false" value = "<?php echo ($getInteressado->nome); ?>">
							</div>
							<br>
							<div class="span6" style="margin-top: 1rem; margin-left: 2px;">
							Email:
							<input type="text" name="email" id="email" style="height: 25px; width: 25rem;"  class="required" placeholder="Email" required="required" aria-required="true" aria-invalid="false" value = "<?php echo ($getInteressado->email); ?>" >
							</div>
						</div>
					</div>
				</div>

				<div class="card" style="margin-top: 20px;">
					<div class="card-header">
						<h4> Notícias e Licitações</h4>
					</div>
					<div class="card-body">
						<div class="checkbox">
							<label style="font-size: 1.5em">
								<input type="checkbox" name="noticia" id="noticia" value="1" <?php if ($getInteressado->noticias == 1){ echo "checked";}?>>
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								<h6>Notícias</h6>
							</label>
						</div>
						<br>
						<div class="checkbox">
							<label style="font-size: 1.5em">
								<input type="checkbox" name="licitacao" id="licitacao" value="1" <?php if ($getInteressado->licitacoes == 1){ echo "checked";}?>>
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								<h6>Licitações</h6>
							</label>
						</div>
					</div>
				</div>

				<div class="card" style="margin-top: 20px;">
					<div class="card-header">
						<h4>Meteorologia</h4>
					</div>
					<div class="card-body">
						<div class="checkbox">
									<label style="font-size: 1.5em">
									<input type="checkbox" name="previsao_tempo" id="previsao_tempo" value="1" <?php if ($getInteressado->previsao_tempo == 1){ echo "checked";}?>>
									<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									<h6>Previsão do Tempo</h6>
								</label>
								</div>
						<br>
						<div>
							<h5>Avisos:
								<hr style="color: rgba(0, 0, 0, .1)">
							</h5>
							<br>
							<?php foreach ($avisosMeteorologicos as $avisosM):?>
								<div class="checkbox">
									<label style="font-size: 1.5em">
									<input type="checkbox" name="avisom[]" id="<?php echo ($avisosM->alias); ?>" value="<?php echo ($avisosM->id); ?>" <?php if (!empty($boletim->meteorologia_avisos)){ foreach ($boletim->meteorologia_avisos as $item): if ($avisosM->id == $item){echo "checked";}?><?php endforeach;} ?>>
									<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									<h6><?php echo ($avisosM->title); ?></h6>
								</label>
								</div>
								<br>
								<?php endforeach;?>

						</div>
						<br>
						<h5>Informes:
							<hr style="color: rgba(0, 0, 0, .1)">
						</h5>
						<br>
						<?php foreach ($informesMeteorologicos as $informesM):?>
							<div class="checkbox">
								<label style="font-size: 1.5em">
								<input type="checkbox" name="informem[]" id="<?php echo ($informesM->alias); ?>" value="<?php echo ($informesM->id); ?>" <?php if (!empty($boletim->meteorologia_informes)){ foreach($boletim->meteorologia_informes as $item):if ($informesM->id == $item){echo "checked";}?><?php endforeach;} ?>>
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								<h6><?php echo ($informesM->title); ?></h6>
							</label>
							</div>
							<br>
							<?php endforeach;?>
					</div>
				</div>

				<div class="card" style="margin-top: 1rem;">
					<div class="card-header">
						<h4> Hidrologia</h4>
					</div>
					<div class="card-body">
						<div>
							<h5>Avisos:
								<hr style="color: rgba(0, 0, 0, .1)">
							</h5>
							<br>
							<?php foreach ($avisosHidrologicos as $avisosH):?>
								<div class="checkbox">
									<label style="font-size: 1.5em">
										<input type="checkbox" name="avisoh[]" id="<?php echo ($avisosH->alias); ?>" value="<?php echo ($avisosH->id); ?>"<?php if (!empty($boletim->hidrologia_avisos)){ foreach ($boletim->hidrologia_avisos as $item): if ($avisosH->id == $item){echo "checked";}?><?php endforeach;} ?>>
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
										<h6><?php echo ($avisosH->title); ?></h6>
									</label>
								</div>
								<br>
							<?php endforeach;?>
						</div>
						<br>
						<div>
							<h5>Informes:
								<hr style="color: rgba(0, 0, 0, .1)">
							</h5>
							<br>
							<?php foreach ($informesHidrologicos as $informesH):?>
								<div class="checkbox">
									<label style="font-size: 1.5em">
										<input type="checkbox" name="informeh[]" id="<?php echo ($informesH->alias); ?>" value="<?php echo ($informesH->id); ?>"<?php if (!empty($boletim->hidrologia_informes)){ foreach ($boletim->hidrologia_informes as $item): if ($informesH->id == $item){echo "checked";}?><?php endforeach;} ?>>
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
										<h6><?php echo ($informesH->title); ?></h6>
									</label>
								</div>
								<br>
							<?php endforeach;?>
						</div>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span6" style="margin-top: 1rem; margin-left: 20px;">
						<div class="checkbox">
							<label style="font-size: 1.5em">
								<input type="checkbox" name="todosB" id="myCheck" onclick="myFunction()">
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								Todos Boletins
							</label>
						</div>
					</div>
				</div>
				<br>

		<?php else: ?>
			<div class="card">
				<div class="card-header">
					<center><h4>Boletim de Publicação da APAC - Cadastro de Interessado</h4></center>
				</div>
				<div class="card" style="margin-top: 20px;">
					<div class="card-header">
						<h4>  Dados do Interessado</h4>
					</div>
					<div class="card-body">
						<div class="row-fluid">
							<div class="span6" style="margin-left: 2px;">
							Nome: <input type="text" name="nome" id="nome"  style="height: 25px; width: 25rem;"  class="required" placeholder="Nome" required="required" aria-required="true" aria-invalid="false">
							</div>
							<br>
							<div class="span6" style="margin-top: 1rem; margin-left: 2px;">
							Email:
							<input type="text" name="email" id="email" style="height: 25px; width: 25rem;"  class="required" placeholder="Email" required="required" aria-required="true" aria-invalid="false">
							</div>
						</div>
					</div>
				</div>
				<div class="card" style="margin-top: 20px;">
					<div class="card-header">
						<h4> Notícias e Licitações</h4>
					</div>
					<div class="card-body">
						<div class="checkbox">
							<label style="font-size: 1.5em">
								<input type="checkbox" name="noticia" id="noticia" value="1">
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								<h6>Notícias</h6>
							</label>
						</div>
						<br>
						<div class="checkbox">
							<label style="font-size: 1.5em">
								<input type="checkbox" name="licitacao" id="licitacao" value="1">
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								<h6>Licitações</h6>
							</label>
						</div>
					</div>
				</div>
				<div class="card" style="margin-top: 20px;">
					<div class="card-header">
						<h4>Meteorologia</h4>
					</div>
					<div class="card-body">
						<div class="checkbox">
									<label style="font-size: 1.5em">
									<input type="checkbox" name="previsao_tempo" id="previsao_tempo" value="1">
									<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									<h6>Previsão do Tempo</h6>
								</label>
								</div>
						<br>
						<div>
							<h6>Avisos:
								<hr style="color: rgba(0, 0, 0, .1)">
							</h6>
							<br>
							<?php foreach ($avisosMeteorologicos as $avisosM):?>
								<div class="checkbox">
									<label style="font-size: 1.5em">
									<input type="checkbox" name="avisom[]" id="<?php echo ($avisosM->alias); ?>" value="<?php echo ($avisosM->id); ?>">
									<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									<h6><?php echo ($avisosM->title); ?></h6>
								</label>
								</div>
								<br>
								<?php endforeach;?>

						</div>
						<br>
						<h6>Informes:
							<hr style="color: rgba(0, 0, 0, .1)">
						</h6>
						<br>
						<?php foreach ($informesMeteorologicos as $informesM):?>
							<div class="checkbox">
								<label style="font-size: 1.5em">
								<input type="checkbox" name="informem[]" id="<?php echo ($informesM->alias); ?>" value="<?php echo ($informesM->id); ?>">
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								<h6><?php echo ($informesM->title); ?></h6>
							</label>
							</div>
							<br>
							<?php endforeach;?>
					</div>
				</div>

				<div class="card" style="margin-top: 1rem;">
					<div class="card-header">
						<h4> Hidrologia</h4>
					</div>
					<div class="card-body">
						<div>
							<h6>Avisos:
								<hr style="color: rgba(0, 0, 0, .1)">
							</h6>
							<br>
							<?php foreach ($avisosHidrologicos as $avisosH):?>
								<div class="checkbox">
									<label style="font-size: 1.5em">
										<input type="checkbox" name="avisoh[]" id="<?php echo ($avisosH->alias); ?>" value="<?php echo ($avisosH->id); ?>">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
										<h6><?php echo ($avisosH->title); ?></h6>
									</label>
								</div>
								<br>
							<?php endforeach;?>
						</div>
						<br>
						<div>
							<h6>Informes:
								<hr style="color: rgba(0, 0, 0, .1)">
							</h6>
							<br>
							<?php foreach ($informesHidrologicos as $informesH):?>
								<div class="checkbox">
									<label style="font-size: 1.5em">
										<input type="checkbox" name="informeh[]" id="<?php echo ($informesH->alias); ?>" value="<?php echo ($informesH->id); ?>">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
										<h6><?php echo ($informesH->title); ?></h6>
									</label>
								</div>
								<br>
							<?php endforeach;?>
						</div>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span6" style="margin-top: 1rem; margin-left: 20px;">
						<div class="checkbox">
							<label style="font-size: 1.5em">
								<input type="checkbox" name="todosB" id="myCheck" onclick="myFunction()">
								<span class="cr"><i class="cr-icon fa fa-check"></i></span>
								Todos Boletins
							</label>
						</div>
					</div>
				</div>
				<br>
		<?php endif;?>	
				<div class="row-fluid">
					<div class="span6" style="margin-top: 1rem; margin-left: 20px;">
						<input type="submit" class="highlight-link btnimprimir" value="Cadastrar">
					</div>
				</div>	
			</div>		
	</form>
	
</body>

<script>
	document.getElementsByClassName("row")[2].style = "min-height:0px;"
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }

    if (mm < 10) {
        mm = '0' + mm;
    }

    today = dd + '/' + mm + '/' + yyyy;
    var data = document.getElementsByName("data_criacao");
    if (data[0].value == ""){
			data[0].value = today;
			console.log(today);
		}

    function myFunction() {
        // Get the checkbox
        var checkBox = document.getElementById("myCheck");
        var avisom = document.getElementsByName("avisom[]");
        var avisoh = document.getElementsByName("avisoh[]");
        var informem = document.getElementsByName("informem[]");
        var informeh = document.getElementsByName("informeh[]");
        // Get the output text
        // If the checkbox is checked, display the output text
        if (checkBox.checked == true) {

            document.getElementById("previsao_tempo").checked = true;
            document.getElementById("noticia").checked = true;
            document.getElementById("licitacao").checked = true;

            for (var i = 0; i < avisom.length; i++) {
                avisom[i].checked = true;
            }
            for (var i = 0; i < avisoh.length; i++) {
                avisoh[i].checked = true;
            }
            for (var i = 0; i < informem.length; i++) {
                informem[i].checked = true;
            }
            for (var i = 0; i < informeh.length; i++) {
                informeh[i].checked = true;
            }
            console.log(true);

        } else {
            //document.getElementById("previsao_tempo").checked = false;
            document.getElementById("noticia").checked = false;
            document.getElementById("licitacao").checked = false;

            for (var i = 0; i < avisom.length; i++) {
                avisom[i].checked = false;
            }
            for (var i = 0; i < avisoh.length; i++) {
                avisoh[i].checked = false;
            }
            for (var i = 0; i < informem.length; i++) {
                informem[i].checked = false;
            }
            for (var i = 0; i < informeh.length; i++) {
                informeh[i].checked = false;
            }
            console.log(false);

        }
    }
</script>

</html>