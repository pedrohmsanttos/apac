<?php defined('_JEXEC') or die; ?>
<style>
  .menu-ativo{
    background-color:#003859;
    color:white !important;
  }
  nav > ul{
    margin-left:-10px!important;
  }
</style>
<nav>
  <ul>
    <?php foreach ($menus as $menuItem) : ?>
    	<?php if($menuItem->menutype == 'mainmenu' && ! in_array($menuItem->alias, $blackList)): ?>
        	<li><a <?php if($menuItem->id == $active->id) echo 'class="menu-ativo" ' ?> href="<?php echo $menuItem->link;?>"><?php echo $menuItem->title;?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</nav>
