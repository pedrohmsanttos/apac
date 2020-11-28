<?php defined( '_JEXEC' ) or die; ?>
<?php include_once JPATH_THEMES.'/'.$this->template.'/logic.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
  <meta name="description" content="<?php echo $sitedescription;?>"/>
  <meta name="keywords" content="<?php echo $sitemetakeywords ?>"/>
  <meta property="og:locale" content="pt_BR">
  <meta property="og:url" content="<?php echo $sitebase;?>">
  <meta property="og:title" content="<?php echo $pagetitle;?>">
  <meta property="og:site_name" content="<?php echo $sitename;?>">
  <meta property="og:description" content="<?php echo $sitedescription;?>">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?php echo $sitebase;?>images/imagem-capa-fb.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="800">
  <meta property="og:image:height" content="600">
  <link rel="canonical" href="http://www.pe.gov.br/" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $tpath; ?>/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet">
    <link rel='stylesheet' href='<?php echo $tpath; ?>/fonts/typicons.min.css' />
	<link rel="stylesheet" href="<?php echo $tpath; ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo $tpath; ?>/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo $tpath; ?>/css/selectric.css">
    
    <style type="text/css">
    @font-face {
      font-family: 'typicons';
      src: url("<?php echo $tpath; ?>/fonts/typicons.eot");
      src: url("<?php echo $tpath; ?>/fonts/typicons.eot?#iefix") format('embedded-opentype'),
           url("<?php echo $tpath; ?>/fonts/typicons.woff") format('woff'),
           url("<?php echo $tpath; ?>/fonts/typicons.ttf") format('truetype'),
           url("<?php echo $tpath; ?>/fonts/typicons.svg#typicons") format('svg');
      font-weight: normal;
      font-style: normal;
    }
  </style>
	<!-- Joomla! includes -->
  <jdoc:include type="head" />
</head>
<body style="visibility:hidden" onload="document.getElementsByTagName('body')[0].style.cssText = '';">
    <script src="<?php echo $tpath; ?>/js/vendor/jquery.selectric.min.js"></script>
    <script src="<?php echo $tpath; ?>/js/tabs.js"></script>
    <script src="<?php echo $tpath; ?>/js/scripts.js"></script>
    <script src="<?php echo $tpath; ?>/js/js.cookie.js"></script>
    <script src="<?php echo $tpath; ?>/js/jquery.treegrid.js"></script>
    <script src="<?php echo $tpath; ?>/js/com_relacionado.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" integrity="sha384-vhJnz1OVIdLktyixHY4Uk3OHEwdQqPppqYR8+5mjsauETgLOcEynD9oPHhhz18Nw" crossorigin="anonymous"></script>
    
	<div id="container">
		<?php if($this->params->get('mostrar_barra_governo')): ?>
			<div class="top-bar-govpe">
				<div class="row">
					<div class="mobile-four twelve columns">
						<a class="logo-gov">Governo do estado de Pernambuco | Juntos fazemos mais.</a>
						<nav>
							<ul>
								<li><a href="#">Pernambuco</a></li>
								<li><a href="#">Governo</a></li>
								<li><a href="#">Secretarias</a></li>
								<li><a href="#">Programas</a></li>
								<li><a href="#">Notícias</a></li>
								<li class="highlight"><a href="#">Rádio SEI</a></li>
								<li class="highlight"><a href="#">Expresso Cidadão</a></li>
								<li class="highlight"><a href="#">Acesso à Informação</a></li>
							</ul>
						</nav>
						<div class="wrap-show-top-bar-govpe-menu">
							<a style="visibility:hidden" href="javascript:void(0);" class="show-top-bar-govpe-menu c-hamburger c-hamburger--htx"><span>&#9776;</span></a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<header id="main_header">
			<div class="row">
				<div class="mobile-four twelve columns nopadding">
					<div class="side-menu">
                        <jdoc:include type="modules" name="side-menu" />
					</div>
					<div class="top-menu">
                        <jdoc:include type="modules" name="top-menu" />
					</div>
                    <jdoc:include type="modules" name="logo" />
                    <jdoc:include type="modules" name="aux-menu" />
					<div class="search-bar">
                        <jdoc:include type="modules" name="search-bar" />
					</div>
				</div>
			</div>
        </header>

        <div id="content" class="descubra-pe internal page-governo contato governo-mapa_do_trabalho governo mapa_do_site secretarias servicos orgaos governo-prefeituras governo-governador <?php echo $pageclass ?>">
            <div class="row" style="min-height: 2000px;">
                <div class="mobile-four push-two ten columns">
                <?php if($mostraNavegacao) :?>
                    <?php if($submenu): ?>
                        <style type="text/css">
                            /*.post-header{display: none}
                            .post-footer{display: none}*/
                        </style>
                    <!-- header sem subcategoria -->
                    <header>
                        <h2 id="titulo-pagina" class="page-title"><?php echo $categPai->title; ?></h2>
                            <!-- -->
                            <div class="menu-governo" id="menu-governo">
                                <button type="button" class="btn-governo-menu-toogle">
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <nav class="collapse collapse-menu">
                                    <ul class="nav-interna clearfix">
                                        <?php $arrSubCategsArticles = getArticlesByCategory($categPai->id); ?>
                                        <?php foreach($arrSubCategsArticles as $currCatgArt): ?>
                                                <li <?php if($article->get('id') == $currCatgArt->id) : ?> class="active" <?php endif; ?> >
                                                    <a href="index.php?option=com_content&view=article&id=<?php echo $currCatgArt->id; ?>&catid=<?php echo $currCatgArt->catid; ?>">
                                                        <span><?php echo $currCatgArt->title ?></span>
                                                    </a>
                                                </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </nav>
                            </div>
                            <!-- -->
                        <div class="header-title">
                            <h3 id="subtitulo-pagina"><?php echo $article->get('title'); ?></h3>
                        </div>
                    </header>
                    <?php $imgArtigo = json_decode($article->images)->image_intro; ?>
                    <?php /*if(! empty($imgArtigo)): ?>
                        <div class="header-img">
                            <img src="<?php echo $imgArtigo; ?>" alt="" />
                        </div>
                    <?php endif;*/ ?>
                    <!-- header sem subcategoria fim -->
                    <?php else: ?>
                        <header>
                            <h2 id="titulo-pagina" class="page-title">
                                <?php echo $categoriaSemSubMenu->title; ?>
                            </h2>
                            <div class="menu-governo">
                                <h3 id="subtitulo-pagina" >Últimas Notícias</h3>
                            </div>
                        </header>
                    <?php endif; ?>
                <?php endif; //fim se mostra a navegação ou nao ?>
										<p>&nbsp;</p>
                    <jdoc:include type="modules" name="content-area" />
                    <jdoc:include type="message" />
                    <jdoc:include type="component" />
                    <script type="text/javascript">
                      mensage = document.getElementsByClassName("alert alert-message");
                      if (mensage != null){ mensage[0].className = "alert alert-success";}
                    </script>
                </div>
            </div>
        </div>
        <footer>
            <div class="row">
                <div class="mobile-four push-two ten columns">
                    <jdoc:include type="modules" name="topfooter" />
                    <jdoc:include type="modules" name="footer" />
                </div>
            </div>
        </footer>
 </div><!-- End container -->
</body>
</html>
