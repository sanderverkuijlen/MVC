<?php
	class Response extends Framework\Support\Facade\Facade{

		protected static function getFacadeAccessor(){
			return 'response';
		}
	}