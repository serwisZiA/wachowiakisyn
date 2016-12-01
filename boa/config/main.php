<?php
$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-boa',
	'basePath' => dirname(__DIR__) . '../../backend',
	'controllerNamespace' => 'backend\controllers',
	'defaultRoute' => 'connection/boa',
	'bootstrap' => ['log'],
	'modules' => [
		'gridview' => [
			'class' => '\kartik\grid\Module',
			'i18n' => [
				'class' => 'yii\i18n\PhpMessageSource',
				'basePath' => '@kvgrid/messages',
				'forceTranslation' => true,
				'sourceLanguage' => 'pl',
			]
		]
	],
	'components' => [
// 		'urlManager' => [
// 			'class' => 'yii\web\UrlManager',
// 			'rules' => [
// 				'class' => 'app\components\DeviceUrlRule'
// 			]
// 		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => false,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
// 		'errorHandler' => [
// 			'errorAction' => 'site/error',
// 		],
	],
	'params' => $params,
];