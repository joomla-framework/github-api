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
 * GitHub API Code Scanning Analyses class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class Analyses extends AbstractPackage
{
    /**
     * List code scanning analyses for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: `tool_name`, `tool_guid`, `pr`, `ref`, `sarif_id`, `direction`, `sort`.
     * @param   integer  $page     The page number to fetch.
     * @param   integer  $limit    The number of results per page (max 100).
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#list-code-scanning-analyses-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getList(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/analyses';

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
     * Get a code scanning analysis for a repository.
     *
     * @param   string   $owner       The account owner of the repository.
     * @param   string   $repo        The name of the repository.
     * @param   integer  $analysisId  The ID of the analysis.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-a-code-scanning-analysis-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $analysisId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/analyses/' . $analysisId;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Delete a code scanning analysis from a repository.
     *
     * @param   string   $owner       The account owner of the repository.
     * @param   string   $repo        The name of the repository.
     * @param   integer  $analysisId  The ID of the analysis.
     * @param   array    $filters     Optional query parameters: `confirm_delete`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#delete-a-code-scanning-analysis-from-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function delete(string $owner, string $repo, int $analysisId, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/analyses/' . $analysisId;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->delete($uri),
            200
        );
    }
}
