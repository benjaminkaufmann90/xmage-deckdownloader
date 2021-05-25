<?php
	require_once 'DeckFileGenerator.php';

	$cardData = [
		'list' => [
			// main deck
			[
				"count" => "4",
				"name" => "Drogskol Captain",
				"cardEdition" => "DKA",
				"cardNumber" => "136",
				"sideboard" => false,
			],
			[
				"count" => "4",
				"name" => "Eidolon of the Great Revel",
				"cardEdition" => "A25",
				"cardNumber" => "128",
				"sideboard" => false,
			],
			// ...

			// sideboard
			[
				"count" => "2",
				"name" => "Rest in Peace",
				"cardEdition" => "SLD",
				"cardNumber" => "96",
				"sideboard" => true,
			],
			// ...
		],
		'errors' => [
			// errors (e.g. 'card <name> not found')
		],
	];

	echo '<pre>';
	var_dump(DeckFileGenerator::generateDeckContent($cardData['list']));
	echo '</pre>';
?>
