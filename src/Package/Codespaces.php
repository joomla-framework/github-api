<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Codespaces class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/codespaces/codespaces
 *
 * @since  __DEPLOY_VERSION__
 *
 * @property-read  Codespaces\Machines             $machines             GitHub API object for codespace machine types.
 * @property-read  Codespaces\Organizations        $organizations        GitHub API object for organization codespaces.
 * @property-read  Codespaces\OrganizationSecrets  $organizationSecrets  GitHub API object for organization codespaces secrets.
 * @property-read  Codespaces\RepositorySecrets    $repositorySecrets    GitHub API object for repository codespaces secrets.
 * @property-read  Codespaces\Secrets              $secrets              GitHub API object for codespaces secrets of the authenticated user.
 */
class Codespaces extends AbstractPackage
{
    /**
     * List codespaces for the authenticated user.
     *
     * @param   array    $filters  Optional query parameters: repository_id.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#list-codespaces-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getList(array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/user/codespaces';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Create a codespace for the authenticated user.
     *
     * @param   integer  $repositoryId  The ID of the repository.
     * @param   array    $options       Optional body fields: ref, location, geo, client_ip, machine, devcontainer_path, multi_repo_permissions_opt_out, working_directory, idle_timeout_minutes, display_name, retention_period_minutes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#create-a-codespace-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function create(int $repositoryId, array $options = [])
    {
        // Build the request path.
        $path = '/user/codespaces';

        $data = array_merge($options, ['repository_id' => $repositoryId]);

        $response = $this->client->post($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [201, 202], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * Get a codespace for the authenticated user.
     *
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#get-a-codespace-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function get(string $codespaceName)
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Update a codespace for the authenticated user.
     *
     * @param   string  $codespaceName  The name of the codespace.
     * @param   array   $options        Optional body fields: machine, display_name, recent_folders.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#update-a-codespace-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function edit(string $codespaceName, array $options = [])
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName);

        // Send an object, so that an empty body is encoded as {} rather than [].
        $data = (object) $options;

        return $this->processResponse($this->client->patch($this->fetchUrl($path), json_encode($data)), 200);
    }

    /**
     * Delete a codespace for the authenticated user.
     *
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#delete-a-codespace-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function delete(string $codespaceName)
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName);

        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 202);
    }

    /**
     * Export a codespace for the authenticated user.
     *
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#export-a-codespace-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function export(string $codespaceName)
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName) . '/exports';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 202);
    }

    /**
     * Get details about a codespace export.
     *
     * @param   string  $codespaceName  The name of the codespace.
     * @param   string  $exportId       The ID of the export operation, or `latest`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#get-details-about-a-codespace-export
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getExport(string $codespaceName, string $exportId)
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName) . '/exports/' . rawurlencode($exportId);

        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Create a repository from an unpublished codespace.
     *
     * @param   string  $codespaceName  The name of the codespace.
     * @param   array   $options        Optional body fields: name, private.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#create-a-repository-from-an-unpublished-codespace
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function publish(string $codespaceName, array $options = [])
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName) . '/publish';

        // Send an object, so that an empty body is encoded as {} rather than [].
        $data = (object) $options;

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Start a codespace for the authenticated user.
     *
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#start-a-codespace-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function start(string $codespaceName)
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName) . '/start';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 200);
    }

    /**
     * Stop a codespace for the authenticated user.
     *
     * @param   string  $codespaceName  The name of the codespace.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#stop-a-codespace-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function stop(string $codespaceName)
    {
        // Build the request path.
        $path = '/user/codespaces/' . rawurlencode($codespaceName) . '/stop';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 200);
    }

    /**
     * List codespaces in a repository for the authenticated user.
     *
     * @param   string   $owner  The name of the owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#list-codespaces-in-a-repository-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForRepo(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Create a codespace in a repository.
     *
     * @param   string  $owner    The name of the owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: ref, location, geo, client_ip, machine, devcontainer_path, multi_repo_permissions_opt_out, working_directory, idle_timeout_minutes, display_name, retention_period_minutes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#create-a-codespace-in-a-repository
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForRepo(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces';

        // Send an object, so that an empty body is encoded as {} rather than [].
        $data = (object) $options;

        $response = $this->client->post($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [201, 202], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * List devcontainer configurations in a repository for the authenticated user.
     *
     * @param   string   $owner  The name of the owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#list-devcontainer-configurations-in-a-repository-for-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListDevcontainers(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/devcontainers';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Get default attributes for a codespace.
     *
     * @param   string  $owner    The name of the owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $filters  Optional query parameters: ref, client_ip.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#get-default-attributes-for-a-codespace
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getDefaultAttributes(string $owner, string $repo, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/new';

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Check if permissions defined by a devcontainer have been accepted by the authenticated user.
     *
     * @param   string  $owner             The name of the owner of the repository.
     * @param   string  $repo              The name of the repository.
     * @param   string  $ref               The git reference that points to the location of the devcontainer configuration.
     * @param   string  $devcontainerPath  The path to the devcontainer.json configuration.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#check-if-permissions-defined-by-a-devcontainer-have-been-accepted-by-the-authenticated-user
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function checkPermissions(string $owner, string $repo, string $ref, string $devcontainerPath)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/codespaces/permissions_check';

        $uri = $this->fetchUrl($path);
        $uri->setVar('ref', $ref);
        $uri->setVar('devcontainer_path', $devcontainerPath);

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Create a codespace from a pull request.
     *
     * @param   string   $owner       The name of the owner of the repository.
     * @param   string   $repo        The name of the repository.
     * @param   integer  $pullNumber  The number of the pull request.
     * @param   array    $options     Optional body fields: location, geo, client_ip, machine, devcontainer_path, multi_repo_permissions_opt_out, working_directory, idle_timeout_minutes, display_name, retention_period_minutes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/codespaces/codespaces#create-a-codespace-from-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForPull(string $owner, string $repo, int $pullNumber, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/codespaces';

        // Send an object, so that an empty body is encoded as {} rather than [].
        $data = (object) $options;

        $response = $this->client->post($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [201, 202], true) ? $response->getStatusCode() : 201
        );
    }
}
