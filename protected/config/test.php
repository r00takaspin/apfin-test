<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
        'import'=>array(
            'application.models.*',
            'application.components.*',
            'application.helpers.*',
        ),
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
            'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=apfin-test_test',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
            ),
		),
	)
);
