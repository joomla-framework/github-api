<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Dependabot;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Dependabot Runner Settings class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/dependabot/runner-settings
 *
 * @since  __DEPLOY_VERSION__
 */
class RunnerSettings extends AbstractPackage
{
    /**
     * Get repository Dependabot runner settings.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/runner-settings#get-repository-dependabot-runner-settings
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/runner-settings';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Set repository Dependabot runner settings.
     *
     * @param   string  $owner       The account owner of the repository.
     * @param   string  $repo        The name of the repository.
     * @param   string  $runnerType  The runner type: `github`, `labeled` or `group`.
     * @param   array   $options     Optional body fields: `runner_labels`, `runner_group`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/runner-settings#set-repository-dependabot-runner-settings
     * @since   __DEPLOY_VERSION__
     */
    public function set(string $owner, string $repo, string $runnerType, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/runner-settings';

        $data = array_merge($options, ['runner_type' => $runnerType]);

        return $this->processResponse(
            $this->client->put($this->fetchUrl($path), json_encode($data)),
            200
        );
    }
}
