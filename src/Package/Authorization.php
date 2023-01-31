<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;
use Joomla\Uri\Uri;

/**
 * GitHub API Authorization class for the Joomla Framework.
 *
 * @documentation  http://developer.github.com/v3/oauth/
 * @documentation  http://developer.github.com/v3/oauth_authorizations/
 *
 * @note   The methods in this class are only accessible with Basic Authentication
 * @since  1.0
 */
class Authorization extends AbstractPackage
{
    /**
     * Method to create an authorization.
     *
     * @param   array   $scopes  A list of scopes that this authorization is in.
     * @param   string  $note    A note to remind you what the OAuth token is for.
     * @param   string  $url     A URL to remind you what app the OAuth token is for.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function create(array $scopes = [], $note = '', $url = '')
    {
        // Build the request path.
        $path = '/authorizations';

        $data = json_encode(
            ['scopes' => $scopes, 'note' => $note, 'note_url' => $url]
        );

        // Send the request.
        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Method to delete an authorization
     *
     * @param   integer  $id  ID of the authorization to delete
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function delete($id)
    {
        // Build the request path.
        $path = '/authorizations/' . $id;

        // Send the request.
        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Delete a grant
     *
     * Deleting an OAuth application's grant will also delete all OAuth tokens associated with the application for your user.
     *
     * @param   integer  $id  ID of the authorization to delete
     *
     * @return  object
     *
     * @since   1.5.0
     * @throws  \DomainException
     */
    public function deleteGrant($id)
    {
        // Build the request path.
        $path = '/authorizations/grants/' . $id;

        // Send the request.
        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Method to edit an authorization.
     *
     * @param   integer  $id            ID of the authorization to edit
     * @param   array    $scopes        Replaces the authorization scopes with these.
     * @param   array    $addScopes     A list of scopes to add to this authorization.
     * @param   array    $removeScopes  A list of scopes to remove from this authorization.
     * @param   string   $note          A note to remind you what the OAuth token is for.
     * @param   string   $url           A URL to remind you what app the OAuth token is for.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     * @throws  \RuntimeException
     */
    public function edit($id, array $scopes = [], array $addScopes = [], array $removeScopes = [], $note = '', $url = '')
    {
        // Check if more than one scopes array contains data
        $scopesCount = 0;
        $scope       = '';
        $scopeData   = '';

        if (!empty($scopes)) {
            $scope     = 'scopes';
            $scopeData = $scopes;
            $scopesCount++;
        }

        if (!empty($addScopes)) {
            $scope     = 'add_scopes';
            $scopeData = $addScopes;
            $scopesCount++;
        }

        if (!empty($removeScopes)) {
            $scope     = 'remove_scopes';
            $scopeData = $removeScopes;
            $scopesCount++;
        }

        // Only allowed to send data for one scope parameter
        if ($scopesCount >= 2) {
            throw new \RuntimeException('You can only send one scope key in this request.');
        }

        // Build the request path.
        $path = '/authorizations/' . $id;

        $data = json_encode(
            [
                $scope     => $scopeData,
                'note'     => $note,
                'note_url' => $url,
            ]
        );

        // Send the request.
        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * Method to get details about an authorised application for the authenticated user.
     *
     * @param   integer  $id  ID of the authorization to retrieve
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function get($id)
    {
        // Build the request path.
        $path = '/authorizations/' . $id;

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get a single grant
     *
     * @param   integer  $id  ID of the authorization to retrieve
     *
     * @return  object
     *
     * @since   1.5.0
     * @throws  \DomainException
     */
    public function getGrant($id)
    {
        // Build the request path.
        $path = '/authorizations/grants/' . $id;

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Method to get the authorised applications for the authenticated user.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function getList()
    {
        // Build the request path.
        $path = '/authorizations';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List your grants.
     *
     * You can use this API to list the set of OAuth applications that have been granted access to your account.
     *
     * @return  object
     *
     * @since   1.5.0
     * @throws  \DomainException
     */
    public function getListGrants()
    {
        // Build the request path.
        $path = '/authorizations/grants';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Method to get the rate limit for the authenticated user.
     *
     * @return  object  Returns an object with the properties of `limit` and `remaining`. If there is no limit, the
     *                  `limit` property will be false.
     *
     * @since   1.0
     * @throws  UnexpectedResponseException
     */
    public function getRateLimit()
    {
        // Build the request path.
        $path = '/rate_limit';

        // Send the request.
        $response = $this->client->get($this->fetchUrl($path));

        // Validate the response code.
        if ($response->code != 200) {
            if ($response->code == 404) {
                // Unlimited rate for Github Enterprise sites and trusted users.
                return (object) ['limit' => false, 'remaining' => null];
            }

            // Decode the error response and throw an exception.
            $error = json_decode($response->body);

            throw new UnexpectedResponseException($response, $error->message, $response->code);
        }

        return json_decode($response->body);
    }

    /**
     * 1. Request authorization on GitHub.
     *
     * @param   string  $clientId     The client ID you received from GitHub when you registered.
     * @param   string  $redirectUri  URL in your app where users will be sent after authorization.
     * @param   string  $scope        Comma separated list of scopes.
     * @param   string  $state        An unguessable random string. It is used to protect against cross-site request forgery attacks.
     *
     * @return  string
     *
     * @since   1.0
     */
    public function getAuthorizationLink($clientId, $redirectUri = '', $scope = '', $state = '')
    {
        $uri = new Uri('https://github.com/login/oauth/authorize');

        $uri->setVar('client_id', $clientId);

        if ($redirectUri) {
            $uri->setVar('redirect_uri', urlencode($redirectUri));
        }

        if ($scope) {
            $uri->setVar('scope', $scope);
        }

        if ($state) {
            $uri->setVar('state', $state);
        }

        return (string) $uri;
    }

    /**
     * 2. Request the access token.
     *
     * @param   string  $clientId      The client ID you received from GitHub when you registered.
     * @param   string  $clientSecret  The client secret you received from GitHub when you registered.
     * @param   string  $code          The code you received as a response to Step 1.
     * @param   string  $redirectUri   URL in your app where users will be sent after authorization.
     * @param   string  $format        The response format (json, xml, ).
     *
     * @return  string
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     */
    public function requestToken($clientId, $clientSecret, $code, $redirectUri = '', $format = '')
    {
        $uri = 'https://github.com/login/oauth/access_token';

        $data = [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'code'          => $code,
        ];

        if ($redirectUri) {
            $data['redirect_uri'] = $redirectUri;
        }

        $headers = [];

        switch ($format) {
            case 'json':
                $headers['Accept'] = 'application/json';

                break;

            case 'xml':
                $headers['Accept'] = 'application/xml';

                break;

            default:
                if ($format) {
                    throw new \UnexpectedValueException('Invalid format');
                }

                break;
        }

        // Send the request.
        return $this->processResponse(
            $this->client->post($uri, $data, $headers),
            200
        );
    }

    /**
     * Revoke a grant for an application
     *
     * OAuth application owners can revoke a grant for their OAuth application and a specific user.
     *
     * @param   integer  $clientId     The application client ID
     * @param   integer  $accessToken  The access token to revoke
     *
     * @return  object
     *
     * @since   1.5.0
     * @throws  \DomainException
     */
    public function revokeGrantForApplication($clientId, $accessToken)
    {
        // Build the request path.
        $path = "/applications/$clientId/grants/$accessToken";

        // Send the request.
        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
