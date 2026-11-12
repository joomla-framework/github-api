<?php

/**
 * Part of the Joomla Framework GitHub Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Repositories;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Repositories Branches class for the Joomla Framework.
 *
 * @documentation https://developer.github.com/v3/repos/branches
 *
 * @since  1.4.0
 */
class Branches extends AbstractPackage
{
    /**
     * List Branches.
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.4.0
     */
    public function getList($owner, $repo)
    {
        // Build the request path.
        $path = "/repos/$owner/$repo/branches";

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Get Branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @since   1.4.0
     */
    public function get($owner, $repo, $branch)
    {
        // Build the request path.
        $path = "/repos/$owner/$repo/branches/$branch";

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Rename a branch.
     *
     * @param   string  $owner    Repository owner.
     * @param   string  $repo     Repository name.
     * @param   string  $branch   The current name of the branch.
     * @param   string  $newName  The new name of the branch.
     *
     * @return  object  The renamed branch.
     *
     * @link    https://docs.github.com/rest/branches/branches#rename-a-branch
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function rename(string $owner, string $repo, string $branch, string $newName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/branches/' . rawurlencode($branch) . '/rename';

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode(['new_name' => $newName])),
            201
        );
    }

    /**
     * Sync a branch of a forked repository with the upstream repository.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  The name of the branch to update.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branches#sync-a-fork-branch-with-the-upstream-repository
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function mergeUpstream(string $owner, string $repo, string $branch)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/merge-upstream';

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode(['branch' => $branch])),
            200
        );
    }

    /**
     * Get branch protection.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-branch-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getProtection(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->protectionPath($owner, $repo, $branch))),
            200
        );
    }

    /**
     * Update (replace) branch protection.
     *
     * The four required settings must always be sent; pass null to disable one of them.
     *
     * @param   string      $owner                       Repository owner.
     * @param   string      $repo                        Repository name.
     * @param   string      $branch                      Branch name.
     * @param   array|null  $requiredStatusChecks        Required status checks (keys: strict, contexts, checks) or null.
     * @param   boolean     $enforceAdmins               Enforce all configured restrictions for administrators.
     * @param   array|null  $requiredPullRequestReviews  Pull request review settings (keys: dismissal_restrictions,
     *                                                   dismiss_stale_reviews, require_code_owner_reviews,
     *                                                   required_approving_review_count, require_last_push_approval,
     *                                                   bypass_pull_request_allowances) or null.
     * @param   array|null  $restrictions                Push restrictions (keys: users, teams, apps) or null.
     * @param   array       $options                     Optional body fields: required_linear_history, allow_force_pushes,
     *                                                   allow_deletions, block_creations,
     *                                                   required_conversation_resolution, lock_branch, allow_fork_syncing.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#update-branch-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function editProtection(
        string $owner,
        string $repo,
        string $branch,
        ?array $requiredStatusChecks,
        bool $enforceAdmins,
        ?array $requiredPullRequestReviews,
        ?array $restrictions,
        array $options = []
    ) {
        $data = array_merge(
            $options,
            [
                'required_status_checks'        => $requiredStatusChecks,
                'enforce_admins'                => $enforceAdmins,
                'required_pull_request_reviews' => $requiredPullRequestReviews,
                'restrictions'                  => $restrictions,
            ]
        );

        return $this->processResponse(
            $this->client->put($this->fetchUrl($this->protectionPath($owner, $repo, $branch)), json_encode($data)),
            200
        );
    }

    /**
     * Delete branch protection.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#delete-branch-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteProtection(string $owner, string $repo, string $branch)
    {
        $this->processResponse(
            $this->client->delete($this->fetchUrl($this->protectionPath($owner, $repo, $branch))),
            204
        );
    }

    /**
     * Get admin branch protection (whether the protection is enforced for administrators).
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-admin-branch-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getAdminEnforcement(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/enforce_admins'))),
            200
        );
    }

    /**
     * Set admin branch protection (enforce the protection for administrators).
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#set-admin-branch-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setAdminEnforcement(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->post($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/enforce_admins')), ''),
            200
        );
    }

    /**
     * Delete admin branch protection (stop enforcing the protection for administrators).
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#delete-admin-branch-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteAdminEnforcement(string $owner, string $repo, string $branch)
    {
        $this->processResponse(
            $this->client->delete($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/enforce_admins'))),
            204
        );
    }

    /**
     * Get pull request review protection.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-pull-request-review-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getPullRequestReviewProtection(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->get(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_pull_request_reviews'))
            ),
            200
        );
    }

    /**
     * Update pull request review protection.
     *
     * @param   string  $owner    Repository owner.
     * @param   string  $repo     Repository name.
     * @param   string  $branch   Branch name.
     * @param   array   $options  Optional body fields: dismissal_restrictions, dismiss_stale_reviews,
     *                            require_code_owner_reviews, required_approving_review_count,
     *                            require_last_push_approval, bypass_pull_request_allowances.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#update-pull-request-review-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function editPullRequestReviewProtection(string $owner, string $repo, string $branch, array $options = [])
    {
        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_pull_request_reviews')),
                json_encode($data)
            ),
            200
        );
    }

    /**
     * Delete pull request review protection.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#delete-pull-request-review-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deletePullRequestReviewProtection(string $owner, string $repo, string $branch)
    {
        $this->processResponse(
            $this->client->delete(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_pull_request_reviews'))
            ),
            204
        );
    }

    /**
     * Get commit signature protection (whether signed commits are required).
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-commit-signature-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getCommitSignatureProtection(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_signatures'))),
            200
        );
    }

    /**
     * Create commit signature protection (require signed commits).
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#create-commit-signature-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createCommitSignatureProtection(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->post(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_signatures')),
                ''
            ),
            200
        );
    }

    /**
     * Delete commit signature protection.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#delete-commit-signature-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteCommitSignatureProtection(string $owner, string $repo, string $branch)
    {
        $this->processResponse(
            $this->client->delete($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_signatures'))),
            204
        );
    }

    /**
     * Get status checks protection.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-status-checks-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getRequiredStatusChecks(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_status_checks'))),
            200
        );
    }

    /**
     * Update status check protection.
     *
     * @param   string  $owner    Repository owner.
     * @param   string  $repo     Repository name.
     * @param   string  $branch   Branch name.
     * @param   array   $options  Optional body fields: strict, contexts, checks.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#update-status-check-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function editRequiredStatusChecks(string $owner, string $repo, string $branch, array $options = [])
    {
        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_status_checks')),
                json_encode($data)
            ),
            200
        );
    }

    /**
     * Remove status check protection.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#remove-status-check-protection
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeRequiredStatusChecks(string $owner, string $repo, string $branch)
    {
        $this->processResponse(
            $this->client->delete($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_status_checks'))),
            204
        );
    }

    /**
     * Get all status check contexts.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  array  List of context names.
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-all-status-check-contexts
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getStatusCheckContexts(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->get(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_status_checks/contexts'))
            ),
            200
        );
    }

    /**
     * Add status check contexts.
     *
     * @param   string  $owner     Repository owner.
     * @param   string  $repo      Repository name.
     * @param   string  $branch    Branch name.
     * @param   array   $contexts  The names of the status checks to add.
     *
     * @return  array  List of context names.
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#add-status-check-contexts
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addStatusCheckContexts(string $owner, string $repo, string $branch, array $contexts)
    {
        return $this->processResponse(
            $this->client->post(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_status_checks/contexts')),
                json_encode(['contexts' => $contexts])
            ),
            200
        );
    }

    /**
     * Set (replace) status check contexts.
     *
     * @param   string  $owner     Repository owner.
     * @param   string  $repo      Repository name.
     * @param   string  $branch    Branch name.
     * @param   array   $contexts  The names of the status checks.
     *
     * @return  array  List of context names.
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#set-status-check-contexts
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setStatusCheckContexts(string $owner, string $repo, string $branch, array $contexts)
    {
        return $this->processResponse(
            $this->client->put(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_status_checks/contexts')),
                json_encode(['contexts' => $contexts])
            ),
            200
        );
    }

    /**
     * Remove status check contexts.
     *
     * @param   string  $owner     Repository owner.
     * @param   string  $repo      Repository name.
     * @param   string  $branch    Branch name.
     * @param   array   $contexts  The names of the status checks to remove.
     *
     * @return  array  List of the remaining context names.
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#remove-status-check-contexts
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeStatusCheckContexts(string $owner, string $repo, string $branch, array $contexts)
    {
        return $this->processResponse(
            $this->client->delete(
                $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/required_status_checks/contexts')),
                [],
                null,
                json_encode(['contexts' => $contexts])
            ),
            200
        );
    }

    /**
     * Get access restrictions (who may push to the branch).
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getAccessRestrictions(string $owner, string $repo, string $branch)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/restrictions'))),
            200
        );
    }

    /**
     * Delete access restrictions.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#delete-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteAccessRestrictions(string $owner, string $repo, string $branch)
    {
        $this->processResponse(
            $this->client->delete($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/restrictions'))),
            204
        );
    }

    /**
     * Get the GitHub Apps with push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-apps-with-access-to-the-protected-branch
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getAppAccessRestrictions(string $owner, string $repo, string $branch)
    {
        return $this->getRestrictions($owner, $repo, $branch, 'apps');
    }

    /**
     * Grant GitHub Apps push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $apps    The slugs of the GitHub Apps.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#add-app-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addAppAccessRestrictions(string $owner, string $repo, string $branch, array $apps)
    {
        return $this->changeRestrictions('post', $owner, $repo, $branch, 'apps', $apps);
    }

    /**
     * Replace the GitHub Apps with push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $apps    The slugs of the GitHub Apps.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#set-app-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setAppAccessRestrictions(string $owner, string $repo, string $branch, array $apps)
    {
        return $this->changeRestrictions('put', $owner, $repo, $branch, 'apps', $apps);
    }

    /**
     * Remove push access to the protected branch from GitHub Apps.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $apps    The slugs of the GitHub Apps.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#remove-app-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeAppAccessRestrictions(string $owner, string $repo, string $branch, array $apps)
    {
        return $this->changeRestrictions('delete', $owner, $repo, $branch, 'apps', $apps);
    }

    /**
     * Get the teams with push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-teams-with-access-to-the-protected-branch
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getTeamAccessRestrictions(string $owner, string $repo, string $branch)
    {
        return $this->getRestrictions($owner, $repo, $branch, 'teams');
    }

    /**
     * Grant teams push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $teams   The slugs of the teams.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#add-team-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addTeamAccessRestrictions(string $owner, string $repo, string $branch, array $teams)
    {
        return $this->changeRestrictions('post', $owner, $repo, $branch, 'teams', $teams);
    }

    /**
     * Replace the teams with push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $teams   The slugs of the teams.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#set-team-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setTeamAccessRestrictions(string $owner, string $repo, string $branch, array $teams)
    {
        return $this->changeRestrictions('put', $owner, $repo, $branch, 'teams', $teams);
    }

    /**
     * Remove push access to the protected branch from teams.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $teams   The slugs of the teams.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#remove-team-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeTeamAccessRestrictions(string $owner, string $repo, string $branch, array $teams)
    {
        return $this->changeRestrictions('delete', $owner, $repo, $branch, 'teams', $teams);
    }

    /**
     * Get the users with push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#get-users-with-access-to-the-protected-branch
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getUserAccessRestrictions(string $owner, string $repo, string $branch)
    {
        return $this->getRestrictions($owner, $repo, $branch, 'users');
    }

    /**
     * Grant users push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $users   The user logins.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#add-user-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function addUserAccessRestrictions(string $owner, string $repo, string $branch, array $users)
    {
        return $this->changeRestrictions('post', $owner, $repo, $branch, 'users', $users);
    }

    /**
     * Replace the users with push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $users   The user logins.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#set-user-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function setUserAccessRestrictions(string $owner, string $repo, string $branch, array $users)
    {
        return $this->changeRestrictions('put', $owner, $repo, $branch, 'users', $users);
    }

    /**
     * Remove push access to the protected branch from users.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   array   $users   The user logins.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/branches/branch-protection#remove-user-access-restrictions
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function removeUserAccessRestrictions(string $owner, string $repo, string $branch, array $users)
    {
        return $this->changeRestrictions('delete', $owner, $repo, $branch, 'users', $users);
    }

    /**
     * Build the path of a branch protection resource.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   string  $suffix  Path below `/protection`, starting with a slash.
     *
     * @return  string
     *
     * @since   __DEPLOY_VERSION__
     */
    private function protectionPath(string $owner, string $repo, string $branch, string $suffix = ''): string
    {
        return '/repos/' . $owner . '/' . $repo . '/branches/' . rawurlencode($branch) . '/protection' . $suffix;
    }

    /**
     * Get the apps, teams or users with push access to the protected branch.
     *
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   string  $type    One of apps, teams, users.
     *
     * @return  array
     *
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    private function getRestrictions(string $owner, string $repo, string $branch, string $type)
    {
        return $this->processResponse(
            $this->client->get($this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/restrictions/' . $type))),
            200
        );
    }

    /**
     * Add, set or remove apps, teams or users with push access to the protected branch.
     *
     * @param   string  $method  The HTTP method: post (add), put (set) or delete (remove).
     * @param   string  $owner   Repository owner.
     * @param   string  $repo    Repository name.
     * @param   string  $branch  Branch name.
     * @param   string  $type    One of apps, teams, users (also the name of the body field).
     * @param   array   $items   App slugs, team slugs or user logins.
     *
     * @return  array
     *
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    private function changeRestrictions(string $method, string $owner, string $repo, string $branch, string $type, array $items)
    {
        $url  = $this->fetchUrl($this->protectionPath($owner, $repo, $branch, '/restrictions/' . $type));
        $body = json_encode([$type => $items]);

        if ($method === 'delete') {
            $response = $this->client->delete($url, [], null, $body);
        } else {
            $response = $this->client->$method($url, $body);
        }

        return $this->processResponse($response, 200);
    }
}
