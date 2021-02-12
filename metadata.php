<?php

// allow utf8-detection: öäü€

$sMetadataVersion = '1.1';
$aModule = array(
    'id' => 'dx_smartynocache',
    'title' => 'Dixeno - Kein Smarty Caching',
    'description' => array(
		"de" =>"Sorgt dafür das Smarty Templatedateien bei jedem Aufruf neu kompiliert (setzt force_compile)<br>Erkennt außerdem geänderte lang-Dateien und invalidiert den lang-Cache",
        "en" =>"Forces smarty to always do a fresh compile of template files (sets force_compile)<br>Also detects changed lang-files and forces invalidation of the lang-file cache"
	),
    'thumbnail' => 'dixeno.png',
    'version' => '1.1',
    'author' => 'Dixeno GmbH',
    'url' => 'http://www.dixeno.de',
    'email' => 'info@dixeno.de',
    'extend' => array(
		'oxutilsview'	=> 'dixeno/dx_smartynocache/dx_smartynocache_oxutilsview',
        'oxlang'        => 'dixeno/dx_smartynocache/dx_smartynocache_oxlang'
	)
);