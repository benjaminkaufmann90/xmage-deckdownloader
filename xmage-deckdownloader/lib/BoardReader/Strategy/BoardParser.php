<?php
	abstract class BoardParser {
		protected $cardDB;

		public function __construct(CardDB $cardDB = null) {
			$this->cardDB = $cardDB;
		}

		protected function getElementsByClassName($dom, $tagName, $className) {
			$result = [];
			$elements = $dom->getElementsByTagName($tagName);
			for($i = 0; $i < $elements->length; $i++) {
				$element = $elements->item($i);
				if( $element->attributes['class'] && in_array($className, explode(' ', $element->attributes['class']->value)) ) {
					$result []= $element;
				}
			}
			return $result;
		}

		abstract protected function prepareCardData($input): array;

		abstract public function parse($domd): array;
	}
?>
