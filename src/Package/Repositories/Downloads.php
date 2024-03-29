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
 * GitHub API Repositories Downloads class for the Joomla Framework.
 *
 * The downloads API is for package downloads only.
 * If you want to get source tarballs you should use
 * http://developer.github.com/v3/repos/contents/#get-archive-link instead.
 *
 * @documentation  https://developer.github.com/v3/repos/downloads
 *
 * @since       1.0
 * @deprecated  The Releases API should be used instead
 */
class Downloads extends AbstractPackage
{
    /**
     * List downloads for a repository.
     *
     * @param   string  $owner  The name of the owner of the GitHub repository.
     * @param   string  $repo   The name of the GitHub repository.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  The Releases API should be used instead
     */
    public function getList($owner, $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/downloads';

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Get a single download.
     *
     * @param   string   $owner  The name of the owner of the GitHub repository.
     * @param   string   $repo   The name of the GitHub repository.
     * @param   integer  $id     The id of the download.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  The Releases API should be used instead
     */
    public function get($owner, $repo, $id)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/downloads/' . $id;

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Create a new download (Part 1: Create the resource).
     *
     * Creating a new download is a two step process. You must first create a new download resource.
     *
     * @param   string  $owner        The name of the owner of the GitHub repository.
     * @param   string  $repo         The name of the GitHub repository.
     * @param   string  $name         The name.
     * @param   string  $size         Size of file in bytes.
     * @param   string  $description  The description.
     * @param   string  $contentType  The content type.
     *
     * @return  void
     *
     * @note    This API endpoint no longer exists at GitHub
     * @since   1.0
     * @throws  \RuntimeException
     * @deprecated  The Releases API should be used instead
     */
    public function create($owner, $repo, $name, $size, $description = '', $contentType = '')
    {
        throw new \RuntimeException('The GitHub API no longer supports creating downloads. The Releases API should be used instead.');
    }

    /**
     * Create a new download (Part 2: Upload file to s3).
     *
     * Now that you have created the download resource, you can use the information
     * in the response to upload your file to s3. This can be done with a POST to
     * the s3_url you got in the create response. Here is a brief example using curl:
     *
     * curl \
     *     -F "key=downloads/octocat/Hello-World/new_file.jpg" \
     *     -F "acl=public-read" \
     *     -F "success_action_status=201" \
     *     -F "Filename=new_file.jpg" \
     *     -F "AWSAccessKeyId=1ABCDEF..." \
     *     -F "Policy=ewogIC..." \
     *     -F "Signature=mwnF..." \
     *     -F "Content-Type=image/jpeg" \
     *     -F "file=@new_file.jpg" \
     *           https://github.s3.amazonaws.com/
     *
     * NOTES
     * The order in which you pass these fields matters! Follow the order shown above exactly.
     * All parameters shown are required and if you excluded or modify them your upload will
     * fail because the values are hashed and signed by the policy.
     *
     * More information about using the REST API to interact with s3 can be found here:
     * http://docs.amazonwebservices.com/AmazonS3/latest/API/
     *
     * @param   string  $key                  Value of path field in the response.
     * @param   string  $acl                  Value of acl field in the response.
     * @param   string  $successActionStatus  201, or whatever you want to get back.
     * @param   string  $filename             Value of name field in the response.
     * @param   string  $awsAccessKeyId       Value of accesskeyid field in the response.
     * @param   string  $policy               Value of policy field in the response.
     * @param   string  $signature            Value of signature field in the response.
     * @param   string  $contentType          Value of mime_type field in the response.
     * @param   string  $file                 Local file. Example assumes the file existing in the directory
     *                                        where you are running the curl command. Yes, the @ matters.
     *
     * @return  void
     *
     * @note    This API endpoint no longer exists at GitHub
     * @since   1.0
     * @throws  \RuntimeException
     * @deprecated  The Releases API should be used instead
     */
    public function upload($key, $acl, $successActionStatus, $filename, $awsAccessKeyId, $policy, $signature, $contentType, $file)
    {
        throw new \RuntimeException('The GitHub API no longer supports creating downloads. The Releases API should be used instead.');
    }

    /**
     * Delete a download.
     *
     * @param   string   $owner  The name of the owner of the GitHub repository.
     * @param   string   $repo   The name of the GitHub repository.
     * @param   integer  $id     The id of the download.
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  The Releases API should be used instead
     */
    public function delete($owner, $repo, $id)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/downloads/' . (int) $id;

        // Send the request.
        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path)),
            204
        );
    }
}
