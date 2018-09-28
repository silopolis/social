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


namespace OCA\Social\Command;

use Exception;
use OC\Core\Command\Base;
use OCA\Social\Service\ActivityPub\NoteService;
use OCA\Social\Service\ActivityPubService;
use OCA\Social\Service\ActorService;
use OCA\Social\Service\ConfigService;
use OCA\Social\Service\CurlService;
use OCA\Social\Service\MiscService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class NoteCreate extends Base {

	/** @var ConfigService */
	private $configService;

	/** @var ActivityPubService */
	private $activityPubService;

	/** @var ActorService */
	private $actorService;

	/** @var NoteService */
	private $noteService;

	/** @var CurlService */
	private $curlService;

	/** @var MiscService */
	private $miscService;


	/**
	 * Index constructor.
	 *
	 * @param ActivityPubService $activityPubService
	 * @param ActorService $actorService
	 * @param NoteService $noteService
	 * @param CurlService $curlService
	 * @param ConfigService $configService
	 * @param MiscService $miscService
	 */
	public function __construct(
		ActivityPubService $activityPubService, ActorService $actorService,
		NoteService $noteService, CurlService $curlService,
		ConfigService $configService, MiscService $miscService
	) {
		parent::__construct();

		$this->activityPubService = $activityPubService;
		$this->actorService = $actorService;
		$this->noteService = $noteService;
		$this->curlService = $curlService;
		$this->configService = $configService;
		$this->miscService = $miscService;
	}


	/**
	 *
	 */
	protected function configure() {
		parent::configure();
		$this->setName('social:note:create')
			 ->addOption(
				 'replyTo', 'r', InputOption::VALUE_OPTIONAL, 'in reply to an existing thread'
			 )
			 ->addOption(
				 'to', 't', InputOption::VALUE_OPTIONAL, 'to (default Public)'
			 )
			 ->addArgument('userid', InputArgument::REQUIRED, 'userId of the author')
			 ->addArgument('content', InputArgument::REQUIRED, 'content of the post')
			 ->setDescription('Create a new note');
	}


	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 *
	 * @throws Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {

		$userId = $input->getArgument('userid');
		$content = $input->getArgument('content');
		$to = $input->getOption('to');
		$replyTo = $input->getOption('replyTo');

		$note = $this->noteService->generateNote($userId, $content, ActivityPubService::TO_PUBLIC);

		if ($to !== null) {
			$note->setTo($to);
			$note->addTag(
				[
					'type' => 'Mention',
					'href' => $to
				]
			);
		}


		if ($replyTo !== null) {
			$note->setInReplyTo($replyTo);
		}

		$result = $this->activityPubService->createActivity($userId, $note, $activity);

		echo 'object: ' . json_encode($activity, JSON_PRETTY_PRINT) . "\n";
		echo 'result: ' . json_encode($result, JSON_PRETTY_PRINT) . "\n";

	}

}

