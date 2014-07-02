<?php
	namespace Controller;

	use Framework\Base\Controller;
	use Model\Artiest;
	use Repository\FestivalRepository;
	use Repository\ArtiestRepository;

	class ArtiestController extends Controller{

		private $oFestivalRepo;
		private $oArtiestRepo;

		public function __construct(FestivalRepository $oFestivalRepo, ArtiestRepository $oArtiestRepo){
			$this->oFestivalRepo = $oFestivalRepo;
			$this->oArtiestRepo = $oArtiestRepo;
		}

		/* Pagina's */
		public function getIndex(array $aRouteParams){

			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['festival_id_token']);
			$aArtiest = $this->oArtiestRepo->getByFestival($oFestival);

			//Overzicht view
			$oView = \View::make('beheer/artiest/index', ['oFestival' => $oFestival, 'aArtiest' => $aArtiest]);
			$oView->nest('oSidebarView', 'beheer/festival/sidebar', ['oFestival' => $oFestival]);

			//Render de view
			echo $oView->render();
		}

		public function getAdd(array $aRouteParams){

			$oFestival  = $this->oFestivalRepo->getByIdToken($aRouteParams['festival_id_token']);

			$sFormUrl   = '/beheer/festival/'.$oFestival->getIdToken().'/artiest/add';

			//Bewerk view
			$oView = \View::make('beheer/artiest/bewerk', ['sFormUrl' => $sFormUrl, 'oFestival' => $oFestival]);
			$oView->nest('oSidebarView', 'beheer/festival/sidebar', ['oFestival' => $oFestival]);

			//Render de view
			echo $oView->render();
		}

		public function getEdit(array $aRouteParams){

			$oFestival  = $this->oFestivalRepo->getByIdToken($aRouteParams['festival_id_token']);
			$oArtiest   = $this->oArtiestRepo->getByIdToken($aRouteParams['id_token']);

			$sFormUrl   = '/beheer/festival/'.$oFestival->getIdToken().'/artiest/'.$oArtiest->getIdToken().'/edit';

			//Bewerk view
			$oView = \View::make('beheer/artiest/bewerk', ['sFormUrl' => $sFormUrl, 'oFestival' => $oFestival, 'oArtiest' => $oArtiest]);
			$oView->nest('oSidebarView', 'beheer/festival/sidebar', ['oFestival' => $oFestival]);

			//Render de view
			echo $oView->render();
		}

		//		public function getDetail(array $aRouteParams){
		//
		//			$oArtiest = $this->oArtiestRepo->getByIdToken($aRouteParams['id_token']);
		//
		//			//Bewerk view
		//			$oView = \View::make('beheer/Artiest/bewerk', ['oArtiest' => $oArtiest, 'bShowForms' => false]);
		//
		//			//Render de view
		//			echo $oView->render();
		//		}

		/* Acties */
		//Insert
		public function postAdd(array $aRouteParams){

			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['festival_id_token']);

			$oArtiest = new Artiest($_POST['naam'], $oFestival->getId());
			$this->oArtiestRepo->insert($oArtiest);

			header('Location: /beheer/festival/'.$oFestival->getIdToken().'/artiest');
		}

		//Update
		public function postEdit(array $aRouteParams){

			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['festival_id_token']);

			$oArtiest = $this->oArtiestRepo->getByIdToken($aRouteParams['id_token']);
			$oArtiest->setNaam($_POST['naam']);
			$this->oArtiestRepo->update($oArtiest);

			header('Location: /beheer/festival/'.$oFestival->getIdToken().'/artiest');
		}

		//Delete
		public function postDelete(array $aRouteParams){

			$oFestival = $this->oFestivalRepo->getByIdToken($aRouteParams['festival_id_token']);

			$oArtiest = $this->oArtiestRepo->getByIdToken($aRouteParams['id_token']);
			$this->oArtiestRepo->delete($oArtiest);

			header('Location: /beheer/festival/'.$oFestival->getIdToken().'/artiest');
		}
	}