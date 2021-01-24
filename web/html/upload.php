<?php

	include_once( "functions/all.php" );

	if( !is_loged())
		mov_to_index( "You mast login" );
	
	try {
		if(( $data= $usr->get_user_by( "token", $_SESSION["token"], "s" )) == NULL ) {
			print( 'Błąd' );
			exit;
			//przeniesienie na stronę error
		}

		if( !isset( $_FILES["file"]) )
			mov_to_home();
		
		$path= sprintf( "%s%s/%s", FILESDIR_PATH, $data["id"], $_FILES["file"]["name"] );
		move_uploaded_file( $_FILES["file"]["tmp_name"], $path );

		mov_to_home();
	} catch( Exception $e ) {
		mov_to_error();
	}

?>