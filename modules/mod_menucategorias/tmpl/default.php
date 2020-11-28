<?php defined('_JEXEC') or die; ?>
<ul class="subject-list">
    <li class="title">Assuntos</li>
    <?php foreach ($categories as $category) : ?>
		<?php if($category->id == $categoria_noticia || 
				$category->parent_id == $categoria_noticia || empty($categoria_noticia)) : ?>
		        <li>
						<a href="<?php echo $category->link;?>">
							<?php if($category->parent_id != '1') echo ' > ' ?>
							<?php echo $category->title; ?>
						</a>
				</li>
		<?php endif; ?>
    <?php endforeach;?>
</ul>
