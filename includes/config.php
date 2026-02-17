<?php
if (session_status()===PHP_SESSION_NONE) session_start();
define('MIN_YEAR',1800);
define('MAX_YEAR',2024);
define('IMAGES_PATH','/assets/images/');
function sanitize($s) { return htmlspecialchars($s,ENT_QUOTES,'UTF-8'); }
?>
