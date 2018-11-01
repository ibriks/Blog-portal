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
					<div class="editiranje_posta">
						<?php if ($id_k !== NULL && $_SESSION['id']['admin'] == 0){ ?>
						<textarea class="tekst" rows="3" cols="40"><?php echo $pos->tekst; ?></textarea>
						<input type="hidden" class="id_posta" value="<?php echo $pos->id_posta; ?>" />
						<button type="submit" onClick="editiraj_post(<?php echo $broj; ?>)" class="edit" value="<?php echo $broj; ?>">Editiraj post!</button>
					</div>
		<?php }
			}
		}
    echo '<br>';
  }
		?>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>

<script>

  function editiraj_post(j)
  {
		var elements = document.getElementsByClassName("edit");
		var postovi = document.getElementsByClassName("id_posta");
		var tekstovi = document.getElementsByClassName("tekst");
		for(var i=0; i<elements.length; i++) {
    	if (i+1 === j) {
				var id_posta = postovi[i].value;
		    var tekst = tekstovi[i].value;
			}
		}


    $.ajax(
    {
      url: "controller/editirajPost.php",
      data:
      {
        id_posta: id_posta,
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
          $(".poruke").html( "<p> Uspješno editiran post! </p>");
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
