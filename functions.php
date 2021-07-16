<?php

function find($first, $latest, $text) {
	@preg_match_all('/' . preg_quote($first, '/') . '(.*?)'. preg_quote($latest, '/').'/i', $text, $m);
	return @$m[1];
}

function curl($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/xml', 'Connection: Keep-Alive'));
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Googlebot/2.1; +http://www.google.com/bot.html) Safari/537.36');
	return $html = curl_exec($ch);
	curl_close($ch);
}

function percent($a, $b) {
    if ( $a > 0 ) {
        return round((($b * 100) / $a),2);
    } else {
         return 0;
    }
}