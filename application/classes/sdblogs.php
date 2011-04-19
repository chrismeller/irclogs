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
			
			$this->cache = Cache::instance( 'sdblogs' );
			
		}
		
		public function get_channels ( ) {
			
			if ( $this->cache->get( 'channels' ) !== null ) {
				return $this->cache->get( 'channels' );
			}
			
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
			
			$this->cache->set( 'channels', $channels );
			
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
			
			$cache_key = 'channel_years:' . $channel;
			if ( $this->cache->get( $cache_key ) !== null ) {
				return $this->cache->get( $cache_key );
			}
			
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
			
			$this->cache->set( $cache_key, $years );
			
			return $years;
			
		}
		
		public function get_channel_months ( $channel, $year ) {
			
			$cache_key = 'channel_months:' . $channel . ':' . $year;
			if ( $this->cache->get( $cache_key ) !== null ) {
				return $this->cache->get( $cache_key );
			}
			
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
			
			$this->cache->set( $cache_key, $months );
			
			return $months;
			
		}
		
		public function get_channel_days ( $channel, $year, $month ) {
			
			$cache_key = 'cahnnel_days:' . $channel . ':' . $year . ':' . $month;
			if ( $this->cache->get( $cache_key ) !== null ) {
				return $this->cache->get( $cache_key );
			}
			
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
			
			$this->cache->set( $cache_key, $days );
			
			return $days;
			
		}
		
		public function get_channel_content ( $channel, $year, $month, $day, $next_token = null ) {
			
			$cache_key = 'channel_content:' . implode( ':', array( $channel, $year, $month, $day, $next_token ) );
			if ( $this->cache->get( $cache_key ) !== null ) {
				return $this->cache->get( $cache_key );
			}
			
			$benchmark = Profiler::start('sdblogs', 'get_channel_content');
			
			$key = implode( '-', array( $year, $month, $day ) ) . '%';
			$query = $this->build_channel_query( $channel, $year, $month, $day );
			
			if ( $next_token != null ) {
				$options = array( 'NextToken' => $next_token );
			}
			else {
				$options = array();
			}
			
			$result = $this->sdb->select( $query, false, $options );
						
			$result = $this->process_result( $result );
						
			Profiler::stop( $benchmark );
			
			$this->cache->set( $cache_key, $result );
			
			return $result;
			
		}
		
		public function get_channel_grep ( $channel, $grep ) {
			
			$cache_key = 'channel_grep:' . $channel . ':' . $grep;
			if ( $this->cache->get( $cache_key ) !== null ) {
				return $this->cache->get( $cache_key );
			}
			
			$benchmark = Profiler::start('sdblogs', 'get_channel_grep');
			
			// the tstamp like is included because it has to be in order to sort by it - stupid aws
			$query = 'select * from ' . $this->data_domain . ' where channel = \'' . $channel . '\' and tstamp like \'%\' and message like \'%' . $grep . '%\' order by tstamp desc';
			
			$result = $this->sdb->select( $query );
			
			$result = $this->process_result( $result );
			
			Profiler::stop( $benchmark );
			
			$this->cache->set( $cache_key, $result );
			
			return $result;
			
		}
		
		private function build_channel_query ( $channel, $year, $month, $day ) {
			
			$key = implode( '-', array( $year, $month, $day ) ) . '%';
			
			$query = 'select * from ' . $this->data_domain . ' where channel = \'' . $channel . '\' and tstamp like \'' . $key . '\' order by tstamp asc';
			
			return $query;
			
		}
		
		private function process_result ( $result ) {
			
			// convert the object to a real array and compress our attributes
			$results = array();
			foreach ( $result->response as $r ) {
				
				$name = (string)$r->Name;
				
				$results[ $name ] = array();
				
				foreach ( $r->Attribute as $a ) {
					$a = (array)$a;
					
					if ( empty( $a['Value'] ) ) {
						continue;
					}
					
					$results[ $name ][ $a['Name'] ] = $a['Value'];
				}
			}
			
			$result = array(
				'next_token' => $result->next_token,
				'response' => $results,
			);
			
			return $result;
			
		}
		
		public static function trim_chan ( $name ) {
			
			return ltrim( $channel, '#&+!' );
			
		}
		
	}

?>