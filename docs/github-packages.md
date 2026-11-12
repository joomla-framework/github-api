# Packages

The `Packages` package covers the [GitHub Packages REST API](https://docs.github.com/rest/packages): listing,
reading, deleting and restoring packages and package versions owned by an organization, a user or the
authenticated user, and the Docker migration conflict lists. It is reached through `$github->packages`, for
example `$github->packages->getListForOrg('joomla', 'container')`.

All operations live in one class. The owner scope is part of the method name: `...ForOrg()` takes the
organization name, `...ForUser()` the user name and `...ForAuthenticatedUser()` no owner at all. The package
type (`npm`, `maven`, `rubygems`, `docker`, `nuget` or `container`) comes next, then the package name. Package
names may contain `/` (for example container images such as `joomla/cms`); the package URL-encodes them, so pass
them as they are.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$options = new Registry();
$options->set('gh.token', 'your-token');

$github = new Github($options);

// List the public container images of an organization, 50 per page
$packages = $github->packages->getListForOrg('joomla', 'container', ['visibility' => 'public'], 1, 50);

// List the deleted versions of an image and restore the first one
$versions = $github->packages->getListVersionsForOrg('joomla', 'container', 'joomla/cms', ['state' => 'deleted']);
$github->packages->restoreVersionForOrg('joomla', 'container', 'joomla/cms', $versions[0]->id);
```

`$filters` holds optional query parameters (`visibility` for package lists, `state` for version lists, `token`
for package restores). Paginated methods take `$page` and `$limit` (items per page) as last arguments. Delete
and restore methods are answered with `204 No Content` and return nothing.

## Methods

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $packageType, $filters, $page, $limit) | GET /orgs/{org}/packages |
| getForOrg($org, $packageType, $packageName) | GET /orgs/{org}/packages/{package_type}/{package_name} |
| deleteForOrg($org, $packageType, $packageName) | DELETE /orgs/{org}/packages/{package_type}/{package_name} |
| restoreForOrg($org, $packageType, $packageName, $filters) | POST /orgs/{org}/packages/{package_type}/{package_name}/restore |
| getListVersionsForOrg($org, $packageType, $packageName, $filters, $page, $limit) | GET /orgs/{org}/packages/{package_type}/{package_name}/versions |
| getVersionForOrg($org, $packageType, $packageName, $packageVersionId) | GET /orgs/{org}/packages/{package_type}/{package_name}/versions/{package_version_id} |
| deleteVersionForOrg($org, $packageType, $packageName, $packageVersionId) | DELETE /orgs/{org}/packages/{package_type}/{package_name}/versions/{package_version_id} |
| restoreVersionForOrg($org, $packageType, $packageName, $packageVersionId) | POST /orgs/{org}/packages/{package_type}/{package_name}/versions/{package_version_id}/restore |
| getListDockerConflictsForOrg($org) | GET /orgs/{org}/docker/conflicts |
| getListForUser($username, $packageType, $filters, $page, $limit) | GET /users/{username}/packages |
| getForUser($username, $packageType, $packageName) | GET /users/{username}/packages/{package_type}/{package_name} |
| deleteForUser($username, $packageType, $packageName) | DELETE /users/{username}/packages/{package_type}/{package_name} |
| restoreForUser($username, $packageType, $packageName, $filters) | POST /users/{username}/packages/{package_type}/{package_name}/restore |
| getListVersionsForUser($username, $packageType, $packageName) | GET /users/{username}/packages/{package_type}/{package_name}/versions |
| getVersionForUser($username, $packageType, $packageName, $packageVersionId) | GET /users/{username}/packages/{package_type}/{package_name}/versions/{package_version_id} |
| deleteVersionForUser($username, $packageType, $packageName, $packageVersionId) | DELETE /users/{username}/packages/{package_type}/{package_name}/versions/{package_version_id} |
| restoreVersionForUser($username, $packageType, $packageName, $packageVersionId) | POST /users/{username}/packages/{package_type}/{package_name}/versions/{package_version_id}/restore |
| getListDockerConflictsForUser($username) | GET /users/{username}/docker/conflicts |
| getListForAuthenticatedUser($packageType, $filters, $page, $limit) | GET /user/packages |
| getForAuthenticatedUser($packageType, $packageName) | GET /user/packages/{package_type}/{package_name} |
| deleteForAuthenticatedUser($packageType, $packageName) | DELETE /user/packages/{package_type}/{package_name} |
| restoreForAuthenticatedUser($packageType, $packageName, $filters) | POST /user/packages/{package_type}/{package_name}/restore |
| getListVersionsForAuthenticatedUser($packageType, $packageName, $filters, $page, $limit) | GET /user/packages/{package_type}/{package_name}/versions |
| getVersionForAuthenticatedUser($packageType, $packageName, $packageVersionId) | GET /user/packages/{package_type}/{package_name}/versions/{package_version_id} |
| deleteVersionForAuthenticatedUser($packageType, $packageName, $packageVersionId) | DELETE /user/packages/{package_type}/{package_name}/versions/{package_version_id} |
| restoreVersionForAuthenticatedUser($packageType, $packageName, $packageVersionId) | POST /user/packages/{package_type}/{package_name}/versions/{package_version_id}/restore |
| getListDockerConflictsForAuthenticatedUser() | GET /user/docker/conflicts |

## Notes

* `getListVersionsForUser()` has no `$filters`, `$page` or `$limit` because GitHub's API description lists no
  query parameters for `GET /users/{username}/packages/{package_type}/{package_name}/versions`.
