<?php
	/**
	 * @method static dump($mVar, $bReturn = false)
	 * @method static printR($mVar)
	 * @method static mail($sTo, $sMsg)
	 * @method static isDev()
	 */
	class Debug extends Framework\Support\Facade\Facade{

		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor(){
			return 'debug';
		}
	}