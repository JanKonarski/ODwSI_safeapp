<?php

	include_once( "functions/all.php" );

	if( !isset( $_POST["email"] ))
		mov_to_index( "Required e-mail to restore password" );
	
	$email= sanitization( $_POST["email"] );

	try {
		if(( $data= $usr->get_user_by( "email", $email, "s" ) ) == NULL )
			mov_to_index( "Check e-mail" );
		
		if( $data["status"] != "activate" )
			mov_to_index( "Account doesn't activated" );
		
		$token= generate_id();

		if( !$usr->update_user_by( "token", $token, "s", "id", $data["id"], "s" ))
			mov_to_index( "System error, try again" );
		
		$mes= sprintf( "User '%s' restore token: %s", $email, $token );
		$log->log( $mes );

		mov_to_index( "Check e-mail" );
	} catch( Exception $e ) {
		mov_to_error();
	}

?>