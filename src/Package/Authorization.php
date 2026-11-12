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
        if ($response->getStatusCode() != 200) {
            if ($response->getStatusCode() == 404) {
                // Unlimited rate for Github Enterprise sites and trusted users.
                return (object) ['limit' => false, 'remaining' => null];
            }

            // Decode the error response and throw an exception.
            $error = json_decode((string) $response->getBody());

            throw new UnexpectedResponseException($response, $error->message, $response->getStatusCode());
        }

        return json_decode((string) $response->getBody());
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
}
