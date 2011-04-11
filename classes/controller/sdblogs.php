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
			die('foo');
			$years = $this->logs->get_years( $channel );
			
			$this->template->title = 'Logs :: ' . $channel;
			$this->template->content = View::factory('sdblogs/channel')
				->bind('years', $years);
			
		}
		
	}

?>