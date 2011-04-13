<?php

	$nick = '<' . $line['nick'] . '>';

	echo '<span class="privmsg"><span class="nick">' . HTML::chars( $nick ) . '</span> ' . HTML::chars( $line['message'] ) . '</span>';

?>