<h1><?php echo $channel; ?>: <?php echo $year . '-' . $month . '-' . $day; ?></h1>
<ol id="content">
	
	<?php
	
		foreach ( $content as $line ) {
			echo '<li>' . $line . '</li>';
		}
	
	?>
	
</ol>