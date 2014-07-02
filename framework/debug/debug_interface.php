<?php
	namespace Framework\Debug;

	interface DebugInterface{

		public function printR($mVar);
		public function mail($sTo, $sMsg);
		public function isDev();
	}