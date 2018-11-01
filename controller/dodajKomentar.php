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

//ako ime bloga nije uneseno
if ( !isset($_GET["tekst"]) || empty($_GET["tekst"])  || !preg_match( '/[a-zA-Z0-9_]{1,40}/', $_GET["tekst"] ) )
{
  $arr["msg"] = "error";
  $arr["what"] = "tekst";
  sendJSONandExit( $arr );
}

$id_posta = $_GET["id_posta"];
$id_korisnika = $_GET["id_korisnika"];
$tekst = $_GET["tekst"];

try
{
  $st = $db->prepare( 'SELECT MAX(id_komentara) FROM komentar' );
  $st->execute( );
}
catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

$row = $st->fetch();

//kreiranje jedinstvenog id-a bloga
$maxima = $row["MAX(id_komentara)"] + 1;

//dodavanje novog bloga u bazu
try
{
	$st = $db->prepare( 'INSERT INTO komentar(id_komentara, id_posta, id_korisnika, tekst) VALUES (:id_komentara, :id_posta, :id_korisnika, :tekst)' );

	$st->execute( array( 'id_komentara' => (string)$maxima, 'id_posta' => $id_posta, 'id_korisnika' => $id_korisnika , 'tekst' => $tekst ) );
}
catch( PDOException $e ) { exit( "PDO error #6: " . $e->getMessage() ); }

$arr["msg"] = "Dodao komentar u tablicu 'komentar'.<br />";
$arr["id_komentara"] = (string)$maxima;
//echo (string)$maxima;

sendJSONandExit($arr);

?>
