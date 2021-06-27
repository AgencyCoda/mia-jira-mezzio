<?php

require '../vendor/autoload.php';

use Mia\Jira\JiraHelper;

$appId = '63fc8742-7046-4178-85ad-b2d5ed214587';
$clientId = 'HXlbejYHVOAzLPzYe64hMMkZcvZ8NvFx';
$clientSecret = 'g020z7J6_zHOFIdHUnXU0sXqf3gmog161oD7FjGnZhJtA9qNGWjJf7kGKisGEZpZ';

$helper = new JiraHelper($clientId, $clientSecret);
//echo $helper->generateAuthUrl('read:me read:jira-user manage:jira-project read:jira-work write:jira-work offline_access', 'http://localhost:4200/integration-jira', 'asdasd2234asdasdsa');

//echo $helper->authorizationCodeToAccessToken('ev9GBZT33CtZIxS2', 'http://localhost:4200/integration-jira', 'asdasd2234asdasdsa');

//echo $helper->refreshToken('KoF5LihrJhKp7DyHZJ-Dv1WCoxfl4L-e4RWL-SPJmmGLd');

$accessToken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik16bERNemsxTVRoRlFVRTJRa0ZGT0VGRk9URkJOREJDTVRRek5EZzJSRVpDT1VKRFJrVXdNZyJ9.eyJodHRwczovL2F0bGFzc2lhbi5jb20vb2F1dGhDbGllbnRJZCI6IkhYbGJlallIVk9BekxQelllNjRoTU1rWmN2WjhOdkZ4IiwiaHR0cHM6Ly9hdGxhc3NpYW4uY29tL2VtYWlsRG9tYWluIjoiZ21haWwuY29tIiwiaHR0cHM6Ly9hdGxhc3NpYW4uY29tL3N5c3RlbUFjY291bnRJZCI6IjYwZDhiMzI5NzI2MTkwMDA2ODJjOGY5YiIsImh0dHBzOi8vYXRsYXNzaWFuLmNvbS9zeXN0ZW1BY2NvdW50RW1haWxEb21haW4iOiJjb25uZWN0LmF0bGFzc2lhbi5jb20iLCJodHRwczovL2F0bGFzc2lhbi5jb20vdmVyaWZpZWQiOnRydWUsImh0dHBzOi8vYXRsYXNzaWFuLmNvbS9maXJzdFBhcnR5IjpmYWxzZSwiaHR0cHM6Ly9hdGxhc3NpYW4uY29tLzNsbyI6dHJ1ZSwiaXNzIjoiaHR0cHM6Ly9hdGxhc3NpYW4tYWNjb3VudC1wcm9kLnB1czIuYXV0aDAuY29tLyIsInN1YiI6ImF1dGgwfDU1NzA1ODowN2E5ZmUxNS00MTRhLTRkNjEtOTRiMi0yNGM4YThhOWRhOWMiLCJhdWQiOiJhcGkuYXRsYXNzaWFuLmNvbSIsImlhdCI6MTYyNDgxNjg0NiwiZXhwIjoxNjI0ODIwNDQ2LCJhenAiOiJIWGxiZWpZSFZPQXpMUHpZZTY0aE1Na1pjdlo4TnZGeCIsInNjb3BlIjoibWFuYWdlOmppcmEtcHJvamVjdCB3cml0ZTpqaXJhLXdvcmsgcmVhZDpqaXJhLXdvcmsgcmVhZDpqaXJhLXVzZXIgcmVhZDptZSBvZmZsaW5lX2FjY2VzcyJ9.Axiuhu6knMI7uXv9kx4sGNmQsLlb5CirFqLLzpPkyHGmNq-6tP3SndC2xZ0W0nAibJswmm52DfFf5kejYAU5VANmSEHxtfvBraAmHqTUh0LLRNbdrUg0suyt9iPCyMJ-b9EqIVzeRFHYsLeETD9zl2JgjM_7Wz51dtFrhGIT35-4zVqlW0IWlTSoXpuDPQWQDHLZXrB46RCaol2gUgL2uLOBsCKmmSm9QhoFGV0KcN5rL_HJt3SBMW67qMhWYmLxnuOlEMQYXcwne9Z23wDypeWascaEBW_CyhjusbIr_P5BLOykFrfa_z8n1mwsUHXvTC-7YqgVSC3JTls5WkuxkQ';
$helper->setAccessToken($accessToken);

//var_dump($helper->getCloudId($accessToken));

$apiUrl = 'https://matiascamiletti.atlassian.net/';
$helper->setApiBaseUser($apiUrl);

//var_dump($helper->me());

//var_dump($helper->getProjects());
//var_dump($helper->getIssue('VUL-1'));

//var_dump($helper->getIssueTypes('10000'));
var_dump($helper->createIssueBasic('Test two task', '10000', '10002'));

exit();