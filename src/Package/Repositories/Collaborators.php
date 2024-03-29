<?php

/**
 * Part of the Joomla Framework GitHub Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Repositories;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Repositories Collaborators class for the Joomla Framework.
 *
 * @link   https://developer.github.com/v3/repos/collaborators
 *
 * @since  1.0
 */
class Collaborators extends AbstractPackage
{
    /**
     * List collaborators.
     *
     * When authenticating as an organization owner of an organization-owned repository, all organization
     * owners are included in the list of collaborators. Otherwise, only users with access to the repository
     * are returned in the collaborators list.
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     *
     * @since  1.0
     *
     * @return object
     */
    public function getList($owner, $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/collaborators';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Check if a user is a collaborator.
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     * @param   string  $user   The name of the GitHub user.
     *
     * @throws \UnexpectedValueException
     * @since  1.0
     *
     * @return boolean
     */
    public function get($owner, $repo, $user)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/collaborators/' . $user;

        $response = $this->client->get($this->fetchUrl($path));

        switch ($response->code) {
            case '204':
                return true;

            case '404':
                return false;

            default:
                throw new \UnexpectedValueException('Unexpected code: ' . $response->code);
        }
    }

    /**
     * Add user as a collaborator.
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     * @param   string  $user   The name of the GitHub user.
     *
     * @since  1.0
     *
     * @return object
     */
    public function add($owner, $repo, $user)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/collaborators/' . $user;

        return $this->processResponse(
            $this->client->put($this->fetchUrl($path), ''),
            204
        );
    }

    /**
     * Remove user as a collaborator.
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     * @param   string  $user   The name of the GitHub user.
     *
     * @since  1.0
     *
     * @return object
     */
    public function remove($owner, $repo, $user)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/collaborators/' . $user;

        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }
}
