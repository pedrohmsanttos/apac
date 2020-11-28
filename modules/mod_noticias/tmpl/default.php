<?php defined('_JEXEC') or die; ?>
<script type="text/javascript">
   document.getElementById("content").classList.add("blog");
</script>
<style type="text/css">

    .page-governo.blog.blog-interna .post .post-header h2{
        font-size: 16px;
    }

    .blog-featured{
        display: none;
    }

</style>
<div class="page-content">

    <div class="row">

        <div class="mobile-four ten columns">
            <div id="blog-list" class="blog-list">
                <?php foreach ($noticias as $noticia) : ?>
                    <div class="post row">
                        <div class="post-img mobile-four two columns">
                            <img src="<?php echo json_decode($noticia->images)->image_intro ?>" alt="" />
                        </div>
                        <div class="post-header mobile-four eight columns">

                            <small class="categories">
                                <a href="<?php echo getCategoryById($noticia->catid)->link; ?>" title="<?php echo getCategoryById($noticia->catid)->title; ?>"><?php echo getCategoryById($noticia->catid)->title; ?></a>
                            </small>

                            <h2>
                                <a href="<?php echo getLink($noticia); ?>" title="">
                                    <?php echo limitaString($noticia->title,117); ?>
                                </a>
                            </h2>

                            <p>
                                <a href="<?php echo getLink($noticia); ?>" title="">
                                    <?php echo limitaString($noticia->introtext,194); ?>
                                </a>
                            </p>

                            <small style="visibility: hidden;" class="tags">TAGS: <a href="./blog-interna.php" title="">Fernando de noronha</a><a href="./blog-interna.php" title="">governo de pernambuco</a></small>

                        </div>
                        <div class="post-footer mobile-four two columns">
                            <ul class="datetime">
                                <li>
                                    <i class="icon icon-calendar"></i> <?php echo str2dataArray($noticia->created)[0]; ?>
                                </li>
                                <li>
                                    <i class="icon icon-time"></i> <?php echo str2dataArray($noticia->created)[1]; ?>
                                </li>
                            </ul>
                            <div class="addthis_inline_share_toolbox"></div>
                        </div>
                    </div>
               <?php endforeach; ?>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="mobile-four push-two ten columns">

            <div class="pagination">
                <a href="" title="" class="btn btn-prev"><span>Anterior</span></a>
                <a href="" class="item-pagination" title="1">1</a>
                <span class="current">2</span>
                <a href="" class="item-pagination" title="3">3</a>
                <a href="" class="item-pagination" title="4">4</a>
                <a href="" class="item-pagination" title="5">5</a>
                <a href="" class="item-pagination" title="6">6</a>
                <a href="" class="item-pagination" title="7">7</a>
                <a href="" title="" class="btn btn-next"><span>Próximo</span></a>
            </div>

        </div>

    </div>

</div>