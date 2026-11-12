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
 * GitHub API Code Scanning Default Setup class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class DefaultSetup extends AbstractPackage
{
    /**
     * Get a code scanning default setup configuration.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-a-code-scanning-default-setup-configuration
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/default-setup';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Update a code scanning default setup configuration.
     *
     * Answers 200 when the change was applied and 202 when a workflow run was started for it.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: `state`, `runner_type`, `runner_label`, `query_suite`, `threat_model`, `languages`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#update-a-code-scanning-default-setup-configuration
     * @since   __DEPLOY_VERSION__
     */
    public function edit(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/default-setup';

        $data = (object) $options;

        $response = $this->client->patch($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 202], true) ? $response->getStatusCode() : 200
        );
    }
}
