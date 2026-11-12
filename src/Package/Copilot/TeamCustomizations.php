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
 * GitHub API Copilot team customizations class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot/copilot-team-customizations
 *
 * @since  __DEPLOY_VERSION__
 */
class TeamCustomizations extends AbstractPackage
{
    /**
     * Get Copilot customizations for a team.
     *
     * @param   string  $org       The organisation name.
     * @param   string  $teamSlug  The slug of the team name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-team-customizations#get-copilot-customizations-for-a-team
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $org, string $teamSlug)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/teams/' . $teamSlug . '/copilot/customizations';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set Copilot customizations for a team.
     *
     * @param   string  $org       The organisation name.
     * @param   string  $teamSlug  The slug of the team name.
     * @param   array   $options   Optional body fields: `pluginAssignments`, `extraKnownMarketplaces`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-team-customizations#set-copilot-customizations-for-a-team
     * @since   __DEPLOY_VERSION__
     */
    public function set(string $org, string $teamSlug, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/teams/' . $teamSlug . '/copilot/customizations';

        $data = (object) $options;

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Delete Copilot customizations for a team.
     *
     * @param   string  $org       The organisation name.
     * @param   string  $teamSlug  The slug of the team name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/copilot/copilot-team-customizations#delete-copilot-customizations-for-a-team
     * @since   __DEPLOY_VERSION__
     */
    public function delete(string $org, string $teamSlug)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/teams/' . $teamSlug . '/copilot/customizations';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
