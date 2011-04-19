<h1><?php echo $channel; ?>: <?php echo $year; ?></h1>
<ol id="months">
	
	<?php
	
		foreach ( $months as $month ) {
			
			$link_chan = SDBLogs::trim_chan( $channel );
			$link = Route::get('logs-month')->uri( array( 'channel' => $link_chan, 'year' => $year, 'month' => $month ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $year . '-' . $month ) ) . '</li>';
			
		}
	
	?>
	
</ol>