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
 * GitHub API Dependabot Alerts class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/dependabot/alerts
 *
 * @since  __DEPLOY_VERSION__
 */
class Alerts extends AbstractPackage
{
    /**
     * List Dependabot alerts for an organization.
     *
     * The endpoint uses cursor-based pagination: pass `before` / `after` as filters.
     *
     * @param   string   $org      The organization name.
     * @param   array    $filters  Optional query parameters: `classification`, `state`, `severity`, `ecosystem`, `package`, `epss_percentage`, `artifact_registry_url`, `artifact_registry`, `has`, `assignee`, `runtime_risk`, `scope`, `relationship`, `sort`, `direction`, `before`, `after`.
     * @param   integer  $limit    The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/dependabot/alerts#list-dependabot-alerts-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, array $filters = [], int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/alerts';

        $uri = $this->fetchUrl($path, 0, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * List Dependabot alerts for a repository.
     *
     * The endpoint uses cursor-based pagination: pass `before` / `after` as filters.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: `classification`, `state`, `severity`, `ecosystem`, `package`, `manifest`, `epss_percentage`, `has`, `assignee`, `scope`, `relationship`, `sort`, `direction`, `before`, `after`.
     * @param   integer  $limit    The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/dependabot/alerts#list-dependabot-alerts-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/alerts';

        $uri = $this->fetchUrl($path, 0, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * Get a Dependabot alert.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/alerts#get-a-dependabot-alert
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $alertNumber)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/alerts/' . $alertNumber;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Update a Dependabot alert.
     *
     * At least one of `state` or `assignees` must be given.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     * @param   array    $options      Optional body fields: `state`, `dismissed_reason`, `dismissed_comment`, `assignees`, `agent_assignment`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/alerts#update-a-dependabot-alert
     * @since   __DEPLOY_VERSION__
     */
    public function edit(string $owner, string $repo, int $alertNumber, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/alerts/' . $alertNumber;

        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }
}
