<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Actions;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Actions Self-hosted Runner Groups class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/self-hosted-runner-groups
 *
 * @since  __DEPLOY_VERSION__
 */
class RunnerGroups extends AbstractPackage
{
    /**
     * List self-hosted runner groups for an organization.
     *
     * @param   string   $org      The organization name.
     * @param   array    $filters  Optional query parameters: visible_to_repository.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#list-self-hosted-runner-groups-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getList(string $org, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Create a self-hosted runner group for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   string  $name     Name of the runner group.
     * @param   array   $options  Optional body fields: visibility, selected_repository_ids, runners, allows_public_repositories, restricted_to_workflows, selected_workflows, network_configuration_id.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#create-a-self-hosted-runner-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function create(string $org, string $name, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups';

        $data = array_merge(
            $options,
            [
                'name' => $name,
            ]
        );

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get a self-hosted runner group for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#get-a-self-hosted-runner-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $org, int $runnerGroupId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update a self-hosted runner group for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   string   $name           Name of the runner group.
     * @param   array    $options        Optional body fields: visibility, allows_public_repositories, restricted_to_workflows, selected_workflows, network_configuration_id.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#update-a-self-hosted-runner-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function edit(string $org, int $runnerGroupId, string $name, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId;

        $data = array_merge(
            $options,
            [
                'name' => $name,
            ]
        );

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Delete a self-hosted runner group from an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#delete-a-self-hosted-runner-group-from-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function delete(string $org, int $runnerGroupId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List GitHub-hosted runners in a group for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#list-github-hosted-runners-in-a-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListHostedRunners(string $org, int $runnerGroupId, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/hosted-runners';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List repository access to a self-hosted runner group in an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#list-repository-access-to-a-self-hosted-runner-group-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListRepositories(string $org, int $runnerGroupId, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Set repository access for a self-hosted runner group in an organization.
     *
     * @param   string   $org                    The organization name.
     * @param   integer  $runnerGroupId          The ID of the self-hosted runner group.
     * @param   array    $selectedRepositoryIds  List of repository IDs that can access the runner group.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#set-repository-access-for-a-self-hosted-runner-group-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setRepositories(string $org, int $runnerGroupId, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/repositories';

        $data = [
            'selected_repository_ids' => $selectedRepositoryIds,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Add repository access to a self-hosted runner group in an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   integer  $repositoryId   The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#add-repository-access-to-a-self-hosted-runner-group-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function addRepository(string $org, int $runnerGroupId, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Remove repository access to a self-hosted runner group in an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   integer  $repositoryId   The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#remove-repository-access-to-a-self-hosted-runner-group-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function removeRepository(string $org, int $runnerGroupId, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List self-hosted runners in a group for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#list-self-hosted-runners-in-a-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListRunners(string $org, int $runnerGroupId, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/runners';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Set self-hosted runners in a group for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   array    $runners        List of runner IDs to add to the runner group.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#set-self-hosted-runners-in-a-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setRunners(string $org, int $runnerGroupId, array $runners)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/runners';

        $data = [
            'runners' => $runners,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Add a self-hosted runner to a group for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   integer  $runnerId       The ID of the self-hosted runner.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#add-a-self-hosted-runner-to-a-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function addRunner(string $org, int $runnerGroupId, int $runnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/runners/' . $runnerId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Remove a self-hosted runner from a group for an organization.
     *
     * @param   string   $org            The organization name.
     * @param   integer  $runnerGroupId  The ID of the self-hosted runner group.
     * @param   integer  $runnerId       The ID of the self-hosted runner.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/self-hosted-runner-groups#remove-a-self-hosted-runner-from-a-group-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function removeRunner(string $org, int $runnerGroupId, int $runnerId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/runner-groups/' . $runnerGroupId . '/runners/' . $runnerId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
