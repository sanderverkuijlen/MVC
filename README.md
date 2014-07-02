
-------------------------------------------------------------------------------
--- NIET VERGETEN! --- Ctrl+Alt+Click = Ctrl+Click voor functies uit interfaces
-------------------------------------------------------------------------------

===============================================================================
====== MVC ====================================================================
===============================================================================


-------------------------------------------------------------------------------
--- TODO'S
-------------------------------------------------------------------------------

1. Class handling:
	- Service Providers toevoegen voor modulaire configuratie
		(notitie: binden aan environments? je hoeft niet overal alles te hebben)
	- Application object toevoegen
		- Globale settings zoals Instantie en Taal
		- Registreren van Service Providers
		- registreren en triggeren van Hooks
	- Nog eens goed kijken naar namespacing
		- Configureerbare autoloader?
		- PSR-4?

2. Routing:
	- $aRouteParams uit de controller/path aanroep verwijderen, parameters gewoon in $_GET gooien
	- Ook filters via klassen (met Dependency Injection, voor geavanceerde filters)
	- Filter resultaten cachen voor betere prestaties (voor filter-klassen moet caching disabled kunnen worden ivm flexibiliteit)
	- Routes meertalig maken  (/users/ == /gebruikers/)
	- Goede implementatie bedenken voor named routes

3. Templating:
	X Samenstellen
	X Partials
	X Rendering
	- Response (ipv echo)
	- ViewComposers onderzoeken (waarschijnlijk nuttig voor sidebars, header/footer, e.d.)
		(horen deze in /views/ of in /bll/? misschien geen /bll/ meer gebruiken?)

4. Unit testing:
	- PHP Unit onderzoeken
	- Mockery onderzoeken
	- Continuous Integration (zoals Travis-CI, maar dan met ondersteuning voor private repo's en liefst niet github-specifiek)

-. Dependency management
	- Composer of eigen systeem
	
-. Events
	- Kunnen voor/na request worden uitgevoerd
	- Prioriteiten om volgorde af te dwingen?
	- Registreren via Facade (duh)
	- Voorbeeld: Pagina log
	- Praktisch nut: zou ook (deels) via route filters of index.php kunnen, maar dit is netter omdat index te generiek is en filters hier niet voor bedoeld zijn
	
14. Cronjobs
	- Dit moet nog eens goed uitgezocht worden
	- HatseflatsController->cronHatseflats() ?

-------------------------------------------------------------------------------
--- Fasen
-------------------------------------------------------------------------------

1. 	Class handling
	- onderdelen: 	ClassLoader, Factory
	- keywords: 	Dependency Injection, Namespaces
	- status: 		PROTOTYPE

2. 	Routing
	- onderdelen: 	Router, Route, Controller, Request
	- status: 		PROTOTYPE

3. 	Templating
	- onderdelen: 	View
	- status: 		PROTOTYPE

---- Klaar voor demonstratie -----

4. 	Unit testing
	- onderdelen: 	PHPunit, Mockery
	- status: 		NIET GESTART

---- Prototype afgerond -----

5. 	Resources
	- onderdelen: 	SASS, Minifier
	- status: 		NIET GESTART

6. 	UI
	- onderdelen: 	Menu, Request, Post, Get, Session, Form, OverzichtStatus
	- status: 		NIET GESTART

7. 	Modellen en Persistentie
	- onderdelen: 	Database, Repository, Model, ORM
	- status: 		NIET GESTART

8.	Instanties
	- onderdelen: 	Instantie
	- status: 		NIET GESTART

9. 	Meertaligheid
	- onderdelen: 	Taal, Dictionary
	- status: 		NIET GESTART

10. Authenticatie en Rechten
	- onderdelen: 	Auth
	- status: 		NIET GESTART

11. Logging
	- onderdelen: 	Log
	- status: 		NIET GESTART

12. Systeemberichten
	- onderdelen: 	Mail
	- status: 		NIET GESTART

13. Api
	- onderdelen: 	Controller
	- status: 		NIET GESTART

14. Cronjobs
	- onderdelen: 	
	- status: 		NIET GESTART

----- Versie 1 afgerond, klaar voor gebruik -----