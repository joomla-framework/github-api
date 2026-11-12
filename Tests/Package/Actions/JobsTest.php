<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Jobs;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Jobs::class)]
class JobsTest extends GitHubTestCase
{
    /**
     * @var    Jobs  Object under test.
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

        $this->object = new Jobs($this->options, $this->client);
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
            ->with('/repos/joomla/joomla-platform/actions/jobs/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 'joomla-platform', 1));
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

        $this->object->get('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the downloadLogs method.
     *
     * @return  void
     */
    public function testDownloadLogs()
    {
        $this->response = $this->getResponseObject('', 302, ['Location' => 'https://example.com/download']);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/jobs/1/logs', [], 0)
            ->willReturn($this->response);

        $this->assertSame('https://example.com/download', $this->object->downloadLogs('joomla', 'joomla-platform', 1));
    }

    /**
     * Tests the downloadLogs method.
     *
     * @return  void
     */
    public function testDownloadLogsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->downloadLogs('joomla', 'joomla-platform', 1);
    }

    /**
     * Tests the downloadStepLogs method.
     *
     * @return  void
     */
    public function testDownloadStepLogs()
    {
        $this->response = $this->getResponseObject('', 302, ['Location' => 'https://example.com/download']);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/jobs/1/steps/2/logs', [], 0)
            ->willReturn($this->response);

        $this->assertSame('https://example.com/download', $this->object->downloadStepLogs('joomla', 'joomla-platform', 1, 2));
    }

    /**
     * Tests the downloadStepLogs method.
     *
     * @return  void
     */
    public function testDownloadStepLogsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->downloadStepLogs('joomla', 'joomla-platform', 1, 2);
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
            ->with('/repos/joomla/joomla-platform/actions/runs/1/jobs?page=2&per_page=30&filter=filter-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRun('joomla', 'joomla-platform', 1, ['filter' => 'filter-value'], 2, 30));
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
            ->with('/repos/joomla/joomla-platform/actions/runs/1/jobs', [], 0)
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

        $this->object->getListForRun('joomla', 'joomla-platform', 1, ['filter' => 'filter-value'], 2, 30);
    }

    /**
     * Tests the getListForRunAttempt method.
     *
     * @return  void
     */
    public function testGetListForRunAttempt()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/attempts/2/jobs?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRunAttempt('joomla', 'joomla-platform', 1, 2, 2, 30));
    }

    /**
     * Tests the getListForRunAttempt method.
     *
     * @return  void
     */
    public function testGetListForRunAttemptDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/runs/1/attempts/2/jobs', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRunAttempt('joomla', 'joomla-platform', 1, 2));
    }

    /**
     * Tests the getListForRunAttempt method.
     *
     * @return  void
     */
    public function testGetListForRunAttemptFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForRunAttempt('joomla', 'joomla-platform', 1, 2, 2, 30);
    }
}
