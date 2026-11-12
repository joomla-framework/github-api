<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Search;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;

/**
 * Test class for Activity.
 *
 * @since  1.0
 */
class SearchTest extends GitHubTestCase
{
    /**
     * @var Search
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @since   1.0
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Search($this->options, $this->client);
    }

    /**
     * Tests the issues method
     *
     * @return  void
     */
    #[IgnoreDeprecations]
    public function testIssues()
    {
        $this->expectUserDeprecationMessageMatches('/' . preg_quote('Joomla\Github\Package\Search::issues() is deprecated and will be removed in 5.0', '/') . '/');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/legacy/issues/search/joomla/joomla-platform/open/github')
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->issues('joomla', 'joomla-platform', 'open', 'github')
        );
    }

    /**
     * Tests the issuesInvalidState method
     *
     * @return  void
     */
    public function testIssuesInvalidState()
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->object->issues('joomla', 'joomla-platform', 'invalid', 'github');
    }

    /**
     * Tests the repositories method
     *
     * @return  void
     */
    #[IgnoreDeprecations]
    public function testRepositories()
    {
        $this->expectUserDeprecationMessageMatches('/' . preg_quote('Joomla\Github\Package\Search::repositories() is deprecated and will be removed in 5.0', '/') . '/');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/legacy/repos/search/joomla')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->repositories('joomla'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the users method
     *
     * @return  void
     */
    #[IgnoreDeprecations]
    public function testUsers()
    {
        $this->expectUserDeprecationMessageMatches('/' . preg_quote('Joomla\Github\Package\Search::users() is deprecated and will be removed in 5.0', '/') . '/');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/legacy/user/search/joomla')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->users('joomla'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the email method
     *
     * @return  void
     */
    #[IgnoreDeprecations]
    public function testEmail()
    {
        $this->expectUserDeprecationMessageMatches('/' . preg_quote('Joomla\Github\Package\Search::email() is deprecated and will be removed in 5.0', '/') . '/');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/legacy/user/email/email@joomla')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->email('email@joomla'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests that the legacy issues method accepts the "closed" state its message asks for
     *
     * @return  void
     */
    #[IgnoreDeprecations]
    public function testIssuesClosed()
    {
        $this->expectUserDeprecationMessageMatches('/Search::issues\(\) is deprecated/');

        $this->client->expects($this->once())
            ->method('get')
            ->with('/legacy/issues/search/joomla/joomla-platform/closed/github')
            ->willReturn($this->response);

        $this->object->issues('joomla', 'joomla-platform', 'closed', 'github');
    }

    /**
     * Data provider for the search API v3 methods
     *
     * @return  \Generator
     */
    public static function seachMethodsProvider(): \Generator
    {
        yield 'code' => [
            'getCode',
            ['addClass in:file language:js repo:jquery/jquery', 'asc', 2, 50],
            '/search/code?q=addClass%20in%3Afile%20language%3Ajs%20repo%3Ajquery%2Fjquery&order=asc&page=2&per_page=50',
        ];
        yield 'commits' => [
            'getCommits',
            ['repo:joomla/joomla-cms fix', 'author-date', 'desc'],
            '/search/commits?q=repo%3Ajoomla%2Fjoomla-cms%20fix&sort=author-date&order=desc',
        ];
        yield 'issues' => [
            'getIssues',
            ['repo:joomla/joomla-cms is:issue label:"No Code Attached Yet" created:>2026-01-01+00:00'],
            '/search/issues?q=repo%3Ajoomla%2Fjoomla-cms%20is%3Aissue%20label%3A%22No%20Code%20Attached%20Yet%22'
                . '%20created%3A%3E2026-01-01%2B00%3A00',
        ];
        yield 'labels' => [
            'getLabels',
            [64778136, 'bug defect', 'created'],
            '/search/labels?repository_id=64778136&q=bug%20defect&sort=created',
        ];
        yield 'repositories' => [
            'getRepositories',
            ['joomla language:php stars:>100', 'stars', 'desc', 1, 10],
            '/search/repositories?q=joomla%20language%3Aphp%20stars%3A%3E100&sort=stars&order=desc&page=1&per_page=10',
        ];
        yield 'topics' => [
            'getTopics',
            ['joomla is:featured'],
            '/search/topics?q=joomla%20is%3Afeatured',
        ];
        yield 'users' => [
            'getUsers',
            ['tom repos:>42 followers:>1000', 'followers'],
            '/search/users?q=tom%20repos%3A%3E42%20followers%3A%3E1000&sort=followers',
        ];
    }

    /**
     * Tests the search API v3 methods
     *
     * @param   string  $method     The method to call
     * @param   array   $arguments  The arguments
     * @param   string  $url        The expected request URL
     *
     * @return  void
     */
    #[DataProvider('seachMethodsProvider')]
    public function testSearchMethods(string $method, array $arguments, string $url)
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with($url)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->$method(...$arguments));
    }
}
