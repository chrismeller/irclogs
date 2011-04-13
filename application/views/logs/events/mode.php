<?php

	$message = Arr::get( $line, 'message', '' );

	echo '<span class="serv mode">*** ' . $line['nick'] . ' set mode ' . HTML::chars( $message ) . '</span>';

?>