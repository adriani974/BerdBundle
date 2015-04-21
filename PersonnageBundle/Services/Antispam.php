<?php
namespace Berd\PersonnageBundle\Services;

class Antispam{

	public function isSpam($text){
     return strlen($text) < 50;
	}
}

?>