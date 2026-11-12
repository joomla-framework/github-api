<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Apps;

use Joomla\Github\Package\Apps\Webhooks;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Apps\Webhooks.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Webhooks::class)]
class WebhooksTest extends GitHubTestCase
{
    /**
     * @var    Webhooks  Object under test.
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

        $this->object = new Webhooks($this->options, $this->client);
    }

    /**
     * Tests the getConfig method.
     *
     * @return  void
     */
    public function testGetConfig()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/app/hook/config', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getConfig()
        );
    }

    /**
     * Tests the getConfig method - failure.
     *
     * @return  void
     */
    public function testGetConfigFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getConfig();
    }

    /**
     * Tests the editConfig method.
     *
     * @return  void
     */
    public function testEditConfig()
    {
        $body = '{"content_type":"json","insecure_ssl":"0"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/app/hook/config', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->editConfig(['content_type' => 'json', 'insecure_ssl' => '0'])
        );
    }

    /**
     * Tests the editConfig method - failure.
     *
     * @return  void
     */
    public function testEditConfigFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->editConfig(['content_type' => 'json', 'insecure_ssl' => '0']);
    }

    /**
     * Tests the getListDeliveries method.
     *
     * @return  void
     */
    public function testGetListDeliveries()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/app/hook/deliveries?page=2&per_page=10&cursor=v1_12077215967&status=failure', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListDeliveries(['cursor' => 'v1_12077215967', 'status' => 'failure'], 2, 10)
        );
    }

    /**
     * Tests the getListDeliveries method - failure.
     *
     * @return  void
     */
    public function testGetListDeliveriesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListDeliveries(['cursor' => 'v1_12077215967', 'status' => 'failure'], 2, 10);
    }

    /**
     * Tests the getDelivery method.
     *
     * @return  void
     */
    public function testGetDelivery()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/app/hook/deliveries/12', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getDelivery(12)
        );
    }

    /**
     * Tests the getDelivery method - failure.
     *
     * @return  void
     */
    public function testGetDeliveryFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getDelivery(12);
    }

    /**
     * Tests the redeliver method.
     *
     * @return  void
     */
    public function testRedeliver()
    {
        $this->response = $this->getResponseObject($this->sampleString, 202);
        $this->client->expects($this->once())
            ->method('post')
            ->with('/app/hook/deliveries/12/attempts', '', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->redeliver(12)
        );
    }

    /**
     * Tests the redeliver method - failure.
     *
     * @return  void
     */
    public function testRedeliverFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->redeliver(12);
    }
}
