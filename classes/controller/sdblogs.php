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
		
		public function action_year ( $channel, $year ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$months = $this->logs->get_channel_months( $channel, $year );
			
			$this->template->title = 'Logs :: ' . $channel;
			$this->template->content = View::factory('sdblogs/year')
				->bind('channel', $channel)
				->bind('year', $year)
				->bind('months', $months);
			
		}
		
		public function action_month ( $channel, $year, $month ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$days = $this->logs->get_channel_days( $channel, $year, $month );
			
			$this->template->title = 'Logs :: ' . $channel;
			$this->template->content = View::factory('sdblogs/month')
				->bind('channel', $channel)
				->bind('year', $year)
				->bind('month', $month)
				->bind('days', $days);
			
		}
	}

?>