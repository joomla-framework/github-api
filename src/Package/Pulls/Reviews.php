<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Pulls;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Pull Request Reviews class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/pulls/reviews
 *
 * @since  __DEPLOY_VERSION__
 */
class Reviews extends AbstractPackage
{
    /**
     * List reviews for a pull request.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   integer  $page        The page number from which to get items.
     * @param   integer  $limit       The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/pulls/reviews#list-reviews-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getList(string $owner, string $repo, int $pullNumber, int $page = 0, int $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Create a review for a pull request.
     *
     * Without an `event` the review is created in the PENDING state and must be submitted later.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   array    $options     Optional body fields: commit_id, body, event (APPROVE, REQUEST_CHANGES, COMMENT),
     *                                comments (array of draft review comments).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/pulls/reviews#create-a-review-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function create(string $owner, string $repo, int $pullNumber, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews';

        $data = (object) $options;

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            200
        );
    }

    /**
     * Get a review for a pull request.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   integer  $reviewId    The ID of the review.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/pulls/reviews#get-a-review-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function get(string $owner, string $repo, int $pullNumber, int $reviewId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews/' . $reviewId;

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Update the summary comment of a review for a pull request.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   integer  $reviewId    The ID of the review.
     * @param   string   $body        The body text of the review.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/pulls/reviews#update-a-review-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function edit(string $owner, string $repo, int $pullNumber, int $reviewId, string $body)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews/' . $reviewId;

        // Send the request.
        return $this->processResponse(
            $this->client->put($this->fetchUrl($path), json_encode(['body' => $body])),
            200
        );
    }

    /**
     * Delete a pending review for a pull request.
     *
     * Submitted reviews cannot be deleted.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   integer  $reviewId    The ID of the review.
     *
     * @return  object  The deleted review.
     *
     * @link    https://docs.github.com/rest/pulls/reviews#delete-a-pending-review-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function delete(string $owner, string $repo, int $pullNumber, int $reviewId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews/' . $reviewId;

        // Send the request.
        return $this->processResponse($this->client->delete($this->fetchUrl($path)), 200);
    }

    /**
     * List comments for a pull request review.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   integer  $reviewId    The ID of the review.
     * @param   integer  $page        The page number from which to get items.
     * @param   integer  $limit       The number of items on a page.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/pulls/reviews#list-comments-for-a-pull-request-review
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getListComments(
        string $owner,
        string $repo,
        int $pullNumber,
        int $reviewId,
        int $page = 0,
        int $limit = 0
    ) {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews/' . $reviewId . '/comments';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)), 200);
    }

    /**
     * Dismiss a review for a pull request.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   integer  $reviewId    The ID of the review.
     * @param   string   $message     The message for the pull request review dismissal.
     * @param   array    $options     Optional body fields: event (DISMISS).
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/pulls/reviews#dismiss-a-review-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function dismiss(
        string $owner,
        string $repo,
        int $pullNumber,
        int $reviewId,
        string $message,
        array $options = []
    ) {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews/' . $reviewId . '/dismissals';

        $data = array_merge($options, ['message' => $message]);

        // Send the request.
        return $this->processResponse(
            $this->client->put($this->fetchUrl($path), json_encode($data)),
            200
        );
    }

    /**
     * Submit a pending review for a pull request.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     * @param   integer  $reviewId    The ID of the review.
     * @param   string   $event       The review action: APPROVE, REQUEST_CHANGES or COMMENT.
     * @param   array    $options     Optional body fields: body.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/pulls/reviews#submit-a-review-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function submit(
        string $owner,
        string $repo,
        int $pullNumber,
        int $reviewId,
        string $event,
        array $options = []
    ) {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/reviews/' . $reviewId . '/events';

        $data = array_merge($options, ['event' => $event]);

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            200
        );
    }
}
