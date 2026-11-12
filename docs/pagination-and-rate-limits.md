# Pagination and rate limits

## Paging through a list

List methods take `$page` and `$limit` as their last two arguments and pass them to
`fetchUrl()`, which turns them into GitHub's `page` and `per_page` query parameters:

```php
$page = 1;
$all  = [];

do {
    $batch = $github->issues->getListByRepository($owner, $repo, state: 'open', page: $page, limit: 100);
    $all   = array_merge($all, $batch);
    $page++;
} while (\count($batch) === 100);
```

Several list methods have a long tail of optional filters between the required arguments and
`$page`/`$limit` — `Issues::getListByRepository()` has ten. Named arguments save you counting
`null`s.

Both are only added when greater than zero, so leaving them at `0` uses GitHub's defaults
(page 1, 30 items).

`per_page` is capped at 100 by GitHub for nearly every endpoint. Asking for more silently gives you
100.

**There is no `Link` header support.** GitHub reports the next and last page in a `Link` response
header, but `processResponse()` discards the response once it has decoded the body, so you cannot
reach it. The loop above — keep going while a full page comes back — is the practical substitute.
It costs one extra request when the total is an exact multiple of the page size.

If you need the header, issue that one request through the HTTP client directly. The package
objects expose no accessor for their client, so keep a reference to the `Http` instance you passed
to the constructor:

```php
$client = (new HttpFactory())->getHttp($options);
$github = new Github($options, $client);

$response = $client->get('https://api.github.com/repos/' . $owner . '/' . $repo . '/issues?per_page=100');
$link     = $response->getHeaderLine('Link');   // <…>; rel="next", <…>; rel="last"
```

## Rate limits

GitHub allows 60 requests per hour unauthenticated and 5,000 per hour with a token (15,000 for
GitHub App installations on an Enterprise Cloud organisation). Search has its own, much lower,
limit.

The current state is available without spending quota:

```php
$limit = $github->authorization->getRateLimit();

echo $limit->resources->core->remaining;
echo $limit->resources->core->reset;        // Unix timestamp
echo $limit->resources->search->remaining;
```

`getRateLimit()` is the one method of the `Authorization` package that still works against
github.com. On an instance that does not implement `/rate_limit` it answers `404`, and the method
returns `(object) ['limit' => false, 'remaining' => null]` rather than raising.

### The headers are not read

Every response carries `X-RateLimit-Limit`, `X-RateLimit-Remaining` and `X-RateLimit-Reset`, and
secondary limits add `Retry-After`. The client does not look at any of them and has no backoff. A
loop that runs into the limit gets `403` responses whose cause is not visible in the exception
message.

If you are making many calls, poll `getRateLimit()` yourself and pause:

```php
$limit = $github->authorization->getRateLimit();

if ($limit->resources->core->remaining < 10) {
    $wait = $limit->resources->core->reset - time();
    // sleep, queue for later, or abort - but do not keep hammering
}
```

### Distinguishing a rate limit from a permission problem

Both arrive as `403`. Without the headers, the message text is the only signal:

```php
use Joomla\Http\Exception\UnexpectedResponseException;

try {
    $github->repositories->get($owner, $repo);
} catch (UnexpectedResponseException $e) {
    if ($e->getResponse()->getStatusCode() === 403 && str_contains($e->getMessage(), 'rate limit')) {
        // back off
    }
}
```

GitHub's message for a secondary limit reads "You have exceeded a secondary rate limit"; for the
primary limit it mentions "API rate limit exceeded".

## Conditional requests

A conditional `GET` with `If-None-Match` does not count against the rate limit when the answer is
`304`. This client cannot use that: `processResponse()` compares the status against exactly one
expected code, so a `304` is treated as an error and raises `UnexpectedResponseException` with an
empty message.

If caching matters for your workload, make those requests through `Joomla\Http\Http` yourself and
handle the `ETag` there.
