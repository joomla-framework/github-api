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
 * GitHub API Actions Workflows class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/workflows
 *
 * @since  __DEPLOY_VERSION__
 */
class Workflows extends AbstractPackage
{
    /**
     * List repository workflows.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflows#list-repository-workflows
     * @since   __DEPLOY_VERSION__
     */
    public function getList(string $owner, string $repo, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/workflows';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Get a workflow.
     *
     * @param   string          $owner       The account owner of the repository.
     * @param   string          $repo        The name of the repository.
     * @param   integer|string  $workflowId  The ID of the workflow or its file name, e.g. `main.yml`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflows#get-a-workflow
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int|string $workflowId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/workflows/' . rawurlencode((string) $workflowId);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Disable a workflow.
     *
     * @param   string          $owner       The account owner of the repository.
     * @param   string          $repo        The name of the repository.
     * @param   integer|string  $workflowId  The ID of the workflow or its file name, e.g. `main.yml`.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/workflows#disable-a-workflow
     * @since   __DEPLOY_VERSION__
     */
    public function disable(string $owner, string $repo, int|string $workflowId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/workflows/' . rawurlencode((string) $workflowId) . '/disable';

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Enable a workflow.
     *
     * @param   string          $owner       The account owner of the repository.
     * @param   string          $repo        The name of the repository.
     * @param   integer|string  $workflowId  The ID of the workflow or its file name, e.g. `main.yml`.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/workflows#enable-a-workflow
     * @since   __DEPLOY_VERSION__
     */
    public function enable(string $owner, string $repo, int|string $workflowId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/workflows/' . rawurlencode((string) $workflowId) . '/enable';

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Create a workflow dispatch event.
     *
     * @param   string          $owner       The account owner of the repository.
     * @param   string          $repo        The name of the repository.
     * @param   integer|string  $workflowId  The ID of the workflow or its file name, e.g. `main.yml`.
     * @param   string          $ref         The git reference for the workflow.
     * @param   array           $options     Optional body fields: inputs, return_run_details.
     *
     * @return  object|null
     *
     * @link    https://docs.github.com/rest/actions/workflows#create-a-workflow-dispatch-event
     * @since   __DEPLOY_VERSION__
     */
    public function createDispatch(string $owner, string $repo, int|string $workflowId, string $ref, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/workflows/' . rawurlencode((string) $workflowId) . '/dispatches';

        $data = array_merge(
            $options,
            [
                'ref' => $ref,
            ]
        );

        $response = $this->client->post($this->fetchUrl($path), json_encode($data));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [204, 200], true) ? $response->getStatusCode() : 204
        );
    }

    /**
     * Get workflow usage.
     *
     * @param   string          $owner       The account owner of the repository.
     * @param   string          $repo        The name of the repository.
     * @param   integer|string  $workflowId  The ID of the workflow or its file name, e.g. `main.yml`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflows#get-workflow-usage
     * @since   __DEPLOY_VERSION__
     */
    public function getUsage(string $owner, string $repo, int|string $workflowId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/workflows/' . rawurlencode((string) $workflowId) . '/timing';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
