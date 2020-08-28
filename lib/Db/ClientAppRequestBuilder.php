<?php
declare(strict_types=1);


/**
 * Nextcloud - Social Support
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 * @copyright 2018, Maxence Lange <maxence@artificial-owl.com>
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\Social\Db;


use daita\MySmallPhpTools\Exceptions\RowNotFoundException;
use daita\MySmallPhpTools\Traits\TArrayTools;
use OCA\Social\Exceptions\ClientAppDoesNotExistException;
use OCA\Social\Model\Client\ClientApp;


/**
 * Class ClientAppRequestBuilder
 *
 * @package OCA\Social\Db
 */
class ClientAppRequestBuilder extends CoreRequestBuilder {


	use TArrayTools;


	/**
	 * Base of the Sql Insert request
	 *
	 * @return SocialQueryBuilder
	 */
	protected function getClientAppInsertSql(): SocialQueryBuilder {
		$qb = $this->getQueryBuilder();
		$qb->insert(self::TABLE_CLIENT);

		return $qb;
	}


	/**
	 * Base of the Sql Update request
	 *
	 * @return SocialQueryBuilder
	 */
	protected function getClientAppUpdateSql(): SocialQueryBuilder {
		$qb = $this->getQueryBuilder();
		$qb->update(self::TABLE_CLIENT);

		return $qb;
	}


	/**
	 * Base of the Sql Select request for Shares
	 *
	 * @return SocialQueryBuilder
	 */
	protected function getClientAppSelectSql(): SocialQueryBuilder {
		$qb = $this->getQueryBuilder();

		/** @noinspection PhpMethodParametersCountMismatchInspection */
		$qb->select(
			'cl.id', 'cl.name', 'cl.website', 'cl.redirect_uris', 'cl.client_id', 'cl.client_secret',
			'cl.scopes', 'cl.creation'
		)
		   ->from(self::TABLE_CLIENT, 'cl');

		$this->defaultSelectAlias = 'cl';
		$qb->setDefaultSelectAlias('cl');

		return $qb;
	}


	/**
	 * Base of the Sql Delete request
	 *
	 * @return SocialQueryBuilder
	 */
	protected function getClientAppDeleteSql(): SocialQueryBuilder {
		$qb = $this->getQueryBuilder();
		$qb->delete(self::TABLE_CLIENT);

		return $qb;
	}


	/**
	 * @param SocialQueryBuilder $qb
	 *
	 * @return ClientApp
	 * @throws ClientAppDoesNotExistException
	 */
	public function getClientAppFromRequest(SocialQueryBuilder $qb): ClientApp {
		/** @var ClientApp $result */
		try {
			$result = $qb->getRow([$this, 'parseClientAppSelectSql']);
		} catch (RowNotFoundException $e) {
			throw new ClientAppDoesNotExistException($e->getMessage());
		}

		return $result;
	}


	/**
	 * @param SocialQueryBuilder $qb
	 *
	 * @return ClientApp[]
	 */
	public function getClientAppsFromRequest(SocialQueryBuilder $qb): array {
		/** @var ClientApp[] $result */
		$result = $qb->getRows([$this, 'parseClientAppSelectSql']);

		return $result;
	}


	/**
	 * @param array $data
	 *
	 * @return ClientApp
	 */
	public function parseClientAppSelectSql($data): ClientApp {
		$item = new ClientApp();
		$item->importFromDatabase($data);

		return $item;
	}

}

