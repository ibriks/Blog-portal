<?php require_once 'view/_header.php'; ?>

<?php //poruka nakon logina ?>
<br><br>
<div class="poruke">
  <p>Pozdrav, <?php echo $_SESSION['id']['korisnik_ime']; ?>!</p>
</div>

<div class="kreiranje_posta">
  <label for="ime_posta">Unesite ime posta: </label><input type="text" name="ime_posta" class="ime_posta"><br>
  <textarea class="tekst" rows="15" cols="80"> Tekst posta.. </textarea>
  <input type="hidden" class="id_bloga" value="<?php echo $id_bloga; ?>" />
  <br><button type="button" class="dodaj"> Podnesi! </button>
</div>

<?php require_once 'view/_footer.php'; ?>


<script>

  $(".dodaj").on("click", dodaj_post);

  function dodaj_post()
  {
    var ime_posta = $(".ime_posta").val();
    var tekst = $(".tekst").val();
    var id_bloga = $(".id_bloga").val();

    $.ajax(
    {
      url: "controller/dodajPost.php",
      data:
      {
        ime_posta: ime_posta,
        tekst: tekst,
        id_bloga: id_bloga
      },
      success: function( data )
      {
        if ( jQuery.parseJSON(data)["msg"] == "error")
        {
            $(".poruke").html( "<p> Krivo -> " + jQuery.parseJSON(data)["what"] + " !</p>");
        }
        else
        {
          $(".poruke").html( "<p> Uspješno kreiran post! </p>");
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
