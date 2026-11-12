# Github API package

TODO

## Search

`$github->search` wraps GitHub's search API. Each method takes a search query in GitHub's
[search syntax](https://docs.github.com/en/search-github/getting-started-with-searching-on-github/understanding-the-search-syntax),
pass it unencoded:

| Method | Endpoint |
|---|---|
| `getCode($query, $order, $page, $limit)` | `/search/code` |
| `getCommits($query, $sort, $order, $page, $limit)` | `/search/commits` |
| `getIssues($query, $sort, $order, $page, $limit)` | `/search/issues` (issues and pull requests) |
| `getLabels($repositoryId, $query, $sort, $order, $page, $limit)` | `/search/labels` |
| `getRepositories($query, $sort, $order, $page, $limit)` | `/search/repositories` |
| `getTopics($query, $page, $limit)` | `/search/topics` |
| `getUsers($query, $sort, $order, $page, $limit)` | `/search/users` |

```php
$result = $github->search->getIssues('repo:joomla/joomla-cms is:issue is:open label:bug', 'updated', 'desc');

echo $result->total_count;

foreach ($result->items as $issue) {
    echo $issue->title;
}
```

`issues()`, `repositories()`, `users()` and `email()` use the legacy search API, which GitHub has removed. They are
deprecated and will be removed in 5.0.
