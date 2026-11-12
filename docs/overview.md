# Github API package

TODO

## Watching repositories

`$github->activity->watching->getSubscription()`, `setSubscription()` and `deleteSubscription()` manage the
subscription to a repository. `check()`, `watch()` and `unwatch()` use the legacy `/user/subscriptions` routes; they
are deprecated and will be removed in 5.0.
