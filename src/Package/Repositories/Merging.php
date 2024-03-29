<?php

/**
 * Part of the Joomla Framework GitHub Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Repositories;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Repositories Merging class for the Joomla Framework.
 *
 * @link   https://developer.github.com/v3/repos/merging
 *
 * @since  1.0
 */
class Merging extends AbstractPackage
{
    /**
     * Perform a merge.
     *
     * @param   string  $owner          The name of the owner of the GitHub repository.
     * @param   string  $repo           The name of the GitHub repository.
     * @param   string  $base           The name of the base branch that the head will be merged into.
     * @param   string  $head           The head to merge. This can be a branch name or a commit SHA1.
     * @param   string  $commitMessage  Commit message to use for the merge commit.
     *                                  If omitted, a default message will be used.
     *
     * @return  boolean
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     */
    public function perform($owner, $repo, $base, $head, $commitMessage = '')
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/merges';

        $data = new \stdClass();

        $data->base = $base;
        $data->head = $head;

        if ($commitMessage) {
            $data->commit_message = $commitMessage;
        }

        // Send the request.
        $response = $this->client->post($this->fetchUrl($path), json_encode($data));

        switch ($response->code) {
            case '201':
                // Success
                return json_decode($response->body);

            case '204':
                // No-op response (base already contains the head, nothing to merge)
                throw new \UnexpectedValueException('Nothing to merge');

            case '404':
                // Missing base or Missing head response
                $error = json_decode($response->body);

                $message = (isset($error->message)) ? $error->message : 'Missing base or head: ' . $response->code;

                throw new \UnexpectedValueException($message);

            case '409':
                // Merge conflict response
                $error = json_decode($response->body);

                $message = (isset($error->message)) ? $error->message : 'Merge conflict ' . $response->code;

                throw new \UnexpectedValueException($message);

            default:
                throw new \UnexpectedValueException('Unexpected response code: ' . $response->code);
        }
    }
}
