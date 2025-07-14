<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Issues;

use Joomla\Github\Package\Issues\Labels;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.0
 */
class LabelsTest extends GitHubTestCase
{
    /**
     * @var    Labels  Object under test.
     * @since  1.0
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

        $this->object = new Labels($this->options, $this->client);
    }

    /**
     * Tests the getList method
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/labels', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getList('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the get method
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/labels/1', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get('joomla', 'joomla-platform', '1')
        );
    }

    /**
     * Tests the create method
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/labels', '{"name":"foobar","color":"red"}', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->create('joomla', 'joomla-platform', 'foobar', 'red')
        );
    }

    /**
     * Tests the createFailure method
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 404);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/labels', '{"name":"foobar","color":"red"}', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->create('joomla', 'joomla-platform', 'foobar', 'red')
        );
    }

    /**
     * Tests the update method
     *
     * @return  void
     */
    public function testUpdate()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/labels/foobar', '{"name":"boofaz","color":"red"}', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->update('joomla', 'joomla-platform', 'foobar', 'boofaz', 'red')
        );
    }

    /**
     * Tests the delete method
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/labels/foobar', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->delete('joomla', 'joomla-platform', 'foobar')
        );
    }

    /**
     * Tests the getListByIssue method
     *
     * @return  void
     */
    public function testGetListByIssue()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/issues/1/labels', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListByIssue('joomla', 'joomla-platform', 1)
        );
    }

    /**
     * Tests the add method
     *
     * @return  void
     */
    public function testAdd()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/issues/1/labels', '["A","B"]', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->add('joomla', 'joomla-platform', 1, ['A', 'B'])
        );
    }

    /**
     * Tests the removeFromIssue method
     *
     * @return  void
     */
    public function testRemoveFromIssue()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/issues/1/labels/foobar', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->removeFromIssue('joomla', 'joomla-platform', 1, 'foobar')
        );
    }

    /**
     * Tests the replace method
     *
     * @return  void
     */
    public function testReplace()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/issues/1/labels', '["A","B"]', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->replace('joomla', 'joomla-platform', 1, ['A', 'B'])
        );
    }

    /**
     * Tests the removeAllFromIssue method
     *
     * @return  void
     */
    public function testRemoveAllFromIssue()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/issues/1/labels', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->removeAllFromIssue('joomla', 'joomla-platform', 1)
        );
    }

    /**
     * Tests the getListByMilestone method
     *
     * @return  void
     */
    public function testGetListByMilestone()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/milestones/1/labels', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListByMilestone('joomla', 'joomla-platform', 1)
        );
    }
}
