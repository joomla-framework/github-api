<?php
/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Users;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Response;

/**
 * Test class for Users.
 *
 * @since  1.0
 */
class UsersTest extends GitHubTestCase
{
    /**
     * @var Users
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Users($this->options, $this->client);
    }

    /**
     * Tests the getUser method
     *
     * @return void
     */
    public function testGet()
    {
        $body = '{
  "login": "octocat",
  "id": 1,
  "avatar_url": "https://github.com/images/error/octocat_happy.gif",
  "gravatar_id": "somehexcode",
  "url": "https://api.github.com/users/octocat",
  "name": "monalisa octocat",
  "company": "GitHub",
  "blog": "https://github.com/blog",
  "location": "San Francisco",
  "email": "octocat@github.com",
  "hireable": false,
  "bio": "There once was...",
  "public_repos": 2,
  "public_gists": 1,
  "followers": 20,
  "following": 0,
  "html_url": "https://github.com/octocat",
  "created_at": "2008-01-14T04:33:35Z",
  "type": "User"
}';
        $this->response = new Response('data://text/plain,' . $body, 200);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/joomla', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->get('joomla')
        );
    }

    /**
     * Tests the getUser method with failure
     *
     * @return void
     */
    public function testGetFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = new Response('data://text/plain,{"message":"Not Found"}', 404);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/nonexistentuser', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->get('nonexistentuser')
        );
    }

    /**
     * Tests the getAuthenticatedUser method
     *
     * @return void
     */
    public function testGetAuthenticatedUser()
    {
        $body = '{
  "login": "octocat",
  "id": 1,
  "avatar_url": "https://github.com/images/error/octocat_happy.gif",
  "gravatar_id": "somehexcode",
  "url": "https://api.github.com/users/octocat",
  "name": "monalisa octocat",
  "company": "GitHub",
  "blog": "https://github.com/blog",
  "location": "San Francisco",
  "email": "octocat@github.com",
  "hireable": false,
  "bio": "There once was...",
  "public_repos": 2,
  "public_gists": 1,
  "followers": 20,
  "following": 0,
  "html_url": "https://github.com/octocat",
  "created_at": "2008-01-14T04:33:35Z",
  "type": "User",
  "total_private_repos": 100,
  "owned_private_repos": 100,
  "private_gists": 81,
  "disk_usage": 10000,
  "collaborators": 8,
  "plan": {
    "name": "Medium",
    "space": 400,
    "collaborators": 10,
    "private_repos": 20
  }
}';
        $this->response = new Response('data://text/plain,' . $body, 200);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getAuthenticatedUser()
        );
    }

    /**
     * Tests the GetAuthenticatedUser method with failure
     *
     * @return void
     */
    public function testGetAuthenticatedUserFailure()
    {
        $this->expectException(\DomainException::class);

        $body = '{"message":"Requires authentication"}';

        $this->response = new Response('data://text/plain,' . $body, 401);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getAuthenticatedUser()
        );
    }

    /**
     * Tests the getUsers method
     *
     * @return void
     */
    public function testGetList()
    {
        $body = '[
  {
    "login": "octocat",
    "id": 1,
    "avatar_url": "https://github.com/images/error/octocat_happy.gif",
    "gravatar_id": "somehexcode",
    "url": "https://api.github.com/users/octocat"
  }
],
  {
    "login": "elkuku",
    "id": 33978,
    "avatar_url": "https://github.com/images/error/octocat_happy.gif",
    "gravatar_id": "somehexcode",
    "url": "https://api.github.com/users/elkuku"
  }
]';

        $this->response = new Response('data://text/plain,' . $body, 200);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/users', [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->getList()
        );
    }

    /**
     * Tests the getUsers method
     *
     * @return void
     */
    public function testEdit()
    {
        $name     = 'monalisa octocat';
        $email    = 'octocat@github.com';
        $blog     = 'https =>//github.com/blog';
        $company  = 'GitHub';
        $location = 'San Francisco';
        $hireable = true;
        $bio      = 'There once...';

        $this->response = new Response('data://text/plain,{
  "login": "octocat",
  "id": 1,
  "avatar_url": "https://github.com/images/error/octocat_happy.gif",
  "gravatar_id": "somehexcode",
  "url": "https://api.github.com/users/octocat",
  "name": "' . $name . '",
  "company": "GitHub",
  "blog": "https://github.com/blog",
  "location": "San Francisco",
  "email": "octocat@github.com",
  "hireable": false,
  "bio": "There once was...",
  "public_repos": 2,
  "public_gists": 1,
  "followers": 20,
  "following": 0,
  "html_url": "https://github.com/octocat",
  "created_at": "2008-01-14T04:33:35Z",
  "type": "User",
  "total_private_repos": 100,
  "owned_private_repos": 100,
  "private_gists": 81,
  "disk_usage": 10000,
  "collaborators": 8,
  "plan": {
    "name": "Medium",
    "space": 400,
    "collaborators": 10,
    "private_repos": 20
  }
}', 200);

        $input = json_encode(
            [
                'name'     => $name,
                'email'    => $email,
                'blog'     => $blog,
                'company'  => $company,
                'location' => $location,
                'hireable' => $hireable,
                'bio'      => $bio,
            ]
        );

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/user', $input, [], 0)
            ->willReturn($this->response);

        $response = json_decode((string) $this->response->getBody());

        $this->assertEquals(
            $response,
            $this->object->edit($name, $email, $blog, $company, $location, $hireable, $bio)
        );
    }

    /**
     * Tests the getUsers method
     *
     * @return void
     */
    public function testEditFailure()
    {
        $this->expectException(\DomainException::class);

        $name     = 'monalisa octocat';
        $email    = 'octocat@github.com';
        $blog     = 'https =>//github.com/blog';
        $company  = 'GitHub';
        $location = 'San Francisco';
        $hireable = true;
        $bio      = 'There once...';

        $this->response = new Response('data://text/plain,' . $this->errorString, 404);

        $input = json_encode(
            [
                'name'     => $name,
                'email'    => $email,
                'blog'     => $blog,
                'company'  => $company,
                'location' => $location,
                'hireable' => $hireable,
                'bio'      => $bio,
            ]
        );

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/user', $input, [], 0)
            ->willReturn($this->response);

        // $this->object->edit($name, $email, $blog, $company, $location, $hireable, $bio);

        $this->assertEquals(
            json_decode((string) $this->response->getBody()),
            $this->object->edit($name, $email, $blog, $company, $location, $hireable, $bio)
        );
    }
}
