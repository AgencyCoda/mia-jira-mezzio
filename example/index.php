<?php

require '../vendor/autoload.php';

use Mia\Jira\JiraHelper;

$appId = '';
$clientId = '';
$clientSecret = '';

$helper = new JiraHelper($clientId, $clientSecret);
echo $helper->generateAuthUrl('read:me read:jira-user manage:jira-project read:jira-work write:jira-work offline_access', 'http://localhost:4200/integration-jira', 'asdasd2234asdasdsa');
exit();
//echo $helper->authorizationCodeToAccessToken('', 'http://localhost:4200/integration-jira', 'asdasd2234asdasdsa');

//var_dump($helper->refreshToken(''));

$accessToken = '';
$helper->setAccessToken($accessToken);

//var_dump($helper->getCloudId($accessToken));

$apiUrl = 'https://matiascamiletti.atlassian.net/';
$helper->setApiBaseUser($apiUrl);

//var_dump($helper->me());

var_dump($helper->getProjects());
//var_dump($helper->getIssue('VUL-1'));

//var_dump($helper->getIssueTypes('10000'));
//var_dump($helper->createIssueBasic('Test two task', '10000', '10002'));

exit();