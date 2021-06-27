<?php

namespace Mia\Jira;

use GuzzleHttp\Psr7\Request;

class JiraHelper
{
    /**
     * URL de la API
     */
    const BASE_URL_API = 'https://api.atlassian.com/';
    /**
     * URL de la API
     * Documentation: https://developer.atlassian.com/cloud/jira/platform/oauth-2-3lo-apps/
     */
    const BASE_URL_AUTH = 'https://auth.atlassian.com/';
    /**
     * Documentation: https://developer.atlassian.com/
     * @var string
     */
    protected $clientId = '';
    /**
     * 
     * @var string
     */
    protected $clientSecret = '';
    /**
     * 
     *
     * @var string
     */
    protected $accessToken = '';
    /**
     * 
     *
     * @var string
     */
    protected $apiBaseUser = '';
    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * 
     * @param string $access_token
     */
    public function __construct($client_id, $client_secret)
    {
        $this->clientId = $client_id;
        $this->clientSecret = $client_secret;
        $this->guzzle = new \GuzzleHttp\Client();
    }

    public function generateAuthUrl($scopes, $redirectUrl, $state)
    {
        return self::BASE_URL_AUTH . 'authorize?audience=api.atlassian.com&client_id=' . $this->clientId . '&scope=' . $scopes . '&redirect_uri=' . urlencode($redirectUrl) . '&state=' . $state . '&response_type=code&prompt=consent';
    }

    public function authorizationCodeToAccessToken($code, $redirectUrl, $state)
    {
        return $this->generateRequest('POST', self::BASE_URL_AUTH . 'oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $redirectUrl
        ]);
    }

    public function refreshToken($refreshToken)
    {
        return $this->generateRequest('POST', self::BASE_URL_AUTH . 'oauth/token', [
            'grant_type' => 'refresh_token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $refreshToken,
        ]);
    }
    /**
     * Get info of Cloud
     * 
     * Example data:
     * 
     * [
     *   {
     *     "id": "f0ce88db-1fe8-4a00-8d04-e24b41841867",
     *     "url": "https://matiascamiletti.atlassian.net",
     *     "name": "matiascamiletti",
     *     "scopes": [
     *       "manage:jira-project",
     *       "write:jira-work",
     *       "read:jira-work",
     *       "read:jira-user"
     *     ],
     *     "avatarUrl": "https://site-admin-avatar-cdn.prod.public.atl-paas.net/avatars/240/star.png"
     *   }
     * ]
     *
     * @return object
     */
    public function getCloudId()
    {
        return $this->generateGetRequestWithAuth(self::BASE_URL_API . 'oauth/token/accessible-resources');
    }

    /**
     * Fetch data of user
     *
     * Example data:
     * 
     * {
     *   "account_id": "557058:07a9fe15-414a-4d61-94b2-24c8a8a9da9c",
     *   "email": "matias.camiletti@gmail.com",
     *   "name": "Matias Camiletti",
     *   "picture": "https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/557058:07a9fe15-414a-4d61-94b2-24c8a8a9da9c/743f436f-482b-4f1d-bd46-974eaadd6067/128",
     *   "account_status": "active",
     *   "nickname": "matiascamiletti",
     *   "locale": "es",
     *   "extended_profile": {
     *     "job_title": "Software Engineer",
     *     "organization": "Agency Coda",
     *     "team_type": "Software Development"
     *   },
     *   "account_type": "atlassian",
     *   "email_verified": true
     * }
     * 
     * @return object
     */
    public function me()
    {
        return $this->generateGetRequestWithAuth(self::BASE_URL_API . 'me');
    }

    public function createIssueBasic($title, $projectId, $issueTypeId)
    {
        return $this->createIssue(array(
            'fields' => [
                'summary' => $title,
                'project' => [
                    'id' => $projectId
                ],
                'issuetype' => [
                    'id' => $issueTypeId
                ]
            ]
        ));
    }

    public function createIssue($params)
    {
        return $this->generatePostRequestWithAuth($this->apiBaseUser . 'rest/api/3/issue', $params);
    }

    public function getIssue($issueId)
    {
        return $this->generateGetRequestWithAuth($this->apiBaseUser . 'rest/api/3/issue/' . $issueId);
    }
    /**
     * Example of data:
     * 
     * [
     *   {
     *       "self": "https://matiascamiletti.atlassian.net/rest/api/3/issuetype/10002",
     *       "id": "10002",
     *       "description": "Un trabajo pequeño e independiente.",
     *      "iconUrl": "https://matiascamiletti.atlassian.net/secure/viewavatar?size=medium&avatarId=10318&avatarType=issuetype",
     *      "name": "Tarea",
     *      "untranslatedName": "Task",
     *     "subtask": false,
     *      "avatarId": 10318,
     *       "hierarchyLevel": 0
     *   },
     *   {
     *       "self": "https://matiascamiletti.atlassian.net/rest/api/3/issuetype/10003",
     *       "id": "10003",
     *       "description": "Un trabajo pequeño que forma parte de una tarea de mayor tamaño.",
     *       "iconUrl": "https://matiascamiletti.atlassian.net/secure/viewavatar?size=medium&avatarId=10316&avatarType=issuetype",
     *       "name": "Subtarea",
     *       "untranslatedName": "Sub-task",
     *       "subtask": true,
     *       "avatarId": 10316,
     *       "hierarchyLevel": -1
     *   },
     *   {
     *       "self": "https://matiascamiletti.atlassian.net/rest/api/3/issuetype/10001",
     *       "id": "10001",
     *       "description": "Una función o funcionalidad expresada como objetivo del usuario.",
     *       "iconUrl": "https://matiascamiletti.atlassian.net/secure/viewavatar?size=medium&avatarId=10315&avatarType=issuetype",
     *       "name": "Historia",
     *       "untranslatedName": "Story",
     *       "subtask": false,
     *       "avatarId": 10315,
     *       "hierarchyLevel": 0
     *   },
     *   {
     *       "self": "https://matiascamiletti.atlassian.net/rest/api/3/issuetype/10004",
     *       "id": "10004",
     *       "description": "Un problema o error.",
     *       "iconUrl": "https://matiascamiletti.atlassian.net/secure/viewavatar?size=medium&avatarId=10303&avatarType=issuetype",
     *       "name": "Error",
     *       "untranslatedName": "Bug",
     *       "subtask": false,
     *       "avatarId": 10303,
     *       "hierarchyLevel": 0
     *   },
     *   {
     *       "self": "https://matiascamiletti.atlassian.net/rest/api/3/issuetype/10000",
     *       "id": "10000",
     *       "description": "Una colección de errores, historias y tareas relacionadas.",
     *       "iconUrl": "https://matiascamiletti.atlassian.net/images/icons/issuetypes/epic.svg",
     *       "name": "Epic",
     *       "untranslatedName": "Epic",
     *       "subtask": false,
     *       "hierarchyLevel": 1
     *   }
     *   ]
     *
     * @param string $projectId
     * @return object
     */
    public function getIssueTypes($projectId)
    {
        return $this->generateGetRequestWithAuth($this->apiBaseUser . 'rest/api/3/issuetype/project?projectId=' . $projectId);
    }

    public function getProjects()
    {
        return $this->generateGetRequestWithAuth($this->apiBaseUser . 'rest/api/3/project/search');
    }

    protected function generateGetRequestWithAuth($url)
    {
        return $this->generateRequestWithAuth('GET', $url);
    }

    protected function generatePostRequestWithAuth($url, $params)
    {
        return $this->generateRequestWithAuth('POST', $url, $params);
    }

    protected function generateRequestWithAuth($method, $url, $params = null)
    {
        return $this->generateRequest($method, $url, $params, $this->accessToken);
    }
    /**
     * 
     *
     * @param string $method
     * @param string $url
     * @param array|null $params
     * @param string|null $accessToken
     * @return void
     */
    protected function generateRequest($method, $url, $params = null, $accessToken = null)
    {
        $body = null;
        if($params != null){
            $body = json_encode($params);
        }

        if($accessToken != null){
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken
            ];
        } else {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ];
        }

        $request = new Request($method, $url, $headers, $body);

        $response = $this->guzzle->send($request);
        if($response->getStatusCode() == 200){
            var_dump($response->getBody()->getContents()); exit();
            return json_decode($response->getBody()->getContents());
        }

        return null;
    }
    /**
     * 
     *
     * @param string $accessToken
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    /**
     * 
     *
     * @param string $apiUrl
     * @return void
     */
    public function setApiBaseUser($apiUrl)
    {
        $this->apiBaseUser = $apiUrl;
    }
}