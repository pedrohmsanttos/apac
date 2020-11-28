<?php defined('_JEXEC') or die; ?>
<section class="happen">
    <h3 class="title-section">
        <?php 
            if(isset($titulo)){
                echo($titulo);
            }
            else{
                echo("Acontece em<br><span>Pernambuco</span>");
            }
        ?>    
    </h3>
    <article class="mobile-four six columns">
        <a href="<?php echo $acontece->link_1; ?>" target="_self" 
            title="<?php echo $acontece->titulo_1; ?>">
            <div class="wrap-image">
                <span class="wrap-icon">
                    <!-- <i class="icon icon-job"></i> -->
                    <i class="icon" style="background:url('<?php echo $acontece->categoria_1_imagem ;?>') no-repeat center;border-radius:0% !important; background-size: cover">
                    </i>
                    <p><?php echo limitaString($acontece->categoria_1_titulo,87); ?></p>
                </span>
                <img src="<?php echo $acontece->media_1; ?>" alt="<?php echo $acontece->titulo_1; ?>">
            </div>
            <p><?php echo limitaString($acontece->titulo_1,87); ?></p>
        </a>
    </article>
    <article class="mobile-four six columns nomarginR">
        <div class="wrap-image">
<!--
                <?php //if(ModAconteceHelper::isVideo($acontece->media_2)): ?>
                    <span class="wrap-icon wrap-video">
                        <i class="icon icon-video"></i>
                    </span>
                    <video controls>
                        <source src="<?php //echo JURI::base().'images/'.$acontece->media_2; ?>" 
                            type="video/mp4">
                            Não foi possível carregar o video.
                    </video> 
-->
                <?php //else: ?>
                    <a href="<?php echo $acontece->link_2; ?>" target="_self" title="<?php echo $acontece->titulo_2; ?>">
                        <span class="wrap-icon">

                        <!-- <i class="icon icon-job"></i> -->
                        <i class="icon" style="background:url('<?php echo $acontece->categoria_2_imagem ;?>') no-repeat center;border-radius:0% !important; background-size: cover"></i>

                            <p><?php echo limitaString($acontece->categoria_2_titulo,87); ?></p>
                        </span>
                        <img src="<?php echo $acontece->media_2; ?>" alt="<?php echo $acontece->titulo_2; ?>">
                    </a>
                <?php //endif; ?>
        </div>
        <a href="<?php echo $acontece->link_2; ?>" target="_self" title="<?php echo $acontece->titulo_2; ?>">
            <p><?php echo limitaString($acontece->titulo_2,87); ?></p>
        </a>
        <?php /* se a quantidade de caracteres passar de 90, limitar para esse número ou para 87 e adicionar reticências */ ?>
    </article>
    <article class="mobile-four six columns">
        <a href="<?php echo $acontece->link_3; ?>" target="_self" 
            title="<?php echo $acontece->titulo_3; ?>">
            <div class="wrap-image">
                <span class="wrap-icon">
                    <!-- <i class="icon icon-job"></i> -->
                    <i class="icon" style="background:url('<?php echo $acontece->categoria_3_imagem ;?>') no-repeat center;border-radius:0% !important; background-size: cover"></i>
                    <p><?php echo limitaString($acontece->categoria_3_titulo,87); ?></p>
                </span>
                <img src="<?php echo $acontece->media_3; ?>" alt="<?php echo $acontece->titulo_3; ?>">
            </div>
            <p><?php echo limitaString($acontece->titulo_3,87); ?></p>
        </a>
    </article>
    <article class="mobile-four six columns nomarginR">
       <a href="<?php echo $acontece->link_4; ?>" target="_self" 
            title="<?php echo $acontece->titulo_4; ?>">
            <div class="wrap-image">
                <span class="wrap-icon">
                    <!-- <i class="icon icon-job"></i> -->
                    <i class="icon" style="background:url('<?php echo $acontece->categoria_4_imagem ;?>') no-repeat center;border-radius:0% !important; background-size: cover"></i>
                    <p><?php echo limitaString($acontece->categoria_4_titulo,87); ?></p>
                </span>
                <img src="<?php echo $acontece->media_4; ?>" alt="<?php echo $acontece->titulo_4; ?>">
            </div>
            <p><?php echo limitaString($acontece->titulo_4,87); ?></p>
        </a>
    </article>
    
    <?php $contador=1; ?>
    <?php foreach ($ultimasNoticias as $ultimaNoticia): ?>
       <article class="mobile-four six columns <?php if($contador % 2 == 0) echo "nomarginR"; ?>">
            <a href="<?php echo $aconteceHelper::montaLink($ultimaNoticia->id,$ultimaNoticia->alias,$ultimaNoticia->catid); ?>" target="_self" title="<?php echo $ultimaNoticia->title ?>">               
                <p><?php echo $ultimaNoticia->title ?></p>
            </a>
        </article>
        <?php $contador++; ?>
        <?php if($contador > $boxMax) break; ?>
    <?php endforeach; ?>

</section> 