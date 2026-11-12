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
 * GitHub API Search class for the Joomla Framework.
 *
 * The methods issues(), repositories(), users() and email() use the legacy search API, which GitHub has removed;
 * use the get*() methods instead.
 *
 * @link   https://docs.github.com/en/rest/search/search
 *
 * @since  1.0
 */
class Search extends AbstractPackage
{
    /**
     * Search issues.
     *
     * @param   string  $owner    The name of the owner of the repository.
     * @param   string  $repo     The name of the repository.
     * @param   string  $state    The state - open or closed.
     * @param   string  $keyword  The search term.
     *
     * @return  object
     *
     * @since   1.0
     * @throws  \UnexpectedValueException
     * @deprecated  5.0 GitHub has removed the legacy search API. Use getIssues() instead.
     */
    public function issues($owner, $repo, $state, $keyword)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, use getIssues() instead.',
            __METHOD__
        );

        if (\in_array($state, ['open', 'closed']) == false) {
            throw new \UnexpectedValueException('State must be either "open" or "closed"');
        }

        // Build the request path.
        $path = '/legacy/issues/search/' . $owner . '/' . $repo . '/' . $state . '/' . $keyword;

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Search repositories.
     *
     * Find repositories by keyword. Note, this legacy method does not follow
     * the v3 pagination pattern.
     * This method returns up to 100 results per page and pages can be fetched
     * using the start_page parameter.
     *
     * @param   string   $keyword    The search term.
     * @param   string   $language   Filter results by language https://github.com/languages
     * @param   integer  $startPage  Page number to fetch
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has removed the legacy search API. Use getRepositories() instead.
     */
    public function repositories($keyword, $language = '', $startPage = 0)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, use getRepositories() instead.',
            __METHOD__
        );

        // Build the request path.
        $uri = $this->fetchUrl('/legacy/repos/search/' . $keyword);

        if ($language) {
            $uri->setVar('language', $language);
        }

        if ($startPage) {
            $uri->setVar('start_page', $startPage);
        }

        // Send the request.
        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Search users.
     *
     * Find users by keyword.
     *
     * @param   string   $keyword    The search term.
     * @param   integer  $startPage  Page number to fetch
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has removed the legacy search API. Use getUsers() instead.
     */
    public function users($keyword, $startPage = 0)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, use getUsers() instead.',
            __METHOD__
        );

        // Build the request path.
        $uri = $this->fetchUrl('/legacy/user/search/' . $keyword);

        if ($startPage) {
            $uri->setVar('start_page', $startPage);
        }

        // Send the request.
        return $this->processResponse($this->client->get($uri));
    }

    /**
     * Email search.
     *
     * This API call is added for compatibility reasons only. There’s no guarantee
     * that full email searches will always be available. The @ character in the
     * address must be left unencoded. Searches only against public email addresses
     * (as configured on the user’s GitHub profile).
     *
     * @param   string  $email  The email address(es).
     *
     * @return  object
     *
     * @since   1.0
     * @deprecated  5.0 GitHub has removed the legacy email search. There is no replacement.
     */
    public function email($email)
    {
        trigger_deprecation(
            'joomla/github',
            '__DEPLOY_VERSION__',
            '%s() is deprecated and will be removed in 5.0, GitHub has removed the legacy email search.',
            __METHOD__
        );

        // Build the request path.
        $path = '/legacy/user/email/' . $email;

        // Send the request.
        return $this->processResponse(
            $this->client->get($this->fetchUrl($path))
        );
    }

    /**
     * Search code.
     *
     * @param   string   $query  The search query, e.g. `addClass in:file language:js repo:jquery/jquery`.
     * @param   string   $order  The sort order, `desc` or `asc`. Empty for GitHub's default.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object  An object with the properties total_count, incomplete_results and items.
     *
     * @link    https://docs.github.com/en/rest/search/search#search-code
     * @since   __DEPLOY_VERSION__
     */
    public function getCode(string $query, string $order = '', int $page = 0, int $limit = 0)
    {
        return $this->search('code', ['q' => $query, 'order' => $order], $page, $limit);
    }

    /**
     * Search commits.
     *
     * @param   string   $query  The search query, e.g. `repo:joomla/joomla-cms fix author:octocat`.
     * @param   string   $sort   Sort by `author-date` or `committer-date`. Empty for best match.
     * @param   string   $order  The sort order, `desc` or `asc`. Empty for GitHub's default.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object  An object with the properties total_count, incomplete_results and items.
     *
     * @link    https://docs.github.com/en/rest/search/search#search-commits
     * @since   __DEPLOY_VERSION__
     */
    public function getCommits(string $query, string $sort = '', string $order = '', int $page = 0, int $limit = 0)
    {
        return $this->search('commits', ['q' => $query, 'sort' => $sort, 'order' => $order], $page, $limit);
    }

    /**
     * Search issues and pull requests.
     *
     * @param   string   $query  The search query, e.g. `repo:joomla/joomla-cms is:issue is:open label:bug`.
     * @param   string   $sort   Sort by `comments`, `reactions`, `interactions`, `created` or `updated`, among others.
     *                           Empty for best match.
     * @param   string   $order  The sort order, `desc` or `asc`. Empty for GitHub's default.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object  An object with the properties total_count, incomplete_results and items.
     *
     * @link    https://docs.github.com/en/rest/search/search#search-issues-and-pull-requests
     * @since   __DEPLOY_VERSION__
     */
    public function getIssues(string $query, string $sort = '', string $order = '', int $page = 0, int $limit = 0)
    {
        return $this->search('issues', ['q' => $query, 'sort' => $sort, 'order' => $order], $page, $limit);
    }

    /**
     * Search labels in a repository.
     *
     * @param   integer  $repositoryId  The ID of the repository.
     * @param   string   $query         The search keywords.
     * @param   string   $sort          Sort by `created` or `updated`. Empty for best match.
     * @param   string   $order         The sort order, `desc` or `asc`. Empty for GitHub's default.
     * @param   integer  $page          The page number from which to get items.
     * @param   integer  $limit         The number of items on a page.
     *
     * @return  object  An object with the properties total_count, incomplete_results and items.
     *
     * @link    https://docs.github.com/en/rest/search/search#search-labels
     * @since   __DEPLOY_VERSION__
     */
    public function getLabels(int $repositoryId, string $query, string $sort = '', string $order = '', int $page = 0, int $limit = 0)
    {
        return $this->search(
            'labels',
            ['repository_id' => $repositoryId, 'q' => $query, 'sort' => $sort, 'order' => $order],
            $page,
            $limit
        );
    }

    /**
     * Search repositories.
     *
     * @param   string   $query  The search query, e.g. `joomla language:php stars:>100`.
     * @param   string   $sort   Sort by `stars`, `forks`, `help-wanted-issues` or `updated`. Empty for best match.
     * @param   string   $order  The sort order, `desc` or `asc`. Empty for GitHub's default.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object  An object with the properties total_count, incomplete_results and items.
     *
     * @link    https://docs.github.com/en/rest/search/search#search-repositories
     * @since   __DEPLOY_VERSION__
     */
    public function getRepositories(string $query, string $sort = '', string $order = '', int $page = 0, int $limit = 0)
    {
        return $this->search('repositories', ['q' => $query, 'sort' => $sort, 'order' => $order], $page, $limit);
    }

    /**
     * Search topics.
     *
     * @param   string   $query  The search query, e.g. `joomla is:featured`.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object  An object with the properties total_count, incomplete_results and items.
     *
     * @link    https://docs.github.com/en/rest/search/search#search-topics
     * @since   __DEPLOY_VERSION__
     */
    public function getTopics(string $query, int $page = 0, int $limit = 0)
    {
        return $this->search('topics', ['q' => $query], $page, $limit);
    }

    /**
     * Search users.
     *
     * @param   string   $query  The search query, e.g. `tom repos:>42 followers:>1000`.
     * @param   string   $sort   Sort by `followers`, `repositories` or `joined`. Empty for best match.
     * @param   string   $order  The sort order, `desc` or `asc`. Empty for GitHub's default.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object  An object with the properties total_count, incomplete_results and items.
     *
     * @link    https://docs.github.com/en/rest/search/search#search-users
     * @since   __DEPLOY_VERSION__
     */
    public function getUsers(string $query, string $sort = '', string $order = '', int $page = 0, int $limit = 0)
    {
        return $this->search('users', ['q' => $query, 'sort' => $sort, 'order' => $order], $page, $limit);
    }

    /**
     * Send a search request.
     *
     * The query is encoded here, because Joomla\Uri\Uri does not encode the query values it renders.
     *
     * @param   string   $type   The search type, e.g. `issues`.
     * @param   array    $query  The query parameters; empty values are left out.
     * @param   integer  $page   The page number from which to get items.
     * @param   integer  $limit  The number of items on a page.
     *
     * @return  object
     *
     * @since   __DEPLOY_VERSION__
     */
    private function search(string $type, array $query, int $page, int $limit)
    {
        $query = array_filter($query, static fn ($value) => $value !== '');

        if ($page > 0) {
            $query['page'] = $page;
        }

        if ($limit > 0) {
            $query['per_page'] = $limit;
        }

        $path = '/search/' . $type . '?' . http_build_query($query, '', '&', \PHP_QUERY_RFC3986);

        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }
}
