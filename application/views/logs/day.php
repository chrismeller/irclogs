<h1><?php echo $channel; ?>: <?php echo $year . '-' . $month . '-' . $day; ?></h1>
<ol id="content">
	
	<?php
	
		foreach ( $content as $line ) {
			
			echo '<li>';
			
			echo View::factory('logs/events/timestamp')
				->bind( 'tstamp', $line['tstamp'] )
				->bind( 'line', $line );
			
			// now just load the view for the type of event we're displaying, handing it the entire line
			echo View::factory('logs/events/' . $line['type'])->bind( 'line', $line )->bind( 'channel', $channel );
			
			echo '</li>';
			
		}
	
	?>
	
</ol>