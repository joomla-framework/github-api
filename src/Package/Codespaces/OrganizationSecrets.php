<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Codespaces;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Codespaces Organization Secrets class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/codespaces/organization-secrets
 *
 * @since  __DEPLOY_VERSION__
 */
class OrganizationSecrets extends AbstractPackage
{
    /**
     * List organization secrets.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#list-organization-secrets
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getList(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Get an organization public key.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#get-an-organization-public-key
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getPublicKey(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/public-key';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Get an organization secret.
     *
     * @param   string  $org         The organization name.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#get-an-organization-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function get(string $org, string $secretName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/' . rawurlencode($secretName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Create or update an organization secret.
     *
     * @param   string  $org         The organization name.
     * @param   string  $secretName  The name of the secret.
     * @param   string  $visibility  Which repositories can access the secret (all, private or selected).
     * @param   array   $options     Optional body fields: encrypted_value, key_id, selected_repository_ids.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#create-or-update-an-organization-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createOrUpdate(string $org, string $secretName, string $visibility, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/' . rawurlencode($secretName);

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
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#delete-an-organization-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function delete(string $org, string $secretName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/' . rawurlencode($secretName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List selected repositories for an organization secret.
     *
     * @param   string   $org         The organization name.
     * @param   string   $secretName  The name of the secret.
     * @param   integer  $page        The page number from which to get items.
     * @param   integer  $limit       The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#list-selected-repositories-for-an-organization-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListSelectedRepositories(string $org, string $secretName, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/' . rawurlencode($secretName) . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
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
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#set-selected-repositories-for-an-organization-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setSelectedRepositories(string $org, string $secretName, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/' . rawurlencode($secretName) . '/repositories';

        $data = ['selected_repository_ids' => $selectedRepositoryIds];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
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
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#add-selected-repository-to-an-organization-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addSelectedRepository(string $org, string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
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
     * @link    https://docs.github.com/rest/codespaces/organization-secrets#remove-selected-repository-from-an-organization-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeSelectedRepository(string $org, string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/codespaces/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
