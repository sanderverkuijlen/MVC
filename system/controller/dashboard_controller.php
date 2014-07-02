<?php
	namespace Controller;

	use Framework\Base\Controller;

	class DashboardController extends Controller{

		/* Pagina's */
		public function getIndex(array $aRouteParams){

			\Debug::printR('Dashboard');
			\Debug::printR($aRouteParams);
		}
	}