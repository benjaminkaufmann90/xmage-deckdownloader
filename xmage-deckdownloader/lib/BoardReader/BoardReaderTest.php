<?php
	require_once '../CardDB/CardDB.php';
	require_once 'Strategy/BoardParser.php';
	require_once 'BoardReader.php';

	// parserd
	require_once 'Strategy/TappedOutParser.php';
	require_once 'Strategy/WizardsOfTheCoastParser.php';

	$cardDB = new CardDB('../../card_db.csv');

	/*** Tapped out ***/
	// $boardReader = new BoardReader(new TappedOutParser($cardDB));
	// $deckUrl = 'https://tappedout.net/mtg-decks/scute-ate/';
	// $deckUrl = 'https://tappedout.net/mtg-decks/dragonblins/';
	// $deckUrl = 'https://tappedout.net/mtg-decks/tempo-ghosts-1/';

	/*** Wizards of the Coast ***/
	$boardReader = new BoardReader(new WizardsOfTheCoastParser($cardDB));
	$deckUrl = 'https://magic.wizards.com/en/content/mirrodin-intro-pack-decklist';

	echo '<pre>';
	var_dump($boardReader->getCardList($deckUrl));
	echo '</pre>';
?>
