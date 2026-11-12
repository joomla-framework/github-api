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
 * GitHub API Code Scanning Variant Analyses class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/code-scanning/code-scanning
 *
 * @since  __DEPLOY_VERSION__
 */
class VariantAnalyses extends AbstractPackage
{
    /**
     * Create a CodeQL variant analysis.
     *
     * Exactly one of `repositories`, `repository_lists` or `repository_owners` must be given.
     *
     * @param   string  $owner      The account owner of the repository.
     * @param   string  $repo       The name of the repository.
     * @param   string  $language   The language targeted by the CodeQL query.
     * @param   string  $queryPack  A Base64-encoded tarball containing a CodeQL query and all its dependencies.
     * @param   array   $options    Optional body fields: `repositories`, `repository_lists`, `repository_owners`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#create-a-codeql-variant-analysis
     * @since   __DEPLOY_VERSION__
     */
    public function create(string $owner, string $repo, string $language, string $queryPack, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/codeql/variant-analyses';

        $data = array_merge($options, ['language' => $language, 'query_pack' => $queryPack]);

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }

    /**
     * Get the summary of a CodeQL variant analysis.
     *
     * @param   string   $owner              The account owner of the repository.
     * @param   string   $repo               The name of the repository.
     * @param   integer  $variantAnalysisId  The ID of the variant analysis.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-the-summary-of-a-codeql-variant-analysis
     * @since   __DEPLOY_VERSION__
     */
    public function get(string $owner, string $repo, int $variantAnalysisId)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/codeql/variant-analyses/' . $variantAnalysisId;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }

    /**
     * Get the analysis status of a repository in a CodeQL variant analysis.
     *
     * @param   string   $owner              The account owner of the repository.
     * @param   string   $repo               The name of the repository.
     * @param   integer  $variantAnalysisId  The ID of the variant analysis.
     * @param   string   $repoOwner          The account owner of the variant analysis repository.
     * @param   string   $repoName           The name of the variant analysis repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/code-scanning/code-scanning#get-the-analysis-status-of-a-repository-in-a-codeql-variant-analysis
     * @since   __DEPLOY_VERSION__
     */
    public function getRepoTask(string $owner, string $repo, int $variantAnalysisId, string $repoOwner, string $repoName)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/code-scanning/codeql/variant-analyses/' . $variantAnalysisId . '/repos/' . $repoOwner . '/' . $repoName;

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            200
        );
    }
}
