<?php defined('_JEXEC') or die; ?>

<div id="content" class="internal page-governo telefones-uteis">

<div class="page-content">
    <div class="row">
        <div class="mobile-four twelve columns">
            <header>
                <span class="icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </span>
                <?php echo $params->get('descricao'); ?>
            </header>
            <?php foreach ($categorias as $categoria): ?>
	            <div class="telefones-uteis-category clearfix">
	                <h2><?php echo $categoria->title ?></h2>
	            </div>
				<?php $telefones = $telefoneHelper::getPublishedItems($categoria->id); 
						$flagClasse = 1;
				?>
	            <div class="row">
		            <?php foreach ($telefones as $telefone): ?>
		              	<div class="six columns">
		                    <div class="item-telefone <?php if($flagClasse % 3 == 0 ){ echo '';} else { echo 'dark'; } $flagClasse++;?> ">
		                        <div class="row">
		                            <div class="seven columns">
		                                <h2><?php echo $telefone->descricao; ?></h2>
		                            </div>
		                            <div class="five columns">
		                                <h3><?php echo $telefone->numero; ?></h3>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            <?php endforeach ?>
	            </div>
	        <?php endforeach ?>
        </div>
    </div>
</div>
</div>