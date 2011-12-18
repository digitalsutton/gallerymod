<?php

function check_plain($text) {
	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}



function drupal_strtolower($text) {
  global $multibyte;
  if ($multibyte == UNICODE_MULTIBYTE) {
    return mb_strtolower($text);
  }
  else {
    // Use C-locale for ASCII-only lowercase
    $text = strtolower($text);
    // Case flip Latin-1 accented letters
    $text = preg_replace_callback('/\xC3[\x80-\x96\x98-\x9E]/', '_unicode_caseflip', $text);
    return $text;
  }
}