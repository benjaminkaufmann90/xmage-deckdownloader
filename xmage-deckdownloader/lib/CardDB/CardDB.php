<?php
	/*
		Notes:
		- Type: H2 Database
		- view for testing:
			- open "DBVisualizer" or "SQuirrel SQL"
			- create new connection:
				- H2 Embedded
				- Database URL: jdbc:h2:D:\xmage\xmage\mage-server\db\cards.h2
		
		Setup:
		- start H2 Server mit card.h2 database:
			- D:\H2\bin\h2.bat -> should open browser window with H2 UI
			- Fields:
				JDBC URL: jdbc:h2:D:\xmage\xmage\mage-server\db\cards.h2
				User Name: <empty>
				Password: <empty>
			- click Connect
		- server is running at socket 192.186.99.1:8082
		
		Export DB to CSV:
		- when server is running go to Browser UI
		- go to textfield for running SQL, type the following then press run:
			CALL CSVWRITE('D:\xampp\htdocs\mine\projects\xmage-tappedout-deckgenerator\card_db.csv', 'SELECT * FROM CARD ORDER BY name', 'charset=UTF-8 fieldSeparator=;');
		- check if D:\xampp\htdocs\mine\projects\xmage-tappedout-deckgenerator\card_db.csv exists and has contents

		Deck file format:
		- 1 line per unique card:
			[... SB: ]<amount> [<edition shortcode>:<card number>] <card name>
	*/

	class CardDB {
		private $dbFilePath;
		private $cards;
		private $fields;

		private function stripQuotes($value) {
			return trim($value, "\"");
		}

		public function getCards() {
			return $this->cards;
		}

		public function getFieldsFromLine($line) {
			$result = explode(';', $line);
			return $result;
		}

		public function getDataByName($cardName) {
			$result = [];
			$find = array_values(array_filter($this->cards, function($line) use($cardName) {
				return $this->stripQuotes($this->getFieldsFromLine($line)[1]) === trim(strtolower($cardName));
			}));
			if(count($find) === 0) {
				throw new \Exception('Card "' . $cardName . '" not found!');
			}
			$fields = $this->getFieldsFromLine($find[0]);
			$result["cardNumber"] = $this->stripQuotes($fields[2]);
			$result["cardEdition"] = $this->stripQuotes($fields[3]);
			return $result;
		}

		public function __construct($dbFilePath) {
			$this->dbFilePath = $dbFilePath;

			$dbCSVFileLines = explode(PHP_EOL, file_get_contents($this->dbFilePath));
			// $this->fields = $this->getFieldsFromLine($dbCSVFileLines[0]);
			$this->cards = array_filter(array_slice($dbCSVFileLines, 1), function($line) { return $line !== ''; });
		}
	}
?>