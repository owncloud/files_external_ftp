<?php
/**
 * @author Vincent Petry <pvince81@owncloud.com>
 *
 * @copyright Copyright (c) 2016, ownCloud GmbH.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\Files_external_ftp\Backend;

use \OCP\IL10N;
use \OCA\Files_External\Lib\Backend\Backend;
use \OCA\Files_External\Lib\DefinitionParameter;
use \OCA\Files_External\Lib\Auth\AuthMechanism;
use \OCA\Files_External\Service\BackendService;

use \OCA\Files_External\Lib\Auth\Password\Password;

class FTP extends Backend {

	public function __construct(IL10N $l, Password $legacyAuth) {
		$this
			->setIdentifier('ftp')
			->addIdentifierAlias('\OC\Files\Storage\FTP') // legacy compat
			->setStorageClass('\OCA\Files_external_ftp\Storage\FTP')
			->setText($l->t('FTP (Fly)'))
			->addParameters([
				(new DefinitionParameter('host', $l->t('Host'))),
				(new DefinitionParameter('root', $l->t('Root')))
					->setFlag(DefinitionParameter::FLAG_OPTIONAL),
				(new DefinitionParameter('port', $l->t('Port')))
					->setFlag(DefinitionParameter::FLAG_OPTIONAL),
				(new DefinitionParameter('secure', $l->t('Secure ftps://')))
					->setType(DefinitionParameter::VALUE_BOOLEAN),
			])
			->addAuthScheme(AuthMechanism::SCHEME_PASSWORD)
			->setLegacyAuthMechanism($legacyAuth);
	}

}
