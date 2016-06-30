<?php

$l = \OC::$server->getL10N('files_external_ftp');

if (!class_exists('OC_Mount_Config')) {
	OC_App::loadApp('files_external');
}
OC_Mount_Config::registerBackend('\OCA\Files_External_FTP\FTP', [
	'backend' => (string)$l->t('FTP (Fly)'),
	'priority' => 100,
	'configuration' => [
		'host' => (string)$l->t('hostname'),
		'username' => (string)$l->t('Username'),
		'password' => (string)$l->t('Password'),
		'root' => '&' . $l->t('Remote subfolder'),
		'secure' => '!' . $l->t('Secure ftps://'),
		'port' => '&' . $l->t('Port'),
	],
]);
