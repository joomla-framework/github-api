<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;
use Joomla\Http\Exception\UnexpectedResponseException;

/**
 * GitHub API Pull Requests class for the Joomla Framework.
 *
 * @link   https://developer.github.com/v3/pulls
 *
 * @since  1.0
 *
 * @property-read  Pulls\Comments  $comments  GitHub API object for comments.
 */
class Pulls extends AbstractPackage
{
    /**
     * Create a pull request.
     *
     * @param   string  $user   The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     * @param   string  $title  The title of the new pull request.
     * @param   string  $base   The branch (or git ref) you want your changes pulled into. This
     *                          should be an existing branch on the current repository. You cannot
     *                          submit a pull request to one repo that requests a merge to a base
     *                          of another repo.
     * @param   string  $head   The branch (or git ref) where your changes are implemented.
     * @param   string  $body   The body text for the new pull request.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function create($user, $repo, $title, $base, $head, $body = '')
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls';

        // Build the request data.
        $data = json_encode(
            [
                'title' => $title,
                'base'  => $base,
                'head'  => $head,
                'body'  => $body,
            ]
        );

        // Send the request.
        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Method to create a pull request from an existing issue.
     *
     * @param   string   $user     The name of the owner of the GitHub repository.
     * @param   string   $repo     The name of the GitHub repository.
     * @param   integer  $issueId  The issue number for which to attach the new pull request.
     * @param   string   $base     The branch (or git ref) you want your changes pulled into. This
     *                             should be an existing branch on the current repository. You cannot
     *                             submit a pull request to one repo that requests a merge to a base
     *                             of another repo.
     * @param   string   $head     The branch (or git ref) where your changes are implemented.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function createFromIssue($user, $repo, $issueId, $base, $head)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls';

        // Build the request data.
        $data = json_encode(
            [
                'issue' => (int) $issueId,
                'base'  => $base,
                'head'  => $head,
            ]
        );

        // Send the request.
        return $this->processResponse($this->client->post($this->fetchUrl($path), $data), 201);
    }

    /**
     * Update a pull request.
     *
     * @param   string   $user    The name of the owner of the GitHub repository.
     * @param   string   $repo    The name of the GitHub repository.
     * @param   integer  $pullId  The pull request number.
     * @param   string   $title   The optional new title for the pull request.
     * @param   string   $body    The optional new body text for the pull request.
     * @param   string   $state   The optional new state for the pull request. [open, closed]
     * @param   string   $base    The optional new base branch for the pull request.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function edit($user, $repo, $pullId, $title = null, $body = null, $state = null, $base = null)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId;

        // Create the data object.
        $data = new \stdClass();

        // If a title is set add it to the data object.
        if (isset($title)) {
            $data->title = $title;
        }

        // If a body is set add it to the data object.
        if (isset($body)) {
            $data->body = $body;
        }

        // If a state is set add it to the data object.
        if (isset($state)) {
            $data->state = $state;
        }

        // If a base branch is set add it to the data object.
        if (isset($base)) {
            $data->base = $base;
        }

        // Encode the request data.
        $data = json_encode($data);

        // Send the request.
        return $this->processResponse($this->client->patch($this->fetchUrl($path), $data));
    }

    /**
     * Get a single pull request.
     *
     * @param   string   $user    The name of the owner of the GitHub repository.
     * @param   string   $repo    The name of the GitHub repository.
     * @param   integer  $pullId  The pull request number.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function get($user, $repo, $pullId)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId;

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * List commits on a pull request.
     *
     * @param   string   $user    The name of the owner of the GitHub repository.
     * @param   string   $repo    The name of the GitHub repository.
     * @param   integer  $pullId  The pull request number.
     * @param   integer  $page    The page number from which to get items.
     * @param   integer  $limit   The number of items on a page.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function getCommits($user, $repo, $pullId, $page = 0, $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId . '/commits';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List pull requests files.
     *
     * @param   string   $user    The name of the owner of the GitHub repository.
     * @param   string   $repo    The name of the GitHub repository.
     * @param   integer  $pullId  The pull request number.
     * @param   integer  $page    The page number from which to get items.
     * @param   integer  $limit   The number of items on a page.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function getFiles($user, $repo, $pullId, $page = 0, $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId . '/files';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * List pull requests.
     *
     * @param   string   $user   The name of the owner of the GitHub repository.
     * @param   string   $repo   The name of the GitHub repository.
     * @param   string   $state  The optional state to filter requests by. [open, closed]
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function getList($user, $repo, $state = 'open', $page = 0, $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls';

        // If a state exists append it as an option.
        if ($state != 'open') {
            $path .= '?state=' . $state;
        }

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path, $page, $limit)));
    }

    /**
     * Get if a pull request has been merged.
     *
     * @param   string   $user    The name of the owner of the GitHub repository.
     * @param   string   $repo    The name of the GitHub repository.
     * @param   integer  $pullId  The pull request number.  The pull request number.
     *
     * @return  boolean  True if the pull request has been merged
     *
     * @since   1.0
     * @throws  UnexpectedResponseException
     */
    public function isMerged($user, $repo, $pullId)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId . '/merge';

        // Send the request.
        $response = $this->client->get($this->fetchUrl($path));

        // Validate the response code.
        if ($response->code == 204) {
            return true;
        }

        if ($response->code == 404) {
            return false;
        }

        // Decode the error response and throw an exception.
        $error   = json_decode($response->body);
        $message = isset($error->message) ? $error->message : 'Invalid response received from GitHub.';

        throw new UnexpectedResponseException($response, $message, $response->code);
    }

    /**
     * Merge a pull request (Merge Button).
     *
     * @param   string   $user     The name of the owner of the GitHub repository.
     * @param   string   $repo     The name of the GitHub repository.
     * @param   integer  $pullId   The pull request number.
     * @param   string   $message  The message that will be used for the merge commit.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \DomainException
     */
    public function merge($user, $repo, $pullId, $message = '')
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId . '/merge';

        // Build the request data.
        $data = json_encode(
            [
                'commit_message' => $message,
            ]
        );

        // Send the request.
        return $this->processResponse($this->client->put($this->fetchUrl($path), $data));
    }
}
