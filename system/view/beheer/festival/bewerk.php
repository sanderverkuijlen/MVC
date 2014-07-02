<?php
	/* @var $sFormUrl string */
	/* @var $oFestival Model\Festival|null */
	?>

	<?if($oFestival != null){?>
		Festival | <a href="/beheer/festival/<?=$oFestival->getIdToken()?>/artiest">Artiesten</a><br><br>
	<?}?>

	<form method="post" action="<?=$sFormUrl?>">

		<input type="text" name="naam" value="<?=($oFestival != null ? $oFestival->getNaam() : '')?>">

		<input type="submit" value="Opslaan">

	</form>

	<br>
	<a href="/beheer/festival">Terug</a>