<?php defined('_JEXEC') or die; ?>

<div id="content" class="internal page-governo servicos">
    <div class="page-content">
    	<div class="row">
            <div class="mobile-four twelve columns">
				<header>
				    <span class="icon">
				        <i class="fa fa-exclamation-triangle"></i>
				    </span>
					<?php echo $servicoParams->title_section; ?>
				</header>
				<?php 
					$icone[0] = 'cidadao';
					$icone[1] = 'relacoes_governo';
					$icone[2] = 'company';
					$icone[3] = 'tourism';

					$flag = 0;
				?>
				<?php foreach ($servicos as $servico) : ?>
					<?php if(! empty($servico->itens)): ?>
					<div class="servico-category clearfix">
					    <span class="icon icon-<?php echo $icone[$flag]; ?>"></span>
					    <h2><?php echo $servico->title; ?></h2>
					</div>
					<div class="row">
						<?php foreach ($servico->itens as $item) : ?>
						    <div class="mobile-four six columns">
						        <div class="item-servico">
						            <header>
						                <h2><?php echo $item->titulo; ?></h2>
						            </header>
						            <div class="item-servico-content">
						                <?php echo strip_tags($item->conteudo, '<p><br><br/><strong>'); ?>
						            </div>
						            <footer>
						                <a href="<?php echo $item->link_maisinfo; ?>" title="Acessar">Acessar</a>
						            </footer>
						        </div>
						    </div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
					<?php $flag++; ?>
				<?php endforeach; ?>
  			</div>
        </div>
    </div>
</div>