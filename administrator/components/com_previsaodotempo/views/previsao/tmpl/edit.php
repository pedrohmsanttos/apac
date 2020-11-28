<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');


// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_previsaodotempo/css/form.css');
$document->addStyleSheet(JUri::root() . 'administrator/components/com_previsaodotempo/assets/css/previsaodotempo.css');

//JHtml::_('jquery.framework');
$document->addScript(JUri::root() . 'administrator/components/com_previsaodotempo/assets/js/angular.min.js');
$document->addScript(JUri::root() . 'administrator/components/com_previsaodotempo/assets/js/script.js');
$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
$document->addScript('//cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js');
?>
<script type="text/javascript">
	jQuery.noConflict();
	
	window.scrollTo(500, 0);

	function somenteNumeros(e) {
		var charCode = e.charCode ? e.charCode : e.keyCode;
		console.log(e.target.selectionEnd);
        if (charCode != 8 && charCode != 9) {
            if (charCode < 48 || charCode > 57 || e.target.selectionEnd > 1) {
                return false;
            }
        }
    }

	$(document).ready(function(){
		$('#TMax').on("cut copy paste",function(e) {
			e.preventDefault();
		});
		$('#TMin').on("cut copy paste",function(e) {
			e.preventDefault();
		});
		$('#UMax').on("cut copy paste",function(e) {
			e.preventDefault();
		});
		$('#UMin').on("cut copy paste",function(e) {
			e.preventDefault();
		});
	});

	function checkTime(datatime){
		var errorFlag = false;

		var re = new RegExp("^(3[01]|[12][0-9]|0[1-9])/(1[0-2]|0[1-9])/[0-9]{4} (2[0-3]|[01]?[0-9]):([0-5]?[0-9])$");
		
		if (re.test(datatime)){
			complemento = datatime.split(' ');
			data = complemento[0];
			time = complemento[1];

			hora  = time.split(':'); 
			cData = data.split('/');

			if (hora[0]<0 || hora[0]>23){
				errorFlag = true;
				
			}
			if(hora[1]<0 || hora[1]>59){
				errorFlag = true;
				
			}
			if(hora[2]<=0 || hora[2]>59){
				errorFlag = true;
				
			}
			if (cData[0]<1 || cData[0]>31){
				errorFlag = true;
				
			}
			if (cData[1]<1 || cData[1]>12){
				errorFlag = true;
				
			}
			if (cData[2]<1){
				errorFlag = true;
				
			}
		}else{
			errorFlag = true;
		}
		
		
		return errorFlag;
	}

	function crlScroll(args){
		var divContent = document.getElementById("controlScroll");
		console.log(args);
		if(args == 'next'){
			divContent.scrollLeft += 250;
		}else{
			divContent.scrollLeft -= 250;
		}
	}

	Joomla.submitbutton = function (task) {
		var hora = document.getElementById('jform_datavlida').value;
		var tipo = document.getElementById('jform_tipo').value;
		var formato = checkTime(hora);

		if( ( 
			hora.length != 16 ||
			formato ||
			document.getElementById('jform_datavlida').value == '') &&
			(task != 'previsao.cancel')
		){
			alert("Campos obrigatórios vazios ou nulos (Data Válida/Horário)!");
			event.preventDefault();
		}else if(tipo == '' && (task != 'previsao.cancel')){
			alert("Campos obrigatórios vazios ou nulos (Tipo)!");
			event.preventDefault();
		}else{
			if (task == 'previsao.cancel')
			{
				//Joomla.submitform(task, document.getElementById('previsao-form'));
				window.location = 'index.php?option=com_previsaodotempo';
			}
			else
			{
				if (task != 'previsao.cancel') 
				{	
					Joomla.submitform(task, document.getElementById('previsao-form'));
				}
				else 
				{
					alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
				}
			}
		}		
	}

	var arr_icones = [];

	$(document).ready(function() {
		$("select[id='icone']").map(function(index, select){
			var select_temp = select;
			console.log();
			return $(this).ddslick({
					onSelected: function(data){  
						let length_options = select_temp.length;
						var options        = select_temp.children;
						for(i = 0; i<length_options; ++i){
							if(options[i].value == data.selectedData.value){
								options[i].setAttribute("selected", "selected");
								arr_icones[index] = data.selectedData.value;
							}
						}
						console.log(arr_icones);
						$('#icones').val(arr_icones);
					}
				});
		}).get();
	});
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_previsaodotempo&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="previsao-form" class="form-validate">

	<div class="form-horizontal" ng-app="PrevisaoTempo">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
		

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_PREVISAODOTEMPO_TITLE_PREVISAO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">
					<input type="hidden" id="id" name="jform[id]" value="<?php echo $this->item->id; ?>" />
					<input type="hidden" id="checked_out" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
					<input type="hidden" id="checked_out_time" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

					<?php echo $this->form->renderField('state'); ?>
					<?php echo $this->form->renderField('ordering'); ?>
					<?php echo $this->form->renderField('created_by'); ?>
					<?php echo $this->form->renderField('modified_by'); ?>				
					<?php echo $this->form->renderField('datavlida'); ?>
					<?php echo $this->form->renderField('tipo'); ?>
					<?php echo $this->form->renderField('horario'); ?>
					<?php echo $this->form->renderField('observaes'); ?>

					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>

			</div>
			
			
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general1', JText::_('Mesoregião', true)); ?>
		<div class="row-fluid">
			<div class="span12 form-horizontal">
				<fieldset class="general1">
					<input type="hidden" id="icones" name="icones[]" >
		<?php 
			foreach($this->mesorregioes as $index=>$mesoregiao): 
				$chave = array_search($mesoregiao->id, $this->item->mesorregioes->mesorregiao);
		?>
			<?php
				if($index%2==0) echo('<div class="row-fluid" id="linha">');
			?>
			<?php if($this->item->id != null && $this->item->id > 0 && is_numeric($chave)): ?>
				<div class="span6 form-horizontal" id="mesorregiao_conteudo">
					<div class="row-fluid" id="mesorregiao">
						<div class="span12">
							<h1><?php echo($mesoregiao->nome);?></h1>
							<input type="hidden" id="mesorregioes[]" name="mesorregioes[]" value="<?php echo($mesoregiao->id);?>">
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<div class="row-fluid">
								<div class="span12">
									<div class="row-fluid">
										<div class="span6">
											<input type="text" maxlength="2" name="temMax[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" required value="<?php echo($this->item->mesorregioes->temMax[$chave]);?>" placeholder="T.Máx" id="TMax">
										</div>
										<div class="span6">
											<input type="text" maxlength="2" name="temMin[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" required value="<?php echo($this->item->mesorregioes->temMin[$chave]);?>" placeholder="T.Min" id="TMin">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="row-fluid">
								<div class="span12">
									<div class="row-fluid">
										<div class="span6">
											<input type="text" maxlength="2" name="umiMax[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" required value="<?php echo($this->item->mesorregioes->umiMin[$chave]);?>" placeholder="U.Máx" id="UMax">
										</div>
										<div class="span6">
											<input type="text" maxlength="2" name="umiMin[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" required value="<?php echo($this->item->mesorregioes->umiMax[$chave]);?>" placeholder="U.Min" id="UMin">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="icone[]" id="icone" required>
								<option value=""  >-- Selecione um ícone --</option>
								<?php foreach ($this->icones as $icone) : ?>
									<option value="<?php echo($icone->icone);?>" data-imagesrc="<?php echo(JUri::root() .'/'.$icone->icone);?>" <?php if($this->item->mesorregioes->icone[$chave] == $icone->icone){ echo('selected'); }?>> <?php echo($icone->nome);?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="span6">
							<select name="IntensidadeDoVento[]">
								<option value=""  >-- Intensidades do Vento --</option>
								<option value="Leve a Fraca" <?php if($this->item->mesorregioes->IntensidadeDoVento[$chave] == 'Leve a Fraca'){ echo('selected'); }?>>Leve a Fraca</option>
								<option value="Fracos a moderados" <?php if($this->item->mesorregioes->IntensidadeDoVento[$chave] == 'Fracos a moderados'){ echo('selected'); }?>>Fracos a moderados</option>
								<option value="Moderado" <?php if($this->item->mesorregioes->IntensidadeDoVento[$chave] == 'Moderado'){ echo('selected'); }?>>Moderado</option>
								<option value="Moderados a Forte" <?php if($this->item->mesorregioes->IntensidadeDoVento[$chave] == 'Moderados a Forte'){ echo('selected'); }?>>Moderados a Forte</option>
								<option value="Forte" <?php if($this->item->mesorregioes->IntensidadeDoVento[$chave] == 'Forte'){ echo('selected'); }?>>Forte</option>
								<option value="Fracos" <?php if($this->item->mesorregioes->IntensidadeDoVento[$chave] == 'Fracos'){ echo('selected'); }?>>Fracos</option>
							</select>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="RotaDoVento[]">
								<option value=""  >-- Rota do vento --</option>
								<option value="Leste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Leste'){ echo('selected'); }?>>Leste</option>
								<option value="Norte" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Norte'){ echo('selected'); }?>>Norte</option>
								<option value="Oeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Oeste'){ echo('selected'); }?>>Oeste</option>
								<option value="Sul" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Sul'){ echo('selected'); }?>>Sul</option>
								<option value="Nordeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Nordeste'){ echo('selected'); }?>>Nordeste</option>
								<option value="Noroeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Noroeste'){ echo('selected'); }?>>Noroeste</option>
								<option value="Sudeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Sudeste'){ echo('selected'); }?>>Sudeste</option>
								<option value="Sudoeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Sudoeste'){ echo('selected'); }?>>Sudoeste</option>
								<option value="Norte-Nordeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Norte-Nordeste'){ echo('selected'); }?>>Norte-Nordeste</option>
								<option value="Leste-Nordeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Leste-Nordeste'){ echo('selected'); }?>>Leste-Nordeste</option>
								<option value="Leste-Sudeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Leste-Sudeste'){ echo('selected'); }?>>Leste-Sudeste</option>
								<option value="Sul-Sudeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Sul-Sudeste'){ echo('selected'); }?>>Sul-Sudeste</option>
								<option value="Sul-Sudoeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Sul-Sudoeste'){ echo('selected'); }?>>Sul-Sudoeste</option>
								<option value="Oeste-Sudoeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Oeste-Sudoeste'){ echo('selected'); }?>>Oeste-Sudoeste</option>
								<option value="Oeste-Nordeste" <?php if($this->item->mesorregioes->RotaDoVento[$chave] == 'Oeste-Nordeste'){ echo('selected'); }?>>Oeste-Nordeste</option>
							</select>
						</div>
						<div class="span6">
							<select name="nebulosidade[]">
								<option value=""  >-- Nebulosidade --</option>
								<option value="Céu Claro" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Céu Claro'){ echo('selected'); }?>>Céu Claro</option>
								<option value="Claro a parcialmente nublado" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Claro a parcialmente nublado'){ echo('selected'); }?>>Claro a parcialmente nublado</option>
								<option value="Parcialmente nublado a claro" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Parcialmente nublado a claro'){ echo('selected'); }?>>Parcialmente nublado a claro</option>
								<option value="Parcialmente nublado" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Parcialmente nublado'){ echo('selected'); }?>>Parcialmente nublado</option>
								<option value="Parcialmente nublado a nublado" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Parcialmente nublado a nublado'){ echo('selected'); }?>>Parcialmente nublado a nublado</option>
								<option value="Nublado a parcialmente nublado" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Nublado a parcialmente nublado'){ echo('selected'); }?>>Nublado a parcialmente nublado</option>
								<option value="Nublado" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Nublado'){ echo('selected'); }?>>Nublado</option>
								<option value="Nublado a claro" <?php if($this->item->mesorregioes->nebulosidade[$chave] == 'Nublado a claro'){ echo('selected'); }?>>Nublado a claro</option>
							</select>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="TiposDeChuva[]">
								<option value=""  >-- Tipos de chuva --</option>
								<option value="com chuva rápida" <?php if($this->item->mesorregioes->TiposDeChuva[$chave] == 'com chuva rápida'){ echo('selected'); }?>>com chuva rápida</option>
								<option value="com pancadas de chuva" <?php if($this->item->mesorregioes->TiposDeChuva[$chave] == 'com pancadas de chuva'){ echo('selected'); }?>>com pancadas de chuva</option>
								<option value="com chuva e trovoada" <?php if($this->item->mesorregioes->TiposDeChuva[$chave] == 'com chuva e trovoada'){ echo('selected'); }?>>com chuva e trovoada</option>
								<option value="com chuva contínua" <?php if($this->item->mesorregioes->TiposDeChuva[$chave] == 'com chuva contínua'){ echo('selected'); }?>>com chuva contínua</option>
								<option value="sem chuva" <?php if($this->item->mesorregioes->TiposDeChuva[$chave] == 'sem chuva'){ echo('selected'); }?>>sem chuva</option>
							</select>
						</div>
						<div class="span6">
							<select name="DistribuicaoDaChuva[]">
								<option value=""  >-- Distribuições de Chuva --</option>
								<option value="de forma isolada" <?php if($this->item->mesorregioes->DistribuicaoDaChuva[$chave] == 'de forma isolada'){ echo('selected'); }?>>de forma isolada</option>
								<option value="em toda a região" <?php if($this->item->mesorregioes->DistribuicaoDaChuva[$chave] == 'em toda a região'){ echo('selected'); }?>>em toda a região</option>
							</select>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="PeriodoDaChuva[]">
								<option value=""  >-- Períodos de Chuva --</option>
								<option value="no período da manhã" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'no período da manhã'){ echo('selected'); }?>>no período da manhã</option>
								<option value="no período da tarde" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'no período da tarde'){ echo('selected'); }?>>no período da tarde</option>
								<option value="no período da noite" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'no período da noite'){ echo('selected'); }?>>no período da noite</option>
								<option value="no período da madrugada e primeiras horas da manhã" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'no período da madrugada e primeiras horas da manhã'){ echo('selected'); }?>>no período da madrugada e primeiras horas da manhã</option>
								<option value="no período da tarde e noite" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'no período da tarde e noite'){ echo('selected'); }?>>no período da tarde e noite</option>
								<option value="ao longo do dia" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'ao longo do dia'){ echo('selected'); }?>>ao longo do dia</option>
								<option value="nas primeiras horas da manhã e noite" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'nas primeiras horas da manhã e noite'){ echo('selected'); }?>>nas primeiras horas da manhã e noite</option>
								<option value="na madrugada" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'na madrugada'){ echo('selected'); }?>>na madrugada</option>
								<option value="manhã e noite" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'manhã e noite'){ echo('selected'); }?>>manhã e noite</option>
								<option value="madrugada e noite" <?php if($this->item->mesorregioes->PeriodoDaChuva[$chave] == 'madrugada e noite'){ echo('selected'); }?>>madrugada e noite</option>
							</select>
						</div>
						<div class="span6">
							<select name="IntensidadeDaChuva[]">
								<option value=""  >-- Intensidades da Chuva --</option>
								<option value="com intensidade fraca" <?php if($this->item->mesorregioes->IntensidadeDaChuva[$chave] == 'com intensidade fraca'){ echo('selected'); }?>>com intensidade fraca</option>
								<option value="com intensidade fraca a moderada" <?php if($this->item->mesorregioes->IntensidadeDaChuva[$chave] == 'com intensidade fraca a moderada'){ echo('selected'); }?>>com intensidade fraca a moderada</option>
								<option value="com intensidade moderada" <?php if($this->item->mesorregioes->IntensidadeDaChuva[$chave] == 'com intensidade moderada'){ echo('selected'); }?>>com intensidade moderada</option>
								<option value="com intensidade moderada a forte" <?php if($this->item->mesorregioes->IntensidadeDaChuva[$chave] == 'com intensidade moderada a forte'){ echo('selected'); }?>>com intensidade moderada a forte</option>
								<option value="com intensidade forte" <?php if($this->item->mesorregioes->IntensidadeDaChuva[$chave] == 'com intensidade forte'){ echo('selected'); }?>>com intensidade forte</option>
								<option value="nenhuma" <?php if($this->item->mesorregioes->IntensidadeDaChuva[$chave] == 'nenhuma'){ echo('selected'); }?>>nenhuma</option>
							</select>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="span6 form-horizontal" id="mesorregiao_conteudo">
					<div class="row-fluid" id="mesorregiao">
						<div class="span12">
							<h1><?php echo($mesoregiao->nome);?></h1>
							<input type="hidden" id="mesorregioes[]" name="mesorregioes[]" value="<?php echo($mesoregiao->id);?>">
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<div class="row-fluid">
								<div class="span12">
									<div class="row-fluid">
										<div class="span6">
											<input type="text" maxlength="2" name="temMax[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" placeholder="T.Máx" id="TMax">
										</div>
										<div class="span6">
											<input type="text" maxlength="2" name="temMin[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" placeholder="T.Min" id="TMin">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="row-fluid">
								<div class="span12">
									<div class="row-fluid">
										<div class="span6">
											<input type="text" maxlength="2" name="umiMax[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" placeholder="U.Máx" id="UMax">
										</div>
										<div class="span6">
											<input type="text" maxlength="2" name="umiMin[]" pattern="([0-9]{2})" onkeypress="return somenteNumeros(event)" placeholder="U.Min" id="UMin">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="icone[]" id="icone" required>
								<option value=""  >-- Selecione um ícone --</option>
								<?php foreach ($this->icones as $icone) : ?>
									<option value="<?php echo($icone->icone);?>" data-imagesrc="<?php echo(JUri::root() .'/'.$icone->icone);?>" <?php if($this->item->mesorregioes->icone[$chave] == $icone->icone){ echo('selected'); }?>> <?php echo($icone->nome);?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="span6">
							<select name="IntensidadeDoVento[]">
								<option value=""  >-- Intensidades do Vento --</option>
								<option value="Leve a Fraca">Leve a Fraca</option>
								<option value="Fracos a moderados">Fracos a moderados</option>
								<option value="Moderado">Moderado</option>
								<option value="Moderados a Forte">Moderados a Forte</option>
								<option value="Forte">Forte</option>
								<option value="Fracos">Fracos</option>
							</select>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="RotaDoVento[]">
								<option value=""  >-- Rota do vento --</option>
								<option value="Leste">Leste</option>
								<option value="Norte">Norte</option>
								<option value="Oeste">Oeste</option>
								<option value="Sul">Sul</option>
								<option value="Nordeste">Nordeste</option>
								<option value="Noroeste">Noroeste</option>
								<option value="Sudeste">Sudeste</option>
								<option value="Sudoeste">Sudoeste</option>
								<option value="Norte-Nordeste">Norte-Nordeste</option>
								<option value="Leste-Nordeste">Leste-Nordeste</option>
								<option value="Leste-Sudeste">Leste-Sudeste</option>
								<option value="Sul-Sudeste">Sul-Sudeste</option>
								<option value="Sul-Sudoeste">Sul-Sudoeste</option>
								<option value="Oeste-Sudoeste">Oeste-Sudoeste</option>
								<option value="Oeste-Nordeste">Oeste-Nordeste</option>
							</select>
						</div>
						<div class="span6">
							<select name="nebulosidade[]">
								<option value=""  >-- Nebulosidade --</option>
								<option value="Céu Claro">Céu Claro</option>
								<option value="Claro a parcialmente nublado">Claro a parcialmente nublado</option>
								<option value="Parcialmente nublado a claro">Parcialmente nublado a claro</option>
								<option value="Parcialmente nublado">Parcialmente nublado</option>
								<option value="Parcialmente nublado a nublado">Parcialmente nublado a nublado</option>
								<option value="Nublado a parcialmente nublado">Nublado a parcialmente nublado</option>
								<option value="Nublado">Nublado</option>
								<option value="Nublado a claro">Nublado a claro</option>
							</select>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="TiposDeChuva[]">
								<option value=""  >-- Tipos de chuva --</option>
								<option value="com chuva rápida">com chuva rápida</option>
								<option value="com pancadas de chuva">com pancadas de chuva</option>
								<option value="com chuva e trovoada">com chuva e trovoada</option>
								<option value="com chuva contínua">com chuva contínua</option>
								<option value="sem chuva">sem chuva</option>
							</select>
						</div>
						<div class="span6">
							<select name="DistribuicaoDaChuva[]">
								<option value=""  >-- Distribuições de Chuva --</option>
								<option value="de forma isolada">de forma isolada</option>
								<option value="em toda a região">em toda a região</option>
							</select>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<select name="PeriodoDaChuva[]">
								<option value=""  >-- Períodos de Chuva --</option>
								<option value="no período da manhã">no período da manhã</option>
								<option value="no período da tarde">no período da tarde</option>
								<option value="no período da noite">no período da noite</option>
								<option value="no período da madrugada e primeiras horas da manhã">no período da madrugada e primeiras horas da manhã</option>
								<option value="no período da tarde e noite">no período da tarde e noite</option>
								<option value="ao longo do dia">ao longo do dia</option>
								<option value="nas primeiras horas da manhã e noite">nas primeiras horas da manhã e noite</option>
								<option value="na madrugada">na madrugada</option>
								<option value="manhã e noite">manhã e noite</option>
								<option value="madrugada e noite">madrugada e noite</option>
							</select>
						</div>
						<div class="span6">
							<select name="IntensidadeDaChuva[]">
								<option value=""  >-- Intensidades da Chuva --</option>
								<option value="com intensidade fraca">com intensidade fraca</option>
								<option value="com intensidade fraca a moderada">com intensidade fraca a moderada</option>
								<option value="com intensidade moderada">com intensidade moderada</option>
								<option value="com intensidade moderada a forte">com intensidade moderada a forte</option>
								<option value="com intensidade forte">com intensidade forte</option>
								<option value="nenhuma">nenhuma</option>
							</select>
						</div>
					</div>
				</div>

			<?php endif;?>
			<?php
				if($index%2!=0) echo('</div>');
			?>
		<?php endforeach; ?>						
				</fieldset>
			</div>
		</div>

		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general2', JText::_('Variáveis', true)); ?>
		<div class="row-fluid" ng-controller="valorescrl" ng-init="init()">
			<div class="span10 form-horizontal">
				<fieldset class="general1">
					<div class="row-fluid">
						<div class="span3">
							<select name="mesorregiao" ng-model="mesorregiao">
								<option value="" disabled selected>Selecione uma Mesorregião</option>
                                <?php foreach ($this->mesorregioes as $mesoregiao) : ?>
								
                                	<option value="<?php echo($mesoregiao->nome);?>"> <?php echo($mesoregiao->nome);?></option>
                                <?php endforeach; ?>
							</select>
						</div>
						<div class="span3">
							<select name="variavel" id="variavel" ng-model="variavel" ng-change="trocaValores()" >
								<option value="" disabled selected>Selecione uma variável</option>
                                <?php foreach ($this->variaveis as $variavel) : ?>
                                  	<option value="<?php echo($variavel->valores);?>"> <?php echo($variavel->nome);?></option>
                                <?php endforeach; ?>
							</select>
						</div>
						<div class="span3">
							<select name="valor" id="valor" ng-model="valor">
								<option ng-repeat="option in opcoes" value="{{option}}">{{option}}</option>
							</select>
						</div>
						<div class="span3">
							<a ng-click="addNovoValor()" class="btn btn-small" style="margin-top: 10px;">
								<span class="icon-save-new"></span>
								Adicionar valor
							</a>
						</div>
					</div>
					<br><br><br>
					<div class="row-fluid">
						<div class="control-group">
                        	<div class="control-label">
                            	Valores:
                          	</div>
							<br><br><br>
						  	<div class="controls">
                          		<style type="text/css">
                              		.tg  {border-collapse:collapse;border-spacing:0;min-width: 350px;}
                              		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                              		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                              		.tg .tg-yw4l{vertical-align:top}
								</style>

                              	<table class="tg">
									<tr>
										<th class="tg-yw4l">Mesorregião</th>
										<th class="tg-yw4l">Variável</th>
										<th class="tg-yw4l">Valor</th>
										<th class="tg-yw4l">Ação</th>
									</tr>

									<tr ng-if="variavelValor.length > 0" class="animate-if" ng-repeat="valor in variavelValor track by $index">
										<td>
											<center>
												<input type="hidden" id="valorMesorregioes[]" name="valorMesorregioes[]" value="{{valor.messoregiao}}">
												{{ valor.messoregiao }}
											</center>
										</td>
										<td>
											<center>
												<input type="hidden" id="valorMesorregioes[]" name="valorMesorregioes[]" value="{{valor.variavel}}">
												{{ valor.variavel }}
											</center>
										</td>
										<td>
											<center>
												<input type="hidden" id="valorMesorregioes[]" name="valorMesorregioes[]" value="{{valor.valor}}">
												{{ valor.valor }}
											</center>
										</td>
										<td>
											<a id="gerar" class="btn btn-small btn-danger" ng-click="deletaValor($index)">
												<span class="icon-remove icon-white" aria-hidden="true"></span>
												Deletar
											</a>
										</td>
									</tr>

									<tr ng-if="variavelValor.length === 0" class="animate-if">
										<td colspan="4"><center>Nenhum valor cadastrado.</center></td>
										
									</tr>
									<?php
										if($this->item->id != null && $this->item->id > 0):
									?>
										<input type="hidden" id="valores" name="valores" value="<?php echo(implode(',', $this->item->valores));?>">
									<?php
										else:
									?>
										<input type="hidden" id="valores" name="valores" value="">
									<?php
										endif;
									?>
                        		</table>
                          	</div>
                        </div>
					</div>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>	

	</div>
</form>
