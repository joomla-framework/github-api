# Github API package

TODO

## Issue events of a repository

`$github->issues->events->getListRepository($owner, $repo)` lists the issue events of a whole repository
(`/repos/{owner}/{repo}/issues/events`). It used to request the comments of one issue instead. The third parameter,
`$issueId`, is ignored and deprecated; pass `$page` and `$limit` as named arguments:

```php
$events = $github->issues->events->getListRepository('joomla', 'joomla-cms', page: 2, limit: 100);
```
