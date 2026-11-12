<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Projects;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Projects Views class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/projects/views
 *
 * @since  __DEPLOY_VERSION__
 */
class Views extends AbstractPackage
{
    /**
     * Create a view for an organization-owned project.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   string   $name           The name of the view.
     * @param   string   $layout         The layout of the view: table, board or roadmap.
     * @param   array    $options        Optional request body fields: filter, visible_fields, sort_by, group_by, vertical_group_by.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/views#create-a-view-for-an-organization-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForOrg(string $org, int $projectNumber, string $name, string $layout, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/views';

        $data = json_encode(array_merge($options, ['name' => $name, 'layout' => $layout]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Create a view for a user-owned project.
     *
     * Note that GitHub addresses the user by numeric ID here.
     *
     * @param   string   $userId         The unique (numeric) identifier of the user.
     * @param   integer  $projectNumber  Project number.
     * @param   string   $name           The name of the view.
     * @param   string   $layout         The layout of the view: table, board or roadmap.
     * @param   array    $options        Optional request body fields: filter, visible_fields, sort_by, group_by, vertical_group_by.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/views#create-a-view-for-a-user-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForUser(string $userId, int $projectNumber, string $name, string $layout, array $options = [])
    {
        // Build the request path.
        $path = '/users/' . $userId . '/projectsV2/' . $projectNumber . '/views';

        $data = json_encode(array_merge($options, ['name' => $name, 'layout' => $layout]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }
}
