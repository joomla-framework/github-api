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
 * GitHub API Apps Installations class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/apps/installations
 *
 * @since  __DEPLOY_VERSION__
 */
class Installations extends AbstractPackage
{
    /**
     * List repositories accessible to the app installation.
     *
     * Authenticate with an installation access token.
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/installations#list-repositories-accessible-to-the-app-installation
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListRepositories(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/installation/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Revoke an installation access token.
     *
     * Revokes the installation access token used to authenticate the request.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/installations#revoke-an-installation-access-token
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function revokeAccessToken()
    {
        // Build the request path.
        $path = '/installation/token';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List app installations accessible to the user access token.
     *
     * Authenticate with a user access token.
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/installations#list-app-installations-accessible-to-the-user-access-token
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForAuthenticatedUser(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/installations';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List repositories accessible to the user access token.
     *
     * Authenticate with a user access token.
     *
     * @param   integer  $installationId  Installation identifier.
     * @param   integer  $page            The page number from which to get items.
     * @param   integer  $limit           The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/apps/installations#list-repositories-accessible-to-the-user-access-token
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListRepositoriesForAuthenticatedUser(int $installationId, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/installations/' . $installationId . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Add a repository to an app installation.
     *
     * Authenticate with a personal access token (classic) with the `repo` scope.
     *
     * @param   integer  $installationId  Installation identifier.
     * @param   integer  $repositoryId    Repository identifier.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/installations#add-a-repository-to-an-app-installation
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addRepository(int $installationId, int $repositoryId)
    {
        // Build the request path.
        $path = '/user/installations/' . $installationId . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Remove a repository from an app installation.
     *
     * Authenticate with a personal access token (classic) with the `repo` scope.
     *
     * @param   integer  $installationId  Installation identifier.
     * @param   integer  $repositoryId    Repository identifier.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/apps/installations#remove-a-repository-from-an-app-installation
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeRepository(int $installationId, int $repositoryId)
    {
        // Build the request path.
        $path = '/user/installations/' . $installationId . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
