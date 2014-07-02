<?php
	namespace Framework\Routing;

	/* @var \Framework\Routing\Router */
	interface RouterInterface{

		public function pattern($sTagName, $sRegexPattern);

		public function filter($sKey, \Closure $fFunc);

		public function environment($sAlias, $sRegex, array $aFilters = []);

		public function path($sEnvironmentAlias, $sRegex, \Closure $fCallback, array $aFilters = []);

		public function controller($sEnvironmentAlias, $sRegex, $sController, $aFilters = [], $aSettings = []);

		public function resolve();

		public function resolveFilter($sFilterKey);
	}