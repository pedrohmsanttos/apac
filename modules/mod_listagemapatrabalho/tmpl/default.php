<?php defined('_JEXEC') or die; ?>
<div class="row">
    <div class="mobile-four twelve columns">
        <div class="page-content">
            <article>
                <div class="block-content">
                    <ul class="lista-cidades">
                        <?php foreach ($articles as $article): ?>
                            <a href="<?php echo $article->link; ?>">
                                <li><span><?php echo $article->title; ?></span></li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </article>
        </div>
    </div>
</div>