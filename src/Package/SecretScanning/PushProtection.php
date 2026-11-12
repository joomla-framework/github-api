<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\SecretScanning;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Secret Scanning Push Protection class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/secret-scanning/push-protection
 *
 * @since  __DEPLOY_VERSION__
 */
class PushProtection extends AbstractPackage
{
    /**
     * List organization pattern configurations.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/push-protection#list-organization-pattern-configurations
     * @since   __DEPLOY_VERSION__
     */
    public function getPatternConfigurations(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/secret-scanning/pattern-configurations';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Update organization pattern configurations.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: `pattern_config_version`, `provider_pattern_settings`, `custom_pattern_settings`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/secret-scanning/push-protection#update-organization-pattern-configurations
     * @since   __DEPLOY_VERSION__
     */
    public function editPatternConfigurations(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/secret-scanning/pattern-configurations';

        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }
}
