<?php
/**
 * @author Thomas Müller <thomas.mueller@tmit.eu>
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


use OCA\Files_External\Lib\Config\IBackendProvider;

class BackendProvider implements IBackendProvider {

	/**
	 * @since 9.1.0
	 * @return Backend[]
	 */
	public function getBackends() {
		$l10n = \OC::$server->getL10N('files_external_ftp');
		$extContainer = \OC_Mount_Config::$app->getContainer();
		$passwordAuth = $extContainer->query('OCA\Files_External\Lib\Auth\Password\Password');
		return [
			new Backend($l10n, $passwordAuth)
		];
	}
}
