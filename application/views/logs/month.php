<h1><?php echo $channel; ?>: <?php echo $year . '-' . $month; ?></h1>
<ol id="days">
	
	<?php
	
		foreach ( $days as $day ) {
			
			$link_chan = SDBLogs::trim_chan( $channel );
			$link = Route::get('logs-day')->uri( array( 'channel' => $link_chan, 'year' => $year, 'month' => $month, 'day' => $day ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $year . '-' . $month . '-' . $day ) ) . '</li>';
			
		}
	
	?>
	
</ol>