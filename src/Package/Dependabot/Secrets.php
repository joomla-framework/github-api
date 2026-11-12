<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Dependabot;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Dependabot Secrets class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/dependabot/secrets
 *
 * @since  __DEPLOY_VERSION__
 */
class Secrets extends AbstractPackage
{
    /**
     * List organization secrets.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number to fetch.
     * @param   integer  $limit  The number of results per page (max 100).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#list-organization-secrets
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit)),
            200
        );
    }

    /**
     * Get an organization public key.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#get-an-organization-public-key
     * @since   __DEPLOY_VERSION__
     */
    public function getPublicKeyForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/public-key';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Get an organization secret.
     *
     * @param   string  $org         The organization name.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#get-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org, string $secretName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/' . rawurlencode($secretName);

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Create or update an organization secret.
     *
     * Returns the decoded body on 201 (created) and null on 204 (updated).
     *
     * @param   string  $org         The organization name.
     * @param   string  $secretName  The name of the secret.
     * @param   string  $visibility  Which repositories can access the secret: `all`, `private` or `selected`.
     * @param   array   $options     Optional body fields: `encrypted_value`, `key_id`, `selected_repository_ids`.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#create-or-update-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function createOrUpdateForOrg(string $org, string $secretName, string $visibility, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/' . rawurlencode($secretName);

        $data = array_merge($options, ['visibility' => $visibility]);

        $response = $this->client->put($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [201, 204], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * Delete an organization secret.
     *
     * @param   string  $org         The organization name.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#delete-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForOrg(string $org, string $secretName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/' . rawurlencode($secretName);

        $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }

    /**
     * List selected repositories for an organization secret.
     *
     * @param   string   $org         The organization name.
     * @param   string   $secretName  The name of the secret.
     * @param   integer  $page        The page number to fetch.
     * @param   integer  $limit       The number of results per page (max 100).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#list-selected-repositories-for-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function getSelectedRepositories(string $org, string $secretName, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/' . rawurlencode($secretName) . '/repositories';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit)),
            200
        );
    }

    /**
     * Set selected repositories for an organization secret.
     *
     * @param   string  $org                    The organization name.
     * @param   string  $secretName             The name of the secret.
     * @param   array   $selectedRepositoryIds  The IDs of the repositories that can access the secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#set-selected-repositories-for-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function setSelectedRepositories(string $org, string $secretName, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/' . rawurlencode($secretName) . '/repositories';

        $data = ['selected_repository_ids' => $selectedRepositoryIds];

        $this->processResponse(
            $this->client->put($this->fetchUrl($path), json_encode($data)),
            204
        );
    }

    /**
     * Add selected repository to an organization secret.
     *
     * @param   string   $org           The organization name.
     * @param   string   $secretName    The name of the secret.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#add-selected-repository-to-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function addSelectedRepository(string $org, string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

        $this->processResponse(
            $this->client->put($this->fetchUrl($path), ''),
            204
        );
    }

    /**
     * Remove selected repository from an organization secret.
     *
     * @param   string   $org           The organization name.
     * @param   string   $secretName    The name of the secret.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#remove-selected-repository-from-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function removeSelectedRepository(string $org, string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/dependabot/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

        $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }

    /**
     * List repository secrets.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number to fetch.
     * @param   integer  $limit  The number of results per page (max 100).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#list-repository-secrets
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/secrets';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit)),
            200
        );
    }

    /**
     * Get a repository public key.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#get-a-repository-public-key
     * @since   __DEPLOY_VERSION__
     */
    public function getPublicKeyForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/secrets/public-key';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Get a repository secret.
     *
     * @param   string  $owner       The account owner of the repository.
     * @param   string  $repo        The name of the repository.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#get-a-repository-secret
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/secrets/' . rawurlencode($secretName);

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Create or update a repository secret.
     *
     * Returns the decoded body on 201 (created) and null on 204 (updated).
     *
     * @param   string  $owner       The account owner of the repository.
     * @param   string  $repo        The name of the repository.
     * @param   string  $secretName  The name of the secret.
     * @param   array   $options     Optional body fields: `encrypted_value`, `key_id`.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#create-or-update-a-repository-secret
     * @since   __DEPLOY_VERSION__
     */
    public function createOrUpdateForRepo(string $owner, string $repo, string $secretName, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/secrets/' . rawurlencode($secretName);

        $data = (object) $options;

        $response = $this->client->put($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [201, 204], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * Delete a repository secret.
     *
     * @param   string  $owner       The account owner of the repository.
     * @param   string  $repo        The name of the repository.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/dependabot/secrets#delete-a-repository-secret
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForRepo(string $owner, string $repo, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependabot/secrets/' . rawurlencode($secretName);

        $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }
}
