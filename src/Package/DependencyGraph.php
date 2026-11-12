<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Dependency Graph class for the Joomla Framework.
 *
 * @link   https://docs.github.com/rest/dependency-graph
 *
 * @since  __DEPLOY_VERSION__
 */
class DependencyGraph extends AbstractPackage
{
    /**
     * Get a diff of the dependencies between commits.
     *
     * Both refs are encoded separately and joined with `...`.
     *
     * @param   string  $owner    The account owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   string  $base     The base ref or commit of the comparison.
     * @param   string  $head     The head ref or commit of the comparison.
     * @param   array   $filters  Optional query parameters: `name`.
     *
     * @return  array
     *
     * @link    https://docs.github.com/rest/dependency-graph/dependency-review#get-a-diff-of-the-dependencies-between-commits
     * @since   __DEPLOY_VERSION__
     */
    public function compare(string $owner, string $repo, string $base, string $head, array $filters = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependency-graph/compare/' . rawurlencode($base) . '...' . rawurlencode($head);

        $uri = $this->fetchUrl($path);

        foreach ($filters as $key => $value) {
            $uri->setVar($key, \is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        return $this->processResponse(
            $this->client->get($uri),
            200
        );
    }

    /**
     * Create a snapshot of dependencies for a repository.
     *
     * @param   string   $owner     The account owner of the repository.
     * @param   string   $repo      The name of the repository.
     * @param   integer  $version   The version of the repository snapshot submission.
     * @param   array    $job       The job that created the snapshot (`correlator`, `id`, optional `html_url`).
     * @param   string   $sha       The commit SHA associated with this dependency snapshot.
     * @param   string   $ref       The repository branch that triggered this snapshot, e.g. `refs/heads/main`.
     * @param   array    $detector  The detector used (`name`, `version`, `url`).
     * @param   string   $scanned   The time the snapshot was scanned (ISO 8601).
     * @param   array    $options   Optional body fields: `metadata`, `manifests`.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependency-graph/dependency-submission#create-a-snapshot-of-dependencies-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function createSnapshot(string $owner, string $repo, int $version, array $job, string $sha, string $ref, array $detector, string $scanned, array $options = [])
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependency-graph/snapshots';

        $data = array_merge($options, ['version' => $version, 'job' => $job, 'sha' => $sha, 'ref' => $ref, 'detector' => $detector, 'scanned' => $scanned]);

        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }

    /**
     * Request generation of a software bill of materials (SBOM) for a repository.
     *
     * The returned `sbom_url` contains the UUID to pass to `fetchSbomReport()`.
     *
     * @param   string  $owner  The account owner of the repository.
     * @param   string  $repo   The name of the repository.
     *
     * @return  object
     *
     * @link    https://docs.github.com/rest/dependency-graph/sboms#request-generation-of-a-software-bill-of-materials-sbom-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function generateSbomReport(string $owner, string $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependency-graph/sbom/generate-report';

        return $this->processResponse(
            $this->client->get($this->fetchUrl($path)),
            201
        );
    }

    /**
     * Fetch a software bill of materials (SBOM) for a repository.
     *
     * Returns the temporary download URL (`Location` header of the 302 response), or an empty
     * string while the report is still being generated (202).
     *
     * @param   string  $owner     The account owner of the repository.
     * @param   string  $repo      The name of the repository.
     * @param   string  $sbomUuid  The unique identifier of the SBOM export.
     *
     * @return  string
     *
     * @link    https://docs.github.com/rest/dependency-graph/sboms#fetch-a-software-bill-of-materials-sbom-for-a-repository
     * @since   __DEPLOY_VERSION__
     */
    public function fetchSbomReport(string $owner, string $repo, string $sbomUuid)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/dependency-graph/sbom/fetch-report/' . rawurlencode($sbomUuid);

        $response = $this->client->get($this->fetchUrl($path));

        // The SBOM is still being generated.
        if ($response->getStatusCode() === 202) {
            return '';
        }

        if ($response->getStatusCode() !== 302) {
            $this->processResponse($response, 302);
        }

        return $response->getHeaderLine('Location');
    }
}
