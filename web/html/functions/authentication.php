<?php

	include_once( "functions/sql.php" );

	function is_loged(): bool {
		session_start();

		if( !isset( $_COOKIE['token'] ) ||
			!isset( $_SESSION['token'] ))
			return false;
		
		if( $_COOKIE['token'] != $_SESSION['token'] )
			return false;
		
		try {
			$usr= @new SQLUser();
			if( $usr->get_user_by( "token", $_SESSION['token'], "s" ) == NULL )
				return false;
		} catch( Exception $e ) {
			mov_to_error();
		}
		
		return true;
	}