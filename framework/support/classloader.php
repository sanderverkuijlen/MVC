<?php
	namespace Framework\Support;

	class ClassloaderException extends \Exception{

		public function __construct($sClassName, $sPath){
			$sMsg = '['.get_class($this).']: Class "'.$sClassName.'" was expected in file "'.$sPath.'" but could not be found.';
			parent::__construct($sMsg);
		}
	}

	class Classloader{

		public static function register(){
			spl_autoload_register(array(get_called_class(), 'load'));
		}

		public static function load($sClassName){

			//Trim overbodige slashes
			$sClassName = trim($sClassName, '\\');

			//Split op slashes
			$aClassPath = explode('\\', $sClassName);

			//Stel het pad naar het bestand samen
			$sPath = ROOT;
			for($i = 0; $i < sizeof($aClassPath); $i++){

				//Check of deze klasse een Facade is (deze klassen zitten in de globale namespace maar de bestanden staan in de directory FRAMEWORK_MAP/support/facade/)
				if($i == 0 && sizeof($aClassPath) == 1 && file_exists(FRAMEWORK_ROOT.'support/facade/'.self::normalize($aClassPath[$i]).'.php')){
					$sPath .= FRAMEWORK_MAP.'support/facade/';
				}
				//Als het geen framework klasse is dan begint het pad in de SYSTEM_MAP
				elseif($i == 0 && strtolower($aClassPath[$i]).'/' != FRAMEWORK_MAP){
					$sPath .= SYSTEM_MAP;
				}

				//Normalize de naam (lowercase, snake_case ipv CamelCase)
				$sClassPart = self::normalize($aClassPath[$i]);
				$sPath .= $sClassPart;

				//Eind de part met een slash (voor mappen) of .php voor het uiteindelijke bestand
				if($i == sizeof($aClassPath)-1){
					$sPath .= '.php';
				}
				else{
					$sPath .= '/';
				}
			}

			//Check of er daadwerkelijk een bestand is met het pad dat we bedacht hebben
			if(file_exists($sPath)){

				//Laad het bestand
				require_once($sPath);
				return;
			}
			else{
				//Bestand niet gevonden, gooi een error
				throw new ClassloaderException($sClassName, $sPath);
			}
		}

		private static function normalize($sClassPart){

			$sClassPart = preg_replace('/([A-Z]+)/', '_$1', $sClassPart);
			$sClassPart = strtolower($sClassPart);

			$sClassPart = ltrim($sClassPart, '_');

			return $sClassPart;
		}
	}

	Classloader::register();