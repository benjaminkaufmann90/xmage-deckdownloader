<?php

	require_once 'lib/CardDB/CardDB.php';
	require_once 'lib/BoardReader/Strategy/TappedOutParser.php';
	require_once 'lib/BoardReader/Strategy/WizardsOfTheCoastParser.php';
	require_once 'lib/BoardReader/BoardReader.php';
	require_once 'lib/DeckFileGenerator/DeckFileGenerator.php';

	//@TODO: detect and use correct parser depending of the link's domain name
	//@TODO: handle deck errors
	$deckUrl = @$_POST['deck_url'];
	$message = @$_GET['message'];

	if($deckUrl) {
		$dbPath = 'card_db.csv';
		$deckUrlParts = explode('/', $deckUrl);
		if("" === $deckUrlParts[count($deckUrlParts) - 1]) { unset($deckUrlParts[count($deckUrlParts) - 1]); }
		$urlName = $deckUrlParts[count($deckUrlParts) - 1];

		$boardReader = new BoardReader(new TappedOutParser(new CardDB('card_db.csv')));
		// $boardReader = new BoardReader(new WizardsOfTheCoastParser(new CardDB('card_db.csv')));
		$cardData = $boardReader->getCardList($deckUrl);

		$tmpFile = @tempnam('tmp_download', 'zip');
		$zip = new ZipArchive();
		$zip->open($tmpFile, ZipArchive::OVERWRITE);
		foreach($cardData['decks'] as $deckNumber => $deck) {
			if(count($deck['errors']) > 0) {
				// deck error handling ...
			}
			$deckFileName = ($deck['name'] ? $deck['name'] : $urlName . (count($cardData['decks']) > 1 ? '-' . $deckNumber : '')) . '.dck';
			$zip->addFromString($deckFileName, DeckFileGenerator::generateDeckContent($deck['list']));
		}
		$zip->close();

		header('content-type: application/zip');
		header('Content-Length: ' . filesize($tmpFile));
		header('Content-Disposition: attachment; filename="decks.zip"');
		readfile($tmpFile);
		unlink($tmpFile);

	} else {

		$message = @$_GET['message'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>XMage Deck Download</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/bg-changer.css">
		<script src="assets/js/bg-changer.js" defer></script>
		<meta charset="UTF-8">
	</head>
	<body>
		<?php
			if($message) {
				echo '<p style="color: rgba(0, 100, 200, 1);">' . $message . ' - <a href="index.php" style="text-decoration: none; color: rgba(50, 200, 100, 1);">[OK]</a></p>';
			}
		?>
		<form method="post" action="index.php" id="downLoadForm">
			<input type="text" name="deck_url" placeholder="Enter deck URL ... " class="downLoadForm-control downLoadForm-text">
			<button type="submit" class="downLoadForm-control downLoadForm-button">Download Deck</button>
		</form>
		<div class="bgImages"></div>
	</body>
</html>
<?php
	}
?>