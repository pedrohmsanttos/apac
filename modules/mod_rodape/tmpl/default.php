<?php defined('_JEXEC') or die; ?>
<div class="wrap-sitemap">
    <ul>
        <li class="sitemap-title">
            <a href="<?php echo JUri::base().$categ1->alias ?>">
                <?php echo $categ1->title ?>
            </a>
        </li>
            
            <?php foreach($categ1->getArticles as $article): ?>
                <li><a href="<?php echo montaLink($categ1->id,$categ1->alias,$article->id,$article->alias); ?>">&raquo; <?php echo $article->title;?></a></li>
            <?php endforeach; ?>
    </ul>
    <ul>
        <li class="sitemap-title">
            <a href="<?php echo JUri::base().$categ2->alias ?>">
                <?php echo $categ2->title ?>
            </a>
        </li>
           
            <?php foreach($categ2->getArticles as $article): ?>
                <li><a href="<?php echo montaLink($categ2->id,$categ2->alias,$article->id,$article->alias); ?>">&raquo; <?php echo $article->title;?></a></li>
            <?php endforeach; ?>
    </ul>
    <ul>
        <li class="sitemap-title">
            <a href="<?php echo JUri::base().$categ3->alias ?>">
                <?php echo $categ3->title ?>
            </a>
        </li>
          
            <?php foreach($categ3->getArticles as $article): ?>
                <li><a href="<?php echo montaLink($categ3->id,$categ3->alias,$article->id,$article->alias); ?>">&raquo; <?php echo $article->title;?></a></li>
            <?php endforeach; ?>
    </ul>
    
    <ul class="nomargin">
       <li class="sitemap-title">
            <a href="<?php echo JUri::base().$categ4->alias ?>">
                <?php echo $categ4->title ?>
            </a>
        </li>
        
        <li class="sitemap-title">
            <a href="<?php echo JUri::base().$categ5->alias ?>">
                <?php echo $categ5->title ?>
            </a>
        </li>
        
        <li class="sitemap-title">
            <a href="<?php echo JUri::base().$categ6->alias ?>">
                <?php echo $categ6->title ?>
            </a>
        </li>
    </ul>
</div>
<?php echo $html_endr; ?>
