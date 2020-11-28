<?php defined('_JEXEC') or die; ?>
<ul class="subject-list">
    <li class="title">Assuntos</li>
    <?php foreach ($menus as $menu) : ?>
		        <li>
						<a href="<?php echo $menu->link;?>">
							<?php echo $menu->title; ?>
						</a>
				</li>
    <?php endforeach;?>
</ul>
