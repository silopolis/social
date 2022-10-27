/**
 * @copyright 2022 Louis Chemineau <mlouis@chmn.me>
 *
 * @author Louis Chemineau <mlouis@chmn.me>
 *
 * @license AGPL-3.0-or-later
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

import { getCurrentUser } from '@nextcloud/auth'
import { getLoggerBuilder } from '@nextcloud/logger'

const getLogger = user => {
	if (user === null) {
		return getLoggerBuilder()
			.setApp('social')
			.build()
	}
	return getLoggerBuilder()
		.setApp('social')
		.setUid(user.uid)
		.build()
}

export default getLogger(getCurrentUser())
