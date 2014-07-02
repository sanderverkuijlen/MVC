<?php
	/**
	 * @method static method()
	 * @method static url()
	 * @method static format()
	 * @method static secure()
	 * @method static ajax()
	 * @method static ip()
	 * @method static wantsJson()
	 */
	class Request extends Framework\Support\Facade\Facade{

		protected static function getFacadeAccessor(){
			return 'request';
		}
	}