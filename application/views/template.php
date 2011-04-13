<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Kohana::$charset ?>" />
	<title><?php echo $title; ?></title>
	
	<?php
	
		foreach ( $styles as $style => $media ) {
			echo HTML::style( $style, array( 'media' => $media ) ) . "\n";
		}
	
	?>
	
	<script type="text/javascript">
		var Site = {
			base_url: '<?php echo URL::site(); ?>'
		}
	</script>
	
	<?php
	
		foreach ( $scripts as $script ) {
			echo HTML::script( $script ) . "\n";
		}
	
	?>
	
</head>
<body id="<?php echo UTF8::str_ireplace( '/', '-', Request::current()->uri() ); ?>">

	<?php echo $content; ?>
	
	<!-- Rendered in {execution_time} seconds using {memory_usage} of memory -->
	
	<?php
		if ( Kohana::$environment == Kohana::DEVELOPMENT ) {
			echo View::factory('profiler/stats');
		}
	?>
	
</body>
</html>