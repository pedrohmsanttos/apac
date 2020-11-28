
<?php defined('_JEXEC') or die; ?>
<div id="content" class="internal page-governo imprensa">
    <div class="page-content">
        <div class="row">
            <div class="mobile-four  twelve columns">

                <!-- descrição pagina -->
                <header class="no-border">
                    <span class="icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </span>
                    <?php echo $params->get('descricao'); ?>
                </header>

                <div id="tabs_agenda" class="c-tabs no-js">

                    <!-- abas -->
                    <ul class="c-tabs-nav">
                        <li class="c-tabs_agenda-nav__link is-active">
                            <a href="" title="">Próximos eventos</a>
                        </li>
                        <li class="c-tabs_agenda-nav__link">
                            <a href="" title="">Passados</a>
                        </li>
                    </ul>

                    <!-- eventos futuros -->
                    <div class="c-tab_agenda is-active">
                        <div class="c-tab__content">
                            <ul class="list-agenda">
                                <?php
                                    $redirectUrl = $_SERVER['REDIRECT_URL'].'?page=';
                                    //paginação
                                    $paginaAtual   = JFactory::getApplication()->input->get('page',1, 'int');
                                    $paginaAnterior = $paginaAtual - 1;
                                    $paginaProxima = $paginaAtual + 1;
                                    if($paginaAnterior <= 0) $paginaAnterior = 1;

                                    //paginacao($yourDataArray,$page,$limit)
                                    $vetorPaginado = $agendaHelper::paginacao($eventosFuturos,$paginaAtual,3)->vetor;
                                    $totalPagina   = $agendaHelper::paginacao($eventosFuturos,$paginaAtual,3)->total_paginas;

                                 ?>
                                <?php foreach ($vetorPaginado as $eventoFuturo => $row): ?>
                                    <?php $data = $agendaHelper::formataData($row->data)?>
                                    <li class="list-agenda__item" <?php if($data[0] == $flagData){ echo 'style="margin-top: 0px !important"'; } ?>>
                                    <?php if ($data[0] != $flagData): ?>
                                        <header>
                                            <h2><?php echo $data[0]; ?></h2>
                                            <h3><?php echo $data[1]; ?></h3>
                                        </header>
                                    <?php else: ?>
                                        <header style="visibility: hidden; ">
                                            <h2><?php echo $data[0]; ?></h2>
                                            <h3><?php echo $data[1]; ?></h3>
                                        </header>
                                    <?php endif; ?>

                                        <!-- aba de artigos de datas que irão passar -->
                                        <div class="list-agenda__item__content">
                                            <article>
                                                <h2>
                                                    <a href="" title="" class="btn-agenda">
                                                        <?php echo $row->titulo; ?>
                                                    </a>
                                                </h2>
                                                <div class="resumo">
                                                    <h3>
                                                        <strong>Horário:</strong>
                                                        <?php echo $data[2]; ?> -
                                                        <a href="" title="" class="btn-agenda">Mais informações</a>
                                                    </h3>
                                                </div>
                                                <div class="detail">
                                                    <!-- aqui fica o link para a pagina interna do evento. -->
                                                    <small class="tags">TAGS:
                                                    <a href="<?php echo JRoute::_('index.php?view=article&id='.$row->link_noticia.'&catid='.$row->catid); ?>" title="">Governo de pernambuco</a></small>

                                                    <div class="addthis_inline_share_toolbox"></div>

                                                    <div id="fb-root"></div>
                                                            <script>
                                                                (function(d, s, id) {
                                                                var js, fjs = d.getElementsByTagName(s)[0];
                                                                if (d.getElementById(id)) return;
                                                                js = d.createElement(s); js.id = id;
                                                                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
                                                                fjs.parentNode.insertBefore(js, fjs);
                                                                }(document, 'script', 'facebook-jssdk'));
                                                            </script>

                                                            <script src="https://apis.google.com/js/platform.js" async defer>
                                                             {lang: 'pt-BR'}
                                                            </script>

                                                            <script>
                                                                window.twttr = (function(d, s, id) {
                                                                    var js, fjs = d.getElementsByTagName(s)[0],
                                                                    t = window.twttr || {};
                                                                    if (d.getElementById(id)) return t;
                                                                    js = d.createElement(s);
                                                                    js.id = id;
                                                                    js.src = "https://platform.twitter.com/widgets.js";
                                                                    fjs.parentNode.insertBefore(js, fjs);

                                                                    t._e = [];
                                                                    t.ready = function(f) {
                                                                        t._e.push(f);
                                                                    };

                                                                    return t;
                                                                }(document, "script", "twitter-wjs"));
                                                            </script>

                                                            <div class="row">
                                                                <div class="mobile-four six columns">
                                                                    <div class="fb-like"
                                                                    data-href="<?php echo $_SERVER['REQUEST_URI']; ?>"
                                                                    data-layout="standard"
                                                                    data-action="like"
                                                                    data-show-faces="true">
                                                                    </div>
                                                                </div>
                                                                <div class="mobile-four three columns nomargin">
                                                                   <div class="fb-share-button"
                                                                    data-href="<?php echo $_SERVER['REQUEST_URI']; ?>"
                                                                    data-layout="button_count">
                                                                   </div>
                                                                </div>
                                                                <div class="mobile-four two columns nomargin">
                                                                    <div class="g-plus" data-action="share" data-height="24" data-href=""></div>
                                                                </div>
                                                            </div>

                                                    <p> <?php echo $row->descricao; ?></p>

                                                    <p><strong>Local:</strong> -
                                                        <?php echo $row->local; ?>
                                                    </p>
                                                </div>
                                            </article>
                                        </div>
                                    </li>
                                    <?php $flagData = $data[0]; ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>

                    <!-- eventos passados -->
                    <div class="c-tab_agenda">
                        <div class="c-tab__content">
                            <ul class="list-agenda">
                                <?php $vetorPaginadoPassados = $agendaHelper::paginacao($eventosPassados,$paginaAtual,3)->vetor; ?>
                                <?php foreach ($vetorPaginadoPassados as $eventoPassado => $row): ?>
                                    <?php $data = $agendaHelper::formataData($row->data)?>
                                    <li class="list-agenda__item" <?php if($data[0] == $flagData){ echo 'style="margin-top: 0px !important"'; } ?>>
                                        <?php if ($data[0] != $flagData): ?>
                                            <header>
                                                <h2><?php echo $data[0]; ?></h2>
                                                <h3><?php echo $data[1]; ?></h3>
                                            </header>
                                        <?php else: ?>
                                            <header style="visibility: hidden;">
                                                <h2><?php echo $data[0]; ?></h2>
                                                <h3><?php echo $data[1]; ?></h3>
                                            </header>
                                        <?php endif; ?>
                                            <!-- aba de artigos de datas que irão passar -->
                                            <div class="list-agenda__item__content">
                                                <article>
                                                    <h2>
                                                        <a href="" title="" class="btn-agenda">
                                                            <?php echo $row->titulo; ?>
                                                        </a>
                                                    </h2>
                                                    <div class="resumo">
                                                        <h3>
                                                            <strong>Horário:</strong> <?php echo $data[2]; ?> - <a href="" title="" class="btn-agenda">Mais informações</a>
                                                        </h3>
                                                    </div>
                                                    <div class="detail">
                                                        <!-- aqui fica o link para a pagina interna do evento. -->
                                                        <small class="tags">TAGS: <a href="<?php echo JRoute::_('index.php?view=article&id='.$row->link_noticia.'&catid='.$row->catid); ?>" title="">Governo de pernambuco</a></small>

                                                        <div class="addthis_inline_share_toolbox"></div>

                                                        <div id="fb-root"></div>
                                                            <script>
                                                                (function(d, s, id) {
                                                                var js, fjs = d.getElementsByTagName(s)[0];
                                                                if (d.getElementById(id)) return;
                                                                js = d.createElement(s); js.id = id;
                                                                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
                                                                fjs.parentNode.insertBefore(js, fjs);
                                                                }(document, 'script', 'facebook-jssdk'));
                                                            </script>

                                                            <script src="https://apis.google.com/js/platform.js" async defer>
                                                             {lang: 'pt-BR'}
                                                            </script>

                                                            <script>
                                                                window.twttr = (function(d, s, id) {
                                                                    var js, fjs = d.getElementsByTagName(s)[0],
                                                                    t = window.twttr || {};
                                                                    if (d.getElementById(id)) return t;
                                                                    js = d.createElement(s);
                                                                    js.id = id;
                                                                    js.src = "https://platform.twitter.com/widgets.js";
                                                                    fjs.parentNode.insertBefore(js, fjs);

                                                                    t._e = [];
                                                                    t.ready = function(f) {
                                                                        t._e.push(f);
                                                                    };

                                                                    return t;
                                                                }(document, "script", "twitter-wjs"));
                                                            </script>

                                                            <div class="row">
                                                                <div class="mobile-four six columns">
                                                                    <div class="fb-like"
                                                                    data-href="<?php echo $_SERVER['REQUEST_URI']; ?>"
                                                                    data-layout="standard"
                                                                    data-action="like"
                                                                    data-show-faces="true">
                                                                    </div>
                                                                </div>
                                                                <div class="mobile-four three columns nomargin">
                                                                   <div class="fb-share-button"
                                                                    data-href="<?php echo $_SERVER['REQUEST_URI']; ?>"
                                                                    data-layout="button_count">
                                                                   </div>
                                                                </div>
                                                                <div class="mobile-four two columns nomargin">
                                                                    <div class="g-plus" data-action="share" data-height="24" data-href=""></div>
                                                                </div>
                                                            </div>

                                                        <p> <?php echo $row->descricao; ?></p>

                                                        <p><strong>Local:</strong> - <?php echo $row->local; ?></p>
                                                    </div>
                                                </article>
                                            </div>
                                    </li>
                                    <?php $flagData = $data[0]; ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- paginacao -->
            <div class="row">

                <div class="mobile-four twelve columns">

                    <div class="pagination">
                        <?php if($paginaAtual > 1): ?>
                            <a href="<?php echo $redirectUrl.$paginaAnterior; ?>" title="" class="btn btn-prev"><span>Anterior</span></a>
                        <?php endif; ?>

                            <?php for ($i=1; $i <= $totalPagina; $i++): ?>
                                <?php if($i != $paginaAtual): ?>
                                    <a href="<?php echo $redirectUrl.$i; ?>" class="item-pagination" title="<?php echo $i ?>"><?php echo $i ?></a>
                                <?php else: ?>
                                    <span class="current"><?php echo $i ?></span>
                                <?php endif; ?>
                            <?php endfor; ?>

                        <?php if($paginaAtual != $totalPagina): ?>
                            <a href="<?php echo $redirectUrl.$paginaProxima; ?>" title="" class="btn btn-next"><span>Próximo</span></a>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        <!-- paginacao -->




            </div>
        </div>
    </div>
</div>
