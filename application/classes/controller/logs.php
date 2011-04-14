<?php

	class Controller_Logs extends Controller_Website {
		
		protected $logs = null;
		
		public function before ( ) {
			
			parent::before();
			
			$this->logs = new SDBLogs();
			
		}
		
		public function action_index ( ) {
			
			$channels = $this->logs->get_channels();
			
			$this->template->title = 'Logs';
			$this->template->content = View::factory('logs/index')
				->bind('channels', $channels);
				
		}
		
		public function action_channel ( $channel ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$years = $this->logs->get_channel_years( $channel );
			
			$this->template->title = $channel;
			$this->template->content = View::factory('logs/channel')
				->bind('channel', $channel)
				->bind('years', $years);
			
		}
		
		public function action_year ( $channel, $year ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$months = $this->logs->get_channel_months( $channel, $year );
			
			$this->template->title = $channel;
			$this->template->content = View::factory('logs/year')
				->bind('channel', $channel)
				->bind('year', $year)
				->bind('months', $months);
			
		}
		
		public function action_month ( $channel, $year, $month ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$days = $this->logs->get_channel_days( $channel, $year, $month );
			
			$this->template->title = $channel;
			$this->template->content = View::factory('logs/month')
				->bind('channel', $channel)
				->bind('year', $year)
				->bind('month', $month)
				->bind('days', $days);
			
		}
		
		public function action_day ( $channel, $year, $month, $day ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$result = $this->logs->get_channel_content( $channel, $year, $month, $day );
			
			$content = $result['response'];
			$next_token = $result['next_token'];
			
			$this->template->title = $channel;
			$this->template->content = View::factory('logs/day')
				->bind('channel', $channel)
				->bind('year', $year)
				->bind('month', $month)
				->bind('day', $day)
				->bind('content', $content)
				->bind('next_token', $next_token);
			
		}
		
		public function action_grep ( $channel, $grep ) {
			
			// get the full channel name
			$channel = $this->logs->get_channel_name($channel);
			
			$result = $this->logs->get_channel_grep( $channel, $grep );
			
			$content = $result['response'];
			$next_token = $result['next_token'];
			
			$this->template->title = $channel;
			$this->template->content = View::factory('logs/grep')
				->bind('channel', $channel)
				->bind('grep', $grep)
				->bind('content', $content)
				->bind('next_token', $next_token);
			
		}
		
		public function load_test_data ( ) {
			
			require_once( Kohana::find_file( 'vendor', 'awstools/aws' ) );
			
			$data_domain = Kohana::config( 'sdb-logs-viewer.data_domain' );
			$index_domain = Kohana::config( 'sdb-logs-viewer.index_domain' );
			$aws_key = Kohana::config( 'sdb-logs-viewer.aws_key' );
			$aws_secret = Kohana::config( 'sdb-logs-viewer.aws_secret' );
			
			$sdb = new SimpleDB( $aws_key, $aws_secret );
			
			$channels = array(
				'#habari' => '#habari',
				'#mellershole' => '#mellershole',
			);
			
			$sdb->put_attributes( $index_domain, 'channels', $channels );
			
			$sdb->put_attributes( $index_domain, '#habari', array( '2011' => '2011', '2010' => '2010' ) );
			$sdb->put_attributes( $index_domain, '#mellershole', array( '2009' => '2009' ) );
			
			$sdb->put_attributes( $index_domain, '#habari-2011', array( '01' => '01', '02' => '02', '03' => '03', '04' => '04' ) );
			$sdb->put_attributes( $index_domain, '#habari-2010', array( '11' => '11', '12' => '12' ) );
			
			$sdb->put_attributes( $index_domain, '#mellershole-2009', array( '12' => '12' ) );
			
			$sdb->put_attributes( $index_domain, '#habari-2011-01', array( '01' => '01', '02' => '02' ) );
			$sdb->put_attributes( $index_domain, '#habari-2011-02', array( '03' => '03', '04' => '04' ) );
			
			$sdb->put_attributes( $index_domain, '#mellershole-2009-12', array( '30' => '30', '31' => '31' ) );
			
		}
		
	}

?>