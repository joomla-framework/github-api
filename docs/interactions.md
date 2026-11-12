# Interactions

The Interactions package covers the GitHub interactions REST API: temporary interaction restrictions for organisations, repositories and the public repositories of the authenticated user, plus the pull request creation cap and its bypass list. It is reached as `$github->interactions`, for example `$github->interactions->getRestrictionsForRepo('joomla', 'joomla-cms')`.

```php
$github = new Joomla\Github\Github($options);

// Limit interactions on a repository to collaborators for one week.
$github->interactions->setRestrictionsForRepo('joomla', 'joomla-cms', 'collaborators_only', ['expiry' => 'one_week']);

// Remove the restriction again.
$github->interactions->removeRestrictionsForRepo('joomla', 'joomla-cms');
```

## Interactions

`$github->interactions` - https://docs.github.com/rest/interactions

| Method | Endpoint |
| --- | --- |
| `getRestrictionsForOrg($org)` | `GET /orgs/{org}/interaction-limits` |
| `setRestrictionsForOrg($org, $limit, $options)` | `PUT /orgs/{org}/interaction-limits` |
| `removeRestrictionsForOrg($org)` | `DELETE /orgs/{org}/interaction-limits` |
| `getPullRequestCreationCapForOrg($org)` | `GET /orgs/{org}/interaction-limits/pulls/creation-cap` |
| `editPullRequestCreationCapForOrg($org, $enabled, $options)` | `PATCH /orgs/{org}/interaction-limits/pulls/creation-cap` |
| `getRestrictionsForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/interaction-limits` |
| `setRestrictionsForRepo($owner, $repo, $limit, $options)` | `PUT /repos/{owner}/{repo}/interaction-limits` |
| `removeRestrictionsForRepo($owner, $repo)` | `DELETE /repos/{owner}/{repo}/interaction-limits` |
| `getPullRequestBypassListForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/interaction-limits/pulls/bypass-list` |
| `addPullRequestBypassUsersForRepo($owner, $repo, $users)` | `PUT /repos/{owner}/{repo}/interaction-limits/pulls/bypass-list` |
| `removePullRequestBypassUsersForRepo($owner, $repo, $users)` | `DELETE /repos/{owner}/{repo}/interaction-limits/pulls/bypass-list` |
| `getPullRequestCreationCapForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/interaction-limits/pulls/creation-cap` |
| `editPullRequestCreationCapForRepo($owner, $repo, $enabled, $options)` | `PATCH /repos/{owner}/{repo}/interaction-limits/pulls/creation-cap` |
| `getRestrictionsForAuthenticatedUser()` | `GET /user/interaction-limits` |
| `setRestrictionsForAuthenticatedUser($limit, $options)` | `PUT /user/interaction-limits` |
| `removeRestrictionsForAuthenticatedUser()` | `DELETE /user/interaction-limits` |
