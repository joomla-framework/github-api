<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Repositories\Hooks;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class.
 *
 * @covers \Joomla\Github\Package\Repositories\Hooks
 *
 * @since  1.0
 */
class HooksTest extends GitHubTestCase
{
    /**
     * @var    Hooks  Object under test.
     * @since  12.3
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   1.0
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Hooks($this->options, $this->client);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::create()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCreate()
    {
        $this->response->code = 201;

        $hook         = new \stdClass();
        $hook->name   = 'acunote';
        $hook->config = ['token' => '123456789'];
        $hook->events = ['push', 'public'];
        $hook->active = true;

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/hooks', json_encode($hook))
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->create('joomla', 'joomla-platform', 'acunote', ['token' => '123456789'], ['push', 'public']),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::create()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCreateFailure()
    {
        $exception = false;

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $hook         = new \stdClass();
        $hook->name   = 'acunote';
        $hook->config = ['token' => '123456789'];
        $hook->events = ['push', 'public'];
        $hook->active = true;

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/hooks', json_encode($hook))
            ->will($this->returnValue($this->response));

        try {
            $this->object->create('joomla', 'joomla-platform', 'acunote', ['token' => '123456789'], ['push', 'public']);
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::create()
     *
     * Unauthorised event
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCreateUnauthorisedEvent()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->create('joomla', 'joomla-platform', 'acunote', ['token' => '123456789'], ['push', 'faker']);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::delete()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testDelete()
    {
        $this->response->code = 204;

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/hooks/42')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->delete('joomla', 'joomla-platform', 42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::delete()
     *
     * Simulated failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testDeleteFailure()
    {
        $exception = false;

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/hooks/42')
            ->will($this->returnValue($this->response));

        try {
            $this->object->delete('joomla', 'joomla-platform', 42);
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::edit()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEdit()
    {
        $hook = '{'
            . '"name":"acunote","config":{"token":"123456789"},"events":["push","public"],'
            . '"add_events":["watch"],"remove_events":["watch"],"active":true'
            . '}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/hooks/42', $hook)
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->edit(
                'joomla',
                'joomla-platform',
                42,
                'acunote',
                ['token' => '123456789'],
                ['push', 'public'],
                ['watch'],
                ['watch']
            ),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::edit()
     *
     * Simulated failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditFailure()
    {
        $exception = false;

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $hook = '{'
            . '"name":"acunote","config":{"token":"123456789"},"events":["push","public"],'
            . '"add_events":["watch"],"remove_events":["watch"],"active":true'
            . '}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/hooks/42', $hook)
            ->will($this->returnValue($this->response));

        try {
            $this->object->edit(
                'joomla',
                'joomla-platform',
                42,
                'acunote',
                ['token' => '123456789'],
                ['push', 'public'],
                ['watch'],
                ['watch']
            );
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::edit()
     *
     * Unauthorised event
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditUnauthorisedEvent()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->edit('joomla', 'joomla-platform', 42, 'acunote', ['token' => '123456789'], ['invalid']);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::edit()
     *
     * Unauthorised event
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditUnauthorisedAddEvent()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->edit('joomla', 'joomla-platform', 42, 'acunote', ['token' => '123456789'], ['push'], ['invalid']);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::edit()
     *
     * Unauthorised event
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditUnauthorisedRemoveEvent()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->edit(
            'joomla',
            'joomla-platform',
            42,
            'acunote',
            ['token' => '123456789'],
            ['push'],
            ['push'],
            ['invalid']
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::get()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/hooks/42')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->get('joomla', 'joomla-platform', 42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::get()
     *
     * Failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/hooks/42')
            ->will($this->returnValue($this->response));

        $this->object->get('joomla', 'joomla-platform', 42);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::getList()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/hooks')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->getList('joomla', 'joomla-platform'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::getList()
     *
     * Failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetListFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/hooks')
            ->will($this->returnValue($this->response));

        $this->object->getList('joomla', 'joomla-platform');
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::test()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testTest()
    {
        $this->response->code = 204;

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/hooks/42/test')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->test('joomla', 'joomla-platform', 42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::test()
     *
     * Failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testTestFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response->code = 500;
        $this->response->body = $this->errorString;

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/hooks/42/test')
            ->will($this->returnValue($this->response));

        $this->object->test('joomla', 'joomla-platform', 42);
    }

    /**
     * Test method.
     *
     * @covers \Joomla\Github\Package\Repositories\Hooks::ping()
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testPing()
    {
        $this->response->code = 204;

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/{user}/{repo}/hooks/42/pings')
            ->will($this->returnValue($this->response));

        $this->assertThat(
            $this->object->ping('{user}', '{repo}', 42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }
}
