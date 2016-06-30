<?php

\OC::$server->getEventDispatcher()->addListener(
	'OCA\\Files_External::loadAdditionalBackends', function($event) {
	$backendService = \OC::$server->getStoragesBackendService();
	$backendService->registerBackendProvider(new \OCA\Files_External_FTP\BackendProvider());
}
);
