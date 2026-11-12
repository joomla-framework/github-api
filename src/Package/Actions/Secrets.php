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
 * GitHub API Actions Secrets class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/secrets
 *
 * @since  __DEPLOY_VERSION__
 */
class Secrets extends AbstractPackage
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
     * @link    https://docs.github.com/rest/actions/secrets#list-organization-secrets
     * @since   __DEPLOY_VERSION__
     */
    public function getListForOrg(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Get an organization public key.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#get-an-organization-public-key
     * @since   __DEPLOY_VERSION__
     */
    public function getPublicKeyForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/public-key';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get an organization secret.
     *
     * @param   string  $org         The organization name.
     * @param   string  $secretName  The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#get-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org, string $secretName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/' . rawurlencode($secretName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Create or update an organization secret.
     *
     * @param   string  $org             The organization name.
     * @param   string  $secretName      The name of the secret.
     * @param   string  $encryptedValue  Value for your secret, encrypted with LibSodium using the public key retrieved from the Get an organization public key endpoint.
     * @param   string  $keyId           ID of the key you used to encrypt the secret.
     * @param   string  $visibility      Which type of organization repositories have access to the organization secret.
     * @param   array   $options         Optional body fields: selected_repository_ids.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/actions/secrets#create-or-update-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function createOrUpdateForOrg(string $org, string $secretName, string $encryptedValue, string $keyId, string $visibility, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/' . rawurlencode($secretName);

        $data = array_merge(
            $options,
            [
                'encrypted_value' => $encryptedValue,
                'key_id'          => $keyId,
                'visibility'      => $visibility,
            ]
        );

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
     * @link    https://docs.github.com/rest/actions/secrets#delete-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForOrg(string $org, string $secretName)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/' . rawurlencode($secretName);

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
     * @link    https://docs.github.com/rest/actions/secrets#list-selected-repositories-for-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function getListSelectedRepositoriesForOrg(string $org, string $secretName, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/' . rawurlencode($secretName) . '/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Set selected repositories for an organization secret.
     *
     * @param   string  $org                    The organization name.
     * @param   string  $secretName             The name of the secret.
     * @param   array   $selectedRepositoryIds  An array of repository ids that can access the organization secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/secrets#set-selected-repositories-for-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function setSelectedRepositoriesForOrg(string $org, string $secretName, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/' . rawurlencode($secretName) . '/repositories';

        $data = [
            'selected_repository_ids' => $selectedRepositoryIds,
        ];

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
     * @link    https://docs.github.com/rest/actions/secrets#add-selected-repository-to-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function addSelectedRepositoryForOrg(string $org, string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

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
     * @link    https://docs.github.com/rest/actions/secrets#remove-selected-repository-from-an-organization-secret
     * @since   __DEPLOY_VERSION__
     */
    public function removeSelectedRepositoryForOrg(string $org, string $secretName, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/secrets/' . rawurlencode($secretName) . '/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List repository organization secrets.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#list-repository-organization-secrets
     * @since   __DEPLOY_VERSION__
     */
    public function getListOrganizationSecretsForRepo(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/organization-secrets';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List repository secrets.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#list-repository-secrets
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/secrets';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Get a repository public key.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#get-a-repository-public-key
     * @since   __DEPLOY_VERSION__
     */
    public function getPublicKeyForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/secrets/public-key';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
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
     * @link    https://docs.github.com/rest/actions/secrets#get-a-repository-secret
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/secrets/' . rawurlencode($secretName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Create or update a repository secret.
     *
     * @param   string  $owner           The account owner of the repository.
     * @param   string  $repo            The name of the repository.
     * @param   string  $secretName      The name of the secret.
     * @param   string  $encryptedValue  Value for your secret, encrypted with LibSodium using the public key retrieved from the Get a repository public key endpoint.
     * @param   string  $keyId           ID of the key you used to encrypt the secret.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/actions/secrets#create-or-update-a-repository-secret
     * @since   __DEPLOY_VERSION__
     */
    public function createOrUpdateForRepo(string $owner, string $repo, string $secretName, string $encryptedValue, string $keyId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/secrets/' . rawurlencode($secretName);

        $data = [
            'encrypted_value' => $encryptedValue,
            'key_id'          => $keyId,
        ];

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
     * @link    https://docs.github.com/rest/actions/secrets#delete-a-repository-secret
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForRepo(string $owner, string $repo, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/secrets/' . rawurlencode($secretName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * List environment secrets.
     *
     * @param   string   $owner            The account owner of the repository.
     * @param   string   $repo             The name of the repository.
     * @param   string   $environmentName  The name of the environment.
     * @param   integer  $page             The page number from which to get items.
     * @param   integer  $limit            The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#list-environment-secrets
     * @since   __DEPLOY_VERSION__
     */
    public function getListForEnvironment(string $owner, string $repo, string $environmentName, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/secrets';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Get an environment public key.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#get-an-environment-public-key
     * @since   __DEPLOY_VERSION__
     */
    public function getPublicKeyForEnvironment(string $owner, string $repo, string $environmentName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/secrets/public-key';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Get an environment secret.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     * @param   string  $secretName       The name of the secret.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/secrets#get-an-environment-secret
     * @since   __DEPLOY_VERSION__
     */
    public function getForEnvironment(string $owner, string $repo, string $environmentName, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/secrets/' . rawurlencode($secretName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Create or update an environment secret.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     * @param   string  $secretName       The name of the secret.
     * @param   string  $encryptedValue   Value for your secret, encrypted with LibSodium using the public key retrieved from the Get an environment public key endpoint.
     * @param   string  $keyId            ID of the key you used to encrypt the secret.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/actions/secrets#create-or-update-an-environment-secret
     * @since   __DEPLOY_VERSION__
     */
    public function createOrUpdateForEnvironment(string $owner, string $repo, string $environmentName, string $secretName, string $encryptedValue, string $keyId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/secrets/' . rawurlencode($secretName);

        $data = [
            'encrypted_value' => $encryptedValue,
            'key_id'          => $keyId,
        ];

        $response = $this->client->put($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [201, 204], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * Delete an environment secret.
     *
     * @param   string  $owner            The account owner of the repository.
     * @param   string  $repo             The name of the repository.
     * @param   string  $environmentName  The name of the environment.
     * @param   string  $secretName       The name of the secret.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/secrets#delete-an-environment-secret
     * @since   __DEPLOY_VERSION__
     */
    public function deleteForEnvironment(string $owner, string $repo, string $environmentName, string $secretName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/environments/' . rawurlencode($environmentName) . '/secrets/' . rawurlencode($secretName);

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
