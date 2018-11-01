<?php

require_once '../model/db.class.php';
$db = DB::getConnection();

function sendJSONandExit( $message )
{
  // Kao izlaz skripte pošalji $message u JSON formatu i prekini izvođenje.
  //header( 'Content-type:application/json;charset=utf-8' );
  //echo json_encode( $message );
  echo json_encode($message);
  flush();
  exit( 0 );
}

$id_komentara = $_GET["id_komentara"];

if ( $id_komentra < 1 )
{
  $arr["msg"] = "error";
  $arr["what"] = "tekst";
  sendJSONandExit( $arr );
}

try
{
  $st = $db->prepare( "DELETE FROM komentar WHERE id_komentara LIKE :id_komentara" );

 $st->execute( array( 'id_komentara' => $id_komentara ) );

}
catch( PDOException $e ) { exit( "PDO error #6: " . $e->getMessage() ); }

$arr["msg"] = "Obrisao komentar iz tablice 'komentar'.<br />";
$arr["id_komentara"] = $id_komentara;
//echo (string)$maxima;

sendJSONandExit($arr);

?>
