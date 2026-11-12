<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\CodeScanning;

use Joomla\Github\Package\CodeScanning\Autofix;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning\Autofix.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Autofix::class)]
class AutofixTest extends GitHubTestCase
{
    /**
     * @var    Autofix  Object under test.
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

        $this->object = new Autofix($this->options, $this->client);
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
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/autofix', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 42)
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
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/autofix', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform', 42);
    }

    /**
     * Tests the create method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreate()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/autofix', '', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 42)
        );
    }

    /**
     * Tests the create method with a 202 response.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreate202()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/autofix', '', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 42)
        );
    }

    /**
     * Tests the create method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/autofix', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->create('joomla', 'joomla-platform', 42);
    }

    /**
     * Tests the commit method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCommit()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/autofix/commits', json_encode(['target_ref' => 'refs/heads/fix', 'message' => 'Fix alert']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->commit('joomla', 'joomla-platform', 42, ['target_ref' => 'refs/heads/fix', 'message' => 'Fix alert'])
        );
    }

    /**
     * Tests the commit method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCommitFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/code-scanning/alerts/42/autofix/commits', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->commit('joomla', 'joomla-platform', 42);
    }
}
