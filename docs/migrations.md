# Migrations

The Migrations package covers the GitHub migrations REST API for organisation and user migrations: starting a migration, checking its status, downloading and deleting the archive, unlocking migrated repositories and listing them. It is reached as `$github->migrations`, for example `$github->migrations->getListForOrg('joomla')`. The archive download methods return the URL GitHub redirects to (the `Location` header of the 302 response) instead of the archive itself.

```php
$github = new Joomla\Github\Github($options);

// Start a migration of two repositories.
$migration = $github->migrations->startForOrg('joomla', ['joomla-cms', 'joomla-framework'], ['lock_repositories' => true]);

// When its state is "exported", get the archive URL.
$status = $github->migrations->getStatusForOrg('joomla', $migration->id);
$url    = $github->migrations->downloadArchiveForOrg('joomla', $migration->id);
```

## Migrations

`$github->migrations` - https://docs.github.com/rest/migrations

| Method | Endpoint |
| --- | --- |
| `getListForOrg($org, $filters, $page, $limit)` | `GET /orgs/{org}/migrations` |
| `startForOrg($org, $repositories, $options)` | `POST /orgs/{org}/migrations` |
| `getStatusForOrg($org, $migrationId, $filters)` | `GET /orgs/{org}/migrations/{migration_id}` |
| `downloadArchiveForOrg($org, $migrationId)` | `GET /orgs/{org}/migrations/{migration_id}/archive` |
| `deleteArchiveForOrg($org, $migrationId)` | `DELETE /orgs/{org}/migrations/{migration_id}/archive` |
| `unlockRepoForOrg($org, $migrationId, $repoName)` | `DELETE /orgs/{org}/migrations/{migration_id}/repos/{repo_name}/lock` |
| `getRepositoriesForOrg($org, $migrationId, $page, $limit)` | `GET /orgs/{org}/migrations/{migration_id}/repositories` |
| `getListForAuthenticatedUser($page, $limit)` | `GET /user/migrations` |
| `startForAuthenticatedUser($repositories, $options)` | `POST /user/migrations` |
| `getStatusForAuthenticatedUser($migrationId, $filters)` | `GET /user/migrations/{migration_id}` |
| `downloadArchiveForAuthenticatedUser($migrationId)` | `GET /user/migrations/{migration_id}/archive` |
| `deleteArchiveForAuthenticatedUser($migrationId)` | `DELETE /user/migrations/{migration_id}/archive` |
| `unlockRepoForAuthenticatedUser($migrationId, $repoName)` | `DELETE /user/migrations/{migration_id}/repos/{repo_name}/lock` |
| `getRepositoriesForAuthenticatedUser($migrationId, $page, $limit)` | `GET /user/migrations/{migration_id}/repositories` |

The source import API (`/repos/{owner}/{repo}/import`) was removed by GitHub and is therefore not included. Enterprise migration endpoints are not included either.
