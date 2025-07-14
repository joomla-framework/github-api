<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Forks;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Forks.
 *
 * @since  1.0
 */
class ForksTest extends GitHubTestCase
{
    /**
     * @var    Forks  Object under test.
     * @since  11.4
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Forks($this->options, $this->client);
    }

    /**
     * Tests the create method
     *
     * @return void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 202);

        // Build the request data.
        $data = json_encode(
            [
                'org' => 'jenkins-jools',
            ]
        );

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/forks', $data)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->create('joomla', 'joomla-platform', 'jenkins-jools'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the create method - failure
     *
     * @return void
     */
    public function testCreateFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        // Build the request data.
        $data = json_encode(
            []
        );

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/forks', $data)
            ->willReturn($this->response);

        $this->object->create('joomla', 'joomla-platform', '');
    }

    /**
     * Tests the getList method
     *
     * @return void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/forks')
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getList('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getList method - failure
     *
     * @return void
     */
    public function testGetListFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/forks')
            ->willReturn($this->response);

        $this->object->getList('joomla', 'joomla-platform');
    }
}
