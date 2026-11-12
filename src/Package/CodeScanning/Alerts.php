<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\CodeScanning;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Code Scanning Alerts class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class Alerts extends AbstractPackage
{
    /**
     * List code scanning alerts for an organization.
     *
     * @param   string   $org      The organization name.
     * @param   array    $filters  Optional query parameters: `tool_name`, `tool_guid`, `before`, `after`, `direction`, `state`, `sort`, `severity`, `assignees`.
     * @param   integer  $page     The page number to fetch.
     * @param   integer  $limit    The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#list-code-scanning-alerts-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/code-scanning/alerts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * List code scanning alerts for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: `tool_name`, `tool_guid`, `ref`, `pr`, `direction`, `before`, `after`, `sort`, `state`, `severity`, `assignees`.
     * @param   integer  $page     The page number to fetch.
     * @param   integer  $limit    The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#list-code-scanning-alerts-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/alerts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * Get a code scanning alert.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-a-code-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $alertNumber)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/alerts/' . $alertNumber;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Update a code scanning alert.
     *
     * At least one of `state` or `assignees` must be given.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     * @param   array    $options      Optional body fields: `state`, `dismissed_reason`, `dismissed_comment`, `create_request`, `assignees`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#update-a-code-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function edit(string $owner, string $repo, int $alertNumber, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/alerts/' . $alertNumber;

        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }

    /**
     * List instances of a code scanning alert.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     * @param   array    $filters      Optional query parameters: `ref`, `pr`.
     * @param   integer  $page         The page number to fetch.
     * @param   integer  $limit        The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#list-instances-of-a-code-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function getInstances(string $owner, string $repo, int $alertNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/alerts/' . $alertNumber . '/instances';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }
}
