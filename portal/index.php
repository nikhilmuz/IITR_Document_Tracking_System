<?php
require_once(dirname(__FILE__).'/plugins/session.php');
if (chk_tok()){header('Location: track.php');}
else{header('Location: login.php');}