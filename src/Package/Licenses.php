<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Licenses class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/licenses/licenses
 *
 * @since  __DEPLOY_VERSION__
 */
class Licenses extends AbstractPackage
{
    /**
     * Get all commonly used licenses.
     *
     * @param   array  $filters  Optional query parameters: `featured`.
     * @param   int    $page     The page number from which to get items.
     * @param   int    $limit    The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/licenses/licenses#get-all-commonly-used-licenses
     * @since   __DEPLOY_VERSION__
     */
    public function getList(array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/licenses';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            if (\is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get a license.
     *
     * @param   string  $license  The license key, e.g. `mit`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/licenses/licenses#get-a-license
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $license)
    {
        // Build the request path.
        $path = '/licenses/' . rawurlencode($license);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get the license for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $filters  Optional query parameters: `ref`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/licenses/licenses#get-the-license-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/license';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri));
    }
}
