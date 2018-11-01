<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div>
	<h1><?php echo $title; ?></h1>
</div>

<div class="poruke">
</div>

		<?php

	foreach( $lista_blogova as $b){
		if ($b->id_bloga == $id_bloga){
      $lista_postova = $b->get_all_postovi();
			$broj=0;
		  foreach( $lista_postova as $pos ){
				$broj++;
				echo '<h2>' . $pos->naslov . '</h2>' . $pos->tekst . '<br><br>';
				$lista_komentara = $pos->get_all_komentari();
				foreach( $lista_komentara as $komentar ){
					$korisnik = $komentar->get_korisnik();
					foreach($korisnik as $k)
					echo '<li>' . $k->ime . ': ' . $komentar->tekst . '</li>';
			  }
				?>	<br>
					<div class="kreiranje_komentara">
						<?php if ($id_k !== NULL && $_SESSION['id']['admin'] == 0){ ?>
							Komentar:
						<textarea class="tekst" rows="3" cols="40"></textarea>
						<input type="hidden" class="id_posta" value="<?php echo $pos->id_posta; ?>" />
						<input type="hidden" class="id_korisnika" value="<?php echo $id_k; ?>" />
						<button type="submit" onClick="dodaj_komentar(<?php echo $broj; ?>)" class="dodaj" value="<?php echo $broj; ?>">Dodaj</button>
					</div>
		<?php }
			}
		}
    echo '<br>';
  }
		?>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>

<script>

  function dodaj_komentar(j)
  {
		var elements = document.getElementsByClassName("dodaj");
		var postovi = document.getElementsByClassName("id_posta");
		var korisnici = document.getElementsByClassName("id_korisnika");
		var tekstovi = document.getElementsByClassName("tekst");
		for(var i=0; i<elements.length; i++) {
    	if (i+1 === j) {
				var id_posta = postovi[i].value;
			  var id_korisnika = korisnici[i].value;
		    var tekst = tekstovi[i].value;
			}
		}


    $.ajax(
    {
      url: "controller/dodajKomentar.php",
      data:
      {
        id_posta: id_posta,
        id_korisnika: id_korisnika,
        tekst: tekst
      },
      success: function( data )
      {
        if ( jQuery.parseJSON(data)["msg"] == "error")
        {
            $(".poruke").html( "<p> Krivo -> " + jQuery.parseJSON(data)["what"] + " !</p>");
        }
        else
        {
          $(".poruke").html( "<p> Uspješno dodan komentar! </p>");
          id_posta = jQuery.parseJSON(data)["id_posta"];
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
