# Github API package

TODO

## Organization webhooks

`$github->orgs->hooks->editHook($org, $id, ...)` edits an organization webhook (`PATCH /orgs/{org}/hooks/{hook_id}`)
and sends only the values that are given:

```php
$github->orgs->hooks->editHook('joomla', 12345, active: false);
```

`$github->orgs->hooks->edit()` is deprecated and throws a `BadMethodCallException`. It has no hook ID parameter and
used to send the request to the create endpoint, so every call created another webhook.
