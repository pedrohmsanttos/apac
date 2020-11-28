<?php defined('_JEXEC') or die; ?>
<script type="text/javascript">
    jQuery.noConflict();
    (function( $ ) {
      $(function() {
            
        var camelize = function(str) 
            {
              return str.replace(/(?:^\w|[A-Z]|\b\w|\s+)/g, function(match, index) {
                if (+match === 0) return ""; // or if (/\s+/.test(match)) for white spaces
                return index == 0 ? match.toLowerCase() : match.toUpperCase();
              });
            }

        var captitalize = function(str,force)
            {
              str=force ? str.toLowerCase() : str;
              return str.replace(/(\b)([a-zA-Z])/,
                       function(firstLetter){
                          return   firstLetter.toUpperCase();
                       });
            }

        var mostraPelaLetra = function(elemento)
            {
                $( "#ordem-alfabetica" ).show();

                if($( "#ordem-alfabetica" ).is(":visible")){
                    $( "#ordem-normal" ).hide();
                }

                $( "#"+elemento.data('letra') ).show();
            }

        var buscar = function(busca)
            {
               if(busca != ''){

                $(".selecionado").css("font-weight", "normal");
                $(".selecionado").removeClass( "selecionado" );

                $( "span:contains('"+busca+"')" ).css( "font-weight", "bold" );
                $( "span:contains('"+busca.toLowerCase()+"')" ).css( "font-weight", "bold" );
                $( "span:contains('"+busca.toUpperCase()+"')" ).css( "font-weight", "bold" );
                $( "span:contains('"+captitalize(busca)+"')" ).css( "font-weight", "bold" );
                $( "span:contains('"+camelize(busca)+"')" ).css( "font-weight", "bold" );

                $( "span:contains('"+busca+"')" ).addClass( "selecionado" );
                $( "span:contains('"+busca.toLowerCase()+"')" ).addClass( "selecionado" );
                $( "span:contains('"+busca.toUpperCase()+"')" ).addClass( "selecionado" );
                $( "span:contains('"+captitalize(busca)+"')" ).addClass( "selecionado" );
                $( "span:contains('"+camelize(busca)+"')" ).addClass( "selecionado" );

                }
            }

            $("form").submit(function(e){
                e.preventDefault();
            });

            $( "#ordem-alfabetica" ).hide();
            $( ".lista-alfabetica" ).hide();

            $( "#botao-busca-prefeitura" ).click(function() {
                    var buscaVal = $( "#input-busca-prefeitura" ).val();
                    buscar(buscaVal);
            });

            $( ".mostra-pela-letra" ).click(function() {
                mostraPelaLetra($(this));
            });
            
            
      });
    })(jQuery);
</script>
    <div class="row">

        <div class="mobile-four seven columns">

            <div id="ordem-normal" class="page-content">

                <?php foreach ($mesorregioes as $mesorregiao) : ?>
                    <?php if(! empty($mesorregiao->prefeituras)) : ?>
                        <article>
                            <header>
                                <h3><?php echo $mesorregiao->title; ?></h3>
                                    <img src="<?php echo json_decode($mesorregiao->params)->image; ?>" alt="" />
                            </header>
                            <div class="block-content">
                                <ul class="lista-cidades">
                                    <?php if(! empty($mesorregiao->prefeituras)): ?>
                                        <?php foreach ($mesorregiao->prefeituras as $prefeitura) :?>
                                            <a href="<?php if(!empty($prefeitura->link)) echo $prefeitura->link; ?>" target="_blank"><li><span><?php echo $prefeitura->nome; ?></span></li></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>

            <div id="ordem-alfabetica" class="page-content">

                <?php foreach ($letras as $letra) :?>
                <?php $cidades = $prefeituraHelper::getPrefeiturasPelaLetraInicial($letra); ?>
                    <article class="lista-alfabetica" id="<?php echo $letra; ?>">
                        <header>
                            <h3><?php echo $letra; ?></h3>
                            <figure>
                                <img src="images/regiao_img.jpg" alt="" />
                            </figure>
                        </header>
                        <div class="block-content">
                            <ul class="lista-cidades">
                                <?php foreach ($cidades as $cidade) : ?>
                                    <li><span><?php echo $cidade->nome; ?></span></li>
                               <?php endforeach; ?>
                            </ul>
                        </div>
                    </article>
                <?php endforeach; ?>
               

            </div>

            
        </div>

        <div class="mobile-four five columns">
            <div class="right-sidebar">

                <div class="sidebar-box">
                    <h3 class="title">Busca por Prefeitura</h3>
                    <div class="content">
                        <form>
                            <div class="field">
                                <label class="custom_select_label">
                                    <select id="mesorregiao" name="mesorregiao" class="custom_select">
                                        <option value="0">Selecione a mesorregião</option>
                                        <?php foreach ($mesorregioes as $mesorregiao) : ?>
                                            <option value="<?php echo $mesorregiao->id; ?>">
                                                <?php echo $mesorregiao->title; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>
                            <div class="field group">
                                <input type="text" id="input-busca-prefeitura" name="prefeitura" placeholder="digite o nome da prefeitura" />
                                <button class="submit" id="botao-busca-prefeitura">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="sidebar-box">
                    <h3 class="title">Por ordem alfabética</h3>
                    <div class="content">
                        <ul class="lista-indice-alfabetico">
                            <li>
                                <a class="mostra-pela-letra" data-letra="a">A</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="b">B</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="c">C</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="d">D</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="e">E</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="f">F</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="g">G</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="h">H</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="i">I</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="j">J</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="k">K</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="l">L</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="m">M</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="n">N</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="o">O</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="p">P</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="q">Q</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="r">R</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="s">S</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="t">T</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="u">U</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="v">V</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="w">W</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="x">X</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="y">Y</a>
                            </li>
                            <li>
                                <a class="mostra-pela-letra" data-letra="z">Z</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>

