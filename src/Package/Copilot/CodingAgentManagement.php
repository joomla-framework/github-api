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
 * GitHub API Copilot coding (cloud) agent management class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/copilot/copilot-coding-agent-management
 *
 * @since  __DEPLOY_VERSION__
 */
class CodingAgentManagement extends AbstractPackage
{
    /**
     * Get Copilot cloud agent permissions for an organisation.
     *
     * @param   string  $org  The organisation name.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-coding-agent-management#get-copilot-cloud-agent-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getPermissions(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/coding-agent/permissions';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set Copilot cloud agent permissions for an organisation.
     *
     * @param   string  $org                  The organisation name.
     * @param   string  $enabledRepositories  The repositories that may use the cloud agent: `all`, `selected` or `none`.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/copilot/copilot-coding-agent-management#set-copilot-cloud-agent-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setPermissions(string $org, string $enabledRepositories)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/coding-agent/permissions';

        $data = ['enabled_repositories' => $enabledRepositories];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * List repositories enabled for Copilot cloud agent in an organisation.
     *
     * @param   string  $org    The organisation name.
     * @param   int     $page   The page number from which to get items.
     * @param   int     $limit  The number of items on a page.
     *
     * @return  object|array
     *
     * @link    https://docs.github.com/rest/copilot/copilot-coding-agent-management#list-repositories-enabled-for-copilot-cloud-agent-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getRepositories(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/coding-agent/permissions/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Set selected repositories for Copilot cloud agent in an organisation.
     *
     * @param   string  $org                    The organisation name.
     * @param   array   $selectedRepositoryIds  List of repository IDs to enable.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/copilot/copilot-coding-agent-management#set-selected-repositories-for-copilot-cloud-agent-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setRepositories(string $org, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/coding-agent/permissions/repositories';

        $data = ['selected_repository_ids' => $selectedRepositoryIds];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Enable a repository for Copilot cloud agent in an organisation.
     *
     * @param   string  $org           The organisation name.
     * @param   int     $repositoryId  The unique identifier of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/copilot/copilot-coding-agent-management#enable-a-repository-for-copilot-cloud-agent-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function enableRepository(string $org, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/coding-agent/permissions/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Disable a repository for Copilot cloud agent in an organisation.
     *
     * @param   string  $org           The organisation name.
     * @param   int     $repositoryId  The unique identifier of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/copilot/copilot-coding-agent-management#disable-a-repository-for-copilot-cloud-agent-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function disableRepository(string $org, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/copilot/coding-agent/permissions/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
