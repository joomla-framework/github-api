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
 * GitHub API Actions Workflow Jobs class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/workflow-jobs
 *
 * @since  __DEPLOY_VERSION__
 */
class Jobs extends AbstractPackage
{
    /**
     * Get a job for a workflow run.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $jobId  The ID of the job.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-jobs#get-a-job-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $jobId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/jobs/' . $jobId;

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Download job logs for a workflow run.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $jobId  The ID of the job.
     *
     * @return  string
     *
     * @link    https://docs.github.com/rest/actions/workflow-jobs#download-job-logs-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function downloadLogs(string $owner, string $repo, int $jobId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/jobs/' . $jobId . '/logs';

        $response = $this->client->get($this->fetchUrl($path));

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }

    /**
     * Download step logs for a workflow run job.
     *
     * @param   string   $owner       The account owner of the repository.
     * @param   string   $repo        The name of the repository.
     * @param   integer  $jobId       The ID of the job.
     * @param   integer  $stepNumber  The number of the step in the job.
     *
     * @return  string
     *
     * @link    https://docs.github.com/rest/actions/workflow-jobs#download-step-logs-for-a-workflow-run-job
     * @since   __DEPLOY_VERSION__
     */
    public function downloadStepLogs(string $owner, string $repo, int $jobId, int $stepNumber)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/jobs/' . $jobId . '/steps/' . $stepNumber . '/logs';

        $response = $this->client->get($this->fetchUrl($path));

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }

    /**
     * List jobs for a workflow run.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $runId    The ID of the workflow run.
     * @param   array    $filters  Optional query parameters: filter.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-jobs#list-jobs-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRun(string $owner, string $repo, int $runId, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/jobs';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List jobs for a workflow run attempt.
     *
     * @param   string   $owner          The account owner of the repository.
     * @param   string   $repo           The name of the repository.
     * @param   integer  $runId          The ID of the workflow run.
     * @param   integer  $attemptNumber  The attempt number of the workflow run.
     * @param   integer  $page           The page number from which to get items.
     * @param   integer  $limit          The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-jobs#list-jobs-for-a-workflow-run-attempt
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRunAttempt(string $owner, string $repo, int $runId, int $attemptNumber, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/attempts/' . $attemptNumber . '/jobs';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }
}
