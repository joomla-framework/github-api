<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Checks;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Checks Runs class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/checks/runs
 *
 * @since  __DEPLOY_VERSION__
 */
class Runs extends AbstractPackage
{
    /**
     * Create a check run.
     *
     * When `status` is `completed`, `conclusion` is required as well.
     *
     * @param   string  $owner    Repository owner.
     * @param   string  $repo     Repository name.
     * @param   string  $name     The name of the check, e.g. "code-coverage".
     * @param   string  $headSha  The SHA of the commit.
     * @param   array   $options  Optional request body fields: details_url, external_id, status, started_at, conclusion, completed_at, output, actions.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/runs#create-a-check-run
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function create(string $owner, string $repo, string $name, string $headSha, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-runs';

        $data = json_encode(array_merge($options, ['name' => $name, 'head_sha' => $headSha]));

        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Get a check run.
     *
     * @param   string   $owner       Repository owner.
     * @param   string   $repo        Repository name.
     * @param   integer  $checkRunId  Check run identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/runs#get-a-check-run
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function get(string $owner, string $repo, int $checkRunId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-runs/' . $checkRunId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update a check run.
     *
     * @param   string   $owner       Repository owner.
     * @param   string   $repo        Repository name.
     * @param   integer  $checkRunId  Check run identifier.
     * @param   array    $options     Optional request body fields: name, details_url, external_id, started_at, status, conclusion, completed_at, output, actions.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/runs#update-a-check-run
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function edit(string $owner, string $repo, int $checkRunId, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-runs/' . $checkRunId;

        $data = json_encode((object) $options);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * List check run annotations.
     *
     * @param   string   $owner       Repository owner.
     * @param   string   $repo        Repository name.
     * @param   integer  $checkRunId  Check run identifier.
     * @param   integer  $page        The page number from which to get items.
     * @param   integer  $limit       The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/checks/runs#list-check-run-annotations
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListAnnotations(string $owner, string $repo, int $checkRunId, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-runs/' . $checkRunId . '/annotations';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Rerequest a check run.
     *
     * @param   string   $owner       Repository owner.
     * @param   string   $repo        Repository name.
     * @param   integer  $checkRunId  Check run identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/runs#rerequest-a-check-run
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function rerequest(string $owner, string $repo, int $checkRunId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-runs/' . $checkRunId . '/rerequest';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * List check runs in a check suite.
     *
     * @param   string   $owner         Repository owner.
     * @param   string   $repo          Repository name.
     * @param   integer  $checkSuiteId  Check suite identifier.
     * @param   array    $filters       Optional query parameters: check_name, status, filter.
     * @param   integer  $page          The page number from which to get items.
     * @param   integer  $limit         The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/runs#list-check-runs-in-a-check-suite
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForSuite(string $owner, string $repo, int $checkSuiteId, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-suites/' . $checkSuiteId . '/check-runs';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List check runs for a Git reference.
     *
     * @param   string   $owner    Repository owner.
     * @param   string   $repo     Repository name.
     * @param   string   $ref      Git reference (SHA, branch name or tag name).
     * @param   array    $filters  Optional query parameters: check_name, status, filter, app_id.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/runs#list-check-runs-for-a-git-reference
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForRef(string $owner, string $repo, string $ref, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/commits/' . rawurlencode($ref) . '/check-runs';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }
}
