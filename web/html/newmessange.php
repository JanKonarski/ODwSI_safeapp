<?php

	include_once( "functions/all.php" );

	if( !is_loged())
		mov_to_index( "You mast login" );
	
	if( !isset( $_POST["messange"] ))
		mov_to_home();
	
	$content= serialize( $_POST["messange"] );
	$public= ( isset( $_POST["check"] ) && $_POST["check"] == "public" ) ? "yes" : "no";
	$encrypt= ( isset( $_POST["check"] ) && $_POST["check"] == "encrypt" ) ? "yes" : "no";

	if( $public == "yes" && $encrypt == "yes" )
		mov_to_home();

	try {
		if(( $data= $usr->get_user_by( "token", $_SESSION["token"], "s" )) == NULL )
			throw new Exception();
		
		if( $encrypt == "yes" )
			$content= openssl_encrypt(
				$content,
				SERVER_ALGORITHM,
				SERVER_PASSWORD,
				$options=0,
				hex2bin( SERVER_IV )
			);
		
		if( !$mes->new_messange( $data["id"], $content, $public, $encrypt ))
			throw new Exception();

		mov_to_home();
	} catch( Exception $e ) {
		mov_to_error();
	}

?>