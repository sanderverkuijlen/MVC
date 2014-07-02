<?php
	namespace Framework\Http;

	use Framework\Traits\Singleton;

	class Request implements RequestInterface{
		use Singleton;

		public function method(){
			return $_SERVER['REQUEST_METHOD'];
		}

		public function url(){
			return str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
		}

		public function format(){
			return 'html'; //TODO: temp
		}

		public function secure(){
			return ($_SERVER['HTTPS']);
		}

		public function ajax(){
			return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
		}

		public function ip(){
			return $_SERVER['REMOTE_ADDR'];
		}

		public function wantsJson(){
			return false; //TODO: temp
		}
	}