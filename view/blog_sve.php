<?php require_once 'view/_header.php'; ?>

	<?php
    foreach( $lista_blogova as $b){
      $lista_postova = $b->get_all_postovi();
      echo '<h1>' . $b->naziv . '</h1>';
			foreach( $lista_postova as $pos ){
				echo '<ul><h2>' . $pos->naslov . '</h2>' . $pos->tekst . '<br><br>';
				$lista_komentara = $pos->get_all_komentari();
				foreach( $lista_komentara as $komentar ){
					$korisnik = $komentar->get_korisnik();
					foreach($korisnik as $k)
					echo '<li>' . $k->ime . ': ' . $komentar->tekst . '</li>';
			  }
				echo '</ul>';
	  	}
    }
	?>
</ul>

<?php require_once 'view/_footer.php'; ?>
