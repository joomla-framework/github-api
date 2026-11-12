# Github API package

TODO

## Authentication and request headers

The options are read on every request, so a changed token is used from the next request on. The headers are added
to each request only; they are not stored on the HTTP client, so a client shared with other code never sends the
GitHub credentials elsewhere.

| Option | Default | Meaning |
|---|---|---|
| `api.url` | `https://api.github.com` | API root; for GitHub Enterprise Server `https://<host>/api/v3` |
| `api.version` | `2022-11-28` | Sent as `X-GitHub-Api-Version` |
| `gh.token` | | Token sent as `Authorization: token <gh.token>` |
| `gh.token_scheme` | `token` | Scheme of the `Authorization` header, e.g. `Bearer` for GitHub App tokens |
| `api.username`, `api.password` | | Sent as `Authorization: Basic` when no token is set (GitHub Enterprise Server only) |

```php
$options = new Registry();
$options->set('gh.token', getenv('GITHUB_TOKEN'));
$options->set('gh.token_scheme', 'Bearer');

$github = new Github($options);
```

Every request also sends `Accept: application/vnd.github+json`, and a JSON request body is sent with
`Content-Type: application/json`. A header set on the HTTP client (its `headers` option) or passed with a request
takes precedence over these defaults.

GitHub removed password authentication for the API in November 2020; `api.username` and `api.password` only work
against GitHub Enterprise Server instances that still accept it. They are sent in the `Authorization` header, not in
the URL.

## Deprecated endpoints

GitHub has removed some of the endpoints this package wraps. Calling these methods triggers a deprecation notice;
they will be removed in 5.0.

* `Authorization`: everything except `getRateLimit()`, `getAuthorizationLink()` and `requestToken()` (the OAuth
  Authorizations API). Use a token (`gh.token`) instead.
* `Repositories\Downloads`: the whole class. Use `Repositories\Releases` and its assets instead.
