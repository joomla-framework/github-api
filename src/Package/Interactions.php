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
 * GitHub API Interactions class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/interactions
 *
 * @since  __DEPLOY_VERSION__
 */
class Interactions extends AbstractPackage
{
    /**
     * Get interaction restrictions for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/orgs#get-interaction-restrictions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getRestrictionsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/interaction-limits';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set interaction restrictions for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   string  $limit    The type of user that may interact: `existing_users`, `contributors_only` or `collaborators_only`.
     * @param   array   $options  Optional body fields: `expiry`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/orgs#set-interaction-restrictions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setRestrictionsForOrg(string $org, string $limit, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/interaction-limits';

        $data = array_merge($options, ['limit' => $limit]);

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Remove interaction restrictions for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/interactions/orgs#remove-interaction-restrictions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function removeRestrictionsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/interaction-limits';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get the pull request creation cap for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/orgs#get-pull-request-creation-cap-for-an-org
     * @since   __DEPLOY_VERSION__
     */
    public function getPullRequestCreationCapForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/interaction-limits/pulls/creation-cap';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update the pull request creation cap for an organisation.
     *
     * @param   string  $org      The organisation name.
     * @param   bool    $enabled  Whether the pull request creation cap is enabled.
     * @param   array   $options  Optional body fields: `max_open_pull_requests`, `include_drafts`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/orgs#update-pull-request-creation-cap-for-an-org
     * @since   __DEPLOY_VERSION__
     */
    public function editPullRequestCreationCapForOrg(string $org, bool $enabled, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/interaction-limits/pulls/creation-cap';

        $data = array_merge($options, ['enabled' => $enabled]);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Get interaction restrictions for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/repos#get-interaction-restrictions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getRestrictionsForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set interaction restrictions for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   string  $limit    The type of user that may interact: `existing_users`, `contributors_only` or `collaborators_only`.
     * @param   array   $options  Optional body fields: `expiry`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/repos#set-interaction-restrictions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setRestrictionsForRepo(string $owner, string $repo, string $limit, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits';

        $data = array_merge($options, ['limit' => $limit]);

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Remove interaction restrictions for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/interactions/repos#remove-interaction-restrictions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function removeRestrictionsForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get the pull request creation cap bypass list for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/repos#get-pull-request-creation-cap-bypass-list-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getPullRequestBypassListForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits/pulls/bypass-list';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Add users to the pull request creation cap bypass list for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     * @param   array   $users  List of usernames.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/interactions/repos#add-users-to-the-pull-request-creation-cap-bypass-list-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function addPullRequestBypassUsersForRepo(string $owner, string $repo, array $users)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits/pulls/bypass-list';

        $data = ['users' => $users];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Remove users from the pull request creation cap bypass list for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     * @param   array   $users  List of usernames.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/interactions/repos#remove-users-from-the-pull-request-creation-cap-bypass-list-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function removePullRequestBypassUsersForRepo(string $owner, string $repo, array $users)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits/pulls/bypass-list';

        $data = ['users' => $users];

        $this->processResponse($this->client->delete($this->fetchUrl($path), [], null, json_encode($data)), 204);
    }

    /**
     * Get the pull request creation cap for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/repos#get-pull-request-creation-cap-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getPullRequestCreationCapForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits/pulls/creation-cap';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update the pull request creation cap for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   bool    $enabled  Whether the pull request creation cap is enabled.
     * @param   array   $options  Optional body fields: `max_open_pull_requests`, `include_drafts`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/repos#update-pull-request-creation-cap-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function editPullRequestCreationCapForRepo(string $owner, string $repo, bool $enabled, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/interaction-limits/pulls/creation-cap';

        $data = array_merge($options, ['enabled' => $enabled]);

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Get interaction restrictions for the public repositories of the authenticated user.
     *
     * @return  object|array|null  Null when GitHub answers 204 No Content.
     *
     * @link    https://docs.github.com/rest/interactions/user#get-interaction-restrictions-for-your-public-repositories
     * @since   __DEPLOY_VERSION__
     */
    public function getRestrictionsForAuthenticatedUser()
    {
        // Build the request path.
        $path = '/user/interaction-limits';

        $response = $this->client->get($this->fetchUrl($path));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 204], true) ? $response->getStatusCode() : 200
        );
    }

    /**
     * Set interaction restrictions for the public repositories of the authenticated user.
     *
     * @param   string  $limit    The type of user that may interact: `existing_users`, `contributors_only` or `collaborators_only`.
     * @param   array   $options  Optional body fields: `expiry`.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/interactions/user#set-interaction-restrictions-for-your-public-repositories
     * @since   __DEPLOY_VERSION__
     */
    public function setRestrictionsForAuthenticatedUser(string $limit, array $options = [])
    {
        // Build the request path.
        $path = '/user/interaction-limits';

        $data = array_merge($options, ['limit' => $limit]);

        return $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Remove interaction restrictions from the public repositories of the authenticated user.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/interactions/user#remove-interaction-restrictions-from-your-public-repositories
     * @since   __DEPLOY_VERSION__
     */
    public function removeRestrictionsForAuthenticatedUser()
    {
        // Build the request path.
        $path = '/user/interaction-limits';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
