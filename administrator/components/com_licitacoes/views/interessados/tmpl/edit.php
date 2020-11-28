<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
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
$document->addStyleSheet(JUri::root() . 'media/com_licitacoes/css/form.css');

$document->addScript(JUri::root() . 'administrator/components/com_licitacoes/assets/js/angular.min.js');
$document->addScript(JUri::root() . 'administrator/components/com_licitacoes/assets/js/script.js');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'licitacao.cancel') {
			Joomla.submitform(task, document.getElementById('licitacao-form'));
		}
		else {
			
			if (task != 'licitacao.cancel' && document.formvalidator.isValid(document.id('licitacao-form'))) {
				
				Joomla.submitform(task, document.getElementById('licitacao-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_licitacoes&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="licitacao-form" class="form-validate">

	<div class="form-horizontal"  ng-app="Licitacoes">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_LICITACOES_TITLE_LICITACAO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>
                <?php echo $this->form->renderField('publicado'); ?>
				<?php echo $this->form->renderField('titulo'); ?>
				<?php echo $this->form->renderField('resumo'); ?>
				<?php echo $this->form->renderField('data_licitacao'); ?>
				<?php echo $this->form->renderField('numero_processo'); ?>
				<?php echo $this->form->renderField('ano_processo'); ?>
				<?php echo $this->form->renderField('modalidade'); ?>
				<?php echo $this->form->renderField('numero_modalidade'); ?>
				<?php echo $this->form->renderField('ano_modalidade'); ?>
				<?php echo $this->form->renderField('objeto'); ?>
				<?php echo $this->form->renderField('data_publicacao'); ?>


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
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'generall', JText::_('jkldsglhsdafl', false)); ?>
        <div class="row-fluid" ng-controller="valorescrl" ng-init="init()">
            <div class="span10 form-horizontal">
                <fieldset class="general1">
                    <h2>Consulta de Pessoas Físicas ou Jurídicas</h2>
                    <hr>
                    <div class="row-fluid">
                        <div class="span3">
                            <input ng-model="documento" placeholder="CPF/CNPJ" type="text" class=""  name="documento" id="documento" class="" value="<?php // echo ($this->processo != "" ? $this->processo : ''); ?>" />
                        </div>
                        <div class="span3">
                            <input ng-model="nome" placeholder="Nome/Razão Social" type="text" class=""  name="nome" id="nome" class="" value="<?php // echo ($this->processo != "" ? $this->processo : ''); ?>" />
                        </div>
                        <div class="span3">
                            <select name="tipo" id="tipo" style="width: 100%;" ng-model="tipo">
                                <option value="" <?php echo ($this->tipo == "" ? ' selected="selected"' : ''); ?>>Selecione o Tipo</option>
                                <option value="1" <?php echo ($this->tipo == 1 ? ' selected="selected"' : ''); ?>>Física</option>
                                <option value="2" <?php echo ($this->tipo == 2 ? ' selected="selected"' : ''); ?>>Jurídica</option>
                            </select>
                        </div>
                        <div class="span3">
                            &nbsp;&nbsp;&nbsp;&nbsp;
<!--                            <button id="gerar" class="btn button-new btn-success">-->
<!--                                <span class="icon-new icon-white" aria-hidden="true"></span>-->
<!--                                Gerar Pesquisa-->
<!--                            </button>-->
                            <a ng-click="addNovoValor()" class="btn button-new btn-success">
                                <span class="icon-save-new"></span>
                                Gerar Pesquisa
                            </a>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div>&nbsp;</div>
        <div class="form-horizontal">
            <style type="text/css">
                .tg  {
                    border-collapse:collapse;
                    border-spacing:0;
                    min-width: 700px;
                }
                .tg td{
                    font-family:Arial, sans-serif;
                    font-size:14px;
                    padding:10px;
                    border-style:solid;
                    border-width:1px;
                    overflow:hidden;
                    word-break:normal;
                }
                .tg th{
                    font-family:Arial, sans-serif;
                    font-size:14px;
                    font-weight:normal;
                    padding:10px;
                    border-style:solid;
                    border-width:1px;
                    overflow:hidden;
                    word-break:normal;
                    background: rgb(201, 201, 201)
                }
                .tg .tg-yw4l{vertical-align:top}
                .title  {
                    border-collapse:collapse;
                    border-spacing:0;
                    vertical-align: 8px;
                    background: rgb(20, 162, 200);
                    font-family:Arial, sans-serif;
                    font-size:14px;
                    font-weight:normal;
                    padding:10px 144.5px;
                    border-style:solid;
                    border-width:1px;
                    overflow:hidden;
                    word-break:normal;
                }
            </style>
            <table class="tg">
                <!--                    <tr>-->
                <!--                        <td colspan="2" class="title">DOWNLOAD EDITAL -" </td>-->
                <!--                    </tr>-->
                <tr>
                    <th class="tg-yw4l">Nome/Razão Social</th>
                    <th class="tg-yw4l">Tipo</th>
                    <th class="tg-yw4l">CPF/CNPJ</th>
                    <th class="tg-yw4l">Telefone</th>
                </tr>
                <tr ng-repeat="item in data">
                    <td>{{ item.nome_razao }}</td>
                    <td>tipo</td>
                    <td>{{ item.documento_usuario }}</td>
                    <td>fone</td>
                </tr>
            </table>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
