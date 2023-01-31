<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Package;

use Joomla\Github\AbstractPackage;

/**
 * GitHub API Activity class for the Joomla Framework.
 *
 * @since  1.0
 *
 * @documentation  http://developer.github.com/v3/repos
 *
 * @property-read  Repositories\Branches       $branches       GitHub API object for branches.
 * @property-read  Repositories\Collaborators  $collaborators  GitHub API object for collaborators.
 * @property-read  Repositories\Comments       $comments       GitHub API object for comments.
 * @property-read  Repositories\Commits        $commits        GitHub API object for commits.
 * @property-read  Repositories\Contents       $contents       GitHub API object for contents.
 * @property-read  Repositories\Deployments    $deployments    GitHub API object for deployments.
 * @property-read  Repositories\Downloads      $downloads      GitHub API object for downloads.
 * @property-read  Repositories\Forks          $forks          GitHub API object for forks.
 * @property-read  Repositories\Hooks          $hooks          GitHub API object for hooks.
 * @property-read  Repositories\Keys           $keys           GitHub API object for keys.
 * @property-read  Repositories\Merging        $merging        GitHub API object for merging.
 * @property-read  Repositories\Pages          $pages          GitHub API object for pages.
 * @property-read  Repositories\Releases       $releases       GitHub API object for releases.
 * @property-read  Repositories\Statistics     $statistics     GitHub API object for statistics.
 * @property-read  Repositories\Statuses       $statuses       GitHub API object for statuses.
 */
class Repositories extends AbstractPackage
{
    /**
     * List your repositories.
     *
     * List repositories for the authenticated user.
     *
     * @param   string  $type       Sort type. all, owner, public, private, member. Default: all.
     * @param   string  $sort       Sort field. created, updated, pushed, full_name, default: full_name.
     * @param   string  $direction  Sort direction. asc or desc, default: when using full_name: asc, otherwise desc.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function getListOwn($type = 'all', $sort = 'full_name', $direction = '')
    {
        if (\in_array($type, ['all', 'owner', 'public', 'private', 'member']) == false) {
            throw new \RuntimeException('Invalid type');
        }

        if (\in_array($sort, ['created', 'updated', 'pushed', 'full_name']) == false) {
            throw new \RuntimeException('Invalid sort field');
        }

        // Sort direction default: when using full_name: asc, otherwise desc.
        $direction = ($direction) ?: (($sort == 'full_name') ? 'asc' : 'desc');

        if (\in_array($direction, ['asc', 'desc']) == false) {
            throw new \RuntimeException('Invalid sort order');
        }

        // Build the request path.
        $uri = $this->fetchUrl('/user/repos');
        $uri->setVar('type', $type);
        $uri->setVar('sort', $sort);
        $uri->setVar('direction', $direction);

        // Send the request.
        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List user repositories.
     *
     * List public repositories for the specified user.
     *
     * @param   string  $user       The user name.
     * @param   string  $type       Sort type. all, owner, member. Default: all.
     * @param   string  $sort       Sort field. created, updated, pushed, full_name, default: full_name.
     * @param   string  $direction  Sort direction. asc or desc, default: when using full_name: asc, otherwise desc.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function getListUser($user, $type = 'all', $sort = 'full_name', $direction = '')
    {
        if (\in_array($type, ['all', 'owner', 'member']) == false) {
            throw new \RuntimeException('Invalid type');
        }

        if (\in_array($sort, ['created', 'updated', 'pushed', 'full_name']) == false) {
            throw new \RuntimeException('Invalid sort field');
        }

        // Sort direction default: when using full_name: asc, otherwise desc.
        $direction = $direction ?: ($sort == 'full_name' ? 'asc' : 'desc');

        if (\in_array($direction, ['asc', 'desc']) == false) {
            throw new \RuntimeException('Invalid sort order');
        }

        // Build the request path.
        $uri = $this->fetchUrl('/users/' . $user . '/repos');
        $uri->setVar('type', $type);
        $uri->setVar('sort', $sort);
        $uri->setVar('direction', $direction);

        // Send the request.
        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List organization repositories.
     *
     * List repositories for the specified org.
     *
     * @param   string  $org   The name of the organization.
     * @param   string  $type  Sort type. all, public, private, forks, sources, member. Default: all.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function getListOrg($org, $type = 'all')
    {
        if (\in_array($type, ['all', 'public', 'private', 'forks', 'sources', 'member']) == false) {
            throw new \RuntimeException('Invalid type');
        }

        // Build the request path.
        $uri = $this->fetchUrl('/orgs/' . $org . '/repos');
        $uri->setVar('type', $type);

        // Send the request.
        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List all public repositories.
     *
     * This provides a dump of every repository, in the order that they were created.
     *
     * @param   integer  $id  The integer ID of the last Repository that you’ve seen.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function getList($id = 0)
    {
        // Build the request path.
        $uri = $this->fetchUrl('/repositories');

        if ($id) {
            $uri->setVar('since', (int) $id);
        }

        // Send the request.
        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Create.
     *
     * Create a new repository for the authenticated user or an organization. OAuth users must supply repo scope.
     *
     * @param   string   $name               The repository name.
     * @param   string   $org                The organization name (if needed).
     * @param   string   $description        The repository description.
     * @param   string   $homepage           The repository homepage.
     * @param   boolean  $private            Set true to create a private repository, false to create a public one. Creating private repositories
     *                                       requires a paid GitHub account.
     * @param   boolean  $hasIssues          Set true to enable issues for this repository, false to disable them.
     * @param   boolean  $hasWiki            Set true to enable the wiki for this repository, false to disable it.
     * @param   boolean  $hasDownloads       Set true to enable downloads for this repository, false to disable them.
     * @param   integer  $teamId             The id of the team that will be granted access to this repository. This is only valid when creating a
     *                                       repo in an organization.
     * @param   boolean  $autoInit           true to create an initial commit with empty README.
     * @param   string   $gitignoreTemplate  Desired language or platform .gitignore template to apply. Use the name of the template without the
     *                                       extension. For example, “Haskell” Ignored if auto_init parameter is not provided.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function create(
        $name,
        $org = '',
        $description = '',
        $homepage = '',
        $private = false,
        $hasIssues = false,
        $hasWiki = false,
        $hasDownloads = false,
        $teamId = 0,
        $autoInit = false,
        $gitignoreTemplate = ''
    ) {
        $path = ($org)
            // Create a repository for an organization
            ? '/orgs/' . $org . '/repos'
            // Create a repository for a user
            : '/user/repos';

        $data = [
            'name'               => $name,
            'description'        => $description,
            'homepage'           => $homepage,
            'private'            => $private,
            'has_issues'         => $hasIssues,
            'has_wiki'           => $hasWiki,
            'has_downloads'      => $hasDownloads,
            'team_id'            => $teamId,
            'auto_init'          => $autoInit,
            'gitignore_template' => $gitignoreTemplate,
        ];

        // Send the request.
        return $this->processResponse(
            $this->client->post($this->fetchUrl($path), json_encode($data)),
            201
        );
    }

    /**
     * Get.
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function get($owner, $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo;

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Edit.
     *
     * @param   string   $owner          Repository owner.
     * @param   string   $repo           Repository name.
     * @param   string   $name           The repository name.
     * @param   string   $description    The repository description.
     * @param   string   $homepage       The repository homepage.
     * @param   boolean  $private        Set true to create a private repository, false to create a public one. Creating private repositories
     *                                   requires a paid GitHub account.
     * @param   boolean  $hasIssues      Set true to enable issues for this repository, false to disable them.
     * @param   boolean  $hasWiki        Set true to enable the wiki for this repository, false to disable it.
     * @param   boolean  $hasDownloads   Set true to enable downloads for this repository, false to disable them.
     * @param   string   $defaultBranch  Update the default branch for this repository
     *
     * @return  object
     *
     * @since   1.0
     */
    public function edit(
        $owner,
        $repo,
        $name,
        $description = '',
        $homepage = '',
        $private = false,
        $hasIssues = false,
        $hasWiki = false,
        $hasDownloads = false,
        $defaultBranch = ''
    ) {
        $path = '/repos/' . $owner . '/' . $repo;

        $data = [
            'name'           => $name,
            'description'    => $description,
            'homepage'       => $homepage,
            'private'        => $private,
            'has_issues'     => $hasIssues,
            'has_wiki'       => $hasWiki,
            'has_downloads'  => $hasDownloads,
            'default_branch' => $defaultBranch,
        ];

        // Send the request.
        return $this->processResponse(
            $this->client->patch($this->fetchUrl($path), json_encode($data))
        );
    }

    /**
     * List contributors.
     *
     * @param   string   $owner  Repository owner.
     * @param   string   $repo   Repository name.
     * @param   boolean  $anon   Set to 1 or true to include anonymous contributors in results.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function getListContributors($owner, $repo, $anon = false)
    {
        // Build the request path.
        $uri = $this->fetchUrl('/repos/' . $owner . '/' . $repo . '/contributors');

        if ($anon) {
            $uri->setVar('anon', 'true');
        }

        // Send the request.
        return $this->processResponse($this->client->get($uri));
    }

    /**
     * List languages.
     *
     * List languages for the specified repository. The value on the right of a language is the number of bytes of code
     * written in that language.
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function getListLanguages($owner, $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/languages';

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * List Teams
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function getListTeams($owner, $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/teams';

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * List Tags.
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function getListTags($owner, $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo . '/tags';

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Delete a Repository.
     *
     * Deleting a repository requires admin access. If OAuth is used, the delete_repo scope is required.
     *
     * @param   string  $owner  Repository owner.
     * @param   string  $repo   Repository name.
     *
     * @return  object
     *
     * @since   1.0
     */
    public function delete($owner, $repo)
    {
        // Build the request path.
        $path = '/repos/' . $owner . '/' . $repo;

        // Send the request.
        return $this->processResponse(
            $this->client->delete($this->fetchUrl($path))
        );
    }
}
