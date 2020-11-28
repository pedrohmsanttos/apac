<?php defined('_JEXEC') or die; ?>
<section class="online-services">
	<h3 class="title-section"><?php echo $servicoParams->title_section;?></h3>
	<?php if ($detectMob->isMobile()) : ?>
		<div class="accordion">
			<ul>

			<?php foreach ($servicos as $servico) : ?>
				<li class="accordion-item">
					<a href="#servico_<?php echo $servico->id ?>">
						<span class="wrap-icon">
							<i class="icon icon-citizen"></i>
							<p><?php echo $servico->title ?></p>
						</span>
					</a>
					<div id="servico_<?php echo $servico->id ?>" class="accordion-content">
						<ul>
							<?php foreach ($servico->itens as $item) : ?>
								<li>
									<a target="_blank"  href="<?php echo $item->link_maisinfo; ?>">
										<?php echo $item->titulo; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</li>
			<?php endforeach; ?>

			</ul>
		</div>
	<?php else: ?>
		<div id="tabs" class="c-tabs no-js">
			<div class="c-tabs-nav">

				<?php $primeiroItem = true; ?>
				<?php $icone[0] = 'citizen';
					  $icone[1] = 'gov-relations';
					  $icone[2] = 'company';
					  $icone[3] = 'tourism';

					  $flag = 0;
				?>
					<?php foreach ($servicos as $servico) : ?>
						<a href="#" class="c-tabs-nav__link <?php if($primeiroItem) echo 'is-active'; ?>">
							<span class="wrap-icon">
								<i class="icon"><img src="<?php echo json_decode($servico->params)->image;?>" /></i>
								<p><?php echo $servico->title ?></p>
							</span>
						</a>
					<?php $primeiroItem = false; ?>
					<?php $flag++; ?>
				<?php endforeach; ?>
			</div>

			<?php $primeiroItem = true; ?>
			<?php foreach ($servicos as $servico) : ?>
				<div class="c-tab <?php if($primeiroItem) echo 'is-active'; ?>">
					<div class="c-tab__content">
						<ul>
							<?php foreach ($servico->itens as $item) : ?>
								<li>
									<a target="_blank" href="<?php echo $item->link_maisinfo; ?>">
										<?php echo $item->titulo; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<?php $primeiroItem = false; ?>
			<?php endforeach; ?>


		</div>
	<?php endif; ?>
</section>
