<?php

class Zend_View_Helper_SanitizeAge extends Zend_View_Helper_Abstract
{

	public function sanitizeAge($content) {

        $output = '';
        if (!isset($content)) return $output;
        $output = preg_replace("/[^0-9]/", '', $content);
        return $output;

	}

}
