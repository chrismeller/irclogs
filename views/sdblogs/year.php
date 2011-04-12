<h1><?php echo $channel; ?>: <?php echo $year; ?></h1>
<ul id="months">
	
	<?php
	
		foreach ( $months as $month ) {
			
			$link_chan = ltrim( $channel, '#&+!' );
			$link = Route::get('sdblogs-month')->uri( array( 'channel' => $link_chan, 'year' => $year, 'month' => $month ) );
			
			echo '<li>' . HTML::anchor( $link, HTML::chars( $year . '-' . $month ) ) . '</li>';
			
		}
	
	?>
	
</ul>