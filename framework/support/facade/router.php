<?php
	/**
	 * @method static pattern($sTag, $sRegex)
	 * @method static filter($sKey, \Closure $fFunc)
	 * @method static environment($sAlias, $sRegex, array $aFilters = [])
	 * @method static path($sEnvironmentAlias, $sRegex, \Closure $fFunc, array $aFilters = [])
	 * @method static controller($sEnvironmentAlias, $sRegex, $sController, $aFilters = [], $aSettings = [])
	 * @method static resolve()
	 * @method static resolveFilter($sFilterKey)
	 */
	class Router extends Framework\Support\Facade\Facade{
		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor(){
			return 'router';
		}
	}