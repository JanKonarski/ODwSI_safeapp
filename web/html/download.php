<?php

	include_once( "functions/all.php" );

	if( !is_loged())
		mov_to_index( "You mast login" );

	try {
		if(( $data= $usr->get_user_by( "token", $_SESSION["token"], "s" )) == NULL )
			mov_to_error();

		if( !isset( $_POST["file"] ))
			mov_to_home();
		
		$filename= sprintf( "%s%s/%s", FILESDIR_PATH, $data["id"], $_POST["file"] );

		header( "Content-Description: File Transfer" );
		header( "Content-Type: application/octet-stream" );
		header( "Cache-Control: no-cache, must-revalidate" );
		header( "Expires: 0" );
		header( 'Content-Disposition: attachment; filename="' . basename( $filename ) . '"');
		header( "Content-Length: " . filesize( $filename ));
		header( "Pragma: public" );

		flush();
		readfile( $filename );
	} catch( Exception $e ) {
		mov_to_error();
	}

?>