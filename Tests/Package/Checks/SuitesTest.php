<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Checks;

use Joomla\Github\Package\Checks\Suites;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Checks\Suites.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Suites::class)]
class SuitesTest extends GitHubTestCase
{
    /**
     * @var    Suites  Object under test.
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

        $this->object = new Suites($this->options, $this->client);
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"head_sha":"ce587453ced02b1526dfb4cb910479d431683101"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/check-suites', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 'ce587453ced02b1526dfb4cb910479d431683101')
        );
    }

    /**
     * Tests the create method with the alternative 200 response.
     *
     * @return  void
     */
    public function testCreateAlternativeCode()
    {
        $this->response = $this->getResponseObject($this->sampleString, 200);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create('joomla', 'joomla-platform', 'ce587453ced02b1526dfb4cb910479d431683101')
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

        $this->object->create('joomla', 'joomla-platform', 'ce587453ced02b1526dfb4cb910479d431683101');
    }

    /**
     * Tests the setPreferences method.
     *
     * @return  void
     */
    public function testSetPreferences()
    {
        $body = '{"auto_trigger_checks":[{"app_id":4,"setting":false}]}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/check-suites/preferences', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->setPreferences('joomla', 'joomla-platform', ['auto_trigger_checks' => [['app_id' => 4, 'setting' => false]]])
        );
    }

    /**
     * Tests the setPreferences method - failure.
     *
     * @return  void
     */
    public function testSetPreferencesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->setPreferences('joomla', 'joomla-platform', ['auto_trigger_checks' => [['app_id' => 4, 'setting' => false]]]);
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
            ->with('/repos/joomla/joomla-platform/check-suites/5', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 5)
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

        $this->object->get('joomla', 'joomla-platform', 5);
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
            ->with('/repos/joomla/joomla-platform/check-suites/5/rerequest', '', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->rerequest('joomla', 'joomla-platform', 5)
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

        $this->object->rerequest('joomla', 'joomla-platform', 5);
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
            ->with('/repos/joomla/joomla-platform/commits/feature%2Fnew/check-suites?page=2&per_page=10&app_id=1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRef('joomla', 'joomla-platform', 'feature/new', ['app_id' => 1], 2, 10)
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

        $this->object->getListForRef('joomla', 'joomla-platform', 'feature/new', ['app_id' => 1], 2, 10);
    }
}
