# Licenses

The Licenses package covers the GitHub licenses REST API: the commonly used open source licenses, a single license and the license of a repository. It is reached as `$github->licenses`, for example `$github->licenses->get('mit')`.

```php
$github = new Joomla\Github\Github($options);

// Featured licenses only.
$licenses = $github->licenses->getList(['featured' => true]);

// The license of a repository.
$license = $github->licenses->getForRepo('joomla', 'joomla-cms');
```

## Licenses

`$github->licenses` - https://docs.github.com/rest/licenses/licenses

| Method | Endpoint |
| --- | --- |
| `getList($filters, $page, $limit)` | `GET /licenses` |
| `get($license)` | `GET /licenses/{license}` |
| `getForRepo($owner, $repo, $filters)` | `GET /repos/{owner}/{repo}/license` |
