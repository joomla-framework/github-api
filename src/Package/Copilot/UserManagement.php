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
 * GitHub API Copilot user management class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot/copilot-user-management
 *
 * @since  __DEPLOY_VERSION__
 */
class UserManagement extends AbstractPackage
{
    /**
     * Get Copilot seat information and settings for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-user-management#get-copilot-seat-information-and-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/billing';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List all Copilot seat assignments for an organisation.
     *
     * @param   string  $org    The organisation name.
     * @param   int     $page   The page number from which to get items.
     * @param   int     $limit  The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-user-management#list-all-copilot-seat-assignments-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getList(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/billing/seats';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Add teams to the Copilot subscription for an organisation.
     *
     * @param   string  $org            The organisation name.
     * @param   array   $selectedTeams  List of team names.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-user-management#add-teams-to-the-copilot-subscription-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function addTeams(string $org, array $selectedTeams)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/billing/selected_teams';

        $data = ['selected_teams' => $selectedTeams];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Remove teams from the Copilot subscription for an organisation.
     *
     * @param   string  $org            The organisation name.
     * @param   array   $selectedTeams  List of team names.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-user-management#remove-teams-from-the-copilot-subscription-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function removeTeams(string $org, array $selectedTeams)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/billing/selected_teams';

        $data = ['selected_teams' => $selectedTeams];

        return $this->processResponse($this->client->delete($this->fetchUrl($path), [], null, json_encode($data)));
    }

    /**
     * Add users to the Copilot subscription for an organisation.
     *
     * @param   string  $org                The organisation name.
     * @param   array   $selectedUsernames  List of usernames.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-user-management#add-users-to-the-copilot-subscription-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function addUsers(string $org, array $selectedUsernames)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/billing/selected_users';

        $data = ['selected_usernames' => $selectedUsernames];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Remove users from the Copilot subscription for an organisation.
     *
     * @param   string  $org                The organisation name.
     * @param   array   $selectedUsernames  List of usernames.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-user-management#remove-users-from-the-copilot-subscription-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function removeUsers(string $org, array $selectedUsernames)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/billing/selected_users';

        $data = ['selected_usernames' => $selectedUsernames];

        return $this->processResponse($this->client->delete($this->fetchUrl($path), [], null, json_encode($data)));
    }

    /**
     * Get Copilot seat assignment details for a user.
     *
     * @param   string  $org       The organisation name.
     * @param   string  $username  The handle for the GitHub user account.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-user-management#get-copilot-seat-assignment-details-for-a-user
     * @since   __DEPLOY_VERSION__
     */
    public function getForUser(string $org, string $username)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/members/' . $username . '/copilot';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
