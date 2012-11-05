<?php

class Zend_View_Helper_SanitizeGender extends Zend_View_Helper_Abstract
{

    const GENDER_UNKNOWN = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    private $genderSymbols = array(
    	'male'		=> 	self::GENDER_MALE,
    	'female'	=>	self::GENDER_FEMALE
    );

	public function sanitizeGender($content) {

		if (!isset($content)) return self::GENDER_UNKNOWN;
		if (isset($this->genderSymbols[$content])) return $this->genderSymbols[$content];
		return self::GENDER_UNKNOWN;

	}

}
