<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');


JHtml::_('jquery.framework', false);

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);

?>

<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		jQuery(".icon-enviarEmail").removeClass('icon-enviarEmail');
		jQuery(".icon-gerarPDF").removeClass('icon-gerarPDF');
	});

	Joomla.submitbutton = function (task) {
		if (task == 'avisometeorologicos.enviarEmail' || task == 'avisometeorologicos.gerarPDF') 
		{
			var aux = 0;
			jQuery("input[name='cid[]']").each( function () {
				if(jQuery(this).prop("checked") == true){
					aux++;
				}       
			});

			if(aux > 1){
				alert("Selecione apenas um item!")
			}else{
				Joomla.submitform(task, document.getElementById('adminForm'));
			}

		}else{
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	}
</script>

<div class="row-fluid">
	<div class="span12">
		
		<a href="index.php?option=com_avisometeorologico&view=regioes" >
			<div class="btn-wrapper pull-right" id="toolbar-unpublish" style="margin-left:5px;">
				<button class="btn btn-small button-unpublish">
				<span class="icon-folder-open" aria-hidden="true"></span>
				Regiões</button>
			</div>
		</a>
	
		&nbsp
	</div>
</div>
<form action="index.php?option=com_avisometeorologico&view=Avisometeorologicos" method="post" id="adminForm" name="adminForm">
  <div id="j-sidebar-container" class="span2">
  		<?php echo JHtmlSidebar::render(); ?>
  	</div>
  <div id="j-main-container" class="span10">
	<div class="row-fluid">
		<div class="span12">
			<?php echo JText::_('Filtros'); ?>
			<?php
				echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
			?>
		</div>
	</div>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
      <th width="1%" class="nowrap center hidden-phone">
        <?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
      </th>
			<th width="1%">#</th>
      <th width="2%">
        <?php echo JHtml::_('grid.checkall'); ?>
      </th>
      <th width="5%">
        <?php echo JHtml::_('grid.sort', 'Estado', 'published', $listDirn, $listOrder); ?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Identificador', 'identificador', $listDirn, $listOrder); ?>
			</th>
			<th width="15%">
				<?php echo JHtml::_('grid.sort', 'Titulo', 'titulo', $listDirn, $listOrder); ?>
			</th>
      <th width="10%">
        <?php echo JHtml::_('grid.sort', 'Tipo de Aviso', 'tipo', $listDirn, $listOrder); ?>
      </th>
      <th width="11%">
				<?php echo JHtml::_('grid.sort', 'Regiões', 'regioes', $listDirn, $listOrder); ?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Tags', 'tags', $listDirn, $listOrder); ?>
			</th>
			<th width="13%">
				<?php echo JHtml::_('grid.sort', 'Data inicio', 'inicio', $listDirn, $listOrder); ?>
			</th>
			<th width="13%">
				<?php echo JHtml::_('grid.sort', 'Validade', 'validade', $listDirn, $listOrder); ?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Author', 'tags', $listDirn, $listOrder); ?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Enviado', 'enviado', $listDirn, $listOrder); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
  				<?php foreach ($this->items as $i => $row) :
						/*controle de perfil de usuario*/
						if (in_array($row->tipo, $group_blacklist_array)) {
							    unset($row);
									$row->blacklist = 0;
							} else {
								  $row->blacklist = 1;
							}

  					$link = JRoute::_('index.php?option=com_avisometeorologico&task=avisometeorologico.edit&id=' . $row->rg);
            $ordering  = ($listOrder == 'ordering');
  				?>
					<tr class="row<?php echo $i % 2; ?>">
						<?php if($row->blacklist): ?>
            <td class="order nowrap center hidden-phone">
                  <?php
                      $iconClass = '';
                      if (!$saveOrder) {
                          $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
                      }
                   ?>
               <span class="sortable-handler <?php echo $iconClass ?>">
                   <span class="icon-menu"></span>
               </span>
               <?php if ($saveOrder) : ?>
                 <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
               <?php endif; ?>
            </td>
						<td>
									<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td>
									<?php echo JHtml::_('grid.id', $i, $row->rg); ?>
						</td>
            <td align="center">
              <?php echo JHtml::_('jgrid.published', $row->published, $i, 'avisometeorologicos.', true, 'cb'); ?>
            </td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
								<?php echo $row->identificador; ?>
							</a>
						</td>
            <td>
              <a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
                <?php echo $row->titulo; ?>
              </a>
            </td>
						<td>
							<?php echo $row->category_title; ?>
						</td>
						<td>
							<?php echo $row->regioes; ?>
						</td>
						<td>
							<?php echo $row->tag_title; ?>
						</td>
						<td>
							<?php echo date("d/m/Y H:i", strtotime($row->inicio)); ?>
						</td>
						<td>
							<?php echo date("d/m/Y H:i", strtotime($row->validade)); ?>
						</td>
						<td>
							<?php echo $row->author; ?>
						</td>
						<td style="text-align: center">
							<?php echo (!empty($row->enviado) && trim($row->enviado == "1")) ? "<p class='icon-publish'></p>" : "<p class='icon-unpublish'></p>"; ?>
						</td>
					</tr>
					 <?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>
