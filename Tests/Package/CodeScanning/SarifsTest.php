<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\CodeScanning;

use Joomla\Github\Package\CodeScanning\Sarifs;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for CodeScanning\Sarifs.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Sarifs::class)]
class SarifsTest extends GitHubTestCase
{
    /**
     * @var    Sarifs  Object under test.
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

        $this->object = new Sarifs($this->options, $this->client);
    }

    /**
     * Tests the upload method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testUpload()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/code-scanning/sarifs', json_encode(['tool_name' => 'codeql', 'commit_sha' => '4b6472266afd7b471e86085a6659e8c7f2b119da', 'ref' => 'refs/heads/main', 'sarif' => 'H4sIAAAA']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->upload('joomla', 'joomla-platform', '4b6472266afd7b471e86085a6659e8c7f2b119da', 'refs/heads/main', 'H4sIAAAA', ['tool_name' => 'codeql'])
        );
    }

    /**
     * Tests the upload method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testUploadFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/code-scanning/sarifs', json_encode(['commit_sha' => '4b6472266afd7b471e86085a6659e8c7f2b119da', 'ref' => 'refs/heads/main', 'sarif' => 'H4sIAAAA']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->upload('joomla', 'joomla-platform', '4b6472266afd7b471e86085a6659e8c7f2b119da', 'refs/heads/main', 'H4sIAAAA');
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
            ->with('/repos/joomla/joomla-platform/code-scanning/sarifs/47177e22-5596-11eb', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', '47177e22-5596-11eb')
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
            ->with('/repos/joomla/joomla-platform/code-scanning/sarifs/47177e22-5596-11eb', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->get('joomla', 'joomla-platform', '47177e22-5596-11eb');
    }
}
