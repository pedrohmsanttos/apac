<?php defined('_JEXEC') or die; ?>
<style type="text/css">

@media (min-width: 700px)
{
	.logo
	{
		background:url('<?php echo $url_image;?>') 0 0 no-repeat !important;
	}

}

@media (max-width: 700px)
{
	.logo
	{
		background: #005f98 url('<?php echo $url_image_mobile;?>') 15px center no-repeat !important;
	}

}

</style>
<a href="<?php echo $base_url?>" class="logo" title="Governo do Estado de Pernambuco - Juntos fazemos mais.">
	Governo do Estado de Pernambuco - Juntos fazemos mais.
</a>
<h1><?php echo $html_title;?></h1>
<div class="wrap-show-menu">
	<a href="javascript:void(0);" class="show-menu c-hamburger c-hamburger--htx"><span>&#9776;</span></a>
</div>
