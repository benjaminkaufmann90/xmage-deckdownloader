<?php
	require_once 'BoardParser.php';

	class WizardsOfTheCoastParser extends BoardParser {

		// @TODO: refactor method (maybe export fetching of DOM-Element data and cardDb data to seperate methods and call them by this method)
		protected function prepareCardData($member) : array {
			$data = [];

			$count = $member->childNodes->item(1)->textContent; // span.count -> textContent
			$name = $member->childNodes->item(3)->getElementsByTagName('a')->item(0)->textContent; // span.card-name a -> textContent
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

			//div.sorted-by-overview-container
			$mainBoardContainers = $this->getElementsByClassName($domd, 'div', 'sorted-by-overview-container');

			foreach($mainBoardContainers as $containerIndex => $container) {
				$result['decks'][$containerIndex] = ['name' => '', 'list' => [], 'errors' => [], 'warnings' => []];

				//div.sorted-by-overview-container div.element
				$elements = $this->getElementsByClassName($container, 'div', 'element');

				foreach($elements as $element) {
					$cards = $this->getElementsByClassName($element, 'span', 'row');

					foreach($cards as $card) {
						try {
							$data = $this->prepareCardData($card);
							$result['decks'][$containerIndex]['list'] []= $data;
						} catch(\Exception $e) {
							$result['decks'][$containerIndex]['errors'] []= $e->getMessage();
						}
					}
				}
			}

			return $result;
		}
	}
?>
