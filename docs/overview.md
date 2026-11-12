# Github API package

TODO

## Creating and editing repositories and the user profile

`$github->repositories->create()`, `$github->repositories->edit()` and `$github->users->edit()` send only the values
that are given. Leave a parameter out (or pass `null`) to keep the current setting, or GitHub's default when creating:

```php
// Renames the repository; description, visibility, issues and wiki stay as they are
$github->repositories->edit('joomla', 'old-name', 'new-name');

// Changes only the bio
$github->users->edit(bio: 'Joomla! contributor');
```

Before, every parameter that was not given was sent with its default (`''` or `false`), so a plain rename cleared
the description, disabled issues and the wiki and made a private repository public.
