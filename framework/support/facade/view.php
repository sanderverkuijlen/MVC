<?php
	/**
	 * @method static \Framework\Templating\ViewInterface make($sPath, array $aData = [])
	 * @method static exists($sPath)
	 */
	class View extends Framework\Support\Facade\Facade{

		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor(){
			return 'view';
		}
	}