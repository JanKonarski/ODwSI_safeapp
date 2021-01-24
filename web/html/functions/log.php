<?php

	include_once( "../config.php" );

	class Log {
		protected $handle;

		public function __construct() {
			$this->handle= fopen( LOGFILE_PATH . "/log.txt", "a+" );
		}

		public function log( $mes ) {
			$datetime= date( "Y-m-d h:m:s" );
			$content= sprintf( "[%s] %s\n", $datetime, $mes );
			fwrite( $this->handle, $content );

			$STDOUT= fopen( "php://stdout", "w" );
			fwrite( $STDOUT, $content );
			fclose( $STDOUT );
		}

		public function __destruct() {
			fclose( $this->handle );
		}
	}