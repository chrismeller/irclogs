<h1><?php echo $channel; ?>: <?php echo $year . '-' . $month; ?></h1>
<ul id="days">
	
	<?php
	
		foreach ( $days as $day ) {
			
			$link_chan = ltrim( $channel, '#&+!' );
			$link = Route::get('sdblogs-day')->uri( array( 'channel' => $link_chan, 'year' => $year, 'month' => $month, 'day' => $day ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $year . '-' . $month . '-' . $day ) ) . '</li>';
			
		}
	
	?>
	
</ul>