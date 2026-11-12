<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Activity;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Activity Watching Events class for the Joomla Framework.
 *
 * @link   https://developer.github.com/v3/activity/watching/
 *
 * @since  1.0
 */
class Watching extends AbstractPackage
{
    /**
     * List watchers
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  mixed
     *
     * @since   1.0
     */
    public function getList(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/subscribers';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * List repositories being watched.
     *
     * List repositories being watched by a user.
     *
     * @param   string  $user  User name.
     *
     * @return  mixed
     *
     * @since   1.0
     */
    public function getRepositories(string $user = '')
    {
        // Build the request path.
        $path = ($user)
            ? '/users/' . $user . '/subscriptions'
            : '/user/subscriptions';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Get a Repository Subscription.
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function getSubscription(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/subscription';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Set a Repository Subscription.
     *
     * @param   string   $owner       Repository owner.
     * @param   string   $repo        Repository name.
     * @param   boolean  $subscribed  Determines if notifications should be received from this thread.
     * @param   boolean  $ignored     Determines if all notifications should be blocked from this thread.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function setSubscription(string $owner, string $repo, bool $subscribed, bool $ignored)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/subscription';

        $data = [
            'subscribed' => $subscribed,
            'ignored'    => $ignored,
        ];

        return $this->processResponse(
            $this->client->put($this->fetchUrl($path), json_encode($data))
        );
    }

    /**
     * Delete a Repository Subscription.
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function deleteSubscription(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/subscription';

        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }
}
