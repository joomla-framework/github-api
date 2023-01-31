<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\Data;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Data Tags class for the Joomla Framework.
 *
 * This tags API only deals with tag objects - so only annotated tags, not lightweight tags.
 *
 * @link   https://developer.github.com/v3/git/tags/
 *
 * @since  1.0
 */
class Tags extends AbstractPackage
{
    /**
     * Get a Tag.
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     * @param   string  $sha    The SHA1 value to set the reference to.
     *
     * @since   1.0
     *
     * @return object
     */
    public function get($owner, $repo, $sha)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/git/tags/' . $sha;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Create a Tag Object
     *
     * Note that creating a tag object does not create the reference that makes a tag in Git.
     * If you want to create an annotated tag in Git, you have to do this call to create the tag object,
     * and then create the refs/tags/[tag] reference. If you want to create a lightweight tag,
     * you simply have to create the reference - this call would be unnecessary.
     *
     * @param   string  $owner        The name of the owner of the GitHub repository.
     * @param   string  $repo         The name of the GitHub repository.
     * @param   string  $tag          The tag string.
     * @param   string  $message      The tag message.
     * @param   string  $object       The SHA of the git object this is tagging.
     * @param   string  $type         The type of the object we’re tagging. Normally this is a commit but it can also be a tree or a blob.
     * @param   string  $taggerName   The name of the author of the tag.
     * @param   string  $taggerEmail  The email of the author of the tag.
     * @param   string  $taggerDate   Timestamp of when this object was tagged.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function create($owner, $repo, $tag, $message, $object, $type, $taggerName, $taggerEmail, $taggerDate)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/git/tags';

        $data = [
            'tag'     => $tag,
            'message' => $message,
            'object'  => $object,
            'type'    => $type,
            'tagger'  => [
                'name'  => $taggerName,
                'email' => $taggerEmail,
                'date'  => $taggerDate,
            ],
        ];

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }
}
