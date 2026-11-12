<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\ConcurrencyGroups;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(ConcurrencyGroups::class)]
class ConcurrencyGroupsTest extends GitHubTestCase
{
    /**
     * @var    ConcurrencyGroups  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new ConcurrencyGroups($this->options, $this->client);
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/concurrency_groups?per_page=30&after=after-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform', ['after' => 'after-value'], 30));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/concurrency_groups', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForRepo('joomla', 'joomla-platform', ['after' => 'after-value'], 30);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/concurrency_groups/deploy%2Fmain?ahead_of_run=42', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 'joomla-platform', 'deploy/main', ['ahead_of_run' => 42]));
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/concurrency_groups/deploy%2Fmain', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 'joomla-platform', 'deploy/main'));
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->get('joomla', 'joomla-platform', 'deploy/main', ['ahead_of_run' => 42]);
    }

    /**
     * Tests the getListForRun method.
     *
     * @return  void
     */
    public function testGetListForRun()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/concurrency_groups?per_page=30&before=before-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRun('joomla', 'joomla-platform', 1, ['before' => 'before-value'], 30));
    }

    /**
     * Tests the getListForRun method.
     *
     * @return  void
     */
    public function testGetListForRunDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/concurrency_groups', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRun('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the getListForRun method.
     *
     * @return  void
     */
    public function testGetListForRunFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForRun('joomla', 'joomla-platform', 1, ['before' => 'before-value'], 30);
    }
}
