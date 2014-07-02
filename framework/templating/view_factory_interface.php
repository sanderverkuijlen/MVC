<?php
	namespace Framework\Templating;

	/* @var \Framework\Templating\ViewFactory */
	interface ViewFactoryInterface{

		/**
		 * @param       $sPath
		 * @param array $aData
		 *
		 * @return View
		 */
		public function make($sPath, array $aData = []);

		/**
		 * @param $sPath
		 *
		 * @return mixed
		 */
		public function exists($sPath);
	}