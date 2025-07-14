<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Gitignore;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Gitignore.
 *
 * @since  1.0
 */
class GitignoreTest extends GitHubTestCase
{
    /**
     * @var Gitignore
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

        $this->object = new Gitignore($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetList()
    {
        $body = '[
    "Actionscript",
    "Android",
    "AppceleratorTitanium",
    "Autotools",
    "Bancha",
    "C",
    "C++"
    ]';
        $this->response = $this->getResponseObject($body);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/gitignore/templates', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->getList()
        );
    }

    /**
     * Tests the get method.
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGet()
    {
        $body = '{
    "name": "C",
    "source": "# Object files\n*.o\n\n# Libraries\n*.lib\n*.a\n\n# Shared objects (inc. Windows DLLs)\n'
            . '*.dll\n*.so\n*.so.*\n*.dylib\n\n# Executables\n*.exe\n*.out\n*.app\n"
    }';
        $this->response = $this->getResponseObject($body);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/gitignore/templates/C', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get('C')
        );
    }

    /**
     * Tests the get method with raw return data.
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetRaw()
    {
        $body = '# Object files
     *.o

    # Libraries
     *.lib
     *.a

    # Shared objects (inc. Windows DLLs)
     *.dll
     *.so
     *.so.*
     *.dylib

    # Executables
     *.exe
     *.out
     *.app
';
        $this->response = $this->getResponseObject($body);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/gitignore/templates/C', ['Accept' => 'application/vnd.github.raw+json'], 0)
            ->willReturn($this->response);

        $response = $this->response->getBody()->getContents();
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get('C', true)
        );
    }

    /**
     * Tests the get method with failure.
     *
     * @since   1.0
     * @return  void
     */
    public function testGetFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject('{"message":"Not found"}', 404);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/gitignore/templates/X', [], 0)
            ->willReturn($this->response);

        $response = json_decode($this->response->getBody()->getContents());
        $this->response->getBody()->rewind();

        $this->assertEquals(
            $response,
            $this->object->get('X')
        );
    }
}
