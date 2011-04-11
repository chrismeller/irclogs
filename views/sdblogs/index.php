<h1>Available Channels</h1>
<ul id="channels">
	
	<?php
	
		foreach ( $channels as $chan ) {
			
			$link_chan = ltrim( $chan, '#&+!' );
			$link = Route::get('sdblogs-channel')->uri( array( 'channel' => $link_chan ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $chan ) ) . '</li>';
			
		}
	
	?>
	
</ul>