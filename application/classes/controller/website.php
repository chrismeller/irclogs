<?php

	abstract class Controller_Website extends Controller_Template {
		
		public function before ( ) {
			
			parent::before();
			
			$this->template->styles = array(
				'media/css/style.css' => 'screen',
			);
			
			$this->template->scripts = array(
				'media/js/jquery.min.js',
				'media/js/main.js',
			);
			
		}
		
		public function after ( ) {
			
			// figure out the title of the page, based on the configured site title
			if ( isset( $this->template->title ) && !empty( $this->template->title ) ) {
				$this->template->title = $this->template->title . ' | ' . Kohana::config( 'site.title' );
			}
			else {
				$this->template->title = Kohana::config( 'site.title' );
			}
			
			// if no content was specified, blank it out so the template doesn't generate an error
			if ( !isset( $this->template->content ) ) {
				$this->template->content = '';
			}
			
			parent::after();
			
		}
		
	}

?>