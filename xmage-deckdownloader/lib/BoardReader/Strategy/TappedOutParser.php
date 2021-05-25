<?php
	require_once 'BoardParser.php';

	class TappedOutParser extends BoardParser {

		// @TODO: refactor method (maybe export fetching of DOM-Element data and cardDb data to seperate methods and call them by this method)
		protected function prepareCardData($member) : array {
			$data = [];

			// @TODO: check why $this->getElementsByClassName(...) isn't working properly (below line = quickfix)
			$count = str_replace('x', '', $member->childNodes->item(1)->textContent); // li.member a.qty -> textContent
			$name = $this->getElementsByClassName( $member, 'span', 'card' )[0]->childNodes->item(0)->textContent; // li.member span.card a.card-link -> textContent
			$cardDBData = $this->cardDB->getDataByName($name);

			$data["count"] = $count;
			$data["name"] = $name;
			$data["cardEdition"] = $cardDBData['cardEdition'];
			$data["cardNumber"] = $cardDBData['cardNumber'];

			return $data;
		}

		// @TODO: refactor (improve handling of result variable)
		public function parse($domd): array {
			$result = ['decks' => [
				/* ['name' => '', 'list' => [], 'errors' => [], 'warnings' => []] */
			]];

			$result['decks'][0] = ['name' => '', 'list' => [], 'errors' => [], 'warnings' => []];

			//div.board-container
			$mainBoardContainer = $this->getElementsByClassName($domd, 'div', 'board-container')[0];

			// div.board-col
			$boardCols = $this->getElementsByClassName($mainBoardContainer, 'div', 'board-col');
			foreach($boardCols as $boardCol) {

				$h3s = $boardCol->getElementsByTagName('h3');
				$boardLists = $this->getElementsByClassName($boardCol, 'ul', 'boardlist');

				for($i = 0; $i < $h3s->length; $i++) { // h3 amount = ul.boardlist amount
					// ul.boardlist li.member
					$members = $this->getElementsByClassName($boardLists[$i], 'li', 'member');

					foreach($members as $member) {
						try {
							$cardData = $this->prepareCardData($member);
							$cardData['sideboard'] = strpos(trim(strtolower($h3s[$i]->textContent)), 'sideboard') !== false;
							$result['decks'][0]['list'] []= $cardData;
						} catch(\Exception $e) {
							$result['decks'][0]['errors'] []= $e->getMessage();
						}
					}
				}
			}

			return $result;
		}
	}
?>
