<?php

	include_once( "functions/all.php" );

	session_start();

	try {
		if( isset( $_SESSION['token'] ))
			$usr->update_user_by( "token", NULL, "s", "token", $_SESSION['token'], "s" );
		
		setcookie( "token", "", time()-3600 );

		session_destroy();

		mov_to_index( "Logout complete" );
	} catch( Exception $e ) {
		mov_to_error();
	}

?>