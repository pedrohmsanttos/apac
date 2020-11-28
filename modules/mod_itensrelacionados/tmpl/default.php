<?php defined('_JEXEC') or die; ?>
<div class="four columns" id="sidebar-direito" style="float:right">
  <div class="right-sidebar">
    <div class="sidebar-box">
      <h3 class="title"><?php echo $itensRelacionadosCat->title ?></h3>
      <div class="content">
        <ul>

          <?php if($tipo == 1): ?>
            <?php foreach ($itensRelacionados as $itensRelacionado) :?>
              <li>
                <h3>
                  <a title="<?php echo $itensRelacionado->titulo ?>"> <?php echo $itensRelacionado->titulo ?> - <?php echo $itensRelacionado->identificador ?> - <?php echo ModItensRelacionadosHelper::formataData($itensRelacionado->validade) ?></a>
                </h3>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>

          <?php if($tipo == 3): ?>
            <?php foreach ($itensRelacionados as $itensRelacionado) :?>
              <li>
                <h3>
                  <a href="index.php?option=com_content&view=article&id=<?php echo $itensRelacionado->id?>&catid=<?php echo $itensRelacionado->catid?>" title="<?php echo $itensRelacionado->title ?>"> <?php echo $itensRelacionado->title ?> </a>
                </h3>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>

          <?php if($tipo == 5): ?>
            <?php foreach ($itensRelacionados as $itensRelacionado) :?>
              <li>
                <h3>
                  <a href="<?php echo ($itensRelacionado->linkonly) ? $itensRelacionado->link : 'images/media/'.$itensRelacionado->arquivo ?>" title="<?php echo $itensRelacionado->arquivo ?>"> <?php echo $itensRelacionado->titulo ?> </a>
                </h3>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>

        </ul>
      </div>
    </div>

  </div>
</div>
