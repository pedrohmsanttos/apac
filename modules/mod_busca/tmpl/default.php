<?php defined('_JEXEC') or die; ?>
<style>
select option {
    background-color: #E7BB03 !important;
}
</style>
<div id="busca-home" class="search">
<label>
	<select id="category-select" name="category-select" onchange="(this.options[this.selectedIndex].value == 'buscaavancada') && (window.location = 'http://'+window.location.host +'/component/buscavancada/');">
		<option selected="selected">Assunto</option>
		<option value="buscaavancada">Busca avançada</option>
	<?php foreach ($categories as $category) : ?>
		<option value="<?php echo $category->id ;?>" >
			<?php if($category->parent_id == '1'): ?>
				<?php echo $category->title ;?>
			<?php else: ?>
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category->title ;?>
			<?php endif; ?>
		</option>
	<?php endforeach; ?>
	</select>
</label>

<input type="text" class="busca-input" name="search" id="s" value="<?php echo $_GET['busca'];?>" placeholder="O QUE VOCÊ PROCURA?">

<input id="boom" type="submit" value="">
</div>
<script type="text/javascript">
	jQuery.noConflict();
	(function( $ ) {
	  $(function() {
		$( "#boom" ).click(function( event ) {

		  var category_selected = $("#category-select").val();
		  var campo_busca = $("#s").val();
		  var url = 'index.php?option=com_buscasite&busca='+campo_busca+'&catid='+category_selected;

		  window.location.href= url;

		});
		$('#s').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        if(code == 13){
					var category_selected = $("#category-select").val();
					var campo_busca = $("#s").val();
					var url = 'index.php?option=com_buscasite&busca='+campo_busca+'&catid='+category_selected;

					window.location.href= url;
				}
   });


	  });
	})(jQuery);
</script>
