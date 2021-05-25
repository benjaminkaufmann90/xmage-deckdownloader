<?php

	class BoardReader {
		private $boardParserStrategy;

		private function fetchPageContentRawFromCURL($resourcePath) { }

		private function fetchPageContentRawFromFile($resourcePath) {
			$result = file_get_contents($resourcePath);
			return $result;
		}

		private function fetchPageContentRaw($resourcePath) {
			return $this->fetchPageContentRawFromFile($resourcePath);
		}

		private function getParsedDOM($pageContentRaw) {
			$domd = new DOMDocument();
			libxml_use_internal_errors(true);
			$domd->loadHTML($pageContentRaw);
			libxml_use_internal_errors(false);
			return $domd;
		}

		private function getParsedCardList($pageContentRaw) {
			$domd = $this->getParsedDOM($pageContentRaw);
			return $this->boardParserStrategy->parse($domd);
		}

		public function getCardList($resourcePath) {
			$pageContentRaw = $this->fetchPageContentRaw($resourcePath);
			return $this->getParsedCardList($pageContentRaw);
		}

		public function setStrategy(BoardParserStrategy $strategy) {
			$this->boardParserStrategy = $boardParserStrategy;
		}

		public function __construct(BoardParser $boardParserStrategy) {
			$this->boardParserStrategy = $boardParserStrategy;
		}
	}
?>
