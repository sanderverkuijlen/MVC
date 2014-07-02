<?php
	namespace Framework\Debug;

	use Framework\Traits\Singleton;

	class Debug implements DebugInterface{
//		use Singleton;

		public function dump($mVar){
			var_dump($mVar);
		}

		public function printR($mVar, $bReturn = false){

			$sStr = '<pre>'.print_r($mVar, true).'</pre>';

			if(!$bReturn){
				echo $sStr;
			}
			else{
				return $sStr;
			}

			return null;
		}

		public function mail($sTo, $sContent){
			mail($sTo, 'DEBUG ['.SYSTEM_NAME.']: ', $sContent); //TODO: Gebruik het request object om de url aan het onderwerp te appenden
		}

		public function isDev(){
			return true;
		}
	}