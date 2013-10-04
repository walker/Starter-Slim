<?php

function array_implode($first, $second, $data) {
	$arr = array();
	foreach($data as $key => $value) {
		$arr[] = $key.$first.$value;
	}
	return implode($second, $arr);
}
