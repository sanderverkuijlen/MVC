<?php
	/* @var $aFestival Model\Festival[] */
	?>

	<a href="/beheer/festival/add">Toevoegen</a>

	<ul>
		<?
		foreach($aFestival as $oFestival){
			?>
			<li>
				<a href="/beheer/festival/<?=$oFestival->getIdToken()?>/edit"><?=$oFestival->getLabel()?></a>

				<form method="post" action="/beheer/festival/<?=$oFestival->getIdToken()?>/delete">
					<input type="submit" value="Verwijderen">
				</form>
			</li>
			<?
		}
		?>
	</ul>