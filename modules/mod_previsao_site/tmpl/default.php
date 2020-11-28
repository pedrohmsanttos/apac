<?php
defined('_JEXEC') or die;
?>

<div class="row" style="background-color: rgba(255,255,255,0.5)">
    <div class="mobile-four twelve  columns">

        <div id="Servicos-site">
			<span>Acompanhe em tempo real os dados climáticos de toda a região do estado.</span><br>
			<span>Agora você pode colocar a previsão de todo o estado de Pernambuco no seu site.</span><br><br>
			<span><b>Selecione a dimensão do banner abaixo:</b></span><br><br>
	
			<table style="width:90%;">
			    <tbody>
                    <tr>
                        <td style="width: 30%; padding-bottom: 5px; font-size: 0.9em; padding-left: 10px; padding-right: 10px;text-align: center;">
                            
                        </td>
                        <td style="width: 50%; float:left; padding-bottom: 5px; font-size: 0.9em; padding-left: 10px; padding-right: 10px;text-align: center;">
                            <input type="radio" name="dimensaoBanner" id="dimensao1" value="v130" checked="true"><label for="crust1"></label>
                        </td>
			        </tr>		
			        <tr>
                        <td style="width: 50%; padding-bottom: 5px; font-size: 0.9em; padding-left: 10px; padding-right: 10px;text-align: center;">
                            <div style="float:left;"><input type="checkbox" name="prop" id="prop" checked> <label for="prop">Manter proporção</label></div><br>
                            <label for="largura">Largura:</label>
                            <input type="number" id="largura" name="largura" min="100" max="1000" onchange="prop()">
                            <label for="altura">Altura:</label>
                            <input type="number" id="altura" name="altura" min="100" max="1000">
                            
                        </td>
                        <td style="width: 50%; float:left; text-align: left; padding-left: 10px; padding-right: 10px; text-align: center;">
                            <img width="200px" height="200px" src="<?php echo(JURI::root().'modules/mod_previsao_site/assets/imagens/');?>APAC.PNG">
                        </td>		
			        </tr>		
                </tbody>
            </table>
		
		    <span><b>Passos para geração do código:</b></span><br>
		    <span>Escolha a região do estado que você deseja acompanhar e depois clique em "Gerar código", copie e cole o código na sua página e automaticamente você receberá os dados do tempo no estado.</span>
        </div>
        <div class="escolhaRegiao">

        <div class="row">
            <div class="escolha mobile-twelve six columns">
                <h2>
                    <a href="#" id="dest_href_tit">REGIÕES DO ESTADO</a>
                </h2>
                <select name="regioes" id="regioes" ng-model="regioes">
                    <option value="NULL" selected="selected">Regiões</option>
                        <option value="ALL">Todas</option>
                    <?php foreach ($mesorregioes as $mesoregiao) : ?>
                        <option value="<?php echo($mesoregiao->id);?>"> <?php echo($mesoregiao->nome);?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <div id="buttonAddRegiao">
                    <input type="button" value="Adicionar região" id="btAdicionarRegiao">
                    <script>
                        var prop = function(){
                            var check_prop = document.getElementById("prop").checked;
                            if(check_prop){
                                document.getElementById('altura').value = parseInt( (1040/800) * document.getElementById('largura').value );
                            }
                        }

                        jQuery('#btAdicionarRegiao').click(function() {
                            var regIndice = jQuery('#regioes').val();
                            var regText = jQuery("#regioes option:selected").text()
                            console.log(regText);
                            if (regIndice != null) {
                                if (regIndice != "ALL"){
                                    var v = jQuery("#regioesescolhidas > option");
                                    var link = '';
                                    var i;
                                    var max;
                                    max = v.length;
                                    var existItem = false;
                            
                                    for (i = 0; i < max; i++) {
                                        if (v[i].value == regIndice){
                                            existItem = true;
                                        }
                                    }
                                
                                if (!existItem){
                                    jQuery('#regioesescolhidas').append("<option value=\""+regIndice+"\">"+regText+"</option>");
                                }
                            }
                            else
                            {
                                jQuery('#regioesescolhidas').empty();
                                var v = jQuery("#regioes > option");
                                var link = '';
                                var i;
                                var max;
                                max = v.length;
                                for (i = 0; i < max; i++) {
                                    if ((v[i].value != "NULL") && (v[i].value != "ALL")){
                                        jQuery('#regioesescolhidas').append("<option value=\""+v[i].value+"\">"+v[i].text+"</option>");
                                    }
                                }
                            }
                        }
                    });
                    </script>
                </div>
            </div>

            <div class="regiaoEscolhida mobile-twelve six  columns">	
                <h2>
                    <a href="#" id="dest_href_tit">REGIÕES ESCOLHIDAS</a>
                </h2>	
                <div id="lista_regioes">
                    <select id="regioesescolhidas" name="regioesescolhidas" size="5">					
                    </select>
                    <input type="button" value="Remover região" id="btRemoveRegiao">
                    <input type="submit" value="Gerar código" id="btGerarCodigo">
                    <script>
                        jQuery('#btRemoveRegiao').click(function() {
                            jQuery('#regioesescolhidas').find("option:selected").remove();
                        });
                        jQuery('#btGerarCodigo').click(function() {
                            var v = jQuery("#regioesescolhidas > option");
                            var link = '';
                            var i;
                            var max;
                            max = v.length - 1;
                            var largura = jQuery("#largura").val();
                            var altura  = jQuery("#altura").val();
                            if (max < 0){
                                alert ('Selecione ao menos uma região');
                            }else if(largura == '' && altura == ''){
                                alert('Selecione as dimensões do banner');
                            }else if(largura < 100  && altura < 100){
                                alert('Selecione as dimensões corretas, largura e altura precisam ter mais de 100px');
                            }else{
                                for (i = 0; i < max; i++)
                                {
                                    link = link+v[i].value+",";
                                }
                                link = link+v[i].value;
                                var dimBanner = jQuery("input[name=dimensaoBanner]:checked").val();
                                
                                jQuery('#codigogerado').val("<iframe src='<?php echo JURI::base(); ?>index.php?option=com_previsaonosite&tmpl=component&id_regioes=" + link + "&largura=" + largura + "&altura=" + altura + "' scrolling='no' frameborder='0' width='"+ largura +"' height='"+ altura +"' marginheight='0' marginwidth='0'></iframe>");
                            }
                        });					
                    </script>
                </div>		
            </div>

            <div class="colunasCodigoSite mobile-twelve twelve  columns">
                <div class="bg">
                    <h3><a href="#" id="dest_href_tit">CÓDIGO GERADO:</a></h3>
                    <br>
                    <textarea id="codigogerado" cols="92" rows="5"></textarea>		
                    
                    <div class="line">
                    </div>
                </div>
            </div>
        </div>
		
    
    </div>
</div>

