<?php

	include_once( "functions/all.php" );

	if( !isset( $_POST["token"] ))
		mov_to_index( "Required token box" );
	
	$token= sanitization( $_POST["token"] );

	try {
		if(( $data= $usr->active_user( $token )) == false )
			mov_to_index( "Bad activation token" );
		
		mkdir( FILESDIR_PATH . $data["id"] );
		
		mov_to_index( "User activated" );
	} catch( Exception $e ) {
		mov_to_error();
	}

?>