<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Orgs;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Orgs Teams class for the Joomla Framework.
 *
 * All actions against teams require at a minimum an authenticated user who is a member
 * of the owner’s team in the :org being managed. Additionally, OAuth users require “user” scope.
 *
 * @link   https://developer.github.com/v3/orgs/teams/
 *
 * @since  1.0
 */
class Teams extends AbstractPackage
{
    /**
     * List teams.
     *
     * @param   string  $org  The name of the organization.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function getList($org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/teams';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Get team.
     *
     * @param   integer  $id  The team id.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use getBySlug() instead.
     */
    public function get($id)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use getBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . (int) $id;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Create team.
     *
     * In order to create a team, the authenticated user must be an owner of the organization.
     *
     * @param   string  $org         The name of the organization.
     * @param   string  $name        The name of the team.
     * @param   array   $repoNames   Repository names.
     * @param   string  $permission  The permission. (Deprecated)
     *                               pull - team members can pull, but not push to or administer these repositories. Default
     *                               push - team members can pull and push, but not administer these repositories.
     *                               admin - team members can pull, push and administer these repositories.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     */
    public function create($org, $name, array $repoNames = [], $permission = '')
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/teams';

        $data = [
            'name' => $name,
        ];

        if ($repoNames) {
            $data['repo_names'] = $repoNames;
        }

        if ($permission) {
            if (\in_array($permission, ['pull', 'push', 'admin']) == false) {
                throw new \UnexpectedValueException('Permissions must be either "pull", "push", or "admin".');
            }

            $data['permission'] = $permission;
        }

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), $data),
            201
        );
    }

    /**
     * Edit team.
     *
     * In order to edit a team, the authenticated user must be an owner of the org that the team is associated with.
     *
     * @param   integer  $id          The team id.
     * @param   string   $name        The name of the team.
     * @param   string   $permission  The permission. (Deprecated)
     *                                pull - team members can pull, but not push to or administer these repositories. Default
     *                                push - team members can pull and push, but not administer these repositories.
     *                                admin - team members can pull, push and administer these repositories.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use editBySlug() instead.
     */
    public function edit($id, $name, $permission = '')
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use editBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . (int) $id;

        $data = [
            'name' => $name,
        ];

        if ($permission) {
            if (\in_array($permission, ['pull', 'push', 'admin']) == false) {
                throw new \UnexpectedValueException('Permissions must be either "pull", "push", or "admin".');
            }

            $data['permission'] = $permission;
        }

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), $data)
        );
    }

    /**
     * Delete team.
     *
     * In order to delete a team, the authenticated user must be an owner of the org that the team is associated with.
     *
     * @param   integer  $id  The team id.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use deleteBySlug() instead.
     */
    public function delete($id)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use deleteBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id;

        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }

    /**
     * List team members.
     *
     * In order to list members in a team, the authenticated user must be a member of the team.
     *
     * @param   integer  $id  The team id.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use getListMembersBySlug() instead.
     */
    public function getListMembers($id)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use getListMembersBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id . '/members';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Get team member.
     *
     * In order to get if a user is a member of a team, the authenticated user must be a member of the team.
     *
     * @param   integer  $id    The team id.
     * @param   string   $user  The name of the user.
     *
     * @return  boolean
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use getMembershipBySlug() instead.
     */
    public function isMember($id, $user)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use getMembershipBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id . '/members/' . $user;

        $response = $this->client->get($this->fetchUrl($path));

        switch ($response->getStatusCode()) {
            case 204:
                // Response if user is a member
                return true;

            case 404:
                // Response if user is not a member
                return false;

            default:
                throw new \UnexpectedValueException('Unexpected response code: ' . $response->getStatusCode());
        }
    }

    /**
     * Add team member.
     *
     * In order to add a user to a team, the authenticated user must have ‘admin’ permissions
     * to the team or be an owner of the org that the team is associated with.
     *
     * @param   integer  $id    The team id.
     * @param   string   $user  The name of the user.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use addMembershipBySlug() instead.
     */
    public function addMember($id, $user)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use addMembershipBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id . '/members/' . $user;

        return $this->processResponse(
            $this->client->put($this->fetchUrl($path), ''),
            204
        );
    }

    /**
     * Remove team member.
     *
     * In order to remove a user from a team, the authenticated user must have ‘admin’ permissions
     * to the team or be an owner of the org that the team is associated with.
     * NOTE: This does not delete the user, it just remove them from the team.
     *
     * @param   integer  $id    The team id.
     * @param   string   $user  The name of the user.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use removeMembershipBySlug() instead.
     */
    public function removeMember($id, $user)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use removeMembershipBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id . '/members/' . $user;

        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }

    /**
     * Get team membership
     *
     * In order to get a user's membership with a team, the team must be visible to the authenticated user.
     *
     * @param   integer  $id    The team id.
     * @param   string   $user  The name of the user.
     *
     * @return  string|boolean  The state the user's membership is in or boolean false if the user is not a member.
     *
     * @since   1.4.0
     * @throws  \UnexpectedValueException
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use getMembershipBySlug() instead.
     */
    public function getTeamMembership($id, $user)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use getMembershipBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = "/teams/$id/memberships/$user";

        $response = $this->client->get($this->fetchUrl($path));

        switch ($response->getStatusCode()) {
            case 200:
                // Response if user is an active member or pending membership
                $body = json_decode((string) $response->getBody());

                return $body->state;

            case 404:
                // Response if user is not a member
                return false;

            default:
                throw new \UnexpectedValueException('Unexpected response code: ' . $response->getStatusCode());
        }
    }

    /**
     * Add team membership
     *
     * If the user is already a member of the team's organization, this endpoint will add the user to the team.
     * In order to add a membership between an organization member and a team, the authenticated user must be
     * an organization owner or a maintainer of the team.
     *
     * @param   integer  $id    The team id.
     * @param   string   $user  The name of the user.
     * @param   string   $role  The role the user should have on the team. Can be either 'member' or 'maintainer'.
     *
     * @return  object
     *
     * @since   1.4.0
     * @throws  \UnexpectedValueException
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use addMembershipBySlug() instead.
     */
    public function addTeamMembership($id, $user, $role = 'member')
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use addMembershipBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = "/teams/$id/memberships/$user";

        if (\in_array($role, ['member', 'maintainer']) == false) {
            throw new \UnexpectedValueException('Roles must be either "member" or "maintainer".');
        }

        $data = [
            'role' => $role,
        ];

        return $this->processResponse($this->client->put($this->fetchUrl($path), $data));
    }

    /**
     * Remove team membership
     *
     * In order to remove a membership between a user and a team, the authenticated user must have 'admin' permissions to the team
     * or be an owner of the organization that the team is associated with.
     * NOTE: This does not delete the user, it just removes their membership from the team.
     *
     * @param   integer  $id    The team id.
     * @param   string   $user  The name of the user.
     *
     * @return  object
     *
     * @since   1.4.0
     * @throws  \UnexpectedValueException
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use removeMembershipBySlug() instead.
     */
    public function removeTeamMembership($id, $user)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use removeMembershipBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = "/teams/$id/memberships/$user";

        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List team repos.
     *
     * @param   integer  $id  The team id.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use getListReposBySlug() instead.
     */
    public function getListRepos($id)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use getListReposBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id . '/repos';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Check if a team manages a repository.
     *
     * @param   integer  $id     The team id.
     * @param   string   $owner  The owner of the GitHub repository.
     * @param   string   $repo   The name of the GitHub repository.
     *
     * @return  boolean
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use checkRepoBySlug() instead.
     */
    public function checkRepo($id, $owner, $repo)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use checkRepoBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id . '/repos/' . $owner . '/' . $repo;

        $response = $this->client->get($this->fetchUrl($path));

        switch ($response->getStatusCode()) {
            case 204:
                // Response if repo is managed by this team.
                return true;

            case 404:
                // Response if repo is not managed by this team.
                return false;

            default:
                throw new \UnexpectedValueException('Unexpected response code: ' . $response->getStatusCode());
        }
    }

    /**
     * Add or update team repository.
     *
     * In order to add a repo to a team, the authenticated user must be an owner of the
     * org that the team is associated with. Also, the repo must be owned by the organization,
     * or a direct form of a repo owned by the organization.
     *
     * If you attempt to add a repo to a team that is not owned by the organization, you get:
     * Status: 422 Unprocessable Entity
     *
     * @param   integer  $id    The team id.
     * @param   string   $org   The name of the organization of the GitHub repository.
     * @param   string   $repo  The name of the GitHub repository.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use addRepoBySlug() instead.
     */
    public function addRepo($id, $org, $repo)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use addRepoBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . $id . '/repos/' . $org . '/' . $repo;

        return $this->processResponse(
            $this->client->put($this->fetchUrl($path), ''),
            204
        );
    }

    /**
     * Remove team repository.
     *
     * In order to remove a repo from a team, the authenticated user must be an owner
     * of the org that the team is associated with. NOTE: This does not delete the
     * repo, it just removes it from the team.
     *
     * @param   integer  $id     The team id.
     * @param   string   $owner  The name of the owner of the GitHub repository.
     * @param   string   $repo   The name of the GitHub repository.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has replaced the /teams/{team_id} routes. Use removeRepoBySlug() instead.
     */
    public function removeRepo($id, $owner, $repo)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has replaced the /teams/{team_id} routes. Use removeRepoBySlug() instead.',
            __METHOD__
        );

        // Build the request path.
        $path = '/teams/' . (int) $id . '/repos/' . $owner . '/' . $repo;

        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }

    /**
     * List user teams.
     *
     * List all of the teams across all of the organizations to which the authenticated user belongs.
     * This method requires user, repo, or read:org scope when authenticating via OAuth.
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @since   1.4.0
     */
    public function getUserTeams($page = 0, $limit = 0)
    {
        // Build the request path.
        $path = '/user/teams';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit))
        );
    }

    /**
     * Get a team by its slug.
     *
     * @param   string  $org   The name of the organization.
     * @param   string  $slug  The slug of the team name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/en/rest/teams/teams#get-a-team-by-name
     * @since   __DEPLOY_VERSION__
     */
    public function getBySlug(string $org, string $slug)
    {
        return $this->processResponse($this->client->get($this->fetchUrl($this->slugPath($org, $slug))));
    }

    /**
     * Edit a team. Only the given values are changed.
     *
     * @param   string       $org          The name of the organization.
     * @param   string       $slug         The slug of the team name.
     * @param   string|null  $name         The name of the team.
     * @param   string|null  $description  The description of the team.
     * @param   string|null  $privacy      The privacy level of the team, `secret` or `closed`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/en/rest/teams/teams#update-a-team
     * @since   __DEPLOY_VERSION__
     */
    public function editBySlug(string $org, string $slug, ?string $name = null, ?string $description = null, ?string $privacy = null)
    {
        $data = array_filter(
            ['name' => $name, 'description' => $description, 'privacy' => $privacy],
            static fn ($value) => $value !== null
        );

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($this->slugPath($org, $slug)), json_encode($data))
        );
    }

    /**
     * Delete a team.
     *
     * @param   string  $org   The name of the organization.
     * @param   string  $slug  The slug of the team name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/en/rest/teams/teams#delete-a-team
     * @since   __DEPLOY_VERSION__
     */
    public function deleteBySlug(string $org, string $slug)
    {
        return $this->processResponse($this->client->delete($this->fetchUrl($this->slugPath($org, $slug))), 204);
    }

    /**
     * List the members of a team.
     *
     * @param   string   $org    The name of the organization.
     * @param   string   $slug   The slug of the team name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/en/rest/teams/members#list-team-members
     * @since   __DEPLOY_VERSION__
     */
    public function getListMembersBySlug(string $org, string $slug, int $page = 0, int $limit = 0)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->slugPath($org, $slug) . '/members', $page, $limit))
        );
    }

    /**
     * Get the team membership of a user.
     *
     * @param   string  $org   The name of the organization.
     * @param   string  $slug  The slug of the team name.
     * @param   string  $user  The name of the user.
     *
     * @return  string|boolean  The state of the membership (`active` or `pending`), or false if the user is not a member.
     *
     * @link    https://docs.github.com/en/rest/teams/members#get-team-membership-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  \UnexpectedValueException
     */
    public function getMembershipBySlug(string $org, string $slug, string $user)
    {
        $response = $this->client->get($this->fetchUrl($this->slugPath($org, $slug) . '/memberships/' . $user));

        switch ($response->getStatusCode()) {
            case 200:
                return json_decode((string) $response->getBody())->state;

            case 404:
                return false;

            default:
                throw new \UnexpectedValueException('Unexpected response code: ' . $response->getStatusCode());
        }
    }

    /**
     * Add or update the team membership of a user.
     *
     * @param   string  $org   The name of the organization.
     * @param   string  $slug  The slug of the team name.
     * @param   string  $user  The name of the user.
     * @param   string  $role  The role of the user in the team, `member` or `maintainer`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/en/rest/teams/members#add-or-update-team-membership-for-a-user
     * @since   __DEPLOY_VERSION__
     * @throws  \UnexpectedValueException
     */
    public function addMembershipBySlug(string $org, string $slug, string $user, string $role = 'member')
    {
        if (\in_array($role, ['member', 'maintainer']) == false) {
            throw new \UnexpectedValueException('Roles must be either "member" or "maintainer".');
        }

        return $this->processResponse(
            $this->client->put(
                $this->fetchUrl($this->slugPath($org, $slug) . '/memberships/' . $user),
                json_encode(['role' => $role])
            )
        );
    }

    /**
     * Remove the team membership of a user.
     *
     * @param   string  $org   The name of the organization.
     * @param   string  $slug  The slug of the team name.
     * @param   string  $user  The name of the user.
     *
     * @return  object
     *
     * @link    https://docs.github.com/en/rest/teams/members#remove-team-membership-for-a-user
     * @since   __DEPLOY_VERSION__
     */
    public function removeMembershipBySlug(string $org, string $slug, string $user)
    {
        return $this->processResponse(
            $this->client->delete($this->fetchUrl($this->slugPath($org, $slug) . '/memberships/' . $user)),
            204
        );
    }

    /**
     * List the repositories of a team.
     *
     * @param   string   $org    The name of the organization.
     * @param   string   $slug   The slug of the team name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/en/rest/teams/teams#list-team-repositories
     * @since   __DEPLOY_VERSION__
     */
    public function getListReposBySlug(string $org, string $slug, int $page = 0, int $limit = 0)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->slugPath($org, $slug) . '/repos', $page, $limit))
        );
    }

    /**
     * Check whether a team has access to a repository.
     *
     * @param   string  $org    The name of the organization.
     * @param   string  $slug   The slug of the team name.
     * @param   string  $owner  The owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  boolean
     *
     * @link    https://docs.github.com/en/rest/teams/teams#check-team-permissions-for-a-repository
     * @since   __DEPLOY_VERSION__
     * @throws  \UnexpectedValueException
     */
    public function checkRepoBySlug(string $org, string $slug, string $owner, string $repo)
    {
        $response = $this->client->get($this->fetchUrl($this->slugPath($org, $slug) . '/repos/' . $owner . '/' . $repo));

        switch ($response->getStatusCode()) {
            case 200:
            case 204:
                return true;

            case 404:
                return false;

            default:
                throw new \UnexpectedValueException('Unexpected response code: ' . $response->getStatusCode());
        }
    }

    /**
     * Add a repository to a team or update the team's permission on it.
     *
     * @param   string       $org         The name of the organization.
     * @param   string       $slug        The slug of the team name.
     * @param   string       $owner       The owner of the repository.
     * @param   string       $repo        The name of the repository.
     * @param   string|null  $permission  The permission, e.g. `pull`, `triage`, `push`, `maintain` or `admin`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/en/rest/teams/teams#add-or-update-team-repository-permissions
     * @since   __DEPLOY_VERSION__
     */
    public function addRepoBySlug(string $org, string $slug, string $owner, string $repo, ?string $permission = null)
    {
        $data = $permission === null ? '' : json_encode(['permission' => $permission]);

        return $this->processResponse(
            $this->client->put($this->fetchUrl($this->slugPath($org, $slug) . '/repos/' . $owner . '/' . $repo), $data),
            204
        );
    }

    /**
     * Remove a repository from a team.
     *
     * @param   string  $org    The name of the organization.
     * @param   string  $slug   The slug of the team name.
     * @param   string  $owner  The owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/en/rest/teams/teams#remove-a-repository-from-a-team
     * @since   __DEPLOY_VERSION__
     */
    public function removeRepoBySlug(string $org, string $slug, string $owner, string $repo)
    {
        return $this->processResponse(
            $this->client->delete($this->fetchUrl($this->slugPath($org, $slug) . '/repos/' . $owner . '/' . $repo)),
            204
        );
    }

    /**
     * Build the path of a team in an organization.
     *
     * @param   string  $org   The name of the organization.
     * @param   string  $slug  The slug of the team name.
     *
     * @return  string
     *
     * @since   __DEPLOY_VERSION__
     */
    private function slugPath(string $org, string $slug): string
    {
        return '/orgs/' . $org . '/teams/' . rawurlencode($slug);
    }
}
