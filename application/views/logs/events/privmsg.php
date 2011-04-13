<?php

	$nick = '<' . $line['nick'] . '>';

	echo '<span class="privmsg"><span class="nick">' . HTML::chars( $nick ) . '</span> ' . Text::auto_link( HTML::chars( $line['message'] ) ) . '</span>';

?>