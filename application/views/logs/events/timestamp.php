<?php

	$date = new DateTime( $tstamp );
	
	$id = $date->format( 'H-i-s' );
	$link = '#' . $id;
	$text = $date->format( 'H:i:s' );
	$text = '[' . $text . ']';
	$title = $date->format( DateTime::ISO8601 );
	
	echo HTML::anchor( $link, $text, array( 'id' => $id, 'class' => 'timestamp', 'title' => $title ) );

?>