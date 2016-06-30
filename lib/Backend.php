<?php
/**
 * @author Robin McCorkell <robin@mccorkell.me.uk>
 *
 * @copyright Copyright (c) 2016, ownCloud, Inc.
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
namespace OCA\Files_External_FTP;

use \OCP\IL10N;
use \OCA\Files_External\Lib\DefinitionParameter;
use \OCA\Files_External\Lib\Auth\AuthMechanism;
use \OCA\Files_External\Lib\Auth\Password\Password;

class Backend extends \OCA\Files_External\Lib\Backend\Backend {

	public function __construct(IL10N $l, Password $legacyAuth) {
		$this
			->setIdentifier('ftp')
			->addIdentifierAlias('\OC\Files\Storage\FTP') // legacy compat
			->setStorageClass('\OCA\Files_External_FTP\FTP')
			->setText($l->t('FTP'))
			->addParameters([
				(new DefinitionParameter('host', $l->t('Host'))),
				(new DefinitionParameter('port', $l->t('Port')))
					->setFlag(DefinitionParameter::FLAG_OPTIONAL),
				(new DefinitionParameter('root', $l->t('Remote subfolder')))
					->setFlag(DefinitionParameter::FLAG_OPTIONAL),
				(new DefinitionParameter('secure', $l->t('Secure ftps://')))
					->setType(DefinitionParameter::VALUE_BOOLEAN),
			])
			->addAuthScheme(AuthMechanism::SCHEME_PASSWORD)
			->setLegacyAuthMechanism($legacyAuth)
		;
	}

}
