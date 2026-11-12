<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Dependabot;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Dependabot Repository Access class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/dependabot/repository-access
 *
 * @since  __DEPLOY_VERSION__
 */
class RepositoryAccess extends AbstractPackage
{
    /**
     * List the repositories Dependabot can access in an organization.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number to fetch.
     * @param   integer  $limit  The number of results per page (max 100).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/repository-access#lists-the-repositories-dependabot-can-access-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getList(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/repository-access';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit)),
            200
        );
    }

    /**
     * Update Dependabot's repository access list for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: `repository_ids_to_add`, `repository_ids_to_remove`.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/dependabot/repository-access#updates-dependabots-repository-access-list-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function edit(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/repository-access';

        $data = (object) $options;

        $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            204
        );
    }

    /**
     * Set the default repository access level for Dependabot.
     *
     * @param   string  $org           The organization name.
     * @param   string  $defaultLevel  The default access level: `public` or `internal`.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/dependabot/repository-access#set-the-default-repository-access-level-for-dependabot
     * @since   __DEPLOY_VERSION__
     */
    public function setDefaultLevel(string $org, string $defaultLevel)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/repository-access/default-level';

        $data = ['default_level' => $defaultLevel];

        $this->processResponse(
            $this->client->put($this->fetchUrl($path), json_encode($data)),
            204
        );
    }
}
