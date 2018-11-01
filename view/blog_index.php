<?php require_once 'view/_header.php'; ?>

<?php //ispis svih blogova ?>
<div class="blogovi">
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=blog/postovi'?>">
	<?php
		foreach( $lista_blogova as $blog )
		{
			echo '<h2><p class="blog">'. $blog->naziv . '</p></h2>' . $blog->opis . '<br>';
			echo '<button class="blog_button" type="submit" name="id_bloga" value="' . $blog->id_bloga . '"> Otvori blog </button>';
		}

	?>
	</form>
</div>

<br/>
<br/>

<?php require_once 'view/_footer.php'; ?>
