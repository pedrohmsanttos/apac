<?php defined('_JEXEC') or die; ?>
<ul class="aux-menu">
	<?php foreach ($menus as &$menuItem) : ?>
		<?php if($menuItem->menutype == 'menuauxiliar'): ?>
    		<li><a href="<?php echo $menuItem->link;?>"><?php echo $menuItem->title;?></a></li>
    	<?php endif; ?>
    <?php endforeach; ?>
</ul>