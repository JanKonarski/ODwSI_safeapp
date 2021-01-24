<?php

	include_once( "../config.php" );
	include_once( "functions/log.php" );
	include_once( "functions/sql.php" );
	include_once( "functions/additional.php" );
	include_once( "functions/authentication.php" );

	try {
		$usr= @new SQLUser();
		$mes= @new SQLMessange();
		$log= @new Log();
	} catch( Exception $e ) {
		mov_to_error();
	}