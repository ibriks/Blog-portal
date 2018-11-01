<?php require_once 'view/_header.php'; ?>

	<?php
    $broj_posta = 0;
    $broj_komentara = 0;
    foreach( $lista_blogova as $b){
      $lista_postova = $b->get_all_postovi();
      echo '<h1>' . $b->naziv . '</h1>';
			foreach( $lista_postova as $pos ){
        $broj_posta++;
				echo '<ul><h2>' . $pos->naslov . '</h2>' . $pos->tekst; ?>
          <input type="hidden" class="id_posta" value="<?php echo $pos->id_posta; ?>" />
          <button type="submit" onClick="obrisi_post(<?php echo $broj_posta; ?>)" class="post" value="<?php echo $broj_posta; ?>">Obriši post!</button>
        <?php
        $lista_komentara = $pos->get_all_komentari();
				foreach( $lista_komentara as $komentar ){
          $broj_komentara++;
					$korisnik = $komentar->get_korisnik();
					foreach($korisnik as $k)
					echo '<li>' . $k->ime . ': ' . $komentar->tekst . '</li>'; ?>
            <input type="hidden" class="id_komentara" value="<?php echo $k->id_komentara; ?>" />
            <button type="submit" onClick="obrisi_komentar(<?php echo $broj_komentara; ?>)" class="komentar" value="<?php echo $broj_komentara; ?>">Obriši komentar!</button>
          <?php
			  }
				echo '</ul>';
	  	}
    }
	?>
</ul>

<?php require_once 'view/_footer.php'; ?>

<script>

  function obrisi_komentar(j)
  {
		var elements = document.getElementsByClassName("komentar");
		var komentari = document.getElementsByClassName("id_komentara");
		for(var i=0; i<elements.length; i++) {
    	if (i+1 === j) {
				var id_komentara = komentari[i].value;
			}
		}


    $.ajax(
    {
      url: "controller/obrisiKomentar.php",
      data:
      {
        id_komentara: id_komentara
      },
      success: function( data )
      {
        if ( jQuery.parseJSON(data)["msg"] == "error")
        {
            $(".poruke").html( "<p> Krivo -> " + jQuery.parseJSON(data)["what"] + " !</p>");
        }
        else
        {
          $(".poruke").html( "<p> Uspješno obrisan komentar! </p>");
          id_posta = jQuery.parseJSON(data)["id_komentara"];
        }
      },
      error: function( xhr, status )
      {
        if( status !== null )
          $(".poruke").html( "<p> Greška prilikom Ajax poziva: " + status + "</p>");
      }
    });
  }

</script>
