<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package\CodeScanning;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Code Scanning SARIF class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class Sarifs extends AbstractPackage
{
    /**
     * Upload an analysis as SARIF data.
     *
     * @param   string  $owner      The account owner of the repository.
     * @param   string  $repo       The name of the repository.
     * @param   string  $commitSha  The SHA of the commit to which the analysis you are uploading relates.
     * @param   string  $ref        The full Git reference, e.g. `refs/heads/main`.
     * @param   string  $sarif      The gzip-compressed and Base64-encoded SARIF file.
     * @param   array   $options    Optional body fields: `checkout_uri`, `started_at`, `tool_name`, `validate`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#upload-an-analysis-as-sarif-data
     * @since   __DEPLOY_VERSION__
     */
    public function upload(string $owner, string $repo, string $commitSha, string $ref, string $sarif, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/sarifs';

        $data = array_merge($options, ['commit_sha' => $commitSha, 'ref' => $ref, 'sarif' => $sarif]);

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            202
        );
    }

    /**
     * Get information about a SARIF upload.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   string  $sarifId  The SARIF ID obtained after uploading.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-information-about-a-sarif-upload
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, string $sarifId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/sarifs/' . rawurlencode($sarifId);

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }
}
