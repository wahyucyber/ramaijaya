<?php 

class Hash
{
    public function make($value,$options = 8)
    {

    	$conf = [
    		'cost' => $options
    	];

    	return password_hash($value, PASSWORD_BCRYPT, $conf);

    }

    public function check($value, $hashValue)
    {

    	return password_verify($value,$hashValue);

    }
}