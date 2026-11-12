<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Checks;

use Joomla\Github\Package\Checks\Runs;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Checks\Runs.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Runs::class)]
class RunsTest extends GitHubTestCase
{
    /**
     * @var    Runs  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Runs($this->options, $this->client);
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"status":"in_progress","name":"code-coverage","head_sha":"ce587453ced02b1526dfb4cb910479d431683101"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/check-runs', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 'code-coverage', 'ce587453ced02b1526dfb4cb910479d431683101', ['status' => 'in_progress'])
        );
    }

    /**
     * Tests the create method - failure.
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->create('joomla', 'joomla-platform', 'code-coverage', 'ce587453ced02b1526dfb4cb910479d431683101', ['status' => 'in_progress']);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/check-runs/4', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 4)
        );
    }

    /**
     * Tests the get method - failure.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->get('joomla', 'joomla-platform', 4);
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEdit()
    {
        $body = '{"status":"completed","conclusion":"success"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/check-runs/4', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('joomla', 'joomla-platform', 4, ['status' => 'completed', 'conclusion' => 'success'])
        );
    }

    /**
     * Tests the edit method - failure.
     *
     * @return  void
     */
    public function testEditFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->edit('joomla', 'joomla-platform', 4, ['status' => 'completed', 'conclusion' => 'success']);
    }

    /**
     * Tests the getListAnnotations method.
     *
     * @return  void
     */
    public function testGetListAnnotations()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/check-runs/4/annotations?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListAnnotations('joomla', 'joomla-platform', 4, 2, 10)
        );
    }

    /**
     * Tests the getListAnnotations method - failure.
     *
     * @return  void
     */
    public function testGetListAnnotationsFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListAnnotations('joomla', 'joomla-platform', 4, 2, 10);
    }

    /**
     * Tests the rerequest method.
     *
     * @return  void
     */
    public function testRerequest()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/check-runs/4/rerequest', '', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->rerequest('joomla', 'joomla-platform', 4)
        );
    }

    /**
     * Tests the rerequest method - failure.
     *
     * @return  void
     */
    public function testRerequestFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->rerequest('joomla', 'joomla-platform', 4);
    }

    /**
     * Tests the getListForSuite method.
     *
     * @return  void
     */
    public function testGetListForSuite()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/check-suites/5/check-runs?page=2&per_page=10&status=completed', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForSuite('joomla', 'joomla-platform', 5, ['status' => 'completed'], 2, 10)
        );
    }

    /**
     * Tests the getListForSuite method - failure.
     *
     * @return  void
     */
    public function testGetListForSuiteFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForSuite('joomla', 'joomla-platform', 5, ['status' => 'completed'], 2, 10);
    }

    /**
     * Tests the getListForRef method.
     *
     * @return  void
     */
    public function testGetListForRef()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/commits/feature%2Fnew/check-runs?page=2&per_page=10&check_name=build&filter=latest', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRef('joomla', 'joomla-platform', 'feature/new', ['check_name' => 'build', 'filter' => 'latest'], 2, 10)
        );
    }

    /**
     * Tests the getListForRef method - failure.
     *
     * @return  void
     */
    public function testGetListForRefFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForRef('joomla', 'joomla-platform', 'feature/new', ['check_name' => 'build', 'filter' => 'latest'], 2, 10);
    }
}
