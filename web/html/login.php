<?php

	include_once( "functions/all.php" );

	if( !isset( $_POST['email'] ) ||
		!isset( $_POST['password'] ))
		mov_to_index( "Required all boxes" );
	
	$email= sanitization( $_POST['email'] );
	$password= $_POST['password'];
	
	try {
		sleep( 2 );

		if(( $data= $usr->get_user_by( "email", $email, "s" )) == NULL )
			mov_to_index( "Incorrect e-mail, password or the limit of 10 incorect logins has been exceeded, if so, wait 5 minuts" );
		
		if( $data['status'] == "inactivate" )
			mov_to_index( "Account doesn't activated" );

		if( $data['trys'] >= 10 ) {
			$clock= new DateTime( $data['clock'] );
			$diff= time() - $clock->getTimestamp();

			if( $diff <= 300 )
				mov_to_index( "Incorrect e-mail, password or the limit of 10 incorect logins has been exceeded, if so, wait 5 minuts" );
		}
		$usr->update_user_by( "clock", date( "Y-m-d H:i:s" ), "s", "id", $data["id"], "s" );

		$usr->update_user_by( "ip", $_SERVER['REMOTE_ADDR'], "s", "id", $data['id'], "s" );

		if( !password_verify(
			$password,
			$data['password']
		)) {
			$usr->update_user_by( "trys", $data["trys"]+1, "i", "id", $data["id"], "s" );
			mov_to_index( "Incorrect e-mail, password or the limit of 10 incorect logins has been exceeded, if so, wait 5 minuts" );
		}
		
		$usr->update_user_by( "trys", 0, "i", "id", $data["id"], "s" );

		$token= generate_id();
		
		if( !$usr->update_user_by( "token", $token, "s", "id", $data['id'], "s" ))
			mov_to_error();

		session_start();
		$_SESSION['token']= $token;

		setcookie( "token", $token, time()+3600 );

		header( "Location: home.php" );
	} catch( Exception $e ) {
		mov_to_error();
	}

?>