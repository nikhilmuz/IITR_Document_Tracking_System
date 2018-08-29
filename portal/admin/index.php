<?php
require_once(dirname(dirname(__FILE__)).'/includes/autoload.php');
if ((new Sessions())->chk_tok()){header('Location: '.PATH.'/index.php');}
else{header('Location: '.PATH.'/login.php');}