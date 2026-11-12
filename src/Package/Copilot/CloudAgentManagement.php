<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Copilot;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Copilot cloud agent management class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot/copilot-cloud-agent-management
 *
 * @since  __DEPLOY_VERSION__
 */
class CloudAgentManagement extends AbstractPackage
{
    /**
     * Get the Copilot cloud agent configuration for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-cloud-agent-management#get-copilot-cloud-agent-configuration-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getConfiguration(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/copilot/cloud-agent/configuration';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
