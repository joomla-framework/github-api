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
 * GitHub API Codespaces Secrets class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/codespaces/secrets
 *
 * @since  __DEPLOY_VERSION__
 */
class Secrets extends AbstractPackage
{
    /**
     * List secrets for the authenticated user.
     *
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#list-secrets-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getList(int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/codespaces/secrets';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Get public key for the authenticated user.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#get-public-key-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getPublicKey()
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/public-key';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Get a secret for the authenticated user.
     *
     * @param   string  $secretName  The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#get-a-secret-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function get(string $secretName)
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/' . rawurlencode($secretName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Create or update a secret for the authenticated user.
     *
     * @param   string  $secretName  The name of the secret.
     * @param   string  $keyId       The ID of the key used to encrypt the secret.
     * @param   array   $options     Optional body fields: encrypted_value, selected_repository_ids.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#create-or-update-a-secret-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createOrUpdate(string $secretName, string $keyId, array $options = [])
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/' . rawurlencode($secretName);

        $data = array_merge($options, ['key_id' => $keyId]);

        $response = $this->client->put($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [201, 204], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * Delete a secret for the authenticated user.
     *
     * @param   string  $secretName  The name of the secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#delete-a-secret-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function delete(string $secretName)
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/' . rawurlencode($secretName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List selected repositories for a user secret.
     *
     * @param   string  $secretName  The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#list-selected-repositories-for-a-user-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListSelectedRepositories(string $secretName)
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/' . rawurlencode($secretName) . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Set selected repositories for a user secret.
     *
     * @param   string  $secretName             The name of the secret.
     * @param   array   $selectedRepositoryIds  The IDs of the repositories that can access the secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#set-selected-repositories-for-a-user-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setSelectedRepositories(string $secretName, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/' . rawurlencode($secretName) . '/repositories';

        $data = ['selected_repository_ids' => $selectedRepositoryIds];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Add a selected repository to a user secret.
     *
     * @param   string   $secretName    The name of the secret.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#add-a-selected-repository-to-a-user-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addSelectedRepository(string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Remove a selected repository from a user secret.
     *
     * @param   string   $secretName    The name of the secret.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/codespaces/secrets#remove-a-selected-repository-from-a-user-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeSelectedRepository(string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/user/codespaces/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
