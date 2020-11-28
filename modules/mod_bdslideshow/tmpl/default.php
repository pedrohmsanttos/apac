<?php defined('_JEXEC') or die;?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
	<?php if(! $detectMob->isMobile()): ?>
			.unslider-arrow{
				margin-top: -25%;
			}
			.wrap-image > img{
				max-width: 300px;
			}
		<?php else: ?>
		/* Mobile */
			.wrap-image > img{
				max-width: 300px;
			}
			.unslider-arrow{
				margin-top: -35%;

			}
			.unslider-arrow > i {
				font-size: 65px !important;
			}
			#container #content .home .highlights article.big .wrap-text {
					padding: 115px 0 85px 45px !important;
			}
			ul.datetime{
				margin-top: 3%;
			}
	<?php endif; ?>
</style>

<div id="content">
	<div class="row">
		<div class="mobile-four twelves columns">
			<div class="home">

<section class="highlights" id="slideshow">
	<?php if(count($bigBanner->artigos) > 0): ?>
	<div class="banner-unslider">
	    <ul>
			<?php foreach($bigBanner->artigos as $artigo): ?>
				<li>
					<article class="mobile-four twelve columns big banner-article">
						<a target="_blank" href="<?php echo modBannerDestaqueSlideshowHelper::getLink($artigo->id,modBannerDestaqueSlideshowHelper::getCategory($artigo->catid)->alias);?>" target="_self" title="<?php echo $artigo->title ?>">
							<div class="row">
								<div class="wrap-image mobile-twelves four columns">
									<img src="<?php echo json_decode($artigo->images)->image_intro;?>" alt="<?php echo $artigo->title; ?>">
								</div>
									
								<div class="wrap-text mobile-twelves four columns">
									<span class="wrap-icon">
										<i class="icon icon-education"></i>
										<p><?php echo modBannerDestaqueSlideshowHelper::getCategory($artigo->catid)->title; ?></p>
									</span>
									<h3><?php echo $artigo->title; ?></h3>
									<p><?php echo substr(strip_tags($artigo->metadesc), 0, 147);?></p>
								</div>
							</div>
						</a>
					</article>
				</li>
			<?php endforeach?>
		</ul>
	</div>
	<?php endif; ?>
	<?php if($publish_left_banner) : ?>
		<article class="mobile-four six columns">
			<a target="_blank" href="<?php echo $left_banner_article->link; ?>" target="_self" title="<?php echo $left_banner_article->title; ?>">
				<?php if(! empty($left_banner_article->image)) : ?>
					<div class="wrap-image">
						<span class="wrap-icon">
							<i class="icon icon-education"></i>
							<p><?php echo $left_banner_article_category->title; ?></p>
						</span>
						<img src="<?php echo $left_banner_article->image; ?>" alt="<?php echo $left_banner_article->title; ?>">
					</div>
				<?php endif; ?>
				<p><?php echo $left_banner_article->title; ?></p>
			</a>
		</article>
	<?php endif; ?>

	<?php if($publish_right_banner) : ?>
		<article class="mobile-four six columns nomarginR">
			<a target="_blank" href="<?php echo $right_banner_article->link; ?>" target="_self" title="<?php echo $right_banner_article->title; ?>">

				<?php if(! empty($right_banner_article->image)) : ?>
					<div class="wrap-image">
						<span class="wrap-icon">
							<i class="icon icon-education"></i>
							<p><?php echo $right_banner_article_category->title; ?></p>
						</span>
						<img src="<?php echo $right_banner_article->image; ?>" alt="<?php echo $right_banner_article->title; ?>">
					</div>
				<?php endif; ?>
				<p><?php echo $right_banner_article->title; ?></p>
			</a>
		</article>
	<?php endif; ?>
</section>
</div>
</div>
</div>
</div>