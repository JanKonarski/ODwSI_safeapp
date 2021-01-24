<?php

	include_once( "./functions/all.php" );

	if( !isset( $_POST["email"] ) ||
		!isset( $_POST["password"] ) ||
		!isset( $_POST["password2"] ))
		mov_to_index( "Required all boxes" );

	$email= sanitization( $_POST["email"] );
	$password= $_POST["password"];
	$password2= $_POST["password2"];

	if( $password != $password2 )
		mov_to_index( "Passwords don't match");
	
	$reg= '/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/';
	if( !preg_match( $reg, $password ))
		mov_to_index( "Password too weak" );

	$hash= password_hash(
		$password,
		PASSWORD_BCRYPT
	);

	try {
		$token= generate_id();

		if( !$usr->new_user( generate_id() , $email, $hash, $token ))
			mov_to_index( "User exists" );
		
		$mes= sprintf( "User '%s' activation token: %s", $email, $token );
		$log->log( $mes );

		mov_to_index( "User registered, check email" );
	} catch( Exception $e ) {
		mov_to_error();
	}

?>