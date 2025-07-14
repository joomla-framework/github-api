<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Emojis;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Emojis.
 *
 * @since  1.1.2
 */
class EmojisTest extends GitHubTestCase
{
    /**
     * @var Emojis
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

        $this->object = new Emojis($this->options, $this->client);
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
            ->with('/emojis')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the getList method - simulated failure
     *
     * @return void
     */
    public function testGetListFailure()
    {
        $exception = false;

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/emojis')
            ->willReturn($this->response);

        try {
            $this->object->getList();
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }
}
