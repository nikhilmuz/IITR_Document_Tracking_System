<?php
require_once('plugins/session.php');
require_once('config.php');
des_tok();
header('Location: '.DOMAIN.PATH.'/login.php?msg=2');