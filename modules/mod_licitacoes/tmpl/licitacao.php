<?php defined('_JEXEC') or die; ?>
<div id="content" class="internal page-governo imprensa">
<div class="page-content">
<?php
      $user = JFactory::getUser();        // Get the user object
	 	$app  = JFactory::getApplication(); // Get the application
      if ($user->id != 0){ 
        $userToken = JSession::getFormToken();
        $uri        = JFactory::getURI();
        $return     = $uri->toString();
        $redirecEdit = $_SERVER['REDIRECT_URL'].'?perfil=';
        $url  = 'index.php?option=com_users&view=profile&layout=edit&amp;return=' . urlencode(base64_encode($return));
        
        echo('<div class="card-header">
        <h3>Bem-vindo ao Painel de Licitações, '. $user->username.' </h3>
        <br>
        <div style="text- padding-left: 350px;"><a style="color: black;" href="index.php?option=com_users&task=user.logout&' . $userToken . '=1">Sair - '  . $user->username . '</a></div>
         <div style="text- padding-left: 350px; color: black;"><a style="color: black;" href="component/users/?view=profile">Editar Perfil</a></div>
         </div>');
      }
?>
   <div class="row">
      <div class="mobile-four  twelve columns">
         <?php
            $redirectUrl = $_SERVER['REDIRECT_URL'].'?page=';
            $redirecDownload = $_SERVER['REDIRECT_URL'].'?download=';
            session_start();
               $URL_ATUAL= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
               $_SESSION["url_licit"]= $URL_ATUAL;
            //paginação
            $paginaAtual   = JFactory::getApplication()->input->get('page',1, 'int');
            $paginaAnterior = $paginaAtual - 1;
            $paginaProxima = $paginaAtual + 1;
            if($paginaAnterior <= 0) $paginaAnterior = 1;
            
            //paginacao($yourDataArray,$page,$limit)
            
            $vetorPaginado = $licitacoesHelper::paginacao($licitacao,$paginaAtual,3)->vetor;
            $totalPagina   = $licitacoesHelper::paginacao($licitacao,$paginaAtual,3)->total_paginas;
            
            ?>
         <br>         
         <?php foreach ($vetorPaginado as $row): ?>
         <?php $data = $licitacoesHelper::formataData($row->data_licitacao);
            ?>
         <div id="<?php echo $row->id?>" class="card text-center">
            <div class="card-header">
               <h3 style="text-align: center;"><?php echo $row->titulo; ?></h3>
            </div>
            <div class="card-body">
               <h5 class="card-title">DATA DA LICITAÇÃO: <?php echo $data?></h5>
               <p class="card-text"><?php echo $row ->resumo;?></p>
               <table class="table table-hover">
                  <thead>
                     <tr>
                        <th scope="col">Documentos</th>
                        <th scope="col">Opções</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $arquivos = $licitacoesHelper::getArquivos($row ->id);?>
                     <?php foreach ($arquivos as $arquivo): ?>
                     <tr>
                        <th scope="row"><?php echo $arquivo->titulo?> </th>
                        <td>
                           <?php
                              if ($arquivo->arquivo != ""){
                                 $url = $arquivo->arquivo;

                                 $findme   = 'uploads';
                                 $pos = strpos($url, $findme);
                        
                                 if ($pos === false) {
                                    $url = "images\media\\" . $url;
                                 } 
                               if ($arquivo->tipo == 1){
                                  
                                      echo "<a id=\"{$arquivo->tipo}\" href=\"{$redirecDownload}$arquivo->id\" target=\"_blank\">Download</a>";
                                  
                               }
                               else{
                                  echo "<a id=\"{$arquivo->tipo}\" href=\"{ $url}\" target=\"_blank\">Download</a>";
                               }
                              }
                              else{
                               
                                  echo "<a id=\"{$arquivo->tipo}\" href=\"#\">Download</a>";}?>
                        </td>
                     </tr>
                     <?php endforeach ?>
                  </tbody>
               </table>
               <br>
               <div style="padding-left: 350px;">
                  <button id="btnimprimir" onclick="createPDF('<?php echo $row->id?>','<?php echo $row->titulo?>')" type="button" class="highlight-link" style="border-radius: 10px;  #ffdd00; height: 50px; width: 200px;">Imprimir</button>
               </div>
            </div>
         </div>
         <br>
         <?php endforeach ?>
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
<script language="javascript">
      function createPDF(id,nome) {
        jQuery("#btnimprimir").hide();
         var printContents = document.getElementById(id).innerHTML;
         console.log(printContents);
         var originalContents = document.body.innerHTML;
         document.body.innerHTML = printContents;
         window.print();
         document.body.innerHTML = originalContents;
         jQuery("#btnimprimir").show();
      }
</script>