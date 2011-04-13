<?php

	$date = new DateTime( $tstamp );
	
	$id = $date->format( 'H-i-s' );
	$link = '#' . $id;
	$text = $date->format( 'H:i:s' );
	$text = '[' . $text . ']';
	
	echo HTML::anchor( $link, $text, array( 'id' => $id ) );

?>