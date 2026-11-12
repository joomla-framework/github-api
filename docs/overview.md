# Github API package

TODO

## Gist comments

`$github->gists->comments->get()`, `edit()` and `delete()` take the gist ID as their last argument, for GitHub's
`/gists/{gist_id}/comments/{comment_id}` route:

```php
$comment = $github->gists->comments->get($commentId, $gistId);
$github->gists->comments->edit($commentId, 'New text', $gistId);
$github->gists->comments->delete($commentId, $gistId);
```

Without the gist ID they use the old `/gists/comments/{comment_id}` route, which GitHub has removed; that is
deprecated, and the gist ID will be required in 5.0.
