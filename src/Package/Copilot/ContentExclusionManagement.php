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
 * GitHub API Copilot content exclusion management class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot/copilot-content-exclusion-management
 *
 * @since  __DEPLOY_VERSION__
 */
class ContentExclusionManagement extends AbstractPackage
{
    /**
     * Get Copilot content exclusion rules for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-content-exclusion-management#get-copilot-content-exclusion-rules-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/content_exclusion';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set Copilot content exclusion rules for an organisation.
     *
     * @param   string  $org    The organisation name.
     * @param   array   $rules  The exclusion rules, keyed by repository name, each a list of paths or match objects.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-content-exclusion-management#set-copilot-content-exclusion-rules-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function set(string $org, array $rules)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/content_exclusion';

        $data = (object) $rules;

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }
}
