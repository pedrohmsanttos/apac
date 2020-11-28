<?php defined('_JEXEC') or die;?>
<style>
.post-header,.post-footer{
	display: grid !important;
}
.moduletable > h3:nth-child(1) {
	display: none;
}
.right-sidebar{
margin-top:10%;
}
/* Telefones em paisagem e abaixo */
@media (max-width: 480px) { 
     /* estilos aqui */
 }
 
/* Telefones em paisagem a tablet em retrato */
@media (max-width: 767px) {
     /* estilos aqui */
}
 
/* Tablet em retrato a paisagem e desktop */
@media (min-width: 768px) and (max-width: 979px) {
     /* estilos aqui */
	 .blog-list{
		width: 900px;
	}
}
 
/* Desktop grande */
@media (min-width: 1200px) {
    /* estilos aqui */
	.blog-list{
		width: 900px;
	}
}
</style>
<div class="modulo-noticias  page-content page-governo blog blog-list post post-header">
	<h3 class="title-section"><?php echo $titulo ?></h3>
		<div class="row" style="background-color:white">
				<div class="mobile-four twelve columns">
						<div class="blog-list">
							<?php foreach ($ultimasNoticias as $noticiaAtual) : 
							
								?>
								<!-- intem <?php echo $noticiaAtual->id; ?> -->
								<div class="post row">
										<div class="post-img mobile-four two columns">
												<figure>
														<img src="<?php echo json_decode($noticiaAtual->images)->image_intro; ?>" />
												</figure>
										</div>
										<div class="post-header mobile-four eight columns">
												<small class="categories">
														<a class="strong-brw" href="/index.php?option=com_content&view=category&id=<?php echo $noticiaAtual->catid; ?>">
															<?php echo ModMostraNoticiasHelper::getCategory($noticiaAtual->catid)->alias; ?>
														</a>
												</small>
												<h2>
														<a class="strong-yl" href="/index.php?option=com_content&view=article&id=<?php echo $noticiaAtual->id; ?>&catid=<?php echo $noticiaAtual->catid; ?>" title="<?php echo $noticiaAtual->title; ?>">
																<?php echo $noticiaAtual->title; ?>
														</a>
												</h2>
										</div>
										<div class="post-footer mobile-four two columns">
												<ul class="datetime">
														<li>
																<i class="icon icon-calendar"></i> <?php echo ModMostraNoticiasHelper::preparaData($noticiaAtual->created)[0] ?>
														</li>
														<li>
																<i class="icon icon-time"></i> <?php echo ModMostraNoticiasHelper::preparaData($noticiaAtual->created)[1] ?>min
														</li>
												</ul>
												<div class="addthis_inline_share_toolbox"></div>
										</div>
								</div>
								<!-- intem -->
								<?php $contador++; if(!empty($contagem) && $contador > $contagem) break; ?>
							<?php endforeach; ?>
						</div>
				</div>
		</div>
	</div>
