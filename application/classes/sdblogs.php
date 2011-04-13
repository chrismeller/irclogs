<?php

	class SDBLogs {
		
		protected $sdb = null;
		
		protected $index_domain;
		protected $data_domain;
		
		public function __construct ( ) {
			
			require_once( Kohana::find_file( 'vendor', 'awstools/aws' ) );
			
			$this->data_domain = Kohana::config( 'logs.data_domain' );
			$this->index_domain = Kohana::config( 'logs.index_domain' );
			$aws_key = Kohana::config( 'logs.aws_key' );
			$aws_secret = Kohana::config( 'logs.aws_secret' );
			
			$this->sdb = new SimpleDB( $aws_key, $aws_secret );
			
		}
		
		public function get_channels ( ) {
			
			$benchmark = Profiler::start('sdblogs', 'get_channels');
			
			$result = $this->sdb->select( 'select * from ' . $this->index_domain . ' where itemName() = \'channels\'' );
			
			Profiler::stop( $benchmark );
			
			$channels = array();
			foreach ( $result->response as $item ) {
				
				foreach ( $item->Attribute as $attribute ) {
					
					$channels[] = (string)$attribute->Name;
					
				}
				
			}
			
			natsort($channels);
			
			return $channels;
			
		}
		
		public function get_channel_name ( $channel ) {
			
			$channels = $this->get_channels();
			
			foreach ( $channels as $c ) {
				
				if ( ltrim( $c, '#&+!' ) == $channel ) {
					return $c;
				}
				
			}
			
			return $channel;
			
		}
		
		public function get_channel_years ( $channel ) {
			
			$benchmark = Profiler::start('sdblogs', 'get_channel_years');
			
			$result = $this->sdb->select( 'select * from ' . $this->index_domain . ' where itemName() = \'' . $channel . '\'' );
			
			Profiler::stop( $benchmark );
			
			$years = array();
			foreach ( $result->response as $item ) {
				
				foreach ( $item->Attribute as $attribute ) {
					
					$years[] = (string)$attribute->Name;
					
				}
				
			}
			
			natsort($years);
			$years = array_reverse( $years );	// reverse of natsort
			
			return $years;
			
		}
		
		public function get_channel_months ( $channel, $year ) {
			
			$benchmark = Profiler::start('sdblogs', 'get_channel_months');
			
			$result = $this->sdb->select( 'select * from ' . $this->index_domain . ' where itemName() = \'' . $channel . '-' . $year . '\'' );
			
			Profiler::stop( $benchmark );
			
			$months = array();
			foreach ( $result->response as $item ) {
				
				foreach ( $item->Attribute as $attribute ) {
					
					$months[] = (string)$attribute->Name;
					
				}
				
			}
			
			natsort($months);
			$months = array_reverse( $months );	// reverse of natsort
			
			return $months;
			
		}
		
		public function get_channel_days ( $channel, $year, $month ) {
			
			$benchmark = Profiler::start('sdblogs', 'get_channel_days');
			
			$result = $this->sdb->select( 'select * from ' . $this->index_domain . ' where itemName() = \'' . $channel . '-' . $year . '-' . $month . '\'' );
			
			Profiler::stop( $benchmark );
			
			$days = array();
			foreach ( $result->response as $item ) {
				
				foreach ( $item->Attribute as $attribute ) {
					
					$days[] = (string)$attribute->Name;
					
				}
				
			}
			
			natsort($days);
			$days = array_reverse( $days );		// reverse of natsort
			
			return $days;
			
		}
		
		public function get_channel_content ( $channel, $year, $month, $day ) {
			
			$benchmark = Profiler::start('sdblogs', 'get_channel_content');
			
			$key = implode( '-', array( $year, $month, $day ) ) . '%';
			$query = $this->build_channel_query( $channel, $year, $month, $day );
			
			$result = $this->sdb->select( $query );
			
			Profiler::stop( $benchmark );
			
			return $result;
			
		}
		
		public function get_more_channel_content ( $channel, $year, $month, $day, $next_token ) {
			
			$benchmark = Profiler::start('sdblogs', 'get_more_channel_content');
			
			$query = $this->build_channel_query($channel, $year, $month, $day);
			
			$result = $this->sdb->select( $query, false, array( 'NextToken' => $next_token ) );
			
			Profiler::stop( $benchmark );
			
			return $result;
			
		}
		
		private function build_channel_query ( $channel, $year, $month, $day ) {
			
			$key = implode( '-', array( $year, $month, $day ) ) . '%';
			
			$query = 'select * from ' . $this->data_domain . ' where channel = \'' . $channel . '\' and tstamp like \'' . $key . '\'';
			
			return $query;
			
		}
		
	}

?>