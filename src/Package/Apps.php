<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Apps class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/apps/apps
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Apps\Installations      $installations      GitHub API object for app installations.
 * @property-read  Apps\Marketplace        $marketplace        GitHub API object for GitHub Marketplace.
 * @property-read  Apps\OauthApplications  $oauthApplications  GitHub API object for OAuth applications.
 * @property-read  Apps\Webhooks           $webhooks           GitHub API object for app webhooks.
 */
class Apps extends AbstractPackage
{
    /**
     * Get the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#get-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getAuthenticated()
    {
        // Build the request path.
        $path = '/app';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Create a GitHub App from a manifest.
     *
     * No authentication is needed; the temporary code is the credential.
     *
     * @param   string  $code  The temporary code returned by the manifest flow.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#create-a-github-app-from-a-manifest
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createFromManifest(string $code)
    {
        // Build the request path.
        $path = '/app-manifests/' . $code . '/conversions';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * List installation requests for the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/apps#list-installation-requests-for-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListInstallationRequests(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/app/installation-requests';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List installations for the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   array    $filters  Optional query parameters: since, outdated.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/apps/apps#list-installations-for-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListInstallations(array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/app/installations';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get an installation for the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $installationId  Installation identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#get-an-installation-for-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getInstallation(int $installationId)
    {
        // Build the request path.
        $path = '/app/installations/' . $installationId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Delete an installation for the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $installationId  Installation identifier.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/apps#delete-an-installation-for-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteInstallation(int $installationId)
    {
        // Build the request path.
        $path = '/app/installations/' . $installationId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Create an installation access token for an app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $installationId  Installation identifier.
     * @param   array    $options         Optional request body fields: repositories, repository_ids, permissions.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#create-an-installation-access-token-for-an-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createInstallationAccessToken(int $installationId, array $options = [])
    {
        // Build the request path.
        $path = '/app/installations/' . $installationId . '/access_tokens';

        $data = json_encode((object) $options);

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Suspend an app installation.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $installationId  Installation identifier.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/apps#suspend-an-app-installation
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function suspendInstallation(int $installationId)
    {
        // Build the request path.
        $path = '/app/installations/' . $installationId . '/suspended';

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Unsuspend an app installation.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   integer  $installationId  Installation identifier.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/apps#unsuspend-an-app-installation
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function unsuspendInstallation(int $installationId)
    {
        // Build the request path.
        $path = '/app/installations/' . $installationId . '/suspended';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Create a scoped access token.
     *
     * Authenticate with Basic auth, the client ID as user name and the client secret as password (see docs/apps.md).
     *
     * @param   string  $clientId     Client ID of the GitHub App or OAuth app.
     * @param   string  $accessToken  The OAuth access token.
     * @param   array   $options      Optional request body fields: target, target_id, repositories, repository_ids, permissions.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#create-a-scoped-access-token
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function scopeToken(string $clientId, string $accessToken, array $options = [])
    {
        // Build the request path.
        $path = '/applications/' . $clientId . '/token/scoped';

        $data = json_encode(array_merge($options, ['access_token' => $accessToken]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data));
    }

    /**
     * Get an app.
     *
     * @param   string  $appSlug  URL-friendly name of the GitHub App.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#get-an-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getBySlug(string $appSlug)
    {
        // Build the request path.
        $path = '/apps/' . $appSlug;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get an organization installation for the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   string  $org  Organisation name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#get-an-organization-installation-for-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getInstallationForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/installation';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get a repository installation for the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#get-a-repository-installation-for-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getInstallationForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/installation';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get a user installation for the authenticated app.
     *
     * Authenticate as the GitHub App with a JWT (see docs/apps.md).
     *
     * @param   string  $username  GitHub user name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/apps#get-a-user-installation-for-the-authenticated-app
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getInstallationForUser(string $username)
    {
        // Build the request path.
        $path = '/users/' . $username . '/installation';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
