<?php

	function mov_to_index( $err="" ) {
		$loc= "Location: index.php";
		if( $err != "" ) {
			$err= preg_replace( "/ /", "%20", $err );
			$loc= $loc . "?err=" . $err;
		}

		header( $loc );
		exit;
	}

	function mov_to_home() {
		header( "Location: home.php" );
		exit;
	}

	function mov_to_error() {
		header( "Location: error.php" );
		exit;
	}

	function generate_id() {
		return md5( uniqid( mt_rand(), true ));
	}

	function sanitization( $content ) {
		return htmlentities( $content, ENT_QUOTES, "UTF-8" );
	}