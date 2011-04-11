<?php

	class SDBLogs {
		
		protected $sdb = null;
		
		protected $index_domain;
		protected $data_domain;
		
		public function __construct ( ) {
			
			require_once( Kohana::find_file( 'vendor', 'awstools/aws' ) );
			
			$this->data_domain = Kohana::config( 'sdb-logs-viewer.data_domain' );
			$this->index_domain = Kohana::config( 'sdb-logs-viewer.index_domain' );
			$aws_key = Kohana::config( 'sdb-logs-viewer.aws_key' );
			$aws_secret = Kohana::config( 'sdb-logs-viewer.aws_secret' );
			
			$this->sdb = new SimpleDB( $aws_key, $aws_secret );
			
		}
		
		public function get_channels ( ) {
			
			$result = $this->sdb->select( 'select * from ' . $this->index_domain . ' where itemName() = \'channels\'' );
			
			$channels = array();
			foreach ( $result->response as $item ) {
				
				foreach ( $item->Attribute as $attribute ) {
					
					$channels[] = (string)$attribute->Name;
					
				}
				
			}
			
			return $channels;
			
		}
		
		public function get_channel_name ( $channel ) {
			
			$channels = $this->get_channels();
			
			foreach ( $channels as $c ) {
				
				if ( ltrim( $c, '#&+!' ) == $channel ) {
					return $channel;
				}
				
			}
			
			return false;
			
		}
		
		public function get_channel_years ( $channel ) {
			
			$result = $this->sdb->select( 'select * from ' . $this->index_domain . ' where itemName() = \'' . $channel . '\'' );
			
			$years = array();
			foreach ( $result->response as $item ) {
				
				foreach ( $item->Attribute as $attribute ) {
					
					$years[] = (string)$attribute->Name;
					
				}
				
			}
			
			return $years;
					
			
		}
		
	}

?>