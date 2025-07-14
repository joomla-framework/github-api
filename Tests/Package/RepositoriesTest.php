<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Repositories.
 *
 * @since  1.0
 */
class RepositoriesTest extends GitHubTestCase
{
    /**
     * @var Repositories
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

        $this->object = new Repositories($this->options, $this->client);
    }

    /**
     * Tests the GetListOwn method.
     *
     * @return void
     */
    public function testGetListOwn()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/repos?type=all&sort=full_name&direction=asc', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListOwn()
        );
    }

    /**
     * Tests the GetListOwn method.
     *
     * @return void
     */
    public function testGetListOwnInvalidType()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->getListOwn('INVALID');
    }

    /**
     * Tests the GetListOwn method.
     *
     * @return void
     */
    public function testGetListOwnInvalidSortField()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->getListOwn('all', 'INVALID');
    }

    /**
     * Tests the GetListOwn method.
     *
     * @return void
     */
    public function testGetListOwnInvalidSortOrder()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->getListOwn('all', 'full_name', 'INVALID');
    }

    /**
     * Tests the GetListUser method.
     *
     * @return void
     */
    public function testGetListUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/joomla/repos?type=all&sort=full_name&direction=asc', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListUser('joomla')
        );
    }

    /**
     * Tests the GetListUser method.
     *
     * @return void
     */
    public function testGetListUserInvalidType()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->getListUser('joomla', 'INVALID');
    }

    /**
     * Tests the GetListUser method.
     *
     * @return void
     */
    public function testGetListUserInvalidSortField()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->getListUser('joomla', 'all', 'INVALID');
    }

    /**
     * Tests the GetListUser method.
     *
     * @return void
     */
    public function testGetListUserInvalidSortOrder()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->getListUser('joomla', 'all', 'full_name', 'INVALID');
    }

    /**
     * Tests the GetListOrg method.
     *
     * @return void
     */
    public function testGetListOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/repos?type=all', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListOrg('joomla')
        );
    }

    /**
     * Tests the GetList method.
     *
     * @return void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repositories', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getList()
        );
    }

    /**
     * Tests the Create method.
     *
     * @return void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/user/repos',
                '{"name":"joomla-test","description":"","homepage":"","private":false,"has_issues":false,'
                    . '"has_wiki":false,"has_downloads":false,"team_id":0,"auto_init":false,"gitignore_template":""}',
                [],
                0
            )
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->create('joomla-test')
        );
    }

    /**
     * Tests the Create method.
     *
     * @return void
     */
    public function testCreateWithOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $this->client->expects($this->once())
            ->method('post')
            ->with(
                '/orgs/joomla.org/repos',
                '{"name":"joomla-test","description":"","homepage":"","private":false,"has_issues":false,'
                    . '"has_wiki":false,"has_downloads":false,"team_id":0,"auto_init":false,"gitignore_template":""}',
                [],
                0
            )
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->create('joomla-test', 'joomla.org')
        );
    }

    /**
     * Tests the Get method.
     *
     * @return void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get('joomla', 'joomla-cms')
        );
    }

    /**
     * Tests the GetListOrg method.
     *
     * @return void
     */
    public function testGetListOrgInvalidType()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->getListOrg('joomla', 'INVALID');
    }

    /**
     * Tests the Edit method.
     *
     * @return void
     */
    public function testEdit()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with(
                '/repos/joomla/joomla-test',
                '{"name":"joomla-test-1","description":"","homepage":"","private":'
                    . 'false,"has_issues":false,"has_wiki":false,"has_downloads":false,"default_branch":""}',
                []
            )
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->edit('joomla', 'joomla-test', 'joomla-test-1')
        );
    }

    /**
     * Tests the GetListContributors method.
     *
     * @return void
     */
    public function testGetListContributors()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/contributors', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListContributors('joomla', 'joomla-cms')
        );
    }

    /**
     * Tests the GetListLanguages method.
     *
     * @return void
     */
    public function testGetListLanguages()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/languages', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListLanguages('joomla', 'joomla-cms')
        );
    }

    /**
     * Tests the GetListTeams method.
     *
     * @return void
     */
    public function testGetListTeams()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/teams', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListTeams('joomla', 'joomla-cms')
        );
    }

    /**
     * Tests the GetListTags method.
     *
     * @return void
     */
    public function testGetListTags()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-cms/tags', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getListTags('joomla', 'joomla-cms')
        );
    }

    /**
     * Tests the Delete method.
     *
     * @return void
     */
    public function testDelete()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-cms', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->delete('joomla', 'joomla-cms')
        );
    }
}
