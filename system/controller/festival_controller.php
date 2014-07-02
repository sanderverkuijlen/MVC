<?php
	namespace Controller;

	use Framework\Base\Controller;
	use Model\Festival;
	use Repository\FestivalRepository;

	class FestivalController extends Controller{

		private $oFestivalRepo;

		public function __construct(FestivalRepository $oFestivalRepo){
			$this->oFestivalRepo = $oFestivalRepo;
		}

		/* Pagina's */
		public function getIndex(array $aRouteParams){

			$aFestival = $this->oFestivalRepo->getAll();

			//Overzicht view
			$oView = \View::make('beheer/festival/index', ['aFestival' => $aFestival]);

			//Render de view
			echo $oView->render();
		}

		public function getAdd(array $aRouteParams){

			$sFormUrl = '/beheer/festival/add';

			//Bewerk view
			$oView = \View::make('beheer/festival/bewerk', ['sFormUrl' => $sFormUrl]);

			//Render de view
			echo $oView->render();
		}

		public function getEdit(array $aRouteParams){

			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['id_token']);

			$sFormUrl = '/beheer/festival/'.$oFestival->getIdToken().'/edit';

			//Bewerk view
			$oView = \View::make('beheer/festival/bewerk', ['sFormUrl' => $sFormUrl, 'oFestival' => $oFestival]);

			//Render de view
			echo $oView->render();
		}

//		public function getDetail(array $aRouteParams){
//
//			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['id_token']);
//
//			//Bewerk view
//			$oView = \View::make('beheer/festival/bewerk', ['oFestival' => $oFestival, 'bShowForms' => false]);
//
//			//Render de view
//			echo $oView->render();
//		}

		/* Acties */
		//Insert
		public function postAdd(array $aRouteParams){

			$oFestival = new Festival($_POST['naam']);
			$oFestival = $this->oFestivalRepo->insert($oFestival);

			header('Location: /beheer/festival/'.$oFestival->getIdToken().'/edit');
		}

		//Update
		public function postEdit(array $aRouteParams){

			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['id_token']);
			$oFestival->setNaam($_POST['naam']);
			$this->oFestivalRepo->update($oFestival);

			header('Location: /beheer/festival');
		}

		//Delete
		public function postDelete(array $aRouteParams){

			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['id_token']);
			$this->oFestivalRepo->delete($oFestival);

			header('Location: /beheer/festival');
		}
	}