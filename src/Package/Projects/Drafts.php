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
 * GitHub API Projects Drafts class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/projects/drafts
 *
 * @since  __DEPLOY_VERSION__
 */
class Drafts extends AbstractPackage
{
    /**
     * Create draft item for organization owned project.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     * @param   string   $title          The title of the draft issue item.
     * @param   array    $options        Optional request body fields: body.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/drafts#create-draft-item-for-organization-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForOrg(string $org, int $projectNumber, string $title, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber . '/drafts';

        $data = json_encode(array_merge($options, ['title' => $title]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Create draft item for user owned project.
     *
     * Note that GitHub addresses the user by numeric ID here, under `/user/` (singular).
     *
     * @param   string   $userId         The unique (numeric) identifier of the user.
     * @param   integer  $projectNumber  Project number.
     * @param   string   $title          The title of the draft issue item.
     * @param   array    $options        Optional request body fields: body.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/drafts#create-draft-item-for-user-owned-project
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForUser(string $userId, int $projectNumber, string $title, array $options = [])
    {
        // Build the request path.
        $path = '/user/' . $userId . '/projectsV2/' . $projectNumber . '/drafts';

        $data = json_encode(array_merge($options, ['title' => $title]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }
}
