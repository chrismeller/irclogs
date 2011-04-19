<h1>Available Channels</h1>
<ol id="channels">
	
	<?php
	
		foreach ( $channels as $chan ) {
			
			$link_chan = SDBLogs::trim_chan( $channel );
			$link = Route::get('logs-channel')->uri( array( 'channel' => $link_chan ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $chan ) ) . '</li>';
			
		}
	
	?>
	
</ol>