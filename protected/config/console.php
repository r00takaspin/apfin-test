<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*',
    ),

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=apfin-test',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
		// uncomment the following to use a MySQL database
        'testdb'=>array(
            'class'=>'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=apfin-test_test',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);