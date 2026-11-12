<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Github\Tests\Stub\ObjectMock;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Test class for Joomla\Github\Object.
 *
 * @since  1.0
 */
class GithubObjectTest extends GitHubTestCase
{
    /**
     * @var    ObjectMock  Object under test.
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

        $this->object = new ObjectMock($this->options, $this->client);
    }

    /**
     * Data provider method for the fetchUrl method tests.
     *
     * @return  array
     *
     * @since   1.0
     */
    public static function fetchUrlData(): array
    {
        return [
            'Standard github - no pagination data' => [
                'https://api.github.com',
                '/gists',
                0,
                0,
                'https://api.github.com/gists',
            ],
            'Enterprise github - no pagination data' => [
                'https://mygithub.com',
                '/gists',
                0,
                0,
                'https://mygithub.com/gists',
            ],
            'Standard github - page 3' => [
                'https://api.github.com',
                '/gists',
                3,
                0,
                'https://api.github.com/gists?page=3',
            ],
            'Enterprise github - page 3, 50 per page' => [
                'https://mygithub.com',
                '/gists',
                3,
                50,
                'https://mygithub.com/gists?page=3&per_page=50',
            ],
        ];
    }

    /**
     * Tests the fetchUrl method
     *
     * @param   string   $apiUrl    @todo
     * @param   string   $path      @todo
     * @param   integer  $page      @todo
     * @param   integer  $limit     @todo
     * @param   string   $expected  @todo
     *
     * @return  void
     *
     * @since        1.0
     */
    #[DataProvider('fetchUrlData')]
    public function testFetchUrl($apiUrl, $path, $page, $limit, $expected)
    {
        $this->options->set('api.url', $apiUrl);

        $this->assertThat(
            $this->object->fetchUrl($path, $page, $limit),
            $this->equalTo($expected)
        );
    }

    /**
     * Tests the fetchUrl method with basic authentication data
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testFetchUrlBasicAuth()
    {
        $this->options->set('api.url', 'https://api.github.com');

        $this->options->set('api.username', 'MyTestUser');
        $this->options->set('api.password', 'MyTestPass');

        $this->assertThat(
            $this->object->fetchUrl('/gists', 0, 0),
            $this->equalTo('https://MyTestUser:MyTestPass@api.github.com/gists'),
            'URL is not as expected.'
        );
    }

    /**
     * Tests that processResponse() accepts one of several expected codes
     *
     * @return  void
     */
    public function testProcessResponseWithSeveralExpectedCodes()
    {
        $this->assertEquals(
            json_decode($this->sampleString),
            $this->processResponse($this->getResponseObject($this->sampleString, 202), [202, 205])
        );
    }

    /**
     * Tests that processResponse() returns null for an empty body
     *
     * @return  void
     */
    public function testProcessResponseWithEmptyBody()
    {
        $this->assertNull($this->processResponse($this->getResponseObject('', 204), 204));
    }

    /**
     * Tests that processResponse() throws on a body that is not JSON
     *
     * @return  void
     */
    public function testProcessResponseWithInvalidJson()
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('Invalid JSON received from GitHub');

        $this->processResponse($this->getResponseObject('<html>Maintenance</html>', 200));
    }

    /**
     * Tests the fetchUrl method using an oAuth token.
     *
     * @return void
     */
    public function testFetchUrlToken()
    {
        $this->options->set('api.url', 'https://api.github.com');

        $this->options->set('gh.token', 'MyTestToken');

        $this->assertThat(
            (string) $this->object->fetchUrl('/gists', 0, 0),
            $this->equalTo('https://api.github.com/gists'),
            'URL is not as expected.'
        );
    }

    /**
     * Calls the protected processResponse() method of the object under test.
     *
     * @param   mixed  ...$arguments  The arguments.
     *
     * @return  mixed
     */
    private function processResponse(...$arguments)
    {
        return (new \ReflectionMethod($this->object, 'processResponse'))->invoke($this->object, ...$arguments);
    }
}
