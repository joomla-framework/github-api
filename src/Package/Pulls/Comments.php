<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Pulls;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Pulls Comments class for the Joomla Framework.
 *
 * @link   https://developer.github.com/v3/pulls/comments/
 *
 * @since  1.0
 */
class Comments extends AbstractPackage
{
    /**
     * Create a comment.
     *
     * @param   string   $user      The name of the owner of the GitHub repository.
     * @param   string   $repo      The name of the GitHub repository.
     * @param   integer  $pullId    The pull request number.
     * @param   string   $body      The comment body text.
     * @param   string   $commitId  The SHA1 hash of the commit to comment on.
     * @param   string   $filePath  The Relative path of the file to comment on.
     * @param   string   $position  The line index in the diff to comment on.
     *
     * @since   1.0
     *
     * @return  object
     */
    public function create($user, $repo, $pullId, $body, $commitId, $filePath, $position)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId . '/comments';

        // Build the request data.
        $data = json_encode(
            [
                'body'      => $body,
                'commit_id' => $commitId,
                'path'      => $filePath,
                'position'  => $position,
            ]
        );

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), $data),
            201
        );
    }

    /**
     * Method to create a comment in reply to another comment.
     *
     * @param   string   $user       The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $pullId     The pull request number.
     * @param   string   $body       The comment body text.
     * @param   integer  $inReplyTo  The id of the comment to reply to.
     *
     * @since   1.0
     *
     * @return  object
     */
    public function createReply($user, $repo, $pullId, $body, $inReplyTo)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId . '/comments';

        // Build the request data.
        $data = json_encode(
            [
                'body'        => $body,
                'in_reply_to' => (int) $inReplyTo,
            ]
        );

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), $data),
            201
        );
    }

    /**
     * Delete a comment.
     *
     * @param   string   $user       The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The id of the comment to delete.
     *
     * @since   1.0
     *
     * @return  void
     */
    public function delete($user, $repo, $commentId)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/comments/' . (int) $commentId;

        // Send the request.
        $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }

    /**
     * Edit a comment.
     *
     * @param   string   $user       The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The id of the comment to update.
     * @param   string   $body       The new body text for the comment.
     *
     * @since   1.0
     *
     * @return  object
     */
    public function edit($user, $repo, $commentId, $body)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/comments/' . (int) $commentId;

        // Build the request data.
        $data = json_encode(
            [
                'body' => $body,
            ]
        );

        // Send the request.
        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), $data)
        );
    }

    /**
     * Get a single comment.
     *
     * @param   string   $user       The name of the owner of the GitHub repository.
     * @param   string   $repo       The name of the GitHub repository.
     * @param   integer  $commentId  The comment id to get.
     *
     * @since   1.0
     *
     * @return  object
     */
    public function get($user, $repo, $commentId)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/comments/' . (int) $commentId;

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * List comments on a pull request.
     *
     * @param   string   $user    The name of the owner of the GitHub repository.
     * @param   string   $repo    The name of the GitHub repository.
     * @param   integer  $pullId  The pull request number.
     * @param   integer  $page    The page number from which to get items.
     * @param   integer  $limit   The number of items on a page.
     *
     * @since   1.0
     *
     * @return  array
     */
    public function getList($user, $repo, $pullId, $page = 0, $limit = 0)
    {
        // Build the request path.
        $path = '/repos/' . $user . '/' . $repo . '/pulls/' . (int) $pullId . '/comments';

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit))
        );
    }

    /**
     * List comments in a repository.
     *
     * @param   string   $user   The name of the owner of the GitHub repository.
     * @param   string   $repo   The name of the GitHub repository.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  array
     *
     * @since   1.4.0
     */
    public function getListForRepo($user, $repo, $page = 0, $limit = 0)
    {
        // Build the request path.
        $path = "/repos/$user/$repo/pulls/comments";

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path, $page, $limit))
        );
    }
}
