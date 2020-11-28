<?php defined('_JEXEC') or die; ?>
<?php $testeMob = new Mobile_Detect(); ?>
<?php if(! $testeMob->isMobile()): ?>
	 <div class="row">
	    <div class="mobile-two twelve columns nopadding">
			<?php foreach ($listagemDeCategorias as $categoria): ?>
			        <article class="section">
			            <h3 class="title"><?php echo $categoria->title ?></h3>
			            <div class="section-content">
			                <ul>
								<?php foreach ($categoria->articles as $artigo): ?>
			                    	<li><a target="_blank" href="<?php echo $siteMap::montaLink($artigo->catid,$categoria->alias,$artigo->id,$artigo->alias); ?>" title="">&raquo; <?php echo $artigo->title; ?></a></li>
								<?php endforeach; ?>
			                </ul>
			            </div>
			        </article>
			<?php endforeach; ?>
	    </div>
	</div>
<?php else: ?>
	<style type="text/css">
		 .wrap-sitemap ul li.sitemap-title a {
		font-family: 'Lato',sans-serif;
		font-weight: 900;
		text-transform: uppercase;
		padding-bottom: 10px;
		border-bottom: 1px solid #7a7a7a;
	}

	 .wrap-sitemap ul li.sitemap-title a {
		font-family: 'Lato',sans-serif;
		font-weight: 900;
		text-transform: uppercase;
		padding-bottom: 10px;
		border-bottom: 1px solid #7a7a7a;
	}

	 .wrap-sitemap ul li a {
		position: relative;
		display: block;
		font-family: 'Arial',sans-serif;
		font-weight: 400;
		color: #7a7a7a;
		font-size: 14px;
		line-height: 1;
		text-decoration: none;
		cursor: pointer;
		margin-bottom: 10px;
	}
	</style>


	<div class="wrap-sitemap">
<p>&nbsp;</p>
		<?php foreach ($listagemDeCategorias as $categoria): ?>
		    <ul>
		        <li class="sitemap-title">
		            <a>
		                <?php echo $categoria->title ?>
		            </a>
		        </li>

		           <?php foreach ($categoria->articles as $artigo): ?>
			                    	<li><a target="_blank" href="<?php echo $siteMap::montaLink($artigo->catid,$categoria->alias,$artigo->id,$artigo->alias); ?>" title="">&raquo; <?php echo $artigo->title; ?></a></li>
								<?php endforeach; ?>
		    </ul>
	   <?php endforeach; ?>
	</div>
<?php endif;?>
