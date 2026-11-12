# Copilot

The Copilot package covers the GitHub Copilot REST API: seat management, code review settings and policies, cloud agent permissions and configuration, content exclusion rules, usage metrics reports and team customizations. Each area is a sub-package of `$github->copilot`, for example `$github->copilot->userManagement->getList('joomla')`.

```php
$github = new Joomla\Github\Github($options);

// Give two users a Copilot seat in the organisation.
$result = $github->copilot->userManagement->addUsers('joomla', ['octocat', 'octokitten']);

// Fetch the latest 28-day usage metrics report.
$report = $github->copilot->usageMetrics->getOrganizationLatestReport('joomla');
```

## Cloud agent management

`$github->copilot->cloudAgentManagement` - https://docs.github.com/rest/copilot/copilot-cloud-agent-management

| Method | Endpoint |
| --- | --- |
| `getConfiguration($owner, $repo)` | `GET /repos/{owner}/{repo}/copilot/cloud-agent/configuration` |

## Code review

`$github->copilot->codeReview` - https://docs.github.com/rest/copilot/copilot-code-review

| Method | Endpoint |
| --- | --- |
| `getRunnerForOrg($org)` | `GET /orgs/{org}/copilot/code-review/runner` |
| `setRunnerForOrg($org, $runnerType, $options)` | `PUT /orgs/{org}/copilot/code-review/runner` |
| `getSettingsForOrg($org)` | `GET /orgs/{org}/copilot/code-review/settings` |
| `editSettingsForOrg($org, $options)` | `PATCH /orgs/{org}/copilot/code-review/settings` |
| `getPolicyForOrg($org)` | `GET /orgs/{org}/copilot/policies/code-review` |
| `setPolicyForOrg($org, $state)` | `PUT /orgs/{org}/copilot/policies/code-review` |
| `getSettingsForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/copilot/code-review/settings` |
| `editSettingsForRepo($owner, $repo, $options)` | `PATCH /repos/{owner}/{repo}/copilot/code-review/settings` |

## Coding agent management

`$github->copilot->codingAgentManagement` - https://docs.github.com/rest/copilot/copilot-coding-agent-management

| Method | Endpoint |
| --- | --- |
| `getPermissions($org)` | `GET /orgs/{org}/copilot/coding-agent/permissions` |
| `setPermissions($org, $enabledRepositories)` | `PUT /orgs/{org}/copilot/coding-agent/permissions` |
| `getRepositories($org, $page, $limit)` | `GET /orgs/{org}/copilot/coding-agent/permissions/repositories` |
| `setRepositories($org, $selectedRepositoryIds)` | `PUT /orgs/{org}/copilot/coding-agent/permissions/repositories` |
| `enableRepository($org, $repositoryId)` | `PUT /orgs/{org}/copilot/coding-agent/permissions/repositories/{repository_id}` |
| `disableRepository($org, $repositoryId)` | `DELETE /orgs/{org}/copilot/coding-agent/permissions/repositories/{repository_id}` |

## Content exclusion management

`$github->copilot->contentExclusionManagement` - https://docs.github.com/rest/copilot/copilot-content-exclusion-management

| Method | Endpoint |
| --- | --- |
| `get($org)` | `GET /orgs/{org}/copilot/content_exclusion` |
| `set($org, $rules)` | `PUT /orgs/{org}/copilot/content_exclusion` |

## Team customizations

`$github->copilot->teamCustomizations` - https://docs.github.com/rest/copilot/copilot-team-customizations

| Method | Endpoint |
| --- | --- |
| `get($org, $teamSlug)` | `GET /orgs/{org}/teams/{team_slug}/copilot/customizations` |
| `set($org, $teamSlug, $options)` | `PUT /orgs/{org}/teams/{team_slug}/copilot/customizations` |
| `delete($org, $teamSlug)` | `DELETE /orgs/{org}/teams/{team_slug}/copilot/customizations` |

## Usage metrics

`$github->copilot->usageMetrics` - https://docs.github.com/rest/copilot/copilot-usage-metrics

| Method | Endpoint |
| --- | --- |
| `getOrganizationReport($org, $day)` | `GET /orgs/{org}/copilot/metrics/reports/organization-1-day` |
| `getOrganizationLatestReport($org)` | `GET /orgs/{org}/copilot/metrics/reports/organization-28-day/latest` |
| `getRepositoriesReport($org, $day)` | `GET /orgs/{org}/copilot/metrics/reports/repos-1-day` |
| `getUserTeamsReport($org, $day)` | `GET /orgs/{org}/copilot/metrics/reports/user-teams-1-day` |
| `getUsersReport($org, $day)` | `GET /orgs/{org}/copilot/metrics/reports/users-1-day` |
| `getUsersLatestReport($org)` | `GET /orgs/{org}/copilot/metrics/reports/users-28-day/latest` |

## User management

`$github->copilot->userManagement` - https://docs.github.com/rest/copilot/copilot-user-management

| Method | Endpoint |
| --- | --- |
| `getForOrg($org)` | `GET /orgs/{org}/copilot/billing` |
| `getList($org, $page, $limit)` | `GET /orgs/{org}/copilot/billing/seats` |
| `addTeams($org, $selectedTeams)` | `POST /orgs/{org}/copilot/billing/selected_teams` |
| `removeTeams($org, $selectedTeams)` | `DELETE /orgs/{org}/copilot/billing/selected_teams` |
| `addUsers($org, $selectedUsernames)` | `POST /orgs/{org}/copilot/billing/selected_users` |
| `removeUsers($org, $selectedUsernames)` | `DELETE /orgs/{org}/copilot/billing/selected_users` |
| `getForUser($org, $username)` | `GET /orgs/{org}/members/{username}/copilot` |
