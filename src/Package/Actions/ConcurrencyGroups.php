<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Actions;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Actions Concurrency Groups class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/concurrency-groups
 *
 * @since  __DEPLOY_VERSION__
 */
class ConcurrencyGroups extends AbstractPackage
{
    /**
     * List concurrency groups for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: after.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/concurrency-groups#list-concurrency-groups-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/concurrency_groups';

        $uri = $this->fetchUrl($path, 0, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get a concurrency group for a repository.
     *
     * @param   string  $owner                 The account owner of the repository.
     * @param   string  $repo                  The name of the repository.
     * @param   string  $concurrencyGroupName  The name of the concurrency group.
     * @param   array   $filters               Optional query parameters: ahead_of_run, ahead_of_job.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/concurrency-groups#get-a-concurrency-group-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, string $concurrencyGroupName, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/concurrency_groups/' . rawurlencode($concurrencyGroupName);

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List concurrency groups for a workflow run.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $runId    The ID of the workflow run.
     * @param   array    $filters  Optional query parameters: before, after.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/concurrency-groups#list-concurrency-groups-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRun(string $owner, string $repo, int $runId, array $filters = [], int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/concurrency_groups';

        $uri = $this->fetchUrl($path, 0, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }
}
