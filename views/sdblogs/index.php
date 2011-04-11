<ul id="channels">
	
	<?php
	
		foreach ( $channels as $chan ) {
			
			$link = Route::get('sdblogs-channel')->uri( array( 'channel' => $chan ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $chan ) ) . '</li>';
			
		}
	
	?>
	
</ul>