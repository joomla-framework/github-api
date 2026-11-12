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
 * GitHub API Code Scanning AI Scan class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class AiScan extends AbstractPackage
{
    /**
     * Get the AI Scan setting for an organization.
     *
     * @param   string  $org  The organization name.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-the-ai-scan-setting-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function getForOrg(string $org)
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/code-scanning/ai-scan';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Update the AI Scan setting for an organization.
     *
     * @param   string  $org      The organization name.
     * @param   array   $options  Optional body fields: `pr_scan`, `repository_scan`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#update-the-ai-scan-setting-for-an-organization
     * @since   __DEPLOY_VERSION__
     */
    public function editForOrg(string $org, array $options = [])
    {
        // Build the request path.
        $path = '/orgs/' . $org . '/code-scanning/ai-scan';

        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }

    /**
     * Get AI Scan enablement for a repository.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-ai-scan-enablement-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function getForRepo(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/ai-scan';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Update AI Scan enablement for a repository.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   array   $options  Optional body fields: `pr_scan`, `repository_scan`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#update-ai-scan-enablement-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function editForRepo(string $owner, string $repo, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/ai-scan';

        $data = (object) $options;

        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data)),
            200
        );
    }
}
