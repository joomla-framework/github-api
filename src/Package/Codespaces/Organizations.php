<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Codespaces;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Codespaces Organizations class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/codespaces/organizations
 *
 * @since  __DEPLOY_VERSION__
 */
class Organizations extends AbstractPackage
{
    /**
     * List codespaces for the organization.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organizations#list-codespaces-for-the-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getList(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * List codespaces for a user in organization.
     *
     * @param   string   $org       The organization name.
     * @param   string   $username  The handle for the GitHub user account.
     * @param   integer  $page      The page number from which to get items.
     * @param   integer  $limit     The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organizations#list-codespaces-for-a-user-in-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForUser(string $org, string $username, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/members/' . $username . '/codespaces';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Delete a codespace from the organization.
     *
     * @param   string  $org            The organization name.
     * @param   string  $username       The handle for the GitHub user account.
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organizations#delete-a-codespace-from-the-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function delete(string $org, string $username, string $codespaceName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/members/' . $username . '/codespaces/' . rawurlencode($codespaceName);

        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 202);
    }

    /**
     * Stop a codespace for an organization user.
     *
     * @param   string  $org            The organization name.
     * @param   string  $username       The handle for the GitHub user account.
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organizations#stop-a-codespace-for-an-organization-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function stop(string $org, string $username, string $codespaceName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/members/' . $username . '/codespaces/' . rawurlencode($codespaceName) . '/stop';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 200);
    }
}
