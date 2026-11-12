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
 * GitHub API Actions Artifacts class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/artifacts
 *
 * @since  __DEPLOY_VERSION__
 */
class Artifacts extends AbstractPackage
{
    /**
     * List artifacts for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: name.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/artifacts#list-artifacts-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/artifacts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List workflow run artifacts.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $runId    The ID of the workflow run.
     * @param   array    $filters  Optional query parameters: name, direction.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/artifacts#list-workflow-run-artifacts
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRun(string $owner, string $repo, int $runId, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/artifacts';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get an artifact.
     *
     * @param   string   $owner       The account owner of the repository.
     * @param   string   $repo        The name of the repository.
     * @param   integer  $artifactId  The ID of the artifact.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/artifacts#get-an-artifact
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $artifactId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/artifacts/' . $artifactId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Delete an artifact.
     *
     * @param   string   $owner       The account owner of the repository.
     * @param   string   $repo        The name of the repository.
     * @param   integer  $artifactId  The ID of the artifact.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/artifacts#delete-an-artifact
     * @since   __DEPLOY_VERSION__
     */
    public function delete(string $owner, string $repo, int $artifactId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/artifacts/' . $artifactId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Download an artifact.
     *
     * @param   string   $owner          The account owner of the repository.
     * @param   string   $repo           The name of the repository.
     * @param   integer  $artifactId     The ID of the artifact.
     * @param   string   $archiveFormat  The archive format, currently only `zip`.
     *
     * @return  string
     *
     * @link    https://docs.github.com/rest/actions/artifacts#download-an-artifact
     * @since   __DEPLOY_VERSION__
     */
    public function download(string $owner, string $repo, int $artifactId, string $archiveFormat = 'zip')
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/artifacts/' . $artifactId . '/' . rawurlencode($archiveFormat);

        $response = $this->client->get($this->fetchUrl($path));

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }
}
