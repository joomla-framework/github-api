<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Issues;

use Joomla\Github\Package\Issues\Milestones;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for the GitHub API package.
 *
 * @since  1.0
 */
class MilestonesTest extends GitHubTestCase
{
    /**
     * @var    Milestones  Object under test.
     * @since  1.0
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

        $this->object = new Milestones($this->options, $this->client);
    }

    /**
     * Tests the create method
     *
     * @return void
     *
     * @since  1.0
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $milestone = '{'
            . '"title":"My Milestone","state":"open","description":"This milestone is impossible","due_on":"2012-12-25T20:09:31Z"'
            . '}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/milestones', $milestone)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->create('joomla', 'joomla-platform', 'My Milestone', 'open', 'This milestone is impossible', '2012-12-25T20:09:31Z')
        );
    }

    /**
     * Tests the create method - failure
     *
     * @return void
     *
     * @since  12.3
     */
    public function testCreateFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 501);

        $milestone = '{'
            . '"title":"My Milestone","state":"open","description":"This milestone is impossible","due_on":"2012-12-25T20:09:31Z"'
            . '}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/milestones', $milestone)
            ->willReturn($this->response);

        $this->object->create('joomla', 'joomla-platform', 'My Milestone', 'open', 'This milestone is impossible', '2012-12-25T20:09:31Z');
    }

    /**
     * Tests the edit method
     *
     * @return void
     *
     * @since  12.3
     */
    public function testEdit()
    {
        $milestone        = new \stdClass();
        $milestone->state = 'closed';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/milestones/523', json_encode($milestone))
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->edit('joomla', 'joomla-platform', 523, null, 'closed')
        );
    }

    /**
     * Tests the edit method with all parameters
     *
     * @return void
     *
     * @since  12.3
     */
    public function testEditAllParameters()
    {
        $milestone = '{'
            . '"title":"{title}","state":"closed","description":"{description}","due_on":"2012-12-25T20:09:31Z"'
            . '}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/{user}/{repo}/milestones/523', $milestone)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->edit(
                '{user}',
                '{repo}',
                523,
                '{title}',
                'closed',
                '{description}',
                '2012-12-25T20:09:31Z'
            ),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the edit method - failure
     *
     * @return void
     *
     * @since  12.3
     */
    public function testEditFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $milestone        = new \stdClass();
        $milestone->state = 'closed';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/milestones/523', json_encode($milestone))
            ->willReturn($this->response);

        $this->object->edit('joomla', 'joomla-platform', 523, null, 'closed');
    }

    /**
     * Tests the get method
     *
     * @return void
     *
     * @since  12.3
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/milestones/523')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->get('joomla', 'joomla-platform', 523),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the get method - failure
     *
     * @return void
     *
     * @since  12.3
     */
    public function testGetFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/milestones/523')
            ->willReturn($this->response);

        $this->object->get('joomla', 'joomla-platform', 523);
    }

    /**
     * Tests the getList method
     *
     * @return void
     *
     * @since  12.3
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/milestones?state=open&sort=due_date&direction=desc')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList('joomla', 'joomla-platform'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the getList method - failure
     *
     * @return void
     *
     * @since  12.3
     */
    public function testGetListFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/milestones?state=open&sort=due_date&direction=desc')
            ->willReturn($this->response);

        $this->object->getList('joomla', 'joomla-platform');
    }

    /**
     * Tests the delete method
     *
     * @return void
     *
     * @since  12.3
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/milestones/254')
            ->willReturn($this->response);

        $this->object->delete('joomla', 'joomla-platform', 254);
    }

    /**
     * Tests the delete method - failure
     *
     * @return void
     *
     * @since  12.3
     */
    public function testDeleteFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 504);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/milestones/254')
            ->willReturn($this->response);

        $this->object->delete('joomla', 'joomla-platform', 254);
    }
}
