<?php
	/* @var $oSidebarView \Framework\Templating\View */
	/* @var $sFormUrl string */
	/* @var $oFestival \Model\Festival|null */
	/* @var $oArtiest \Model\Artiest|null */
	?>

	<?if($oFestival != null){?>
		<a href="/beheer/festival/<?=$oFestival->getIdToken()?>/edit">Festival</a> | <a href="/beheer/festival/<?=$oFestival->getIdToken()?>/artiest">Artiesten</a><br><br>
	<?}?>

	<form method="post" action="<?=$sFormUrl?>">

		<input type="text" name="naam" value="<?=($oArtiest != null ? $oArtiest->getNaam() : '')?>">

		<input type="submit" value="Opslaan">

	</form>

	<br>
	<a href="/beheer/festival/<?=$oFestival->getIdToken()?>/artiest">Terug naar het artiesten-overzicht</a>

	<?=$oSidebarView?>