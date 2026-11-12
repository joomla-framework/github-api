<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Projects;

use Joomla\Github\Package\Projects\Fields;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Projects\Fields.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Fields::class)]
class FieldsTest extends GitHubTestCase
{
    /**
     * @var    Fields  Object under test.
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

        $this->object = new Fields($this->options, $this->client);
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/projectsV2/6/fields?page=2&per_page=10&before=Y3Vyc29yOnYyOpK5', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', 6, ['before' => 'Y3Vyc29yOnYyOpK5'], 2, 10)
        );
    }

    /**
     * Tests the getListForOrg method - failure.
     *
     * @return  void
     */
    public function testGetListForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForOrg('joomla', 6, ['before' => 'Y3Vyc29yOnYyOpK5'], 2, 10);
    }

    /**
     * Tests the addForOrg method.
     *
     * @return  void
     */
    public function testAddForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"name":"Priority","data_type":"text"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/projectsV2/6/fields', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addForOrg('joomla', 6, ['name' => 'Priority', 'data_type' => 'text'])
        );
    }

    /**
     * Tests the addForOrg method - failure.
     *
     * @return  void
     */
    public function testAddForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->addForOrg('joomla', 6, ['name' => 'Priority', 'data_type' => 'text']);
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/projectsV2/6/fields/8', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla', 6, 8)
        );
    }

    /**
     * Tests the getForOrg method - failure.
     *
     * @return  void
     */
    public function testGetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForOrg('joomla', 6, 8);
    }

    /**
     * Tests the getListForUser method.
     *
     * @return  void
     */
    public function testGetListForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/projectsV2/6/fields?page=2&per_page=10&after=Y3Vyc29yOnYyOpK5', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForUser('octocat', 6, ['after' => 'Y3Vyc29yOnYyOpK5'], 2, 10)
        );
    }

    /**
     * Tests the getListForUser method - failure.
     *
     * @return  void
     */
    public function testGetListForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForUser('octocat', 6, ['after' => 'Y3Vyc29yOnYyOpK5'], 2, 10);
    }

    /**
     * Tests the addForUser method.
     *
     * @return  void
     */
    public function testAddForUser()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"single_select_options":[{"name":"High","color":"RED"}],"name":"Priority","data_type":"single_select"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/users/octocat/projectsV2/6/fields', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addForUser('octocat', 6, 'Priority', 'single_select', ['single_select_options' => [['name' => 'High', 'color' => 'RED']]])
        );
    }

    /**
     * Tests the addForUser method - failure.
     *
     * @return  void
     */
    public function testAddForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->addForUser('octocat', 6, 'Priority', 'single_select', ['single_select_options' => [['name' => 'High', 'color' => 'RED']]]);
    }

    /**
     * Tests the getForUser method.
     *
     * @return  void
     */
    public function testGetForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/projectsV2/6/fields/8', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForUser('octocat', 6, 8)
        );
    }

    /**
     * Tests the getForUser method - failure.
     *
     * @return  void
     */
    public function testGetForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForUser('octocat', 6, 8);
    }
}
