<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Codespaces;

use Joomla\Github\Package\Codespaces\RepositorySecrets;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Codespaces\RepositorySecrets.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(RepositorySecrets::class)]
class RepositorySecretsTest extends GitHubTestCase
{
    /**
     * @var    RepositorySecrets  Object under test.
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

        $this->object = new RepositorySecrets($this->options, $this->client);
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList('joomla', 'joomla-platform', 2, 30)
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getList('joomla', 'joomla-platform', 2, 30);
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPublicKey('joomla', 'joomla-platform')
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getPublicKey('joomla', 'joomla-platform');
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('joomla', 'joomla-platform', 'GH_TOKEN')
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->get('joomla', 'joomla-platform', 'GH_TOKEN');
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/GH_TOKEN', '{"encrypted_value":"c2VjcmV0"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createOrUpdate('joomla', 'joomla-platform', 'GH_TOKEN', ['encrypted_value' => 'c2VjcmV0'])
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/GH_TOKEN', '{"encrypted_value":"c2VjcmV0"}', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->createOrUpdate('joomla', 'joomla-platform', 'GH_TOKEN', ['encrypted_value' => 'c2VjcmV0']));
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/GH_TOKEN', '{"encrypted_value":"c2VjcmV0"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->createOrUpdate('joomla', 'joomla-platform', 'GH_TOKEN', ['encrypted_value' => 'c2VjcmV0']);
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->delete('joomla', 'joomla-platform', 'GH_TOKEN'));
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
            ->with('/repos/joomla/joomla-platform/codespaces/secrets/GH_TOKEN', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->delete('joomla', 'joomla-platform', 'GH_TOKEN');
    }
}
