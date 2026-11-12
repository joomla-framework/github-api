<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Orgs;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Orgs Teams class for the Joomla Framework.
 *
 * All actions against teams require at a minimum an authenticated user who is a member
 * of the owner’s team in the :org being managed. Additionally, OAuth users require “user” scope.
 *
 * @link   https://developer.github.com/v3/orgs/teams/
 *
 * @since  1.0
 */
class Teams extends AbstractPackage
{
    /**
     * List teams.
     *
     * @param   string  $org  The name of the organization.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function getList(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/teams';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Create team.
     *
     * In order to create a team, the authenticated user must be an owner of the organization.
     *
     * @param   string  $org         The name of the organization.
     * @param   string  $name        The name of the team.
     * @param   array   $repoNames   Repository names.
     * @param   string  $permission  The permission. (Deprecated)
     *                               pull - team members can pull, but not push to or administer these repositories. Default
     *                               push - team members can pull and push, but not administer these repositories.
     *                               admin - team members can pull, push and administer these repositories.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     */
    public function create(string $org, string $name, array $repoNames = [], string $permission = '')
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/teams';

        $data = [
            'name' => $name,
        ];

        if ($repoNames) {
            $data['repo_names'] = $repoNames;
        }

        if ($permission) {
            if (\in_array($permission, ['pull', 'push', 'admin']) == false) {
                throw new \UnexpectedValueException('Permissions must be either "pull", "push", or "admin".');
            }

            $data['permission'] = $permission;
        }

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), $data),
            201
        );
    }

    /**
     * List user teams.
     *
     * List all of the teams across all of the organizations to which the authenticated user belongs.
     * This method requires user, repo, or read:org scope when authenticating via OAuth.
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @since   1.4.0
     */
    public function getUserTeams(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/teams';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit))
        );
    }
}
