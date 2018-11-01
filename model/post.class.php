<?php
require_once 'db.class.php';
require_once 'komentar.class.php';

class Post
{
	protected $id_posta, $id_bloga, $naslov, $tekst;

	function __construct( $id_posta=NULL, $id_bloga=NULL, $naslov=NULL, $tekst=NULL )
	{
		$this->id_posta = $id_posta;
		$this->id_bloga = $id_bloga;
		$this->naslov = $naslov;
		$this->tekst = $tekst;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }

	function get_all_komentari( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_komentara, id_posta, id_korisnika, tekst FROM komentar WHERE id_posta=:id_posta' );
			$st->execute( array( 'id_posta' => $this->id_posta ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Komentar( $row['id_komentara'], $row['id_posta'], $row['id_korisnika'], $row['tekst'] );
		}

		return $arr;
	}
}

?>
