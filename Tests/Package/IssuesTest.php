<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Issues;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Issues
 *
 * @since  1.0
 */
class IssuesTest extends GitHubTestCase
{
    /**
     * @var    Issues  Object under test.
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

        $this->object = new Issues($this->options, $this->client);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::create()
     *
     * @return void
     */
    public function testCreate()
    {
        $this->response->code = 201;

        $issue            = new \stdClass();
        $issue->title     = '{title}';
        $issue->milestone = '{milestone}';
        $issue->labels    = ['{label1}'];
        $issue->body      = '{body}';
        $issue->assignee  = '{assignee}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/{user}/{repo}/issues', json_encode($issue))
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->create('{user}', '{repo}', '{title}', '{body}', '{assignee}', '{milestone}', ['{label1}']),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::create()
     *
     * @return void
     */
    public function testCreate2()
    {
        $this->response->code = 201;

        $issue            = new \stdClass();
        $issue->title     = '{title}';
        $issue->milestone = '{milestone}';
        $issue->labels    = ['{label1}'];
        $issue->body      = '{body}';
        $issue->assignees = ['{assignee1}'];

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/{user}/{repo}/issues', json_encode($issue))
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->create('{user}', '{repo}', '{title}', '{body}', null, '{milestone}', ['{label1}'], ['{assignee1}']),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::create()
     *
     * Failure
     *
     * @return void
     */
    public function testCreateFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 501;
        $this->response->body = $this->errorString;

        $issue            = new \stdClass();
        $issue->title     = '{title}';
        $issue->milestone = '{milestone}';
        $issue->labels    = ['{label1}'];
        $issue->body      = '{body}';
        $issue->assignee  = '{assignee}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/{user}/{repo}/issues', json_encode($issue))
            ->will($this->returnValue($this->response));

        $this->object->create('{user}', '{repo}', '{title}', '{body}', '{assignee}', '{milestone}', ['{label1}']);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::create()
     *
     * @return void
     */
    public function testCreateComment()
    {
        $this->response->code = 201;

        $issue       = new \stdClass();
        $issue->body = 'My Insightful Comment';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/issues/523/comments', json_encode($issue))
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->comments->create('joomla', 'joomla-platform', 523, 'My Insightful Comment'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::create()
     *
     * Failure
     *
     * @return void
     */
    public function testCreateCommentFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 501;
        $this->response->body = $this->errorString;

        $issue       = new \stdClass();
        $issue->body = 'My Insightful Comment';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/issues/523/comments', json_encode($issue))
            ->will($this->returnValue($this->response));

        $this->object->comments->create('joomla', 'joomla-platform', 523, 'My Insightful Comment');
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::edit()
     *
     * @return void
     */
    public function testEdit()
    {
        $issue            = new \stdClass();
        $issue->title     = 'My issue';
        $issue->body      = 'These are my changes - please review them';
        $issue->state     = 'Closed';
        $issue->assignee  = 'JoeAssignee';
        $issue->milestone = '12.2';
        $issue->labels    = ['Fixed'];

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/issues/523', json_encode($issue))
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->edit(
                'joomla',
                'joomla-platform',
                523,
                'Closed',
                'My issue',
                'These are my changes - please review them',
                'JoeAssignee',
                '12.2',
                ['Fixed']
            ),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::edit()
     *
     * Failure
     *
     * @return void
     */
    public function testEditFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $issue        = new \stdClass();
        $issue->title = 'My issue';
        $issue->body  = 'These are my changes - please review them';
        $issue->state = 'Closed';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/issues/523', json_encode($issue))
            ->will($this->returnValue($this->response));

        $this->object->edit('joomla', 'joomla-platform', 523, 'Closed', 'My issue', 'These are my changes - please review them');
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::get()
     *
     * @return void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/issues/523')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->get('joomla', 'joomla-platform', 523),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::get()
     *
     * Failure
     *
     * @return void
     */
    public function testGetFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/issues/523')
            ->will($this->returnValue($this->response));

        $this->object->get('joomla', 'joomla-platform', 523);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::getList()
     *
     * @return void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/issues')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->getList(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::getList()
     *
     * @return void
     */
    public function testGetListAll()
    {
        $since = new \DateTime('January 1, 2012 12:12:12', new \DateTimeZone('UTC'));

        $this->client->expects($this->once())
            ->method('get')
            ->with('/issues?filter={filter}&state={state}&labels={labels}&sort={sort}&direction={direction}&since=2012-01-01T12:12:12+0000')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->getList('{filter}', '{state}', '{labels}', '{sort}', '{direction}', $since),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::getList()
     *
     * Failure
     *
     * @return void
     */
    public function testGetListFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('get')
            ->with('/issues')
            ->will($this->returnValue($this->response));

        $this->object->getList();
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::getListByRepository()
     *
     * @return void
     */
    public function testGetListByRepository()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/issues')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->getListByRepository('joomla', 'joomla-platform'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::getListByRepository()
     *
     * With all parameters
     *
     * @return void
     */
    public function testGetListByRepositoryAll()
    {
        $date = new \DateTime('January 1, 2012 12:12:12', new \DateTimeZone('UTC'));

        $this->client->expects($this->once())
            ->method('get')
            ->with(
                '/repos/joomla/joomla-platform/issues?milestone=25&state=closed&assignee=none&' .
                'mentioned=joomla-jenkins&labels=bug&sort=created&direction=asc&since=2012-01-01T12:12:12+00:00'
            )
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->getListByRepository(
                'joomla',
                'joomla-platform',
                '25',
                'closed',
                'none',
                'joomla-jenkins',
                'bug',
                'created',
                'asc',
                $date
            ),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::getListByRepository()
     *
     * Failure
     *
     * @return void
     */
    public function testGetListByRepositoryFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/issues')
            ->will($this->returnValue($this->response));

        $this->object->getListByRepository('joomla', 'joomla-platform');
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::lock()
     *
     * @return void
     */
    public function testLock()
    {
        $this->response->code = 204;

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/issues/523/lock')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->lock('joomla', 'joomla-platform', 523),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::lock()
     *
     * Failure
     *
     * @return void
     */
    public function testLockFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/issues/523/lock')
            ->will($this->returnValue($this->response));

        $this->object->lock('joomla', 'joomla-platform', 523);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::unlock()
     *
     * @return void
     */
    public function testUnlock()
    {
        $this->response->code = 204;

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/issues/523/lock')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->unlock('joomla', 'joomla-platform', 523),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Issues::unlock()
     *
     * Failure
     *
     * @return void
     */
    public function testUnlockFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/issues/523/lock')
            ->will($this->returnValue($this->response));

        $this->object->unlock('joomla', 'joomla-platform', 523);
    }
}
