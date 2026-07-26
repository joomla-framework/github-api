## Updating from v3 to v4

The following changes were made to the Github API package between v3 and v4.

### Minimum supported PHP version raised

All Framework packages now require PHP 8.3 or newer.

### Modern API headers and authentication (since 4.1)

Starting with version 4.1, `fetchUrl()` automatically sends `Accept: application/vnd.github+json` and pins
`X-GitHub-Api-Version` to `2022-11-28` on every request, matching GitHub's currently recommended REST API
conventions. Both headers are only added if you haven't already set them yourself on the HTTP client, so
existing code that manages its own headers is unaffected.

If you need a different API version, set the `api.version` option:

```php
$options->set('api.version', '2022-11-28');
```

A new `gh.token.scheme` option (default `token`, unchanged) lets you send the `Authorization` header using the
`Bearer` scheme instead, which some fine-grained personal access tokens and GitHub App installation tokens
require:

```php
$options->set('gh.token', $token);
$options->set('gh.token.scheme', 'Bearer');
```

HTTP Basic Authentication (`api.username` / `api.password`) against `https://api.github.com` no longer works —
GitHub removed it in November 2020. Use `gh.token` instead. The `api.username` / `api.password` options remain
available for GitHub Enterprise Server instances that still accept them.

### `Authorization` and `Repositories\Downloads` are deprecated (since 4.1)

`Package\Authorization` wrapped GitHub's OAuth Authorizations API, and `Package\Repositories\Downloads` wrapped
the Repository Downloads API. GitHub has removed both endpoints from github.com (OAuth Authorizations in
November 2020; Downloads years earlier), so every method on these two classes now fails against live GitHub.
The classes are kept so existing `$github->authorization` and `$github->repositories->downloads` call sites
don't fatal, but they are marked `@deprecated`; `Authorization` is scheduled for removal in 5.0.

* Replace `$github->authorization` usage with a personal access token passed via the `gh.token` option, or the
  GitHub Apps / OAuth device flow once supported.
* Replace `$github->repositories->downloads` usage with `$github->repositories->releases`, which manages
  release assets.
