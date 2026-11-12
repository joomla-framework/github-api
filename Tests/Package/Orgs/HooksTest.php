<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Orgs;

use Joomla\Github\Package\Orgs\Hooks;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Orgs\Hooks
 *
 * @since  1.0
 */
class HooksTest extends GitHubTestCase
{
    /**
     * @var Hooks
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

        $this->object = new Hooks($this->options, $this->client);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Orgs\Hooks::getList()
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/hooks')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList('joomla'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Orgs\Hooks::get()
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/hooks/123')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->get('joomla', 123),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Orgs\Hooks::create()
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/hooks')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->create('joomla', '{url}', 'json', '{secret}'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Orgs\Hooks::create()
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Content type must be either "form" or "json"');

        $this->object->create('joomla', '{url}', '{invalid}');
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Orgs\Hooks::create()
     *
     * @return  void
     */
    public function testCreateInvalidEvent()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Your events array contains an unauthorized event.');

        $this->object->create('{org}', '{url}', 'form', null, false, ['{invalid}']);
    }

    /**
     * Tests that edit() no longer creates a hook
     *
     * @return  void
     */
    #[IgnoreDeprecations]
    public function testEdit()
    {
        $this->expectUserDeprecationMessageMatches('/' . preg_quote('Hooks::edit() is deprecated and will be removed in 5.0', '/') . '/');
        $this->expectException(\BadMethodCallException::class);

        $this->client->expects($this->never())
            ->method('post');

        $this->object->edit('{org}', '{url}', 'json', '{secret}', 1, ['create'], true);
    }

    /**
     * Tests that editHook() patches the given hook and sends only the given values as JSON
     *
     * @return  void
     */
    public function testEditHook()
    {
        $this->client->expects($this->never())
            ->method('post');

        $this->client->expects($this->once())
            ->method('patch')
            ->with(
                '/orgs/{org}/hooks/42',
                '{"config":{"url":"{url}","content_type":"json","insecure_ssl":1,"secret":"{secret}"},"active":true,"events":["create"]}'
            )
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->editHook('{org}', 42, '{url}', 'json', '{secret}', true, ['create'], true),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests that editHook() leaves out the values that are not given
     *
     * @return  void
     */
    public function testEditHookPartial()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/{org}/hooks/42', '{"active":false}')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->editHook('{org}', 42, active: false),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests editHook() with an invalid content type
     *
     * @return  void
     */
    public function testEditHookFailure()
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->object->editHook('{org}', 42, '{url}', '{invalid}');
    }

    /**
     * Tests editHook() with an invalid event
     *
     * @return  void
     */
    public function testEditHookInvalidEvent()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->editHook('{org}', 42, '{url}', 'json', '{secret}', true, ['{invalid}']);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Orgs\Hooks::ping()
     *
     * @return  void
     */
    public function testPing()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/{org}/hooks/123/pings')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->ping('{org}', 123),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Orgs\Hooks::delete()
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/hooks/123')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->delete('joomla', 123),
            $this->equalTo(json_decode($this->sampleString))
        );
    }
}
