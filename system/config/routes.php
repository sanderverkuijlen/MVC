<?php
	//Patterns
	Router::pattern('id',           '[0-9]+');
	Router::pattern('id_token',     '[a-z_]+[0-9]+');
	Router::pattern('controller',   '[a-z_]+');
	Router::pattern('action',       '[a-z_]+');
	Router::pattern('catchall',     '.*');

	//Filters
	Router::filter('https', function(){
		return ($_SERVER['HTTPS'] == 'on');
	});
	Router::filter('beheerder_login', function(){
		return true; //Hier zou eigenlijk gecontroleerd moeten worden of er een beheerder is ingelogd
	});

	//Environments
	Router::environment('beheer',   'beheer',                           ['https', 'beheerder_login']    );
	Router::environment('front',    '',                                 ['!https']                      );

	//Default environment (bijvoorbeeld voor error-pagina's, altijd als laatste)
	Router::environment(null,       '');


	//One-page promotie website
	Router::path('front', '', function($aRouteParams){

		echo 'MVC Prototype!';

	});


	//De environment /beheer/ werkt alleen op HTTPS, dus redirecten we de non-HTTPS requests die beginnen met /beheer/
	Router::path(null, 'beheer(/catchall:url)', function($aRouteParams){

		header('Location: https://'.$_SERVER['HTTP_HOST'].'/beheer/'.$aRouteParams['url']);

	}, ['!https']);


	//Op /beheer/ moet het dashboard getoond worden, dit is de taak van de DashboardController
	Router::path('beheer', '', function($aRouteParams){

		/* @var $oDashboardController Controller\DashboardController */
		$oDashboardController = Factory::make('Controller\DashboardController');

		$oDashboardController->getIndex($aRouteParams);

	});

	//De demo werkt met $_SESSION in plaats van een database, deze url zorgt voor een reset
	Router::path(null, 'destroy', function($aRouteParams){

		session_destroy();
	});

	//	Router::path('beheer', '', 'Controller\DashboardController@getIndex');

	//Voor controllers gaan we niet iedere url apart vastleggen, die registreren we voor de hele controller in één keer
	Router::controller('beheer',    'dashboard',    'Controller\DashboardController');
	Router::controller('beheer',    'artiest',      'Controller\ArtiestController');
	Router::controller('beheer',    'festival',     'Controller\FestivalController');