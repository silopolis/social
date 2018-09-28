<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\MailTest\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
	'routes' => [
		['name' => 'Navigation#navigate', 'url' => '/', 'verb' => 'GET'],

		[
			'name' => 'ServiceAccounts#getAvailableAccounts', 'url' => '/user/accounts',
			'verb' => 'GET'
		],
		[
			'name' => 'ServiceAccounts#create', 'url' => '/user/account',
			'verb' => 'POST'
		],
		[
			'name' => 'ActivityStreams#test', 'url' => '/user/account/{accountId}/test',
			'verb' => 'GET'
		],
		[
			'name' => 'ActivityStreams#statuses', 'url' => '/user/account/{accountId}/statuses',
			'verb' => 'GET'
		],
		[
			'name' => 'ActivityStreams#follows', 'url' => '/user/account/{accountId}/follows',
			'verb' => 'GET'
		],

		//		[
		//			'name' => 'OAuth2#getAuthUrl', 'url' => '/client/oauth2/auth/{serviceId}/',
		//			'verb' => 'GET'
		//		],
		[
			'name' => 'OAuth2#setCode', 'url' => '/client/oauth2/redirect/{serviceId}/',
			'verb' => 'GET'
		],

		['name' => 'Account#create', 'url' => '/local/account/{username}', 'verb' => 'POST'],

		['name' => 'ActivityPub#sharedInbox', 'url' => '/inbox', 'verb' => 'POST'],
		['name' => 'ActivityPub#actor', 'url' => '/users/{username}', 'verb' => 'GET'],
		['name' => 'ActivityPub#aliasactor', 'url' => '/@{username}', 'verb' => 'GET'],
		['name' => 'ActivityPub#inbox', 'url' => '/@{username}/inbox', 'verb' => 'POST'],
		['name' => 'ActivityPub#outbox', 'url' => '/@{username}/outbox', 'verb' => 'POST'],
		['name' => 'ActivityPub#followers', 'url' => '/@{username}/followers', 'verb' => 'GET'],
		['name' => 'ActivityPub#following', 'url' => '/@{username}/following', 'verb' => 'GET'],

		['name' => 'SocialPub#displayPost', 'url' => '/@{username}/{postId}', 'verb' => 'GET']
,
		['name' => 'ActivityPub#test', 'url' => '/inbox/{username}', 'verb' => 'POST'],


]
];
