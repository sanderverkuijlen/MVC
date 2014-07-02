<?php
	namespace Framework\Http;

	use Framework\Traits\Singleton;

	class Response implements ResponseInterface{
		use Singleton;

		static public function redirect(){
			//todo: redirect
		}

		static public function routeRedirect(){

			//todo: get route

			//todo: redirect
		}

		static public function errorRedirect(){

			//todo: redirect
		}
	}