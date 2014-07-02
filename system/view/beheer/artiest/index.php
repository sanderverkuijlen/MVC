<?php
	/* @var $oSidebarView \Framework\Templating\View */
	/* @var $oFestival \Model\Festival|null */
	/* @var $aArtiest \Model\Artiest[] */
	?>

	<?if($oFestival != null){?>
		<a href="/beheer/festival/<?=$oFestival->getIdToken()?>/edit">Festival</a> | Artiesten<br><br>
	<?}?>

	<a href="/beheer/festival/<?=$oFestival->getIdToken()?>/artiest/add">Toevoegen</a>

	<ul>
		<?
		foreach($aArtiest as $oArtiest){
			?>
			<li>
				<a href="/beheer/festival/<?=$oFestival->getIdToken()?>/artiest/<?=$oArtiest->getIdToken()?>/edit"><?=$oArtiest->getLabel()?></a>

				<form method="post" action="/beheer/festival/<?=$oFestival->getIdToken()?>/artiest/<?=$oArtiest->getIdToken()?>/delete">
					<input type="submit" value="Verwijderen">
				</form>
			</li>
			<?
		}
		?>
	</ul>

	<br>
	<a href="/beheer/festival">Terug naar het festival-overzicht</a>

	<?=$oSidebarView?>