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
 * GitHub API Actions Variables class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/variables
 *
 * @since  __DEPLOY_VERSION__
 */
class Variables extends AbstractPackage
{
    /**
     * List organization variables.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#list-organization-variables
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Create an organization variable.
     *
     * @param   string  $org         The organization name.
     * @param   string  $name        The name of the variable.
     * @param   string  $value       The value of the variable.
     * @param   string  $visibility  The type of repositories in the organization that can access the variable.
     * @param   array   $options     Optional body fields: selected_repository_ids.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#create-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function createForOrg(string $org, string $name, string $value, string $visibility, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables';

        $data = array_merge(
            $options,
            [
                'name'       => $name,
                'value'      => $value,
                'visibility' => $visibility,
            ]
        );

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get an organization variable.
     *
     * @param   string  $org   The organization name.
     * @param   string  $name  The name of the variable.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#get-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org, string $name)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables/' . rawurlencode($name);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update an organization variable.
     *
     * @param   string  $org      The organization name.
     * @param   string  $name     The name of the variable.
     * @param   array   $options  Optional body fields: name, value, visibility, selected_repository_ids.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#update-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function editForOrg(string $org, string $name, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables/' . rawurlencode($name);

        $data = (object) $options;

        $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Delete an organization variable.
     *
     * @param   string  $org   The organization name.
     * @param   string  $name  The name of the variable.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#delete-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForOrg(string $org, string $name)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables/' . rawurlencode($name);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List selected repositories for an organization variable.
     *
     * @param   string   $org    The organization name.
     * @param   string   $name   The name of the variable.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#list-selected-repositories-for-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function getListSelectedRepositoriesForOrg(string $org, string $name, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables/' . rawurlencode($name) . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Set selected repositories for an organization variable.
     *
     * @param   string  $org                    The organization name.
     * @param   string  $name                   The name of the variable.
     * @param   array   $selectedRepositoryIds  The IDs of the repositories that can access the organization variable.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#set-selected-repositories-for-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function setSelectedRepositoriesForOrg(string $org, string $name, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables/' . rawurlencode($name) . '/repositories';

        $data = [
            'selected_repository_ids' => $selectedRepositoryIds,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Add selected repository to an organization variable.
     *
     * @param   string   $org           The organization name.
     * @param   string   $name          The name of the variable.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#add-selected-repository-to-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function addSelectedRepositoryForOrg(string $org, string $name, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables/' . rawurlencode($name) . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Remove selected repository from an organization variable.
     *
     * @param   string   $org           The organization name.
     * @param   string   $name          The name of the variable.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#remove-selected-repository-from-an-organization-variable
     * @since   __DEPLOY_VERSION__
     */
    public function removeSelectedRepositoryForOrg(string $org, string $name, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/variables/' . rawurlencode($name) . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List repository organization variables.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#list-repository-organization-variables
     * @since   __DEPLOY_VERSION__
     */
    public function getListOrganizationVariablesForRepo(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/organization-variables';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List repository variables.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#list-repository-variables
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/variables';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Create a repository variable.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     * @param   string  $name   The name of the variable.
     * @param   string  $value  The value of the variable.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#create-a-repository-variable
     * @since   __DEPLOY_VERSION__
     */
    public function createForRepo(string $owner, string $repo, string $name, string $value)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/variables';

        $data = [
            'name'  => $name,
            'value' => $value,
        ];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get a repository variable.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     * @param   string  $name   The name of the variable.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#get-a-repository-variable
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo, string $name)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/variables/' . rawurlencode($name);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update a repository variable.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   string  $name     The name of the variable.
     * @param   array   $options  Optional body fields: name, value.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#update-a-repository-variable
     * @since   __DEPLOY_VERSION__
     */
    public function editForRepo(string $owner, string $repo, string $name, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/variables/' . rawurlencode($name);

        $data = (object) $options;

        $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Delete a repository variable.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     * @param   string  $name   The name of the variable.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#delete-a-repository-variable
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForRepo(string $owner, string $repo, string $name)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/variables/' . rawurlencode($name);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List environment variables.
     *
     * @param   string   $owner            The account owner of the repository.
     * @param   string   $repo             The name of the repository.
     * @param   string   $environmentName  The name of the environment.
     * @param   integer  $page             The page number from which to get items.
     * @param   integer  $limit            The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#list-environment-variables
     * @since   __DEPLOY_VERSION__
     */
    public function getListForEnvironment(string $owner, string $repo, string $environmentName, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/variables';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Create an environment variable.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     * @param   string  $name             The name of the variable.
     * @param   string  $value            The value of the variable.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#create-an-environment-variable
     * @since   __DEPLOY_VERSION__
     */
    public function createForEnvironment(string $owner, string $repo, string $environmentName, string $name, string $value)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/variables';

        $data = [
            'name'  => $name,
            'value' => $value,
        ];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get an environment variable.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     * @param   string  $name             The name of the variable.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/variables#get-an-environment-variable
     * @since   __DEPLOY_VERSION__
     */
    public function getForEnvironment(string $owner, string $repo, string $environmentName, string $name)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/variables/' . rawurlencode($name);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Update an environment variable.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     * @param   string  $name             The name of the variable.
     * @param   array   $options          Optional body fields: name, value.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#update-an-environment-variable
     * @since   __DEPLOY_VERSION__
     */
    public function editForEnvironment(string $owner, string $repo, string $environmentName, string $name, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/variables/' . rawurlencode($name);

        $data = (object) $options;

        $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Delete an environment variable.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     * @param   string  $name             The name of the variable.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/variables#delete-an-environment-variable
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForEnvironment(string $owner, string $repo, string $environmentName, string $name)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/variables/' . rawurlencode($name);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
