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

//ako ime bloga nije uneseno
if ( !isset($_GET["ime_posta"]) || empty($_GET["ime_posta"])  || !preg_match( '/[a-zA-Z0-9_]{1,40}/', $_GET["ime_posta"] ) )
{
  $arr["msg"] = "error";
  $arr["what"] = "ime posta";
  sendJSONandExit( $arr );
}
if ( !isset($_GET["tekst"]) || empty($_GET["tekst"])  || !preg_match( '/[a-zA-Z0-9_]{1,40}/', $_GET["tekst"] ) )
{
  $arr["msg"] = "error";
  $arr["what"] = "tekst";
  sendJSONandExit( $arr );
}

$id_bloga = $_GET["id_bloga"];
$ime_posta = $_GET["ime_posta"];
$tekst = $_GET["tekst"];

try
{
  $st = $db->prepare( 'SELECT MAX(id_posta) FROM post' );
  $st->execute( );
}
catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

$row = $st->fetch();

//kreiranje jedinstvenog id-a posta
$maxima = $row["MAX(id_posta)"] + 1;

//dodavanje novog posta u bazu
try
{
	$st = $db->prepare( 'INSERT INTO post(id_posta, id_bloga, naslov, tekst) VALUES (:id_posta, :id_bloga, :naslov, :tekst)' );
	$st->execute( array( 'id_posta' => (string)$maxima, 'id_bloga' => $id_bloga, 'naslov' => $ime_posta , 'tekst' => $tekst ) );
}
catch( PDOException $e ) { exit( "PDO error #6: " . $e->getMessage() ); }

$arr["msg"] = "Dodao post u tablicu 'post'.<br />";
$arr["id_posta"] = (string)$maxima;

sendJSONandExit($arr);

?>
