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
 * GitHub API Code Scanning CodeQL Databases class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class CodeqlDatabases extends AbstractPackage
{
    /**
     * List CodeQL databases for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#list-codeql-databases-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getList(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/codeql/databases';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Get a CodeQL database for a repository.
     *
     * @param   string  $owner     The account owner of the repository.
     * @param   string  $repo      The name of the repository.
     * @param   string  $language  The language of the CodeQL database.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-a-codeql-database-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, string $language)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/codeql/databases/' . rawurlencode($language);

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Delete a CodeQL database.
     *
     * @param   string  $owner     The account owner of the repository.
     * @param   string  $repo      The name of the repository.
     * @param   string  $language  The language of the CodeQL database.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#delete-a-codeql-database
     * @since   __DEPLOY_VERSION__
     */
    public function delete(string $owner, string $repo, string $language)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/codeql/databases/' . rawurlencode($language);

        $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }
}
