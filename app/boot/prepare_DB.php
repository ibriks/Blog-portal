<?php

// Manualno inicijaliziramo bazu ako već nije.
require_once '../../model/db.class.php';

$db = DB::getConnection();

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS blog (' .
		'id_bloga int NOT NULL PRIMARY KEY,' .
		'id_korisnika int NOT NULL,' .
		'naziv varchar(255) NOT NULL,' .
		'opis varchar(255) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #1: " . $e->getMessage() ); }

echo "Napravio tablicu 'blog'.<br />";


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS post (' .
		'id_posta int NOT NULL PRIMARY KEY,' .
		'id_bloga int NOT NULL,' .
		'naslov varchar(255) NOT NULL,' .
		'tekst text NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #2: " . $e->getMessage() ); }

echo "Napravio tablicu 'post'.<br />";


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS korisnik (' .
		'id_korisnika int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'ime varchar(50) NOT NULL,' .
		'pass varchar(255) NOT NULL,' .
		'admin tinyint NOT NULL)'
		);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #3: " . $e->getMessage() ); }

echo "Napravio tablicu 'korisnik'.<br />";


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS komentar (' .
		'id_komentara int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'id_posta int NOT NULL,' .
		'id_korisnika int NOT NULL,' .
		'tekst text NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

echo "Napravio tablicu 'komentar'.<br />";

// Popunjavanje tablica


try
{
	$st = $db->prepare( 'INSERT INTO blog(id_bloga, id_korisnika, naziv, opis) VALUES (:id_bloga, :id_korisnika, :naziv, :opis)' );

	/*blogovi*/
	$st->execute( array('id_bloga' => '1','id_korisnika' => '2','naziv' => 'Matin blog','opis' => 'Ja sam mali Mate') );
	$st->execute( array('id_bloga' => '2','id_korisnika' => '5','naziv' => 'Kuhajte s Ankom','opis' => 'Volim kuhati') );

}
catch( PDOException $e ) { exit( "PDO error #5: " . $e->getMessage() ); }

echo "Kreirao blogove u tablici 'blog'.<br />";


try
{
	$st = $db->prepare( 'INSERT INTO post(id_posta, id_bloga, naslov, tekst) VALUES (:id_posta, :id_bloga, :naslov, :tekst)' );

	/*postovi*/
	$st->execute( array('id_posta' => '1','id_bloga' => '1','naslov' => 'Mate u gradu','tekst' => 'Došau sam u grad. Nije bilo zabavno. Otišao sam doma. Depresija') );
	$st->execute( array('id_posta' => '2','id_bloga' => '2','naslov' => 'Burek od mesa','tekst' => 'Zagorilo mi pa otišla do pekare. Muž nije skužio. Uspješan dan.') );

}
catch( PDOException $e ) { exit( "PDO error #6: " . $e->getMessage() ); }

echo "Kreirao postove u tablici 'post'.<br />";

try
{

	$st = $db->prepare( 'INSERT INTO korisnik(id_korisnika, ime, pass, admin ) VALUES (:id_korisnika, :ime, :pass , :admin)' );
	
	/*korisnici*/
	$st->execute( array('id_korisnika' => '1','ime' => 'admin1','pass' => 'pass1','admin' => '1') );
	$st->execute( array('id_korisnika' => '2','ime' => 'mate','pass' => 'matepass','admin' => '0') );
	$st->execute( array('id_korisnika' => '4','ime' => 'admin2','pass' => 'pass2','admin' => '1') );
	$st->execute( array('id_korisnika' => '5','ime' => 'anka','pass' => 'ankapass','admin' => '0') );

}
catch( PDOException $e ) { exit( "PDO error #7: " . $e->getMessage() ); }

echo "Kreirao korisnike u tablici 'korisnik'.<br />";


try
{
	$st = $db->prepare( 'INSERT INTO komentar(id_komentara, id_posta, id_korisnika, tekst ) VALUES (:id_komentara, :id_posta, :id_korisnika , :tekst)' );
	
	/*komentari*/
	$st->execute( array('id_komentara' => '1','id_posta' => '1','id_korisnika' => '5','tekst' => 'Đe baš u grad, Mate? Radje dođi kuhat sa mnom.') );
	$st->execute( array('id_komentara' => '2','id_posta' => '2','id_korisnika' => '2','tekst' => 'Reći ću te mužu, pazi što pišeš.') );

}
catch( PDOException $e ) { exit( "PDO error #9: " . $e->getMessage() ); }

echo "Kreirao komentare u tablici 'komentar'.<br />";






?>
