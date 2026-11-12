# Dependabot

The Dependabot package covers the GitHub REST API for Dependabot alerts, Dependabot secrets, the organization repository access list and the repository runner settings. It is reached as `$github->dependabot`, with one sub-package per resource, e.g. `$github->dependabot->alerts->getListForRepo('joomla', 'joomla-cms')`.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$github = new Github(new Registry(['gh.token' => 'your-token']));

// Open critical alerts of a repository, 50 per page
$alerts = $github->dependabot->alerts->getListForRepo('joomla', 'joomla-cms', ['state' => 'open', 'severity' => 'critical'], 50);

// Dismiss one of them
$github->dependabot->alerts->edit('joomla', 'joomla-cms', 42, ['state' => 'dismissed', 'dismissed_reason' => 'tolerable_risk']);
```

## Alerts (`$github->dependabot->alerts`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $filters, $limit) | GET /orgs/{org}/dependabot/alerts |
| getListForRepo($owner, $repo, $filters, $limit) | GET /repos/{owner}/{repo}/dependabot/alerts |
| get($owner, $repo, $alertNumber) | GET /repos/{owner}/{repo}/dependabot/alerts/{alert_number} |
| edit($owner, $repo, $alertNumber, $options) | PATCH /repos/{owner}/{repo}/dependabot/alerts/{alert_number} |

## Secrets (`$github->dependabot->secrets`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $page, $limit) | GET /orgs/{org}/dependabot/secrets |
| getPublicKeyForOrg($org) | GET /orgs/{org}/dependabot/secrets/public-key |
| getForOrg($org, $secretName) | GET /orgs/{org}/dependabot/secrets/{secret_name} |
| createOrUpdateForOrg($org, $secretName, $visibility, $options) | PUT /orgs/{org}/dependabot/secrets/{secret_name} |
| deleteForOrg($org, $secretName) | DELETE /orgs/{org}/dependabot/secrets/{secret_name} |
| getSelectedRepositories($org, $secretName, $page, $limit) | GET /orgs/{org}/dependabot/secrets/{secret_name}/repositories |
| setSelectedRepositories($org, $secretName, $selectedRepositoryIds) | PUT /orgs/{org}/dependabot/secrets/{secret_name}/repositories |
| addSelectedRepository($org, $secretName, $repositoryId) | PUT /orgs/{org}/dependabot/secrets/{secret_name}/repositories/{repository_id} |
| removeSelectedRepository($org, $secretName, $repositoryId) | DELETE /orgs/{org}/dependabot/secrets/{secret_name}/repositories/{repository_id} |
| getListForRepo($owner, $repo, $page, $limit) | GET /repos/{owner}/{repo}/dependabot/secrets |
| getPublicKeyForRepo($owner, $repo) | GET /repos/{owner}/{repo}/dependabot/secrets/public-key |
| getForRepo($owner, $repo, $secretName) | GET /repos/{owner}/{repo}/dependabot/secrets/{secret_name} |
| createOrUpdateForRepo($owner, $repo, $secretName, $options) | PUT /repos/{owner}/{repo}/dependabot/secrets/{secret_name} |
| deleteForRepo($owner, $repo, $secretName) | DELETE /repos/{owner}/{repo}/dependabot/secrets/{secret_name} |

## RepositoryAccess (`$github->dependabot->repositoryAccess`)

| Method | Endpoint |
| --- | --- |
| getList($org, $page, $limit) | GET /orgs/{org}/dependabot/repository-access |
| edit($org, $options) | PATCH /orgs/{org}/dependabot/repository-access |
| setDefaultLevel($org, $defaultLevel) | PUT /orgs/{org}/dependabot/repository-access/default-level |

## RunnerSettings (`$github->dependabot->runnerSettings`)

| Method | Endpoint |
| --- | --- |
| get($owner, $repo) | GET /repos/{owner}/{repo}/dependabot/runner-settings |
| set($owner, $repo, $runnerType, $options) | PUT /repos/{owner}/{repo}/dependabot/runner-settings |

## Notes

- The alert lists use cursor-based pagination: pass `before` / `after` (from the `Link` header) in `$filters`; `$limit` sets `per_page`.
- Secret values must be encrypted with the public key (`getPublicKeyForOrg()` / `getPublicKeyForRepo()`) using libsodium before they are sent as `encrypted_value`.
- The enterprise endpoints (`/enterprises/...`) are not covered.
