<?php

class Zend_View_Helper_Slug extends Zend_View_Helper_Abstract
{

	public function slug($content="") {

		$content = trim($content);
		$content = preg_replace("/[^A-Za-z0-9]/", "-", $content);
		$content = preg_replace('{\-+}', '-', $content);
		if ($content[0] == '-') $content = substr($content, 1);
		$wordLength = strlen($content);
		if ($content[$wordLength-1] == '-') $content = substr($content, 0, -1);
		$content = strtolower($content);
		return $content;

	}

}
