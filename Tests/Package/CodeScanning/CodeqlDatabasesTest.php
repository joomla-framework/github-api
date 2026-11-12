<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\CodeScanning;

use Joomla\Github\Package\CodeScanning\CodeqlDatabases;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning\CodeqlDatabases.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(CodeqlDatabases::class)]
class CodeqlDatabasesTest extends GitHubTestCase
{
    /**
     * @var    CodeqlDatabases  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new CodeqlDatabases($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/databases', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getList method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/databases', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getList('joomla', 'joomla-platform');
    }

    /**
     * Tests the get method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/databases/c%23', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 'c#')
        );
    }

    /**
     * Tests the get method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/databases/c%23', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform', 'c#');
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDelete()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/databases/c%23', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->delete('joomla', 'joomla-platform', 'c#'));
    }

    /**
     * Tests the delete method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/databases/c%23', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->delete('joomla', 'joomla-platform', 'c#');
    }
}
