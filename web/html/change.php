<?php

	include_once( "functions/all.php" );

	if( !isset( $_POST["token"] ) ||
		!isset( $_POST["password"] ) ||
		!isset( $_POST["password2"] ))
		mov_to_index( "Required token and passwords to restore" );
	
	$token= sanitization( $_POST["token"] );
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
		if(( $data= $usr->get_user_by( "token", $token, "s" )) == NULL )
			mov_to_index( "Bad restore token" );
		
		if( !$usr->update_user_by( "password", $hash, "s", "id", $data["id"], "s" ))
			mov_to_index( "System error, try again");

		$usr->update_user_by( "token", NULL, "s", "id", $data["id"], "s" );

		mov_to_index( "Password changed" );
	} catch( Exception $e ) {
		mov_to_error();
	}

?>