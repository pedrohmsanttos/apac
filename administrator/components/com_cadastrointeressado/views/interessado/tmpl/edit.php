<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Cadastrointeressado
 * @author     Lerisson Freitas <lerisson.freitas@inhalt.com.br>
 * @copyright  2019 Lerisson Freitas
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_cadastrointeressado/css/form.css');
$document->addStyleSheet(JUri::root() . 'media/com_cadastrointeressado/css/card.css');
?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'interessado.cancel') {
			Joomla.submitform(task, document.getElementById('interessado-form'));
		}
		else {
			
			if (task != 'interessado.cancel' && document.formvalidator.isValid(document.id('interessado-form'))) {
				
				Joomla.submitform(task, document.getElementById('interessado-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_cadastrointeressado&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="interessado-form" class="form-validate">
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CADASTROINTERESSADO_TITLE_INTERESSADO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
					<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
					<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
					<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
					<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
					<input type="hidden" name="jform[data_criacao]" value="<?php echo $this->item->data_criacao; ?>" />
					<?php echo $this->form->renderField('created_by'); ?>	
					<?php echo $this->form->renderField('modified_by'); ?>	
					
					<?php if($this->item->id != null && $this->item->id > 0): $boletim = json_decode($this->item->boletim); ?>
						
						<div class="card " style="width: 40rem; position: relative; float: left; ">
							<div class="card-header">
								<h4> Dados do Interessado </h4>
							</div>
							<div class="card-body">
								<?php echo $this->form->renderField('nome'); ?>
								<?php echo $this->form->renderField('email'); ?>
								<?php echo $this->form->renderField('observacao'); ?>
								<?php echo $this->form->renderField('situacao'); ?>
								<?php echo $this->form->renderField('pertencegoverno'); ?>
								<?php
								if (trim($this->tipoUser[1])=="Super Users" || trim($this->tipoUser[1]) == "Administrator" || trim($this->tipoUser[1])=="Comunicação Autorizados"){
									echo $this->form->renderField('confidencial');
								}else{
									echo '<input type="radio" id="jform_confidencial1" name="jform[confidencial]" value="0" checked="checked" style="display: none;">';
								}
								?>
								</div>
						</div>

						<div class="card" style="width: 40rem;position: relative; float: right;padding-bottom: 0.75rem;">
                            <div class="card-header">
                                <h4>Meteorologia</h4>
                            </div>
                            <div class="card-body">

                                <div class="control-group">
                                    <div class="control-label">
                                        <?php echo $this->form->getLabel('previsao_tempo'); ?>
                                    </div>
                                    <div class="controls">
                                        <?php echo $this->form->getInput('previsao_tempo'); ?>
                                    </div>
                                </div>
                                <br>
                                <h6>Avisos:
                                    <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
								</h6>
								<?php 
									foreach($this->avisosMeteorologicos as $avisosM):
										?>
										<div class="checkbox">
											<label style="font-size: 1.5em">
												<input type="checkbox" name="avisom[]" id="<?php echo($avisosM->alias);?>" value="<?php echo($avisosM->id);?>" <?php if (!empty($boletim->meteorologia_avisos)){ foreach ($boletim->meteorologia_avisos as $item): if ($avisosM->id == $item){echo "checked";}?><?php endforeach;} ?> >
												<span class="cr"><i class="cr-icon fa fa-check"></i></span>
												<h5><?php echo($avisosM->title);?></h5>
											</label>
										</div>
									<?php endforeach; ?>
                                <br>
                                <h6>Informes:
                                    <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
                                </h6>
                                <?php 
									foreach($this->informesMeteorologicos as $informesM): 
								?>
									<div class="checkbox">
										<label style="font-size: 1.5em">
											<input type="checkbox" name="informem[]" id="<?php echo($informesM->alias);?>" value="<?php echo($informesM->id);?>"<?php if (!empty($boletim->meteorologia_informes)){ foreach($boletim->meteorologia_informes as $item):if ($informesM->id == $item){echo "checked";}?><?php endforeach;} ?>>
											<span class="cr"><i class="cr-icon fa fa-check"></i></span>
											<h5><?php echo($informesM->title);?></h5>
										</label>
									</div>
									<?php endforeach; ?>
                            </div>
						</div>

						<div class="card" style="width: 40rem; margin-top: 1rem; float: left; position: relative;">
                            <div class="card-header">
                                <h4> Notícias e licitações</h4>
                            </div>
                            <div class="card-body">
                                <?php echo $this->form->renderField('noticias'); ?>
                                <?php echo $this->form->renderField('licitacoes'); ?>
                            </div>
						</div>
						
						<div class="card" style="width: 82rem; margin-top: 1rem; float: left; position: relative;">
                            <div class="card-header">
                                <h4> Hidrologia</h4>
                            </div>
                            <div class="card-body">
                                <div style=" float: left; position: relative;">
                                    <h6>Avisos:
                                        <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
									</h6>
									
									<?php 
									foreach($this->avisosHidrologicos as $avisosH): 
									?>
									<div class="checkbox">
										<label style="font-size: 1.5em">
											<input type="checkbox" name="avisoh[]" id="<?php echo($avisosH->alias);?>" value="<?php echo($avisosH->id);?>"<?php if (!empty($boletim->hidrologia_avisos)){ foreach ($boletim->hidrologia_avisos as $item): if ($avisosH->id == $item){echo "checked";}?><?php endforeach;} ?>>
											<span class="cr"><i class="cr-icon fa fa-check"></i></span>
											<h5><?php echo($avisosH->title);?></h5>
										</label>
									</div>
									<?php endforeach; ?>

                                </div>
                                <div style="float: right; position: relative;">
                                    <h6>Informes:
                                        <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
									</h6>
									
									<?php 
									foreach($this->informesHidrologicos as $informesH): 
									?>
									<div class="checkbox">
										<label style="font-size: 1.5em">
											<input type="checkbox" name="informeh[]" id="<?php echo($informesH->alias);?>" value="<?php echo($informesH->id);?>"<?php if (!empty($boletim->hidrologia_informes)){ foreach ($boletim->hidrologia_informes as $item): if ($informesH->id == $item){echo "checked";}?><?php endforeach;} ?>>
											<span class="cr"><i class="cr-icon fa fa-check"></i></span>
											<h5><?php echo($informesH->title);?></h5>
										</label>
									</div>
									<?php endforeach; ?>

                                </div>
                            </div>
						</div>
						
						<div class="row-fluid">
							<div class="span6" style="padding-top: 35px;">
								<div class="checkbox">
									<label style="font-size: 1.5em">
										<input type="checkbox" name="todosB" id="myCheck" onclick="myFunction()">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
										Todos Boletins
									</label>
								</div>
							</div>
                        </div>
					
					<?php else: ?>
						<div class="card " style="width: 40rem; position: relative; float: left; ">
							<div class="card-header">
								<h4> Dados do Interessado </h4>
							</div>
							<div class="card-body">
								<?php echo $this->form->renderField('nome'); ?>
								<?php echo $this->form->renderField('email'); ?>
								<?php echo $this->form->renderField('observacao'); ?>
								<?php echo $this->form->renderField('situacao'); ?>
								<?php echo $this->form->renderField('pertencegoverno'); ?>
								<?php
								if (trim($this->tipoUser[1])=="Super Users" || trim($this->tipoUser[1]) == "Administrator" || trim($this->tipoUser[1])=="Comunicação Autorizados"){
									echo $this->form->renderField('confidencial');
								}else{
									echo '<input type="radio" id="jform_confidencial1" name="jform[confidencial]" value="0" checked="checked" style="display: none;">';
								}
								?>
							</div>
						</div>

						<div class="card" style="width: 40rem;position: relative; float: right;padding-bottom: 0.75rem;">
                            <div class="card-header">
                                <h4>Meteorologia</h4>
                            </div>
                            <div class="card-body">

                                <div class="control-group">
                                    <div class="control-label">
                                        <?php echo $this->form->getLabel('previsao_tempo'); ?>
                                    </div>
                                    <div class="controls">
                                        <?php echo $this->form->getInput('previsao_tempo'); ?>
                                    </div>
                                </div>
                                <br>
                                <h6>Avisos:
                                    <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
								</h6>
								<?php 
									foreach($this->avisosMeteorologicos as $avisosM): 
								?>
									<div class="checkbox">
										<label style="font-size: 1.5em">
											<input type="checkbox" name="avisom[]" id="<?php echo($avisosM->alias);?>" value="<?php echo($avisosM->id);?>">
											<span class="cr"><i class="cr-icon fa fa-check"></i></span>
											<h5><?php echo($avisosM->title);?></h5>
										</label>
									</div>
									<?php endforeach; ?>
                                <br>
                                <h6>Informes:
                                    <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
                                </h6>
                                <?php 
									foreach($this->informesMeteorologicos as $informesM): 
								?>
									<div class="checkbox">
										<label style="font-size: 1.5em">
											<input type="checkbox" name="informem[]" id="<?php echo($informesM->alias);?>" value="<?php echo($informesM->id);?>">
											<span class="cr"><i class="cr-icon fa fa-check"></i></span>
											<h5><?php echo($informesM->title);?></h5>
										</label>
									</div>
									<?php endforeach; ?>
                            </div>
						</div>
						
						<div class="card" style="width: 40rem; margin-top: 1rem; float: left; position: relative;">
                            <div class="card-header">
                                <h4> Notícias e licitações</h4>
                            </div>
                            <div class="card-body">
                                <?php echo $this->form->renderField('noticias'); ?>
                                <?php echo $this->form->renderField('licitacoes'); ?>
                            </div>
						</div>
						
						<div class="card" style="width: 82rem; margin-top: 1rem; float: left; position: relative;">
                            <div class="card-header">
                                <h4> Hidrologia</h4>
                            </div>
                            <div class="card-body">
                                <div style=" float: left; position: relative;">
                                    <h6>Avisos:
                                        <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
									</h6>
									
									<?php 
									foreach($this->avisosHidrologicos as $avisosH): 
									?>
									<div class="checkbox">
										<label style="font-size: 1.5em">
											<input type="checkbox" name="avisoh[]" id="<?php echo($avisosH->alias);?>" value="<?php echo($avisosH->id);?>">
											<span class="cr"><i class="cr-icon fa fa-check"></i></span>
											<h5><?php echo($avisosH->title);?></h5>
										</label>
									</div>
									<?php endforeach; ?>

                                </div>
                                <div style="float: right; position: relative;">
                                    <h6>Informes:
                                        <div style="color: rgba(0, 0, 0, .1)"><b>_________________________________________________________________________________________</b></div>
									</h6>
									
									<?php 
									foreach($this->informesHidrologicos as $informesH): 
									?>
									<div class="checkbox">
										<label style="font-size: 1.5em">
											<input type="checkbox" name="informeh[]" id="<?php echo($informesH->alias);?>" value="<?php echo($informesH->id);?>">
											<span class="cr"><i class="cr-icon fa fa-check"></i></span>
											<h5><?php echo($informesH->title);?></h5>
										</label>
									</div>
									<?php endforeach; ?>

                                </div>
                            </div>
						</div>
						
						<div class="row-fluid">
							<div class="span6" style="padding-top: 35px;">
								<div class="checkbox">
									<label style="font-size: 1.5em">
										<input type="checkbox" name="todosB" id="myCheck" onclick="myFunction()">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
										Todos Boletins
									</label>
								</div>
							</div>
                        </div>
					<?php endif;?>							
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

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
<script>
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; 
		var yyyy = today.getFullYear();
		if(dd<10) 
		{
			dd='0'+dd;
		} 

		if(mm<10) 
		{
			mm='0'+mm;
		} 
		
		today = dd+'/'+mm+'/'+yyyy;
		var data = document.getElementsByName("jform[data_criacao]");
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
				
				document.getElementById("jform_previsao_tempo0").checked = true;
				document.getElementById("jform_previsao_tempo1").checked = false;
				document.getElementById("jform_noticias0").checked = true;
                document.getElementById("jform_licitacoes0").checked = true;
				labels = document.getElementsByTagName('label');
				for( var i = 0; i < labels.length; i++ ) {
					if (labels[i].htmlFor == 'jform_previsao_tempo0'){
						labels[i].addClass('active btn-success');
						labels[i+1].removeClass('active btn-danger');
					}
					if (labels[i].htmlFor == 'jform_noticias0'){
						labels[i].addClass('active btn-success');
						labels[i+1].removeClass('active btn-danger');
					}
					if (labels[i].htmlFor == 'jform_licitacoes0'){
						labels[i].addClass('active btn-success');
						labels[i+1].removeClass('active btn-danger');
					}
				}
				for (var i = 0; i < avisom.length; i++) {
					avisom[i].checked = true;
				 }
				 for (var i = 0; i < avisoh.length; i++) {
					avisoh[i].checked = true;
				 }
				 for (var i = 0; i <informem.length; i++) {
					informem[i].checked = true;
				 }
				 for (var i = 0; i < informeh.length; i++) {
					informeh[i].checked = true;
				 }
                console.log(true);
                
            } else {
				document.getElementById("jform_previsao_tempo1").checked = true;
				document.getElementById("jform_noticias1").checked = true;
                document.getElementById("jform_licitacoes1").checked = true;
				labels = document.getElementsByTagName('label');
				for( var i = 0; i < labels.length; i++ ) {
					if (labels[i].htmlFor == 'jform_previsao_tempo1'){
						labels[i].addClass('active btn-danger');
						labels[i-1].removeClass('active btn-success');
					}
					if (labels[i].htmlFor == 'jform_noticias1'){
						labels[i].addClass('active btn-danger');
						labels[i-1].removeClass('active btn-success');
					}
					if (labels[i].htmlFor == 'jform_licitacoes1'){
						labels[i].addClass('active btn-danger');
						labels[i-1].removeClass('active btn-success');
					}
				}
				
				for (var i = 0; i < avisom.length; i++) {
					avisom[i].checked = false;
				 }
				 for (var i = 0; i < avisoh.length; i++) {
					avisoh[i].checked = false;
				 }
				 for (var i = 0; i <informem.length; i++) {
					informem[i].checked = false;
				 }
				 for (var i = 0; i < informeh.length; i++) {
					informeh[i].checked = false;
				 }
                console.log(false);

			}
        }
	</script>