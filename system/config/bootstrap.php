<?php
	//Configuratie
	require_once($sIncludePath.'system/config/config.php');

	session_start();

	//Autoloading
	require_once($sIncludePath.'framework/support/classloader.php');

	//Inversion of Control (Dependency Injection)
	$oFactory = new Framework\Factory\Factory;                      //IoC factory instantieëren
	$oFactory->alias('factory', 'Framework\Factory\Factory');       //Alias instellen voor de IoC factory zodat de facade hieraan gekoppeld wordt
	Framework\Support\Facade\Facade::setFacadeApp($oFactory);       //Referentie opslaan in de Facade klasse, anders werkt de Factory facade niet
	unset($oFactory);

	//Handige aliasen instellen voor framework klassen
	//TODO: Util
	Factory::alias('debug',     'Framework\Debug\DebugInterface');
	//TODO: Get
	//TODO: Post
	//TODO: Session
	//TODO: Cookie
	Factory::alias('request',   'Framework\Http\RequestInterface');
	Factory::alias('response',  'Framework\Http\ResponseInterface');
	//TODO: Auth
	//TODO: Validator
	Factory::alias('router',    'Framework\Routing\RouterInterface');
	Factory::alias('view',      'Framework\Templating\ViewFactoryInterface');

	//Interface bindings
	Factory::bind('Framework\Debug\DebugInterface',             'Framework\Debug\Debug');
	Factory::bind('Framework\Http\RequestInterface',            'Framework\Http\Request');
	Factory::bind('Framework\Http\ResponseInterface',           'Framework\Http\Response');
	Factory::bind('Framework\Routing\RouterInterface',          'Framework\Routing\Router');
	Factory::bind('Framework\Templating\ViewFactoryInterface',  'Framework\Templating\ViewFactory');

	//TODO: Bepaal instantie, security, taal, formtoken, etc

	//Laad de beschikbare routes
	require_once($sIncludePath.'system/config/routes.php');