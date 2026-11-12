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
 * GitHub API Checks Suites class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/checks/suites
 *
 * @since  __DEPLOY_VERSION__
 */
class Suites extends AbstractPackage
{
    /**
     * Create a check suite.
     *
     * GitHub answers 200 when a check suite for the SHA already exists and 201 when it was created.
     *
     * @param   string  $owner    Repository owner.
     * @param   string  $repo     Repository name.
     * @param   string  $headSha  The SHA of the head commit.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/suites#create-a-check-suite
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function create(string $owner, string $repo, string $headSha)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-suites';

        $data = json_encode(['head_sha' => $headSha]);

        $response = $this->client->post($this->fetchUrl($path), $data);

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 201], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * Update repository preferences for check suites.
     *
     * @param   string  $owner    Repository owner.
     * @param   string  $repo     Repository name.
     * @param   array   $options  Optional request body fields: auto_trigger_checks.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/suites#update-repository-preferences-for-check-suites
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setPreferences(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-suites/preferences';

        $data = json_encode((object) $options);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * Get a check suite.
     *
     * @param   string   $owner         Repository owner.
     * @param   string   $repo          Repository name.
     * @param   integer  $checkSuiteId  Check suite identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/suites#get-a-check-suite
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function get(string $owner, string $repo, int $checkSuiteId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-suites/' . $checkSuiteId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Rerequest a check suite.
     *
     * @param   string   $owner         Repository owner.
     * @param   string   $repo          Repository name.
     * @param   integer  $checkSuiteId  Check suite identifier.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/suites#rerequest-a-check-suite
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function rerequest(string $owner, string $repo, int $checkSuiteId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/check-suites/' . $checkSuiteId . '/rerequest';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * List check suites for a Git reference.
     *
     * @param   string   $owner    Repository owner.
     * @param   string   $repo     Repository name.
     * @param   string   $ref      Git reference (SHA, branch name or tag name).
     * @param   array    $filters  Optional query parameters: app_id, check_name.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/checks/suites#list-check-suites-for-a-git-reference
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForRef(string $owner, string $repo, string $ref, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/commits/' . rawurlencode($ref) . '/check-suites';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }
}
