<?php
/**
 * @author Robin Appelman <icewind@owncloud.com>
 *
 * @copyright Copyright (c) 2015, ownCloud, Inc.
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
namespace OCA\Files_external_ftp\Storage;

use League\Flysystem\FilesystemException;
use \League\Flysystem\Ftp\FtpAdapter;
use \League\Flysystem\Ftp\FtpConnectionProvider;
use \League\Flysystem\Ftp\FtpConnectionOptions;
use OCP\Files\Storage\FlysystemStorageAdapter;
use OCP\Files\Storage\PolyFill\CopyDirectory;

class FTP extends FlysystemStorageAdapter {
	use CopyDirectory;

	private $host;
	private $password;
	private $username;
	private $secure;
	private $port;

	/**
	 * @var FtpAdapter
	 */
	private $adapter;
	/**
	 * @var resource
	 */
	private $connection;

	public function __construct($params) {
		if (isset($params['host'], $params['username'], $params['password'])) {
			$this->host = $params['host'];
			$this->username = $params['username'];
			$this->password = $params['password'];
			if (isset($params['secure'])) {
				if (\is_string($params['secure'])) {
					$this->secure = ($params['secure'] === 'true');
				} else {
					$this->secure = (bool)$params['secure'];
				}
			} else {
				$this->secure = false;
			}
			$this->root = isset($params['root']) ? $params['root'] : '/';
			$this->port = isset($params['port']) ? $params['port'] : 21;

			$options = FtpConnectionOptions::fromArray([
				'host' => $params['host'],
				'root' => '',
				'username' => $params['username'],
				'password' => $params['password'],
				'port' => (int)$this->port,
				'ssl' => $this->secure,
			]);

			$conProvider = new FtpConnectionProvider();
			$this->connection = $conProvider->createConnection($options);
			$this->adapter = new FtpAdapter($options, $conProvider);
			$this->buildFlySystem($this->adapter);
		} else {
			throw new \Exception('Creating \OCA\Files_external_ftp\FTP storage failed');
		}
	}

	public function getId() {
		return 'ftp::' . $this->username . '@' . $this->host . '/' . $this->root;
	}

	public function disconnect() {
		if (\is_resource($this->connection)) {
			\ftp_close($this->connection);
		}
	}

	public function __destruct() {
		$this->disconnect();
	}

	public static function checkDependencies() {
		if (\function_exists('ftp_login')) {
			return (true);
		} else {
			return ['ftp'];
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function filemtime($path) {
		if ($this->is_dir($path)) {
			return false;
		}
		/* @phan-suppress-next-line PhanRedefinedClassReference */
		return $this->flysystem->lastModified($this->buildPath($path));
	}

	/**
	 * {@inheritdoc}
	 */
	public function filesize($path) {
		if ($this->is_dir($path)) {
			return false;
		}
		/* @phan-suppress-next-line PhanRedefinedClassReference */
		return $this->flysystem->fileSize($this->buildPath($path));
	}

	/**
	 * {@inheritdoc}
	 */
	public function rmdir($path) {
		try {
			/* @phan-suppress-next-line PhanRedefinedClassReference */
			$this->flysystem->deleteDirectory($this->buildPath($path));
			return true;
			/* @phan-suppress-next-line PhanRedefinedClassReference */
		} catch (FilesystemException $e) {
			return false;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function stat($path) {
		return [
			'mtime' => $this->filemtime($path),
			'size' =>  $this->filesize($path),
		];
	}
}
