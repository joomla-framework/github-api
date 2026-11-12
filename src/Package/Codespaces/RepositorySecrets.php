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
 * GitHub API Codespaces Repository Secrets class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/codespaces/repository-secrets
 *
 * @since  __DEPLOY_VERSION__
 */
class RepositorySecrets extends AbstractPackage
{
    /**
     * List repository secrets.
     *
     * @param   string   $owner  The name of the owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/repository-secrets#list-repository-secrets
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getList(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/secrets';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Get a repository public key.
     *
     * @param   string  $owner  The name of the owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/repository-secrets#get-a-repository-public-key
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getPublicKey(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/secrets/public-key';

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Get a repository secret.
     *
     * @param   string  $owner       The name of the owner of the repository.
     * @param   string  $repo        The name of the repository.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/repository-secrets#get-a-repository-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function get(string $owner, string $repo, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/secrets/' . rawurlencode($secretName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Create or update a repository secret.
     *
     * @param   string  $owner       The name of the owner of the repository.
     * @param   string  $repo        The name of the repository.
     * @param   string  $secretName  The name of the secret.
     * @param   array   $options     Optional body fields: encrypted_value, key_id.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/codespaces/repository-secrets#create-or-update-a-repository-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createOrUpdate(string $owner, string $repo, string $secretName, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/secrets/' . rawurlencode($secretName);

        // Send an object, so that an empty body is encoded as {} rather than [].
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
     * @param   string  $owner       The name of the owner of the repository.
     * @param   string  $repo        The name of the repository.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/codespaces/repository-secrets#delete-a-repository-secret
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function delete(string $owner, string $repo, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/secrets/' . rawurlencode($secretName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
