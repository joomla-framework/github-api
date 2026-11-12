<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\CodeScanning;

use Joomla\Github\Package\CodeScanning\VariantAnalyses;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning\VariantAnalyses.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(VariantAnalyses::class)]
class VariantAnalysesTest extends GitHubTestCase
{
    /**
     * @var    VariantAnalyses  Object under test.
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

        $this->object = new VariantAnalyses($this->options, $this->client);
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
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/variant-analyses', json_encode(['repositories' => ['octocat/hello-world'], 'language' => 'javascript', 'query_pack' => 'aGVsbG8=']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 'javascript', 'aGVsbG8=', ['repositories' => ['octocat/hello-world']])
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
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/variant-analyses', json_encode(['language' => 'javascript', 'query_pack' => 'aGVsbG8=']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->create('joomla', 'joomla-platform', 'javascript', 'aGVsbG8=');
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
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/variant-analyses/7', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 7)
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
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/variant-analyses/7', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform', 7);
    }

    /**
     * Tests the getRepoTask method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetRepoTask()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/variant-analyses/7/repos/octocat/hello-world', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRepoTask('joomla', 'joomla-platform', 7, 'octocat', 'hello-world')
        );
    }

    /**
     * Tests the getRepoTask method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetRepoTaskFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/code-scanning/codeql/variant-analyses/7/repos/octocat/hello-world', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRepoTask('joomla', 'joomla-platform', 7, 'octocat', 'hello-world');
    }
}
