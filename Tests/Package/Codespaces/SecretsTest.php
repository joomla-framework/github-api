<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Codespaces;

use Joomla\Github\Package\Codespaces\Secrets;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Codespaces\Secrets.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Secrets::class)]
class SecretsTest extends GitHubTestCase
{
    /**
     * @var    Secrets  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Secrets($this->options, $this->client);
    }

    /**
     * Test the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList(2, 30)
        );
    }

    /**
     * Test the getList method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getList(2, 30);
    }

    /**
     * Test the getPublicKey method.
     *
     * @return  void
     */
    public function testGetPublicKey()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPublicKey()
        );
    }

    /**
     * Test the getPublicKey method with an unexpected response.
     *
     * @return  void
     */
    public function testGetPublicKeyFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getPublicKey();
    }

    /**
     * Test the get method.
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('GH_TOKEN')
        );
    }

    /**
     * Test the get method with an unexpected response.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->get('GH_TOKEN');
    }

    /**
     * Test the createOrUpdate method.
     *
     * @return  void
     */
    public function testCreateOrUpdate()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/codespaces/secrets/GH_TOKEN', '{"encrypted_value":"c2VjcmV0","key_id":"012345678912345678"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createOrUpdate('GH_TOKEN', '012345678912345678', ['encrypted_value' => 'c2VjcmV0'])
        );
    }

    /**
     * Test the createOrUpdate method with a 204 response.
     *
     * @return  void
     */
    public function testCreateOrUpdateNoContent()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/codespaces/secrets/GH_TOKEN', '{"encrypted_value":"c2VjcmV0","key_id":"012345678912345678"}', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->createOrUpdate('GH_TOKEN', '012345678912345678', ['encrypted_value' => 'c2VjcmV0']));
    }

    /**
     * Test the createOrUpdate method with an unexpected response.
     *
     * @return  void
     */
    public function testCreateOrUpdateFailure()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/codespaces/secrets/GH_TOKEN', '{"encrypted_value":"c2VjcmV0","key_id":"012345678912345678"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->createOrUpdate('GH_TOKEN', '012345678912345678', ['encrypted_value' => 'c2VjcmV0']);
    }

    /**
     * Test the delete method.
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->delete('GH_TOKEN'));
    }

    /**
     * Test the delete method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->delete('GH_TOKEN');
    }

    /**
     * Test the getListSelectedRepositories method.
     *
     * @return  void
     */
    public function testGetListSelectedRepositories()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListSelectedRepositories('GH_TOKEN')
        );
    }

    /**
     * Test the getListSelectedRepositories method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListSelectedRepositoriesFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListSelectedRepositories('GH_TOKEN');
    }

    /**
     * Test the setSelectedRepositories method.
     *
     * @return  void
     */
    public function testSetSelectedRepositories()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories', '{"selected_repository_ids":[1296269,1296280]}', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->setSelectedRepositories('GH_TOKEN', [1296269, 1296280]));
    }

    /**
     * Test the setSelectedRepositories method with an unexpected response.
     *
     * @return  void
     */
    public function testSetSelectedRepositoriesFailure()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories', '{"selected_repository_ids":[1296269,1296280]}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->setSelectedRepositories('GH_TOKEN', [1296269, 1296280]);
    }

    /**
     * Test the addSelectedRepository method.
     *
     * @return  void
     */
    public function testAddSelectedRepository()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories/1296269', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->addSelectedRepository('GH_TOKEN', 1296269));
    }

    /**
     * Test the addSelectedRepository method with an unexpected response.
     *
     * @return  void
     */
    public function testAddSelectedRepositoryFailure()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories/1296269', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->addSelectedRepository('GH_TOKEN', 1296269);
    }

    /**
     * Test the removeSelectedRepository method.
     *
     * @return  void
     */
    public function testRemoveSelectedRepository()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories/1296269', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->removeSelectedRepository('GH_TOKEN', 1296269));
    }

    /**
     * Test the removeSelectedRepository method with an unexpected response.
     *
     * @return  void
     */
    public function testRemoveSelectedRepositoryFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/codespaces/secrets/GH_TOKEN/repositories/1296269', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->removeSelectedRepository('GH_TOKEN', 1296269);
    }
}
