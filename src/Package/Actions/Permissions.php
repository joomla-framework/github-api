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
 * GitHub API Actions Permissions class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/actions/permissions
 *
 * @since  __DEPLOY_VERSION__
 */
class Permissions extends AbstractPackage
{
    /**
     * Get GitHub Actions permissions for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-github-actions-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set GitHub Actions permissions for an organization.
     *
     * @param   string  $org                  The organization name.
     * @param   string  $enabledRepositories  The policy that controls the repositories in the organization that are allowed to run GitHub Actions.
     * @param   array   $options              Optional body fields: allowed_actions, sha_pinning_required.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-github-actions-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setForOrg(string $org, string $enabledRepositories, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions';

        $data = array_merge(
            $options,
            [
                'enabled_repositories' => $enabledRepositories,
            ]
        );

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get artifact and log retention settings for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-artifact-and-log-retention-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getArtifactAndLogRetentionForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/artifact-and-log-retention';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set artifact and log retention settings for an organization.
     *
     * @param   string   $org   The organization name.
     * @param   integer  $days  The number of days to retain checks, workflow runs, commit statuses, artifacts, and logs.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-artifact-and-log-retention-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setArtifactAndLogRetentionForOrg(string $org, int $days)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/artifact-and-log-retention';

        $data = [
            'days' => $days,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get fork PR contributor approval permissions for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-fork-pr-contributor-approval-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getForkPrContributorApprovalForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/fork-pr-contributor-approval';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set fork PR contributor approval permissions for an organization.
     *
     * @param   string  $org             The organization name.
     * @param   string  $approvalPolicy  The policy that controls when fork PR workflows require approval from a maintainer.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-fork-pr-contributor-approval-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setForkPrContributorApprovalForOrg(string $org, string $approvalPolicy)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/fork-pr-contributor-approval';

        $data = [
            'approval_policy' => $approvalPolicy,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get private repo fork PR workflow settings for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-private-repo-fork-pr-workflow-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getPrivateRepoForkPrWorkflowsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/fork-pr-workflows-private-repos';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set private repo fork PR workflow settings for an organization.
     *
     * @param   string   $org                               The organization name.
     * @param   boolean  $runWorkflowsFromForkPullRequests  Whether workflows triggered by pull requests from forks are allowed to run on private repositories.
     * @param   array    $options                           Optional body fields: send_write_tokens_to_workflows, send_secrets_and_variables, require_approval_for_fork_pr_workflows.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-private-repo-fork-pr-workflow-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setPrivateRepoForkPrWorkflowsForOrg(string $org, bool $runWorkflowsFromForkPullRequests, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/fork-pr-workflows-private-repos';

        $data = array_merge(
            $options,
            [
                'run_workflows_from_fork_pull_requests' => $runWorkflowsFromForkPullRequests,
            ]
        );

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * List selected repositories enabled for GitHub Actions in an organization.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#list-selected-repositories-enabled-for-github-actions-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListSelectedRepositoriesForOrg(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Set selected repositories enabled for GitHub Actions in an organization.
     *
     * @param   string  $org                    The organization name.
     * @param   array   $selectedRepositoryIds  List of repository IDs to enable for GitHub Actions.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-selected-repositories-enabled-for-github-actions-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setSelectedRepositoriesForOrg(string $org, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/repositories';

        $data = [
            'selected_repository_ids' => $selectedRepositoryIds,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Enable a selected repository for GitHub Actions in an organization.
     *
     * @param   string   $org           The organization name.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#enable-a-selected-repository-for-github-actions-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function enableRepositoryForOrg(string $org, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Disable a selected repository for GitHub Actions in an organization.
     *
     * @param   string   $org           The organization name.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#disable-a-selected-repository-for-github-actions-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function disableRepositoryForOrg(string $org, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get allowed actions and reusable workflows for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-allowed-actions-and-reusable-workflows-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getAllowedActionsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/selected-actions';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set allowed actions and reusable workflows for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: github_owned_allowed, verified_allowed, patterns_allowed.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-allowed-actions-and-reusable-workflows-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setAllowedActionsForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/selected-actions';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get self-hosted runners settings for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-self-hosted-runners-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getSelfHostedRunnersForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/self-hosted-runners';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set self-hosted runners settings for an organization.
     *
     * @param   string  $org                  The organization name.
     * @param   string  $enabledRepositories  The policy that controls whether self-hosted runners can be used in the organization.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-self-hosted-runners-settings-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setSelfHostedRunnersForOrg(string $org, string $enabledRepositories)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/self-hosted-runners';

        $data = [
            'enabled_repositories' => $enabledRepositories,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * List repositories allowed to use self-hosted runners in an organization.
     *
     * @param   string   $org    The organization name.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#list-repositories-allowed-to-use-self-hosted-runners-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getListSelfHostedRunnersRepositoriesForOrg(string $org, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/self-hosted-runners/repositories';

        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Set repositories allowed to use self-hosted runners in an organization.
     *
     * @param   string  $org                    The organization name.
     * @param   array   $selectedRepositoryIds  IDs of repositories that can use repository-level self-hosted runners.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-repositories-allowed-to-use-self-hosted-runners-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setSelfHostedRunnersRepositoriesForOrg(string $org, array $selectedRepositoryIds)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/self-hosted-runners/repositories';

        $data = [
            'selected_repository_ids' => $selectedRepositoryIds,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Add a repository to the list of repositories allowed to use self-hosted runners in an organization.
     *
     * @param   string   $org           The organization name.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#add-a-repository-to-the-list-of-repositories-allowed-to-use-self-hosted-runners-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function enableSelfHostedRunnersRepositoryForOrg(string $org, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/self-hosted-runners/repositories/' . $repositoryId;

        $this->processResponse($this->client->put($this->fetchUrl($path), ''), 204);
    }

    /**
     * Remove a repository from the list of repositories allowed to use self-hosted runners in an organization.
     *
     * @param   string   $org           The organization name.
     * @param   integer  $repositoryId  The ID of the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#remove-a-repository-from-the-list-of-repositories-allowed-to-use-self-hosted-runners-in-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function disableSelfHostedRunnersRepositoryForOrg(string $org, int $repositoryId)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/self-hosted-runners/repositories/' . $repositoryId;

        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }

    /**
     * Get default workflow permissions for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-default-workflow-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getDefaultWorkflowPermissionsForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/workflow';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set default workflow permissions for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: default_workflow_permissions, can_approve_pull_request_reviews.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-default-workflow-permissions-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function setDefaultWorkflowPermissionsForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/actions/permissions/workflow';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get GitHub Actions permissions for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-github-actions-permissions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set GitHub Actions permissions for a repository.
     *
     * @param   string   $owner    The account owner of the repository.
     * @param   string   $repo     The name of the repository.
     * @param   boolean  $enabled  Whether GitHub Actions is enabled on the repository.
     * @param   array    $options  Optional body fields: allowed_actions, sha_pinning_required.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-github-actions-permissions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setForRepo(string $owner, string $repo, bool $enabled, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions';

        $data = array_merge(
            $options,
            [
                'enabled' => $enabled,
            ]
        );

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get the level of access for workflows outside of the repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-the-level-of-access-for-workflows-outside-of-the-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getWorkflowAccessForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/access';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set the level of access for workflows outside of the repository.
     *
     * @param   string  $owner        The account owner of the repository.
     * @param   string  $repo         The name of the repository.
     * @param   string  $accessLevel  Defines the level of access that workflows outside of the repository have to actions and reusable workflows within the repository.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-the-level-of-access-for-workflows-outside-of-the-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setWorkflowAccessForRepo(string $owner, string $repo, string $accessLevel)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/access';

        $data = [
            'access_level' => $accessLevel,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get artifact and log retention settings for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-artifact-and-log-retention-settings-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getArtifactAndLogRetentionForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/artifact-and-log-retention';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set artifact and log retention settings for a repository.
     *
     * @param   string   $owner  The account owner of the repository.
     * @param   string   $repo   The name of the repository.
     * @param   integer  $days   The number of days to retain checks, workflow runs, commit statuses, artifacts, and logs.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-artifact-and-log-retention-settings-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setArtifactAndLogRetentionForRepo(string $owner, string $repo, int $days)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/artifact-and-log-retention';

        $data = [
            'days' => $days,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get fork PR contributor approval permissions for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-fork-pr-contributor-approval-permissions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getForkPrContributorApprovalForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/fork-pr-contributor-approval';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set fork PR contributor approval permissions for a repository.
     *
     * @param   string  $owner           The account owner of the repository.
     * @param   string  $repo            The name of the repository.
     * @param   string  $approvalPolicy  The policy that controls when fork PR workflows require approval from a maintainer.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-fork-pr-contributor-approval-permissions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setForkPrContributorApprovalForRepo(string $owner, string $repo, string $approvalPolicy)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/fork-pr-contributor-approval';

        $data = [
            'approval_policy' => $approvalPolicy,
        ];

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get private repo fork PR workflow settings for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-private-repo-fork-pr-workflow-settings-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getPrivateRepoForkPrWorkflowsForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/fork-pr-workflows-private-repos';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set private repo fork PR workflow settings for a repository.
     *
     * @param   string   $owner                             The account owner of the repository.
     * @param   string   $repo                              The name of the repository.
     * @param   boolean  $runWorkflowsFromForkPullRequests  Whether workflows triggered by pull requests from forks are allowed to run on private repositories.
     * @param   array    $options                           Optional body fields: send_write_tokens_to_workflows, send_secrets_and_variables, require_approval_for_fork_pr_workflows.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-private-repo-fork-pr-workflow-settings-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setPrivateRepoForkPrWorkflowsForRepo(string $owner, string $repo, bool $runWorkflowsFromForkPullRequests, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/fork-pr-workflows-private-repos';

        $data = array_merge(
            $options,
            [
                'run_workflows_from_fork_pull_requests' => $runWorkflowsFromForkPullRequests,
            ]
        );

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get allowed actions and reusable workflows for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-allowed-actions-and-reusable-workflows-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getAllowedActionsForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/selected-actions';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set allowed actions and reusable workflows for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: github_owned_allowed, verified_allowed, patterns_allowed.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-allowed-actions-and-reusable-workflows-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setAllowedActionsForRepo(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/selected-actions';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }

    /**
     * Get default workflow permissions for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/actions/permissions#get-default-workflow-permissions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getDefaultWorkflowPermissionsForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/workflow';

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Set default workflow permissions for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: default_workflow_permissions, can_approve_pull_request_reviews.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/actions/permissions#set-default-workflow-permissions-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function setDefaultWorkflowPermissionsForRepo(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/actions/permissions/workflow';

        $data = (object) $options;

        $this->processResponse($this->client->put($this->fetchUrl($path), json_encode($data)), 204);
    }
}
