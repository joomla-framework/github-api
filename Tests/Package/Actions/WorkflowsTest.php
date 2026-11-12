<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Workflows;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Workflows::class)]
class WorkflowsTest extends GitHubTestCase
{
    /**
     * @var    Workflows  Object under test.
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

        $this->object = new Workflows($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/workflows?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getList('joomla', 'joomla-platform', 2, 30));
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/workflows', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getList('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getList('joomla', 'joomla-platform', 2, 30);
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
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 'joomla-platform', 'main.yml'));
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

        $this->object->get('joomla', 'joomla-platform', 'main.yml');
    }

    /**
     * Tests the disable method.
     *
     * @return  void
     */
    public function testDisable()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/disable', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->disable('joomla', 'joomla-platform', 'main.yml'));
    }

    /**
     * Tests the disable method.
     *
     * @return  void
     */
    public function testDisableFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->disable('joomla', 'joomla-platform', 'main.yml');
    }

    /**
     * Tests the enable method.
     *
     * @return  void
     */
    public function testEnable()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/enable', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->enable('joomla', 'joomla-platform', 'main.yml'));
    }

    /**
     * Tests the enable method.
     *
     * @return  void
     */
    public function testEnableFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->enable('joomla', 'joomla-platform', 'main.yml');
    }

    /**
     * Tests the createDispatch method.
     *
     * @return  void
     */
    public function testCreateDispatch()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"inputs":{"id":"ubuntu-latest","source":"github"},"ref":"ref"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/dispatches', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->createDispatch('joomla', 'joomla-platform', 'main.yml', 'ref', ['inputs' => ['id' => 'ubuntu-latest', 'source' => 'github']]));
    }

    /**
     * Tests the createDispatch method.
     *
     * @return  void
     */
    public function testCreateDispatchStatus200()
    {
        $this->response = $this->getResponseObject($this->sampleString, 200);

        $body = '{"inputs":{"id":"ubuntu-latest","source":"github"},"ref":"ref"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/dispatches', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createDispatch('joomla', 'joomla-platform', 'main.yml', 'ref', ['inputs' => ['id' => 'ubuntu-latest', 'source' => 'github']]));
    }

    /**
     * Tests the createDispatch method.
     *
     * @return  void
     */
    public function testCreateDispatchDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"ref":"ref"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/dispatches', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->createDispatch('joomla', 'joomla-platform', 'main.yml', 'ref'));
    }

    /**
     * Tests the createDispatch method.
     *
     * @return  void
     */
    public function testCreateDispatchFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createDispatch('joomla', 'joomla-platform', 'main.yml', 'ref', ['inputs' => ['id' => 'ubuntu-latest', 'source' => 'github']]);
    }

    /**
     * Tests the getUsage method.
     *
     * @return  void
     */
    public function testGetUsage()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/workflows/main.yml/timing', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getUsage('joomla', 'joomla-platform', 'main.yml'));
    }

    /**
     * Tests the getUsage method.
     *
     * @return  void
     */
    public function testGetUsageFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getUsage('joomla', 'joomla-platform', 'main.yml');
    }
}
