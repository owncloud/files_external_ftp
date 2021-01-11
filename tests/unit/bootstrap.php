<?php

\define('PHPUNIT_RUN', 1);

require_once __DIR__ . '/../../../../lib/base.php';
require_once __DIR__ . '/../../../../tests/bootstrap.php';

\OC::$composerAutoloader->addPsr4('Test\\', OC::$SERVERROOT . '/tests/lib/', true);
\OC::$composerAutoloader->addPsr4('Tests\\', OC::$SERVERROOT . '/tests/', true);

OC_Hook::clear();
