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
 * GitHub API Pull Request Review Requests class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/pulls/review-requests
 *
 * @since  __DEPLOY_VERSION__
 */
class ReviewRequests extends AbstractPackage
{
    /**
     * Get all requested reviewers (users and teams) for a pull request.
     *
     * @param   string   $owner       The name of the owner of the GitHub repository.
     * @param   string   $repo        The name of the GitHub repository.
     * @param   integer  $pullNumber  The pull request number.
     *
     * @return  object  An object with the properties `users` and `teams`.
     *
     * @link    https://docs.github.com/rest/pulls/review-requests#get-all-requested-reviewers-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function getList(string $owner, string $repo, int $pullNumber)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/requested_reviewers';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)), 200);
    }

    /**
     * Request reviewers for a pull request.
     *
     * At least one of `$reviewers` or `$teamReviewers` must be given.
     *
     * @param   string   $owner          The name of the owner of the GitHub repository.
     * @param   string   $repo           The name of the GitHub repository.
     * @param   integer  $pullNumber     The pull request number.
     * @param   array    $reviewers      User logins to request.
     * @param   array    $teamReviewers  Team slugs to request.
     *
     * @return  object  The pull request.
     *
     * @link    https://docs.github.com/rest/pulls/review-requests#request-reviewers-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function request(string $owner, string $repo, int $pullNumber, array $reviewers = [], array $teamReviewers = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/requested_reviewers';

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($this->buildBody($reviewers, $teamReviewers))),
            201
        );
    }

    /**
     * Remove requested reviewers from a pull request.
     *
     * @param   string   $owner          The name of the owner of the GitHub repository.
     * @param   string   $repo           The name of the GitHub repository.
     * @param   integer  $pullNumber     The pull request number.
     * @param   array    $reviewers      User logins to remove (required by the API, may be empty).
     * @param   array    $teamReviewers  Team slugs to remove.
     *
     * @return  object  The pull request.
     *
     * @link    https://docs.github.com/rest/pulls/review-requests#remove-requested-reviewers-from-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function remove(string $owner, string $repo, int $pullNumber, array $reviewers, array $teamReviewers = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/requested_reviewers';

        $data = ['reviewers' => $reviewers];

        if ($teamReviewers) {
            $data['team_reviewers'] = $teamReviewers;
        }

        // Send the request.
        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path), [], null, json_encode($data)),
            200
        );
    }

    /**
     * Re-request reviews from reviewers who have already reviewed a pull request.
     *
     * At least one of `$reviewers` or `$teamReviewers` must be given.
     *
     * @param   string   $owner          The name of the owner of the GitHub repository.
     * @param   string   $repo           The name of the GitHub repository.
     * @param   integer  $pullNumber     The pull request number.
     * @param   array    $reviewers      User logins whose reviews are re-requested.
     * @param   array    $teamReviewers  Team slugs whose reviews are re-requested.
     *
     * @return  object  The pull request.
     *
     * @link    https://docs.github.com/rest/pulls/review-requests#rerequest-reviewers-for-a-pull-request
     * @since   __DEPLOY_VERSION__
     * @throws  UnexpectedResponseException
     */
    public function rerequest(string $owner, string $repo, int $pullNumber, array $reviewers = [], array $teamReviewers = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/pulls/' . $pullNumber . '/requested_reviewers/rerequest';

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($this->buildBody($reviewers, $teamReviewers))),
            201
        );
    }

    /**
     * Build the request body from the given reviewers, leaving out empty lists.
     *
     * @param   array  $reviewers      User logins.
     * @param   array  $teamReviewers  Team slugs.
     *
     * @return  object
     *
     * @since   __DEPLOY_VERSION__
     */
    private function buildBody(array $reviewers, array $teamReviewers)
    {
        $data = [];

        if ($reviewers) {
            $data['reviewers'] = $reviewers;
        }

        if ($teamReviewers) {
            $data['team_reviewers'] = $teamReviewers;
        }

        return (object) $data;
    }
}
