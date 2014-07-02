<?php
	/**
	 * @method static make($sClass, array $aArgs = [])
	 * @method static call($mObject, $sFunc)
	 * @method static alias($sAlias, $sClass)
	 * @method static unalias($sAlias)
	 * @method static bind($sBind, $sClass)
	 * @method static unbind($sBind)
	 * @method static register($sAlias, $mMixed)
	 * @method static unregister($sAlias)
	 * @method static mock($sAlias, $sClass)
	 * @method static unmock($sAlias)
	 */
	class Factory extends Framework\Support\Facade\Facade{

		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor(){
			return 'factory';
		}
	}