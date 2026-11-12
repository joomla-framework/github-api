<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Codespaces;

use Joomla\Github\Package\Codespaces\Machines;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Codespaces\Machines.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Machines::class)]
class MachinesTest extends GitHubTestCase
{
    /**
     * @var    Machines  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Machines($this->options, $this->client);
    }

    /**
     * Test the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/machines?location=WestUs2', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRepo('joomla', 'joomla-platform', ['location' => 'WestUs2'])
        );
    }

    /**
     * Test the getListForRepo method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListForRepoFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/machines?location=WestUs2', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListForRepo('joomla', 'joomla-platform', ['location' => 'WestUs2']);
    }

    /**
     * Test the getListForCodespace method.
     *
     * @return  void
     */
    public function testGetListForCodespace()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/machines', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForCodespace('monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the getListForCodespace method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListForCodespaceFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/machines', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListForCodespace('monalisa-octocat-hello-world-g4wpq6h95q');
    }
}
