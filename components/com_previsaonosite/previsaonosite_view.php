
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>APAC - Previsão do Tempo para o Estado de Pernambuco - www.apac.pe.gov.br</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js" ></script>
</head>
<body marginwidth="0" marginheight="0">
<a href='http://www.apac.pe.gov.br' target='_blank'>
<?php

if($tamanho == 'v130'):
?>
<div id='templates130'>
<?php
elseif($tamanho == 'v150'):
?>
<div id='templates150'>
<?php
else:
?>
<div id='templates170' style="width: <?php echo $largura.'px'; ?> !important; height: <?php echo $altura.'px'; ?> !important; position: relative;">
<?php
endif;
?>
	<?php
	if(count($previsoes) <= 0):
	?>
    <div id='template0'>
        <div class='regiao'>--</div>
        <div class='data'><?php echo($diaprevisao); ?></div>
       <!--  <div class='legendaImagem'>
            <img border=0 width='20%' height='20%' margin-top='10px' src='http://www.apac.pe.gov.br/msirh/images/legendas/45.png'/>
        </div> -->
        <div class='tempMax'>N/A</div>
        <div class='tempMin'>N/A</div>
        <div class='descricao'>
            Não há previsões disponíveis para esta(s) região(ões).
        </div>
    </div> 
	<?php
	else:
		$index = 0;
		foreach($previsoes as $previsao):
    ?>
		<div id='template<?php echo($index); ?>'>
			<div class='regiao'><?php echo($previsao->messoregiao); ?></div>
			<div class='data'><?php echo($diaprevisao); ?></div>
			<div class='legendaImagem'>
				<img border=0 width=<?php echo"'".($largura/3).'px'."'"; ?> height=<?php echo"'".($altura/3).'px'."'"; ?> style="margin-top:<?php echo ($altura/30).'%'; ?>;margin-left:17%" src='<?php echo(JURI::base());?><?php echo($previsao->icone); ?>'/>
			</div>
			<div class='tempMax' <?php if($largura > 200){ echo('style="font-size:20px !important"');}?>><?php echo($previsao->tempMax); ?></div>
			<div class='tempMin' <?php if($largura > 200){ echo('style="font-size:20px !important"');}?>><?php echo($previsao->tempMin); ?></div>
			<div class='amanha_tempMin' <?php if($largura > 200){ echo('style="font-size:18px !important"');}?>> <?php echo($previsao->amaTempMin); ?></div>
			<div class='amanha_tempMax' <?php if($largura > 200){ echo('style="font-size:18px !important"');}?>> <?php echo($previsao->amaTempMax); ?></div>
			<div class='amanha_legendaImagem'>
				<img border=0 width='20%' height='20%' src='<?php echo(JURI::base());?><?php echo($previsao->amaIcone); ?>'/>
			</div>
			<div class='apac_url'>apac.pe.gov.br<br>+ info</div>
    	</div>
	<?php
		++$index;
		endforeach;
	endif;
    ?>
</div>
</a>
<script type="text/javascript">
	var i = 0;
	function fireEvent(template){
		for (var i = 0; i < jQuery('div[id*="template"]').length - 1; i++){
			jQuery("#template" + i).css("display", "none");
		}
		
		jQuery("#" + template).css("display", "block");
		var fTemplate = "<div id='" + template + "'>" + jQuery("#" + template).html() + "</div>";
	}
	
	function AtualizaDados () {
		if (i == jQuery('div[id*="template"]').length - 1){
			i=0;
		}  
		fireEvent("template" + i);
		i = i + 1;
	}	
	
	function fadeOut(template){
		jQuery("#templates").fadeOut('slow');
	}


	function fadeIn(template){ 					
		jQuery("#templates").fadeIn('slow');
	}
	
	function sleep(milliSeconds)
	{
		var tatual= new Date().getTime();
		while (new Date().getTime() < tatual + milliSeconds);
	}

	function Processa(){
		//fadeOut();
		//sleep(800);
		AtualizaDados();
		//fadeIn();
	}

	if (3 > 1) 
	{  
		//var t=setTimeout("Processa()",4000);
		setInterval('Processa()', 4000);
	}	
</script>
<script type='text/javascript'>fireEvent('template0');</script></body>
</html>