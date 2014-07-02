<?php
	namespace Framework\Templating;

	/* @var \Framework\Templating\View */
	interface ViewInterface{

		/**
		 * @param $sKey
		 * @param $mValue
		 *
		 * @return \Framework\Templating\ViewInterface
		 */
		public function with($sKey, $mValue);

		/**
		 * @param $sAlias
		 * @param $sPath
		 * @param $aData
		 *
		 * @return \Framework\Templating\ViewInterface
		 */
		public function nest($sAlias, $sPath, $aData);

		public function render();
	}