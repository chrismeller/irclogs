<?php
	
	$lines = array();
	foreach ( $content as $line ) {
		
		$c = '<li>';
		
		$c .= View::factory('logs/events/timestamp')
			->bind( 'tstamp', $line['tstamp'] )
			->bind( 'line', $line );
		
		// now just load the view for the type of event we're displaying, handing it the entire line
		$c .= View::factory('logs/events/' . $line['type'])->bind( 'line', $line )->bind( 'channel', $channel );
		
		$c .= '</li>';
		
		$lines[] = $c;
		
	}
	
	$content = implode("\n", $lines);
	echo json_encode( array( 'next_token' => $next_token, 'content' => $content ) );

?>