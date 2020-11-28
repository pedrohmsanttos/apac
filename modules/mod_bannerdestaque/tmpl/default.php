<?php defined('_JEXEC') or die;?>
<section class="highlights">
	<article class="mobile-four twelve columns big">
		<a href="<?php echo $big_banner_article->link ?>" target="_self" title="<?php echo $big_banner_article->title ?>">
			<div class="wrap-image">
				<img src="<?php echo $big_banner_article->image; ?>" alt="<?php echo $big_banner_article->title; ?>">
			</div>
			<div class="wrap-text">
				<span class="wrap-icon">
					<i class="icon icon-security"></i>
					<p><?php echo $big_banner_article_category->title; ?></p>
				</span>
				<h3><?php echo $big_banner_article->title; ?></h3>
				<p><?php echo $big_banner_article_description; ?></p>
			</div>
		</a>
	</article>
	<?php if($publish_left_banner) : ?>
		<article class="mobile-four six columns">
			<a href="<?php echo $left_banner_article->link; ?>" target="_self" title="<?php echo $left_banner_article->title; ?>">
				<div class="wrap-image">
					<span class="wrap-icon">
						<i class="icon icon-development"></i>
						<p><?php echo $left_banner_article_category->title; ?></p>
					</span>
					<img src="<?php echo $left_banner_article->image; ?>" alt="<?php echo $left_banner_article->title; ?>">
				</div>
				<p><?php echo $left_banner_article->title; ?></p>
			</a>
		</article>
	<?php endif; ?>
	<?php if($publish_right_banner) : ?>
		<article class="mobile-four six columns nomarginR">
			<a href="<?php echo $right_banner_article->link; ?>" target="_self" title="<?php echo $right_banner_article->title; ?>">
				<div class="wrap-image">
					<span class="wrap-icon">
						<i class="icon icon-education"></i>
						<p><?php echo $right_banner_article_category->title; ?></p>
					</span>
					<img src="<?php echo $right_banner_article->image; ?>" alt="<?php echo $right_banner_article->title; ?>">
				</div>
				<p><?php echo $right_banner_article->title; ?></p>
			</a>
		</article>
	<?php endif; ?>
</section>