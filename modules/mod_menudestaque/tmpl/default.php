<?php defined('_JEXEC') or die; ?>
<?php foreach ($menus as $menuItem) : ?>
	<?php if($menuItem->menutype == 'menudestaque'): ?>
		<a href="<?php echo $menuItem->link;?>" class="highlight-link">
			<?php echo $menuItem->title;?>
		</a>
    <?php endif; ?>
<?php endforeach; ?>
