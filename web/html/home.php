<?php

	include_once( "functions/all.php" );

	if( !is_loged())
		mov_to_index( "You mast login" );

	if(( $data= $usr->get_user_by( "token", $_SESSION["token"], "s" )) == NULL )
		mov_to_error();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<style>
			li {
				border-style: solid;
				border-width: 1px;
			}

			ul {
				border-style: dashed;
				border-width: 1px;
			}
		</style>
	</head>
	<body>
		<a href="logout.php">Logout</a>
		<form action="newmessange.php" method="post">
			<input type="text" name="messange" placeholder="New messange" required />
			<input type="radio" id="public" name="check" value="public" />
			<label for="public">Public</label>
			<input type="radio" id="encrypt" name="check" value="encrypt" />
			<label for="encrypt">Encrypt</label>
			<input type="submit" value="Create new" />
		</form>
<!-- PRIVATE -->
		<ul>
			<h3>My private messanges</h3>
<?php
	try {
		$contents= $mes->get_message_by( "userId", $data["id"], "s" );
		if( $contents != NULL )
			while( $row= $contents->fetch_assoc()) {
				if( $row['encrypted'] == "no" )
					$html= "<li>" . $row["content"] . "</li>";

				else {
					$decrypt= openssl_decrypt(
						$row['content'],
						SERVER_ALGORITHM,
						SERVER_PASSWORD,
						$options=0,
						hex2bin( SERVER_IV )
					);
					$html= '<li class="two" style="color: red;">';
					$html= $html . '<div class="encrypt">' . $row["content"] . "</div>";
					$html= $html . '<div class="decrypt" style="display: none;">' . $decrypt . "</div>";
					$html= $html . "</li>";
				}

				print( $html );
			}
	} catch( Exception $e ) {
		mov_to_error();
	}
?>
		</ul>
<!-- END PRIVATE -->
<!-- PUBLIC -->
<ul>
			<h3>Public messanges</h3>
<?php
	try {
		$contents= $mes->get_message_by( "public", "yes", "s" );
		if( $contents != NULL )
			while( $row= $contents->fetch_assoc())
				print( sprintf( "<li>%s</li>", $row["content"] ));
	} catch( Exception $e ) {
		print( 'Błąd' );
		exit;
		//przeniesienie na stronę error
	}
?>
		</ul>
<!-- END PUBLIC -->
		<form enctype="multipart/form-data" action="upload.php" method="post">
			<input type="file" name="file" required />
			<input type="submit" value="Upload" />
		</form>
		<form action="download.php" method="POST">
			<ul>
<?php
	$scan= scandir( sprintf( "%s%s", FILESDIR_PATH, $data["id"]));
	$files= array_diff( $scan, array('.', '..') );
	for( $i= 2; $i < count($files)+2; $i++ ) {
		$label= '<label for="' . $i . '">' . $files[$i] . '</label>';
		$row= '<input type="radio" id="' . $i . '" name="file" value="' . $files[$i] . '" />';
		print( $row . $label . '</br>' );
	}
	if( count( $files ) != 0 )
		print( '<input type="submit" value="Download file" />' );
?>
			</ul>
		</form>
		<script>
			$('.two').on('mouseover', function(){
				$(this).children('.encrypt').hide();
				$(this).children('.decrypt').show();
			});

			$('.two').on('mouseleave', function(){
				$(this).children('.encrypt').show();
				$(this).children('.decrypt').hide();
			});
		</script>
	</body>
</html>