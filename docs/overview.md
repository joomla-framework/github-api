# Github API package

TODO

## Package objects

`Github` creates the package objects (`$github->issues`, `$github->repositories`, …) and their sub-packages
(`$github->repositories->forks`) on first access and reuses them afterwards. They can be replaced, for example with a
mock in a test:

```php
$github->issues = $issuesMock;
$github->repositories->forks = $forksMock;
```

`isset($github->issues)` tells whether the object has been created or set; `unset($github->issues)` makes the next
access create a new one.
