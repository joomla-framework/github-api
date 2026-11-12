<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Codespaces;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Codespaces Machines class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/codespaces/machines
 *
 * @since  __DEPLOY_VERSION__
 */
class Machines extends AbstractPackage
{
    /**
     * List available machine types for a repository.
     *
     * @param   string  $owner    The name of the owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $filters  Optional query parameters: location, client_ip, ref.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/machines#list-available-machine-types-for-a-repository
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/machines';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * List machine types for a codespace.
     *
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/machines#list-machine-types-for-a-codespace
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForCodespace(string $codespaceName)
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName) . '/machines';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }
}
