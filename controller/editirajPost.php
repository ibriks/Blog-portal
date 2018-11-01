<?php

require_once '../model/db.class.php';
$db = DB::getConnection();

function sendJSONandExit( $message )
{
  // Kao izlaz skripte pošalji $message u JSON formatu i prekini izvođenje.

  echo json_encode($message);
  flush();
  exit( 0 );
}

//ako tekst posta nije unesen
if ( !isset($_GET["tekst"]) || empty($_GET["tekst"])  || !preg_match( '/[a-zA-Z0-9_]{1,40}/', $_GET["tekst"] ) )
{
  $arr["msg"] = "error";
  $arr["what"] = "tekst posta";
  sendJSONandExit( $arr );
}

$id_posta = $_GET["id_posta"];
$tekst = $_GET["tekst"];

try
{
  $st = $db->prepare( 'UPDATE post SET tekst="' . $tekst . '" WHERE id_posta="' . $id_posta . '"');
  $st->execute( );
}
catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

$arr["msg"] = "Editirao post u tablicu 'post'.<br />";
$arr["id_posta"] = (string)$maxima;

sendJSONandExit($arr);

?>
