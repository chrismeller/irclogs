<h1><?php echo $channel; ?> Logs</h1>
<ul id="years">
	
	<?php
	
		foreach ( $years as $year ) {
			
			$link_chan = ltrim( $channel, '#&+!' );
			$link = Route::get('sdblogs-year')->uri( array( 'channel' => $link_chan, 'year' => $year ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $chan ) ) . '</li>';
			
		}
	
	?>
	
</ul>