<h1><?php echo $channel; ?> Logs</h1>
<ol id="years">
	
	<?php
	
		foreach ( $years as $year ) {
			
			$link_chan = ltrim( $channel, '#&+!' );
			$link = Route::get('sdblogs-year')->uri( array( 'channel' => $link_chan, 'year' => $year ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $year ) ) . '</li>';
			
		}
	
	?>
	
</ol>