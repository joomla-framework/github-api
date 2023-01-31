<?php

/**
 * @copyright  Copyright (C) 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Branches;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Repositories\Branches
 *
 * @since  1.0
 */
class BranchesTest extends GitHubTestCase
{
    /**
     * @var Branches
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

        $this->object = new Branches($this->options, $this->client);
    }

    /**
     * Tests the GetList method.
     *
     * @covers \Joomla\Github\Package\Repositories\Branches::getList()
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/{owner}/{repo}/branches')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->getList('{owner}', '{repo}'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the Get method.
     *
     * @covers \Joomla\Github\Package\Repositories\Branches::get()
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/{owner}/{repo}/branches/{branch}')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->get('{owner}', '{repo}', '{branch}'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }
}
