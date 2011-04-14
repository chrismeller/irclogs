<?php

	$date = new DateTime( $tstamp );
	
	$id = $date->format( 'H-i-s' );
	
	$channel = Arr::get( $line, 'channel' );
	// trim off the crap
	$channel = ltrim( $channel, '#&+!' );
	
	$year = $date->format( 'Y' );
	$month = $date->format( 'm' );
	$day = $date->format( 'd' );
	
	$link = Route::get('logs-day')->uri( array( 'channel' => $channel, 'year' => $year, 'month' => $month, 'day' => $day ) );
	
	$text = $date->format( 'H:i:s' );
	$text = '[' . $text . ']';
	$title = $date->format( DateTime::ISO8601 );
	
	echo HTML::anchor( $link . '#' . $id, $text, array( 'id' => $id, 'class' => 'timestamp', 'title' => $title ) );

?>