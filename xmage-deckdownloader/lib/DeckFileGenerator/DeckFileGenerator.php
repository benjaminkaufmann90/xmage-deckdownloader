<?php
	class DeckFileGenerator {
		private static function getFormattedDeckLine($data) {
			if(!isset($data["sideboard"])) {
				$data["sideboard"] = false;
			}
			return ($data["sideboard"] ? 'SB: ' : '') . $data["count"] . ' [' . $data["cardEdition"] . ':' . $data["cardNumber"] . '] ' . $data["name"];
		}

		public static function generateDeckContent($cardData) {
			$result = "";

			for($i = 0; $i < count($cardData); $i++) {
				$result .= DeckFileGenerator::getFormattedDeckLine($cardData[$i]) . PHP_EOL;
			}

			return $result;
		}

		public static function generateDeckFile($cardData, $fileURL) {
			$fileContent = DeckFileGenerator::generateDeckContent($cardData);

			$f = fopen($fileURL, 'w+');
			fwrite($f, $fileContent);
			fclose($f);
		}
	}
?>
