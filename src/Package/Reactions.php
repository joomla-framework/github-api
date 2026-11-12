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
 * GitHub API Reactions class for the Joomla Framework.
 *
 * Lists, creates and deletes reactions on commit comments, issues, issue comments, pull request review comments
 * and releases.
 *
 * @link   https://docs.github.com/rest/reactions
 *
 * @since  __DEPLOY_VERSION__
 */
class Reactions extends AbstractPackage
{
    /**
     * List reactions for a commit comment.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The ID of the commit comment.
     * @param   array    $filters    Optional query parameters: content (only return this reaction type).
     * @param   integer  $page       The page number from which to get items.
     * @param   integer  $limit      The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/reactions/reactions#list-reactions-for-a-commit-comment
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForCommitComment(string $owner, string $repo, int $commentId, array $filters = [], int $page = 0, int $limit = 0)
    {
        return $this->listReactions('/repos/' . $owner . '/' . $repo . '/comments/' . $commentId . '/reactions', $filters, $page, $limit);
    }

    /**
     * Create a reaction for a commit comment.
     *
     * Returns the existing reaction (HTTP 200) when the same reaction was already added.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The ID of the commit comment.
     * @param   string   $content    The reaction type: +1, -1, laugh, confused, heart, hooray, rocket, eyes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/reactions/reactions#create-reaction-for-a-commit-comment
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForCommitComment(string $owner, string $repo, int $commentId, string $content)
    {
        return $this->createReaction('/repos/' . $owner . '/' . $repo . '/comments/' . $commentId . '/reactions', $content);
    }

    /**
     * Delete a reaction from a commit comment.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $commentId   The ID of the commit comment.
     * @param   integer  $reactionId  The ID of the reaction.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/reactions/reactions#delete-a-commit-comment-reaction
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForCommitComment(string $owner, string $repo, int $commentId, int $reactionId)
    {
        $this->deleteReaction('/repos/' . $owner . '/' . $repo . '/comments/' . $commentId . '/reactions' . '/' . $reactionId);
    }

    /**
     * List reactions for an issue comment.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The ID of the issue comment.
     * @param   array    $filters    Optional query parameters: content (only return this reaction type).
     * @param   integer  $page       The page number from which to get items.
     * @param   integer  $limit      The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/reactions/reactions#list-reactions-for-an-issue-comment
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForIssueComment(string $owner, string $repo, int $commentId, array $filters = [], int $page = 0, int $limit = 0)
    {
        return $this->listReactions('/repos/' . $owner . '/' . $repo . '/issues/comments/' . $commentId . '/reactions', $filters, $page, $limit);
    }

    /**
     * Create a reaction for an issue comment.
     *
     * Returns the existing reaction (HTTP 200) when the same reaction was already added.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The ID of the issue comment.
     * @param   string   $content    The reaction type: +1, -1, laugh, confused, heart, hooray, rocket, eyes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/reactions/reactions#create-reaction-for-an-issue-comment
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForIssueComment(string $owner, string $repo, int $commentId, string $content)
    {
        return $this->createReaction('/repos/' . $owner . '/' . $repo . '/issues/comments/' . $commentId . '/reactions', $content);
    }

    /**
     * Delete a reaction from an issue comment.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $commentId   The ID of the issue comment.
     * @param   integer  $reactionId  The ID of the reaction.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/reactions/reactions#delete-an-issue-comment-reaction
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForIssueComment(string $owner, string $repo, int $commentId, int $reactionId)
    {
        $this->deleteReaction('/repos/' . $owner . '/' . $repo . '/issues/comments/' . $commentId . '/reactions' . '/' . $reactionId);
    }

    /**
     * List reactions for an issue.
     *
     * @param   string   $owner        The name of the owner of the GitHub repository.
     * @param   string   $repo         The name of the GitHub repository.
     * @param   integer  $issueNumber  The number of the issue.
     * @param   array    $filters      Optional query parameters: content (only return this reaction type).
     * @param   integer  $page         The page number from which to get items.
     * @param   integer  $limit        The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/reactions/reactions#list-reactions-for-an-issue
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForIssue(string $owner, string $repo, int $issueNumber, array $filters = [], int $page = 0, int $limit = 0)
    {
        return $this->listReactions('/repos/' . $owner . '/' . $repo . '/issues/' . $issueNumber . '/reactions', $filters, $page, $limit);
    }

    /**
     * Create a reaction for an issue.
     *
     * Returns the existing reaction (HTTP 200) when the same reaction was already added.
     *
     * @param   string   $owner        The name of the owner of the GitHub repository.
     * @param   string   $repo         The name of the GitHub repository.
     * @param   integer  $issueNumber  The number of the issue.
     * @param   string   $content      The reaction type: +1, -1, laugh, confused, heart, hooray, rocket, eyes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/reactions/reactions#create-reaction-for-an-issue
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForIssue(string $owner, string $repo, int $issueNumber, string $content)
    {
        return $this->createReaction('/repos/' . $owner . '/' . $repo . '/issues/' . $issueNumber . '/reactions', $content);
    }

    /**
     * Delete a reaction from an issue.
     *
     * @param   string   $owner        The name of the owner of the GitHub repository.
     * @param   string   $repo         The name of the GitHub repository.
     * @param   integer  $issueNumber  The number of the issue.
     * @param   integer  $reactionId   The ID of the reaction.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/reactions/reactions#delete-an-issue-reaction
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForIssue(string $owner, string $repo, int $issueNumber, int $reactionId)
    {
        $this->deleteReaction('/repos/' . $owner . '/' . $repo . '/issues/' . $issueNumber . '/reactions' . '/' . $reactionId);
    }

    /**
     * List reactions for a pull request review comment.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The ID of the pull request review comment.
     * @param   array    $filters    Optional query parameters: content (only return this reaction type).
     * @param   integer  $page       The page number from which to get items.
     * @param   integer  $limit      The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/reactions/reactions#list-reactions-for-a-pull-request-review-comment
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForPullRequestReviewComment(string $owner, string $repo, int $commentId, array $filters = [], int $page = 0, int $limit = 0)
    {
        return $this->listReactions('/repos/' . $owner . '/' . $repo . '/pulls/comments/' . $commentId . '/reactions', $filters, $page, $limit);
    }

    /**
     * Create a reaction for a pull request review comment.
     *
     * Returns the existing reaction (HTTP 200) when the same reaction was already added.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The ID of the pull request review comment.
     * @param   string   $content    The reaction type: +1, -1, laugh, confused, heart, hooray, rocket, eyes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/reactions/reactions#create-reaction-for-a-pull-request-review-comment
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForPullRequestReviewComment(string $owner, string $repo, int $commentId, string $content)
    {
        return $this->createReaction('/repos/' . $owner . '/' . $repo . '/pulls/comments/' . $commentId . '/reactions', $content);
    }

    /**
     * Delete a reaction from a pull request review comment.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $commentId   The ID of the pull request review comment.
     * @param   integer  $reactionId  The ID of the reaction.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/reactions/reactions#delete-a-pull-request-comment-reaction
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForPullRequestReviewComment(string $owner, string $repo, int $commentId, int $reactionId)
    {
        $this->deleteReaction('/repos/' . $owner . '/' . $repo . '/pulls/comments/' . $commentId . '/reactions' . '/' . $reactionId);
    }

    /**
     * List reactions for a release.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $releaseId  The ID of the release.
     * @param   array    $filters    Optional query parameters: content (only return this reaction type).
     * @param   integer  $page       The page number from which to get items.
     * @param   integer  $limit      The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/reactions/reactions#list-reactions-for-a-release
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListForRelease(string $owner, string $repo, int $releaseId, array $filters = [], int $page = 0, int $limit = 0)
    {
        return $this->listReactions('/repos/' . $owner . '/' . $repo . '/releases/' . $releaseId . '/reactions', $filters, $page, $limit);
    }

    /**
     * Create a reaction for a release.
     *
     * Returns the existing reaction (HTTP 200) when the same reaction was already added.
     *
     * @param   string   $owner      The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $releaseId  The ID of the release.
     * @param   string   $content    The reaction type: +1, laugh, heart, hooray, rocket, eyes.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/reactions/reactions#create-reaction-for-a-release
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function createForRelease(string $owner, string $repo, int $releaseId, string $content)
    {
        return $this->createReaction('/repos/' . $owner . '/' . $repo . '/releases/' . $releaseId . '/reactions', $content);
    }

    /**
     * Delete a reaction from a release.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $releaseId   The ID of the release.
     * @param   integer  $reactionId  The ID of the reaction.
     *
     * @return  void
     *
     * @link    https://docs.github.com/rest/reactions/reactions#delete-a-release-reaction
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function deleteForRelease(string $owner, string $repo, int $releaseId, int $reactionId)
    {
        $this->deleteReaction('/repos/' . $owner . '/' . $repo . '/releases/' . $releaseId . '/reactions' . '/' . $reactionId);
    }

    /**
     * Send a list request for the given reactions path.
     *
     * @param   string   $path     The reactions path.
     * @param   array    $filters  Optional query parameters.
     * @param   integer  $page     The page number from which to get items.
     * @param   integer  $limit    The number of items on a page.
     *
     * @return  array
     *
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    private function listReactions(string $path, array $filters, int $page, int $limit)
    {
        $uri = $this->fetchUrl($path, $page, $limit);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, $value);
        }

        return $this->processResponse($this->client->get($uri), 200);
    }

    /**
     * Send a create request for the given reactions path.
     *
     * @param   string  $path     The reactions path.
     * @param   string  $content  The reaction type.
     *
     * @return  object
     *
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    private function createReaction(string $path, string $content)
    {
        $response = $this->client->post($this->fetchUrl($path), json_encode(['content' => $content]));

        return $this->processResponse(
            $response,
            \in_array($response->getStatusCode(), [200, 201], true) ? $response->getStatusCode() : 201
        );
    }

    /**
     * Send a delete request for the given reaction path.
     *
     * @param   string  $path  The reaction path.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    private function deleteReaction(string $path)
    {
        $this->processResponse($this->client->delete($this->fetchUrl($path)), 204);
    }
}
