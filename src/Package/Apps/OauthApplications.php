<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Apps;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Apps OAuth Applications class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/apps/oauth-applications
 *
 * @since  __DEPLOY_VERSION__
 */
class OauthApplications extends AbstractPackage
{
    /**
     * Delete an app authorization.
     *
     * Authenticate with Basic auth, the client ID as user name and the client secret as password (see docs/apps.md).
     *
     * @param   string  $clientId     Client ID of the GitHub App or OAuth app.
     * @param   string  $accessToken  The OAuth access token.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/oauth-applications#delete-an-app-authorization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteAuthorization(string $clientId, string $accessToken)
    {
        // Build the request path.
        $path = '/applications/' . $clientId . '/grant';

        $data = json_encode(['access_token' => $accessToken]);

        $this->processResponse($this->client->delete($this->fetchUrl($path), [], null, $data), 204);
    }

    /**
     * Check a token.
     *
     * Authenticate with Basic auth, the client ID as user name and the client secret as password (see docs/apps.md).
     *
     * @param   string  $clientId     Client ID of the GitHub App or OAuth app.
     * @param   string  $accessToken  The OAuth access token.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/oauth-applications#check-a-token
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function checkToken(string $clientId, string $accessToken)
    {
        // Build the request path.
        $path = '/applications/' . $clientId . '/token';

        $data = json_encode(['access_token' => $accessToken]);

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data));
    }

    /**
     * Reset a token.
     *
     * Authenticate with Basic auth, the client ID as user name and the client secret as password (see docs/apps.md).
     *
     * @param   string  $clientId     Client ID of the GitHub App or OAuth app.
     * @param   string  $accessToken  The OAuth access token.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/oauth-applications#reset-a-token
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function resetToken(string $clientId, string $accessToken)
    {
        // Build the request path.
        $path = '/applications/' . $clientId . '/token';

        $data = json_encode(['access_token' => $accessToken]);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * Delete an app token.
     *
     * Authenticate with Basic auth, the client ID as user name and the client secret as password (see docs/apps.md).
     *
     * @param   string  $clientId     Client ID of the GitHub App or OAuth app.
     * @param   string  $accessToken  The OAuth access token.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/oauth-applications#delete-an-app-token
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteToken(string $clientId, string $accessToken)
    {
        // Build the request path.
        $path = '/applications/' . $clientId . '/token';

        $data = json_encode(['access_token' => $accessToken]);

        $this->processResponse($this->client->delete($this->fetchUrl($path), [], null, $data), 204);
    }
}
