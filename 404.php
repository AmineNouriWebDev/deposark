<?php
get_header();
?>

<style>
	<?php
	// Inclure le CSS uniquement sur la page 404
	if (is_404()) {
		echo file_get_contents(get_theme_file_path('/assets/css/404.css'));
	}
	?>
</style>

<div class="noise"></div>
<div class="overlay"></div>
<div class="terminal">
	<h1>Error <span class="errorcode">404</span></h1>
	<p class="output">La page que vous recherchez a peut-être été supprimée, renommée ou est temporairement indisponible.</p>
	<p class="output">Essayez de <a href="javascript:history.back()">retourner en arrière</a> ou de <a href="<?php echo home_url('/'); ?>">revenir à l'accueil</a>.</p>
	<p class="output">Bonne chance.</p>
</div>

<?php
