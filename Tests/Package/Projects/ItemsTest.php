<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Projects;

use Joomla\Github\Package\Projects\Items;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Projects\Items.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Items::class)]
class ItemsTest extends GitHubTestCase
{
    /**
     * @var    Items  Object under test.
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

        $this->object = new Items($this->options, $this->client);
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
            ->with('/orgs/joomla/projectsV2/6/items?page=2&per_page=10&q=is:open&fields=1,2', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', 6, ['q' => 'is:open', 'fields' => '1,2'], 2, 10)
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

        $this->object->getListForOrg('joomla', 6, ['q' => 'is:open', 'fields' => '1,2'], 2, 10);
    }

    /**
     * Tests the addForOrg method.
     *
     * @return  void
     */
    public function testAddForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"id":42,"type":"Issue"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/projectsV2/6/items', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addForOrg('joomla', 6, 'Issue', ['id' => 42])
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

        $this->object->addForOrg('joomla', 6, 'Issue', ['id' => 42]);
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
            ->with('/orgs/joomla/projectsV2/6/items/11?fields=1,2', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla', 6, 11, ['fields' => '1,2'])
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

        $this->object->getForOrg('joomla', 6, 11, ['fields' => '1,2']);
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrg()
    {
        $body = '{"fields":[{"id":1,"value":"Done"}]}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/projectsV2/6/items/11', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editForOrg('joomla', 6, 11, [['id' => 1, 'value' => 'Done']])
        );
    }

    /**
     * Tests the editForOrg method - failure.
     *
     * @return  void
     */
    public function testEditForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->editForOrg('joomla', 6, 11, [['id' => 1, 'value' => 'Done']]);
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrg()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/projectsV2/6/items/11', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForOrg('joomla', 6, 11));
    }

    /**
     * Tests the deleteForOrg method - failure.
     *
     * @return  void
     */
    public function testDeleteForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteForOrg('joomla', 6, 11);
    }

    /**
     * Tests the getListForOrgView method.
     *
     * @return  void
     */
    public function testGetListForOrgView()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/projectsV2/6/views/3/items?page=2&per_page=10&fields=1,2', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrgView('joomla', 6, 3, ['fields' => '1,2'], 2, 10)
        );
    }

    /**
     * Tests the getListForOrgView method - failure.
     *
     * @return  void
     */
    public function testGetListForOrgViewFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForOrgView('joomla', 6, 3, ['fields' => '1,2'], 2, 10);
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
            ->with('/users/octocat/projectsV2/6/items?page=2&per_page=10&q=is:open', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForUser('octocat', 6, ['q' => 'is:open'], 2, 10)
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

        $this->object->getListForUser('octocat', 6, ['q' => 'is:open'], 2, 10);
    }

    /**
     * Tests the addForUser method.
     *
     * @return  void
     */
    public function testAddForUser()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);
        $body = '{"owner":"joomla","repo":"joomla-cms","number":1,"type":"Issue"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/users/octocat/projectsV2/6/items', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->addForUser('octocat', 6, 'Issue', ['owner' => 'joomla', 'repo' => 'joomla-cms', 'number' => 1])
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

        $this->object->addForUser('octocat', 6, 'Issue', ['owner' => 'joomla', 'repo' => 'joomla-cms', 'number' => 1]);
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
            ->with('/users/octocat/projectsV2/6/items/11?fields=1,2', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForUser('octocat', 6, 11, ['fields' => '1,2'])
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

        $this->object->getForUser('octocat', 6, 11, ['fields' => '1,2']);
    }

    /**
     * Tests the editForUser method.
     *
     * @return  void
     */
    public function testEditForUser()
    {
        $body = '{"fields":[{"id":1,"value":"Done"}]}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/users/octocat/projectsV2/6/items/11', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editForUser('octocat', 6, 11, [['id' => 1, 'value' => 'Done']])
        );
    }

    /**
     * Tests the editForUser method - failure.
     *
     * @return  void
     */
    public function testEditForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->editForUser('octocat', 6, 11, [['id' => 1, 'value' => 'Done']]);
    }

    /**
     * Tests the deleteForUser method.
     *
     * @return  void
     */
    public function testDeleteForUser()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/users/octocat/projectsV2/6/items/11', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForUser('octocat', 6, 11));
    }

    /**
     * Tests the deleteForUser method - failure.
     *
     * @return  void
     */
    public function testDeleteForUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteForUser('octocat', 6, 11);
    }

    /**
     * Tests the getListForUserView method.
     *
     * @return  void
     */
    public function testGetListForUserView()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/projectsV2/6/views/3/items?page=2&per_page=10&fields=1,2', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForUserView('octocat', 6, 3, ['fields' => '1,2'], 2, 10)
        );
    }

    /**
     * Tests the getListForUserView method - failure.
     *
     * @return  void
     */
    public function testGetListForUserViewFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForUserView('octocat', 6, 3, ['fields' => '1,2'], 2, 10);
    }
}
