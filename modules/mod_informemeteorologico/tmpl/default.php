<?php
defined('_JEXEC') or die;
?>
 <?php
   foreach ($arrItensinformes as $informe):
 ?>
    <div class="sidebar-box">
        <h3 class="title"><?php echo($informe->titulo); ?></h3>
        <div class="content">
            <table class="tree table table-bordered table-condensed">
            <tbody>
            <?php 
                foreach($informe->itens as $item):
            ?>
                <!-- Mol -->
                <?php if($item->level_parent == 0) : ?>
                <?php if($item->level_id == 0) $item->level_id =1; ?>
                <tr class="expanded treegrid-<?php echo $item->level_id?> ">
                <?php else : ?>
                <tr class="expanded treegrid-<?php echo $item->level_id?> treegrid-parent-<?php echo $item->level_parent?>">
                <?php endif; ?>
                    <td>
                        <?php 
                            $currUrl = 'uploads/'.$item->arquivo;
                            $href = 'href="'.$currUrl.'"';
                            $item->print = false;
                        ?>
                        <a <?php echo $href ?>  style="word-break: break-word;"><span class="typcn typcn-folder"></span> <?php echo $item->titulo; ?></a>
                    </td>
                    </tr>
                <?php
                endforeach;
                ?>

                </tbody>
            </table>
            <div style="text-align: center;">
                <p>
                    <a href="component/buscavancada/">Anteriores (Busca avançada)</a>
                </p>
            </div>
        </div>
    </div>
<?php 
 endforeach;  
?>
