<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="page-content">

<input type="hidden" id="filtro" value="<?php echo $filtro; ?>">
<input type="hidden" id="ordem" value="<?php echo $ordem; ?>">
<input type="hidden" id="tipo" value="<?php echo $tipo; ?>">

    <div class="row">

        <div class="mobile-four eight columns">

			<?php if( empty($resultadoBusca) && empty($resultadoBuscaArq) && empty($resultadoBuscaAgenda)) : ?>
				<header>
		            <span class="icon">
              <i class="fa fa-exclamation-triangle"></i>
          </span>
          Nenhum resultado foi encontrado. Deseja realizar uma nova busca?
        </header>
			<?php endif; ?>

            <form class="search-form">
                <div class="field">
                    <input type="text" id="busca" name="busca" placeholder="buscar no portal" />
                    <button id="botao_busca" class="btn-search"><i class="fa fa-search"></i></button>
                </div>
            </form>

            <div class="resultado-list">
                <?php foreach ($resultadoBusca as $resultadoBuscaAtual) : ?>
  	                <article class="resultado-item">
  	                    <h2>
                               <a href="<?php echo getLink($resultadoBuscaAtual); ?>" title="">
  	                            <?php echo $resultadoBuscaAtual->title; ?>
  	                        </a>
  	                    </h2>

  	                    <small class="data">publicado em <?php echo str2data($resultadoBuscaAtual->created); ?> - última atualização em <?php echo str2data($resultadoBuscaAtual->modified); ?></small>
  	                    <small class="category">CATEGORIA: <a href=""><?php echo getCategoryById($resultadoBuscaAtual->catid)->title ?></a></small>
  	                </article>
				        <?php endforeach; ?>
                <?php if(!empty($resultadoBuscaArq)): ?>
                    <?php foreach ($resultadoBuscaArq as $resultadoBuscaAtualArq) : ?>
                      <article class="resultado-item">
                          <h2>
                                 <a href="images/media/<?php echo $resultadoBuscaAtualArq->arquivo; ?>" title="">
                                  <?php echo $resultadoBuscaAtualArq->titulo; ?>
                              </a>
                          </h2>

                          <small class="data"></small>
                          <small class="category">CATEGORIA: <a><?php echo getCategoryById($resultadoBuscaAtualArq->catid)->title ?></a></small>
                      </article>
                  <?php endforeach; ?>
                <?php endif; ?>
                 <?php if(!empty($resultadoBuscaAgenda)): ?>
                    <?php foreach ($resultadoBuscaAgenda as $resultadoBuscaAtualAgenda) : ?>
                      <article class="resultado-item">
                          <h2>
                                 <a href="/imprensa" title="">
                                  <?php echo $resultadoBuscaAtualAgenda->titulo; ?>
                              </a>
                          </h2>

                          <small class="data"><?php echo str2data($resultadoBuscaAtualAgenda->data); ?></small>
                          <small><?php echo $resultadoBuscaAtualAgenda->local; ?></small>
                          <small class="category">CATEGORIA: <a><?php echo getCategoryById($resultadoBuscaAtualAgenda->catid)->title ?></a></small>
                      </article>
                  <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="three push-one columns">
            <div class="right-sidebar">

                <div class="sidebar-box">
                    <h2><?php echo $qtdResults; ?> itens atendem ao seu critério.</h2>
                    <h3 class="title">Filtrar os resultados</h3>
                </div>
                <div class="sidebar-box">
                            <h3 class="title text-uppercase">Tipo de item</h3>
                            <div class="content">
                                <ul>
                                    <li id="select_all">
                                        <input id="todos" type="checkbox">
                                        <label for="todos">Selecionar Todos/Nenhum</label>
                                    </li>
                                    <li>
                                        <input class="marca" id="agenda_diaria" type="checkbox" value="agenda_diaria">
                                        <label for="agenda_diaria">Agenda Diária</label>
                                    </li>
                                    <li>
                                        <input class="marca" id="audio" type="checkbox" value="audio">
                                        <label for="audio">Audio/Video</label>
                                    </li>
                                    <li>
                                        <input class="marca" id="pagina" type="checkbox" value="pagina">
                                        <label for="pagina">Página</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                <div class="sidebar-box">
                    <h3 class="title text-uppercase">Notícias desde</h3>
                    <div class="content">
                        <ul>
                            <li>
                                <input value="ontem" type="checkbox" id="ontem" />
                                <label for="ontem">Ontem</label>
                            </li>
                            <li>
                                <input value="ultimas_semanas" type="checkbox" id="ultimas_semanas" />
                                <label for="ultimas_semanas">Últimas semanas</label>
                            </li>
                            <li>
                                <input value="ultimo_mes" type="checkbox" id="ultimo_mes" />
                                <label for="ultimo_mes">Último mês</label>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="sidebar-box">
                    <h3 class="title text-uppercase">Ordenar por</h3>
                    <div class="content">
                        <ul>
                            <li>
                                <a style="cursor:pointer;" id="filtro_relevancia" title="">Relevância</a>
                            </li>
                            <li>
                                <a style="cursor:pointer;" id="filtro_recente" title="">Data (Mais recente primeiro)</a>
                            </li>
                            <li>
                                <a style="cursor:pointer;" id="filtro_alfabetica" title="">Alfabeticamente</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- paginacao -->
    <div class="row" style="<?php if($totalPagina == 0) echo 'visibility:hidden' ?>">
        <div class="mobile-four ten columns">
            <div class="pagination">
                <?php if($paginaAtual > 1): ?>
                     <a href="<?php echo mudaParamUrl($redirectUrl,"page=$paginaAnterior"); ?>" title="" class="btn btn-prev"><span>Anterior</span></a>
                <?php endif; ?>
                <?php for ($i=1; $i <= $totalPagina; $i++): ?>
                  <?php if($i != $paginaAtual): ?>
                      <a href="<?php echo mudaParamUrl($redirectUrl,"page=$i"); ?>" class="item-pagination" title="<?php echo $i ?>"><?php echo $i ?></a>
                  <?php else: ?>
                      <span class="current"><?php echo $i ?></span>
                 <?php endif; ?>
               <?php endfor; ?>
               <?php if($paginaAtual != $totalPagina): ?>
                  <a href="<?php echo mudaParamUrl($redirectUrl,"page=$paginaProxima"); ?>" title="" class="btn btn-next"><span>Próximo</span></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<!-- paginacao -->

</div>
<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
  $(function() {
    document.getElementById('content').className += ' busca resultado-busca';

    //pra deixar já selecionado
    var filtro_url = document.getElementById('filtro').value.toString();
    var filtro_tipo = document.getElementById('tipo').value.toString();
    var filtro_ordem = document.getElementById('ordem').value.toString();

    if(filtro_url != ''){
        $("#"+filtro_url).attr("checked","checked");
    }

    if(filtro_tipo != ''){
        var array = filtro_tipo.split(',');
        $.each(array, function( index, value ) {
            value = value.replace("]", "");
            value = value.replace("[", "");
            $("#"+value).attr("checked","checked");
        });
    }

    if(filtro_ordem != ''){
      document.getElementById("filtro_"+filtro_ordem).style.fontWeight = "bold";
    }

    //função de filtro
    function filtra(){

      var category_selected = document.getElementById('category-select').value.toString();
      var campo_busca = document.getElementById('busca').value.toString();
      var ordem = document.getElementById('ordem').value.toString();
      var filtro = document.getElementById('filtro').value.toString();
      var url = '';
      var checked = $('.marca:checkbox:checked');//tipos selecionados
      var values = [];//arrayDeTipos

      for(var i = 0; i < checked.length; i++) {
        values.push(checked[i].value);
      }

      if(campo_busca == '' && document.getElementById('s').value != "") {
        campo_busca = document.getElementById('s').value.toString();
      }

      if(ordem == '' || ordem == 'undefined' || typeof ordem == undefined) {
        ordem = '';
      }

      if(filtro == '' || filtro == 'undefined' || typeof filtro == undefined) {
        filtro = '';
      }

      if(category_selected == '' || category_selected == 'undefined' || typeof category_selected == undefined) {
        category_selected = '';
      }

      url = 'index.php?option=com_buscasite&busca='+campo_busca+'&catid='+category_selected+'&ordem='+ordem+'&filtro='+filtro;

      if(values && values.length){
        url += '&tipo=['+values.join(",")+']';
      }

      //paginacao
      url += '&page=1';

      setTimeout(function(){
          window.location.href = url;
      }, 3000);

    }

      $("#content").addClass(" busca resultado-busca");
      $("#titulo-pagina").text('busca');
      $("#subtitulo-pagina").text('Resultado da Busca por <?php echo $busca; ?>');

      //auto seta o valor da categoria
      $("#category-select").val('<?php echo $idCategoria; ?>');

      $( "#botao_busca" ).click(function(event) {
        event.preventDefault();
        filtra();
      });

      //filtro de datas filtra(ordem,filtro)
      $( "#ontem" ).click(function() {
        if(document.getElementById('filtro').value == 'ontem'){
          document.getElementById('filtro').value = '';
        } else {
          document.getElementById('filtro').value = 'ontem';
        }
        filtra();
      });

      $( "#ultimas_semanas" ).click(function() {
        if(document.getElementById('filtro').value == 'ultimas_semanas'){
          document.getElementById('filtro').value = '';
        } else {
          document.getElementById('filtro').value = 'ultimas_semanas';
        }
        filtra();
      });

      $( "#ultimo_mes" ).click(function() {
        if(document.getElementById('filtro').value == 'ultimo_mes'){
          document.getElementById('filtro').value = '';
        } else {
          document.getElementById('filtro').value = 'ultimo_mes';
        }
        filtra();
      });

      //ordenacao
      $( "#filtro_relevancia" ).click(function() {
        if(document.getElementById('ordem').value == 'relevancia'){
          document.getElementById('ordem').value = '';
        } else {
          document.getElementById('ordem').value = 'relevancia';
        }
        filtra();
      });

      $( "#filtro_recente" ).click(function() {
        if(document.getElementById('ordem').value == 'recente'){
          document.getElementById('ordem').value = '';
        } else {
          document.getElementById('ordem').value = 'recente';
        }
        filtra();
      });

      $( "#filtro_alfabetica" ).click(function() {
        if(document.getElementById('ordem').value == 'alfabetica'){
          document.getElementById('ordem').value = '';
        } else {
          document.getElementById('ordem').value = 'alfabetica';
        }
        filtra();
      });

      //seleciona um ou todos
      var marcadosFlag = false;
      $( "#select_all" ).change(function() {
          if(! marcadosFlag){
            $(".marca").attr("checked","checked");
            marcadosFlag = true;
          } else {
            $(".marca").removeAttr("checked");
            marcadosFlag = false;
          }
      });

      $( ".marca" ).click(function() {
          filtra();
      });

  });


})(jQuery);


</script>
