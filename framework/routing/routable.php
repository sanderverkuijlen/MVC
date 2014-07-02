<?php
	namespace Framework\Routing;

	abstract class Routable{

//		const PATTERN_REGEX = '/\\\\\((\/?[a-z_]+)(?:\\\\\:([a-z_]+))?\\\\\)/';
		const PATTERN_REGEX = '/\\\\\(((?:\\\\\/)*)([a-z_]+)(?:\\\\\:([a-z_]+))?\\\\\)/';  //Zoals het werkt in RegExr: \\\(((?:\?|\\/)*)([a-z]+)(?::([a-z]+))?\\\)

		protected function prepareRegex($sUrl){

			//Trim slashes
			$sUrl = trim($sUrl, '/');
			$sUrl = preg_quote($sUrl, '/');

			return $sUrl;
		}

		protected function cleanUrl($sUrl){

			//Trim slashes
			$sUrl = trim($sUrl, '/');

			return $sUrl;
		}

		protected function replaceTags($aMatches, array &$aAppliedPatterns, $aPattern){
			$sMatchedRegex  = $aMatches[0];
			$aModifiers     = str_split(stripslashes($aMatches[1]));
			$sTag           = $aMatches[2];
			$sAlias         = (isset($aMatches[3]) ? $aMatches[3] : $aMatches[2]);

			$sTag = stripslashes($sTag);

			if(array_key_exists($sTag, $aPattern)){

				//Bijhouden dat deze tag is gebruikt
				$aAppliedPatterns[] = $sAlias;

				$sPatternRegex = $aPattern[$sTag];

				//Check de / modifier (optioneel, vooraf gegaan door een slash)
				if(in_array('/', $aModifiers)){
					$sPatternRegex = '?:\/('.$sPatternRegex.')';
				}

				//Wrap $sPatternRegex in haakjes zodat het een capturing group wordt
				$sPatternRegex = '('.$sPatternRegex.')';

				//Check de ? modifier (optioneel)
				if(in_array('?', $aModifiers) || in_array('/', $aModifiers)){
					$sPatternRegex .= '?';
				}

				return $sPatternRegex;
			}

			return $sMatchedRegex;
		}

		protected function preparePatternRegex($sRegex, $aPattern, array &$aAppliedPatterns){

			$sRegex = $this->prepareRegex($sRegex);

			$fFunc = function($aMatches) use(&$aAppliedPatterns, $aPattern){
				return $this->replaceTags($aMatches, $aAppliedPatterns, $aPattern);
			};

			$sRegex = preg_replace_callback(self::PATTERN_REGEX, $fFunc, $sRegex);

			return $sRegex;
		}
	}