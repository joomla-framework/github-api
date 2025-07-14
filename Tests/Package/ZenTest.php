<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Zen;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Response;

/**
 * Test class for the Zen package.
 *
 * @since  1.0
 */
class ZenTest extends GitHubTestCase
{
    /**
     * @var Zen
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

        $this->object = new Zen($this->options, $this->client);
    }

    /**
     * Tests the Get method.
     *
     * @return void
     */
    public function testGet()
    {
        $this->response = new Response('data://text/plain,My Zen', 200);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/zen', [], 0)
            ->willReturn($this->response);

        $response = $this->response->getBody()->getContents();
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get()
        );
    }

    /**
     * Tests the Get method.
     *
     * @return void
     */
    public function testGetFailure()
    {
        $this->expectException(\RuntimeException::class);

        $this->response = new Response('data://text/plain,My Zen', 400);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/zen', [], 0)
            ->willReturn($this->response);

        $response = $this->response->getBody()->getContents();
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get()
        );
    }
}
