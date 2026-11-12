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
 * GitHub API Code Scanning Autofix class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class Autofix extends AbstractPackage
{
    /**
     * Get the status of an autofix for a code scanning alert.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-the-status-of-an-autofix-for-a-code-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $alertNumber)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/alerts/' . $alertNumber . '/autofix';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Create an autofix for a code scanning alert.
     *
     * Answers 200 when an autofix already exists and 202 when its generation was started.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#create-an-autofix-for-a-code-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function create(string $owner, string $repo, int $alertNumber)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/alerts/' . $alertNumber . '/autofix';

        $response = $this->client->post($this->fetchUrl($path), '');

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 202], true) ? $response->getStatusCode() : 200
        );
    }

    /**
     * Commit an autofix for a code scanning alert.
     *
     * @param   string   $owner        The account owner of the repository.
     * @param   string   $repo         The name of the repository.
     * @param   integer  $alertNumber  The number that identifies the alert.
     * @param   array    $options      Optional body fields: `target_ref`, `message`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#commit-an-autofix-for-a-code-scanning-alert
     * @since   __DEPLOY_VERSION__
     */
    public function commit(string $owner, string $repo, int $alertNumber, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/alerts/' . $alertNumber . '/autofix/commits';

        $data = (object) $options;

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }
}
