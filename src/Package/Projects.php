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
 * GitHub API Projects (v2) class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/projects/projects
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Projects\Drafts  $drafts  GitHub API object for project draft items.
 * @property-read  Projects\Fields  $fields  GitHub API object for project fields.
 * @property-read  Projects\Items   $items   GitHub API object for project items.
 * @property-read  Projects\Views   $views   GitHub API object for project views.
 */
class Projects extends AbstractPackage
{
    /**
     * List projects for organization.
     *
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $org      Organisation name.
     * @param   array    $filters  Optional query parameters: q, before, after.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/projects#list-projects-for-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForOrg(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get project for organization.
     *
     * @param   string   $org            Organisation name.
     * @param   integer  $projectNumber  Project number.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/projects#get-project-for-organization
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForOrg(string $org, int $projectNumber)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/projectsV2/' . $projectNumber;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List projects for user.
     *
     * Cursor-based pagination: pass the `before` / `after` filters; GitHub uses only `$limit` (per_page), not `$page`.
     *
     * @param   string   $username  GitHub user name.
     * @param   array    $filters   Optional query parameters: q, before, after.
     * @param   integer  $page      The page number from which to get items.
     * @param   integer  $limit     The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/projects/projects#list-projects-for-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForUser(string $username, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get project for user.
     *
     * @param   string   $username       GitHub user name.
     * @param   integer  $projectNumber  Project number.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/projects/projects#get-project-for-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getForUser(string $username, int $projectNumber)
    {
        // Build the request path.
        $path = '/users/' . $username . '/projectsV2/' . $projectNumber;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
