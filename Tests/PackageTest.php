<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Github;
use Joomla\Github\Package\Issues;
use Joomla\Github\Package\Repositories\Forks;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Joomla\Github\Github.
 *
 * @since  1.0
 */
class PackageTest extends GitHubTestCase
{
    /**
     * @var    Github  Object under test.
     * @since  1.0
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

        $this->object = new Github($this->options, $this->client);
    }

    /**
     * Tests the magic __get method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGet()
    {
        $this->assertThat(
            $this->object->repositories->forks,
            $this->isInstanceOf('Joomla\Github\Package\Repositories\Forks')
        );
    }

    /**
     * Tests the magic __get method with an invalid parameter.
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->object->repositories->INVALID;
    }

    /**
     * Tests that the lazily created objects are cached without dynamic properties
     *
     * @return  void
     */
    public function testGetCachesWithoutDynamicProperties()
    {
        $errors = [];

        set_error_handler(
            static function (int $errno, string $errstr) use (&$errors): bool {
                $errors[] = $errstr;

                return true;
            }
        );

        try {
            $repositories = $this->object->repositories;
            $forks        = $this->object->repositories->forks;

            $this->assertSame($repositories, $this->object->repositories);
            $this->assertSame($forks, $this->object->repositories->forks);
        } finally {
            restore_error_handler();
        }

        $this->assertSame([], $errors);
    }

    /**
     * Tests that API objects can be replaced, e.g. with mocks
     *
     * @return  void
     */
    public function testSetReplacesObjects()
    {
        $issues = $this->createStub(Issues::class);
        $forks  = $this->createStub(Forks::class);

        $this->object->issues              = $issues;
        $this->object->repositories->forks = $forks;

        $this->assertSame($issues, $this->object->issues);
        $this->assertSame($forks, $this->object->repositories->forks);
    }

    /**
     * Tests the magic __isset and __unset methods
     *
     * @return  void
     */
    public function testIssetAndUnset()
    {
        $this->assertFalse(isset($this->object->issues));
        $this->assertFalse(isset($this->object->repositories->forks));

        $issues = $this->object->issues;
        $forks  = $this->object->repositories->forks;

        $this->assertTrue(isset($this->object->issues));
        $this->assertTrue(isset($this->object->repositories->forks));

        unset($this->object->issues, $this->object->repositories->forks);

        $this->assertFalse(isset($this->object->issues));
        $this->assertNotSame($issues, $this->object->issues);
        $this->assertNotSame($forks, $this->object->repositories->forks);
    }
}
