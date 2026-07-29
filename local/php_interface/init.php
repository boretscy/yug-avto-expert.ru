<?php

	require_once __DIR__.'/YApp/YApp.php';
	require_once __DIR__.'/YApp/BEESMS.class.php';
    $yapp = new YApp();

	require_once __DIR__.'/Cabinet/Cabinet.php';
    $cabConf = require __DIR__.'/Cabinet/Config.php';
    $cab = new Cabinet( $cabConf );
    

?>