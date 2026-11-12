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
 * GitHub API Actions Workflow Runs class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/workflow-runs
 *
 * @since  __DEPLOY_VERSION__
 */
class Runs extends AbstractPackage
{
    /**
     * List workflow runs for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   array    $filters  Optional query parameters: actor, branch, event, status, created, exclude_pull_requests, check_suite_id, head_sha.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#list-workflow-runs-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getListForRepo(string $owner, string $repo, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List workflow runs for a workflow.
     *
     * @param   string          $owner       The account owner of the repository.
     * @param   string          $repo        The name of the repository.
     * @param   integer|string  $workflowId  The ID of the workflow or its file name, e.g. `main.yml`.
     * @param   array           $filters     Optional query parameters: actor, branch, event, status, created, exclude_pull_requests, check_suite_id, head_sha.
     * @param   integer         $page        The page number from which to get items.
     * @param   integer         $limit       The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#list-workflow-runs-for-a-workflow
     * @since   __DEPLOY_VERSION__
     */
    public function getListForWorkflow(string $owner, string $repo, int|string $workflowId, array $filters = [], int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/workflows/' . rawurlencode((string) $workflowId) . '/runs';

        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Get a workflow run.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $runId    The ID of the workflow run.
     * @param   array    $filters  Optional query parameters: exclude_pull_requests.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#get-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $runId, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Delete a workflow run.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#delete-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function delete(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get the review history for a workflow run.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#get-the-review-history-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function getReviews(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/approvals';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Approve a workflow run for a fork pull request.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#approve-a-workflow-run-for-a-fork-pull-request
     * @since   __DEPLOY_VERSION__
     */
    public function approve(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/approve';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 201);
    }

    /**
     * Get a workflow run attempt.
     *
     * @param   string   $owner          The account owner of the repository.
     * @param   string   $repo           The name of the repository.
     * @param   integer  $runId          The ID of the workflow run.
     * @param   integer  $attemptNumber  The attempt number of the workflow run.
     * @param   array    $filters        Optional query parameters: exclude_pull_requests.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#get-a-workflow-run-attempt
     * @since   __DEPLOY_VERSION__
     */
    public function getAttempt(string $owner, string $repo, int $runId, int $attemptNumber, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/attempts/' . $attemptNumber;

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Download workflow run attempt logs.
     *
     * @param   string   $owner          The account owner of the repository.
     * @param   string   $repo           The name of the repository.
     * @param   integer  $runId          The ID of the workflow run.
     * @param   integer  $attemptNumber  The attempt number of the workflow run.
     *
     * @return  string
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#download-workflow-run-attempt-logs
     * @since   __DEPLOY_VERSION__
     */
    public function downloadAttemptLogs(string $owner, string $repo, int $runId, int $attemptNumber)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/attempts/' . $attemptNumber . '/logs';

        $response = $this->client->get($this->fetchUrl($path));

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }

    /**
     * Cancel a workflow run.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#cancel-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function cancel(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/cancel';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 202);
    }

    /**
     * Force cancel a workflow run.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#force-cancel-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function forceCancel(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/force-cancel';

        return $this->processResponse($this->client->post($this->fetchUrl($path), ''), 202);
    }

    /**
     * Review custom deployment protection rules for a workflow run.
     *
     * @param   string   $owner            The account owner of the repository.
     * @param   string   $repo             The name of the repository.
     * @param   integer  $runId            The ID of the workflow run.
     * @param   string   $environmentName  The name of the environment to approve or reject.
     * @param   array    $options          Optional body fields: comment, state.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#review-custom-deployment-protection-rules-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function reviewCustomGates(string $owner, string $repo, int $runId, string $environmentName, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/deployment_protection_rule';

        $data = array_merge(
            $options,
            [
                'environment_name' => $environmentName,
            ]
        );

        $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Download workflow run logs.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  string
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#download-workflow-run-logs
     * @since   __DEPLOY_VERSION__
     */
    public function downloadLogs(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/logs';

        $response = $this->client->get($this->fetchUrl($path));

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }

    /**
     * Delete workflow run logs.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#delete-workflow-run-logs
     * @since   __DEPLOY_VERSION__
     */
    public function deleteLogs(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/logs';

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get pending deployments for a workflow run.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#get-pending-deployments-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function getPendingDeployments(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/pending_deployments';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Review pending deployments for a workflow run.
     *
     * @param   string   $owner           The account owner of the repository.
     * @param   string   $repo            The name of the repository.
     * @param   integer  $runId           The ID of the workflow run.
     * @param   array    $environmentIds  The list of environment ids to approve or reject.
     * @param   string   $state           Whether to approve or reject deployment to the specified environments.
     * @param   string   $comment         A comment to accompany the deployment review.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#review-pending-deployments-for-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function reviewPendingDeployments(string $owner, string $repo, int $runId, array $environmentIds, string $state, string $comment)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/pending_deployments';

        $data = [
            'environment_ids' => $environmentIds,
            'state'           => $state,
            'comment'         => $comment,
        ];

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)));
    }

    /**
     * Re-run a workflow.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $runId    The ID of the workflow run.
     * @param   array    $options  Optional body fields: enable_debug_logging.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#re-run-a-workflow
     * @since   __DEPLOY_VERSION__
     */
    public function rerun(string $owner, string $repo, int $runId, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/rerun';

        $data = (object) $options;

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Re-run failed jobs from a workflow run.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $runId    The ID of the workflow run.
     * @param   array    $options  Optional body fields: enable_debug_logging.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#re-run-failed-jobs-from-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function rerunFailedJobs(string $owner, string $repo, int $runId, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/rerun-failed-jobs';

        $data = (object) $options;

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Re-run a job from a workflow run.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   integer  $jobId    The ID of the job.
     * @param   array    $options  Optional body fields: enable_debug_logging, enable_debugger.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#re-run-a-job-from-a-workflow-run
     * @since   __DEPLOY_VERSION__
     */
    public function rerunJob(string $owner, string $repo, int $jobId, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/jobs/' . $jobId . '/rerun';

        $data = (object) $options;

        return $this->processResponse($this->client->post($this->fetchUrl($path), json_encode($data)), 201);
    }

    /**
     * Get workflow run usage.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $runId  The ID of the workflow run.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/workflow-runs#get-workflow-run-usage
     * @since   __DEPLOY_VERSION__
     */
    public function getUsage(string $owner, string $repo, int $runId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/runs/' . $runId . '/timing';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
