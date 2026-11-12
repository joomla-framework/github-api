# Authentication and options

All configuration goes through the `Joomla\Registry\Registry` passed to the `Github` constructor.
The same registry is handed on to every package object and to `HttpFactory`.

## Options

| Option | Default | Meaning |
|---|---|---|
| `api.url` | `https://api.github.com` | API root. Set this for GitHub Enterprise Server |
| `api.version` | `2022-11-28` | Sent as `X-GitHub-Api-Version` |
| `gh.token` | — | Personal access token or installation token |
| `gh.token.scheme` | `token` | `Authorization` scheme; use `Bearer` where GitHub asks for it |
| `api.username` | — | Basic-auth user (Enterprise only, discouraged) |
| `api.password` | — | Basic-auth password (Enterprise only, discouraged) |
| `userAgent` | `JGitHub/2.0` | Sent by the HTTP client |

```php
$options = new Registry([
    'gh.token'    => getenv('GITHUB_TOKEN'),
    'api.version' => '2022-11-28',
]);
```

Options can also be set after construction:

```php
$github->setOption('gh.token', $token);
$github->getOption('api.url');
```

Package objects read the options registry on every request, so changing an option affects
subsequent calls — with the caveat about the shared `Authorization` header below.

## Token authentication

This is the only form that still works against github.com:

```php
$github = new Github(new Registry(['gh.token' => getenv('GITHUB_TOKEN')]));
```

`fetchUrl()` then sends:

```
Authorization: token <your token>
Accept: application/vnd.github+json
X-GitHub-Api-Version: 2022-11-28
```

Both `Accept` and `X-GitHub-Api-Version` are only set when the HTTP client does not already carry
them, so you can override either by setting it on the client yourself.

### Choosing the scheme

| Token type | Scheme |
|---|---|
| Classic personal access token | `token` (the default) |
| Fine-grained personal access token | `token` or `Bearer` |
| GitHub App installation token | `Bearer` |
| GitHub App JWT | `Bearer` |

```php
$options = new Registry([
    'gh.token'        => $installationToken,
    'gh.token.scheme' => 'Bearer',
]);
```

## Basic authentication

```php
$options = new Registry([
    'api.url'      => 'https://github.example.com/api/v3',
    'api.username' => 'svc-bot',
    'api.password' => $password,
]);
```

> **Only for Enterprise Server, and only if you have no alternative.** GitHub removed
> username/password authentication for the API in November 2020.
>
> The credentials are written into the URL's userinfo, so they appear in logs and in the message of
> any `UnexpectedResponseException`, which renders the URI as a string. And if `api.username` is
> set without `api.password`, `Joomla\Uri` leaves out the `@` separator, producing
> `https://svc-botgithub.example.com/…` — a request to an entirely different host. Set both or
> neither.

A token works on Enterprise Server too, and avoids all of the above.

## GitHub Enterprise Server

Point `api.url` at the instance's API root — note the `/api/v3` suffix, which github.com does not
have:

```php
$options = new Registry([
    'api.url'  => 'https://github.example.com/api/v3',
    'gh.token' => $token,
]);
```

`api.version` is a github.com concept; older Enterprise releases ignore the header, which is
harmless.

## Isolating the HTTP client

`fetchUrl()` stores the `Authorization` header as an **option on the HTTP client**, not on the
individual request. Anything else that later uses the same client sends the token too — including
requests to other hosts, and including redirects, which `joomla/http` follows by default.

Give the GitHub client an instance of its own:

```php
use Joomla\Http\HttpFactory;
use Joomla\Github\Github;

$github = new Github($options, (new HttpFactory())->getHttp($options));
```

In a DI container, register it as a distinct service rather than reusing the shared `Http`:

```php
$container->share(Github::class, function (Container $container) {
    $options = new Registry(['gh.token' => getenv('GITHUB_TOKEN')]);

    // A dedicated client - not $container->get(Http::class)
    return new Github($options, (new HttpFactory())->getHttp($options));
});
```

The same reasoning applies to using two accounts at once: two `Github` objects sharing a client
overwrite each other's header, so each needs its own `Http`.

## Verifying the token

```php
$user = $github->users->getAuthenticatedUser();
echo $user->login;
```

A `401` here means the token is missing, expired or revoked; a `403` usually means the token lacks
the required scope, or you have hit a rate limit — see
[Pagination and rate limits](pagination-and-rate-limits.md).
