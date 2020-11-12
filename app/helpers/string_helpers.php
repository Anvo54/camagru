<?php

function removeSpecialChar($str){

	$res = preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$str); 
	return $res; 
}