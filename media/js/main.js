var Logs = {
	
	running: false,
	
	init: function ( ) {
		
		if ( $('ol#content').length == 0 ) {
			return;
		}
		
		$(window).bind( 'scroll', Logs.scroll );
		
	},

	scroll: function ( ) {
		
		if ( $(window).scrollTop() >= $(document).height() - ( $(window).height() * 3 ) ) {
			
			Logs.fetch();
			
		}
		
	},
	
	fetch: function ( ) {
		
		// if we're already running there's nothing to do
		if ( Logs.running ) {
			return;
		}
		
		// if there is no more to get
		if ( Logs.next_token == '' || Logs.next_token == undefined ) {
			return;
		}
		
		// set the running flag
		Logs.running = true;
		
		var url = Site.base_url + Logs.channel + '/' + Logs.year + '/' + Logs.month + '/' + Logs.day + '/' + Logs.next_token;
		
		$.ajax( {
			url: url,
			dataType: 'json',
			success: Logs.success,
			error: Logs.error
		} );
		
	},
	
	success: function ( data ) {
		
		// pull out contents from the response
		var contents = data.content;
		var next_token = data.next_token;
		
		// set the next token for the next request
		Logs.next_token = next_token;
		
		// and append the contents
		$('ol#content').append( contents );
		
		// turn off the running flag
		Logs.running = false;
		
	},
	
	error: function ( ) {
		
		// turn off the running flag
		Logs.running = false;
		
	}
	
};

$(document).ready( function () {
	Logs.init();
} );