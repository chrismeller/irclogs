<?php

	class Controller_SDBLogs extends Controller_Website {
		
		protected $logs = null;
		
		public function before ( ) {
			
			parent::before();
			
			$this->logs = new SDBLogs();
			
		}
		
		public function action_index ( ) {
			
			$channels = $this->logs->get_channels();
			
			$this->template->title = 'Logs';
			$this->template->content = View::factory('sdblogs/index')
				->bind('channels', $channels);
				
		}
		
		public function action_channel ( $channel ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$years = $this->logs->get_channel_years( $channel );
			
			$this->template->title = 'Logs :: ' . $channel;
			$this->template->content = View::factory('sdblogs/channel')
				->bind('channel', $channel)
				->bind('years', $years);
			
		}
		
	}

?>