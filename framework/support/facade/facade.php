<?php
	namespace Framework\Support\Facade;

	abstract class Facade{

		/* @var $oApp \Framework\Factory\Factory */
		protected static $oApp = null;

		public static function setFacadeApp($oApp){
			static::$oApp = $oApp;
		}
		public static function getFacadeApp(){
			return static::$oApp;
		}

		/**
		 * Get the registered name of the component.
		 *
		 * @return string
		 */
		protected static function getFacadeAccessor(){
			return 'test'; //TODO: throw een FacadeException ofzo
		}

		//Voorkomt fatal errors bij foute routes en gooit in plaats daarvan een exception op
		public static function __callStatic($sName, $aArgs){

			//Haal de juiste klasse uit de factory
			$oInstance = static::$oApp->make(static::getFacadeAccessor());

			//Call de juiste functie ($sName) met de parameters ($aArgs)
			return call_user_func_array(array($oInstance, $sName), $aArgs);
		}

		public static function obj(){
			return static::$oApp->make(static::getFacadeAccessor());
		}
	}