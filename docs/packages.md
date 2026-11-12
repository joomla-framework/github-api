# Endpoint packages

Every endpoint lives on a package object hanging off `Joomla\Github\Github`. Packages with
sub-packages expose them as further magic properties, so the call chain mirrors the URL structure:

```php
$github->repositories->releases->getLatest($owner, $repo);
//      └ package     └ sub-package
```

Both levels are lazily instantiated and cached. Asking for a name that does not exist raises an
`InvalidArgumentException`.

## Activity

`$github->activity`

| Sub-package | Methods |
|---|---|
| `events` | `getPublic`, `getRepository`, `getIssue`, `getNetwork`, `getOrg`, `getUser`, `getUserPublic`, `getByUser`, `getByUserPublic`, `getUserOrg` |
| `feeds` | `getFeeds` |
| `notifications` | `getList`, `getListRepository`, `markRead`, `markReadRepository`, `viewThread`, `markReadThread`, `getThreadSubscription`, `setThreadSubscription`, `deleteThreadSubscription` |
| `starring` | `getList`, `getRepositories`, `check`, `star`, `unstar` |
| `watching` | `getList`, `getRepositories`, `getSubscription`, `setSubscription`, `deleteSubscription`, `check`, `watch`, `unwatch` |

```php
$github->activity->starring->star($owner, $repo);
$github->activity->notifications->getList(false, false, $since);
```

## Authorization

`$github->authorization` — `create`, `delete`, `deleteGrant`, `edit`, `get`, `getGrant`, `getList`,
`getListGrants`, `getRateLimit`, `getAuthorizationLink`, `requestToken`,
`revokeGrantForApplication`

> **Mostly dead against github.com.** The OAuth Authorizations API was shut down in November 2020.
> Of this class only `getRateLimit()` still works. Use a personal access token or a GitHub App
> installation token via the `gh.token` option instead — see [Authentication](authentication.md).

```php
$limit = $github->authorization->getRateLimit();
echo $limit->resources->core->remaining;
```

## Data (the git database)

`$github->data`

| Sub-package | Methods |
|---|---|
| `blobs` | `get`, `create` |
| `commits` | `get`, `create` |
| `refs` | `get`, `getList`, `create`, `edit`, `delete` |
| `tags` | `get`, `create` |
| `trees` | `get`, `getRecursively`, `create` |

This is the low-level plumbing — enough to build a commit by hand:

```php
$blob   = $github->data->blobs->create($owner, $repo, $contents, 'utf-8');
$tree   = $github->data->trees->create($owner, $repo, $treeEntries, $baseTree);
$commit = $github->data->commits->create($owner, $repo, $message, $tree->sha, [$parentSha]);
$github->data->refs->edit($owner, $repo, 'heads/main', $commit->sha);
```

## Gists

`$github->gists` — `create`, `delete`, `edit`, `fork`, `get`, `getCommitList`, `getForkList`,
`getList`, `getListByUser`, `getListPublic`, `getListStarred`, `getRevision`, `isStarred`, `star`,
`unstar`

`$github->gists->comments` — `create`, `delete`, `edit`, `get`, `getList`

## Issues

`$github->issues` — `create`, `edit`, `get`, `getList`, `getListByRepository`, `lock`, `unlock`

| Sub-package | Methods |
|---|---|
| `assignees` | `getList`, `check`, `add`, `remove` |
| `comments` | `getList`, `getRepositoryList`, `get`, `edit`, `create`, `delete` |
| `events` | `getList`, `getListRepository`, `get` |
| `labels` | `getList`, `get`, `create`, `delete`, `update`, `getListByIssue`, `add`, `removeFromIssue`, `replace`, `removeAllFromIssue`, `getListByMilestone` |
| `milestones` | `getList`, `get`, `create`, `edit`, `delete` |

```php
$issue = $github->issues->create($owner, $repo, 'Title', 'Body', $assignee, $milestone, $labels);
$github->issues->labels->add($owner, $repo, $issue->number, ['bug']);
$github->issues->comments->create($owner, $repo, $issue->number, 'Thanks for the report.');
```

## Pull requests

`$github->pulls` — `create`, `createFromIssue`, `edit`, `get`, `getCommits`, `getFiles`,
`getList`, `isMerged`, `merge`

| Sub-package | Methods |
|---|---|
| `comments` | `create`, `createReply`, `delete`, `edit`, `get`, `getList`, `getListForRepo` |
| `reviews` | `create`, `delete`, `dismiss`, `get`, `getComments`, `getList`, `submit`, `update` |
| `reviewRequests` | `create`, `getList`, `remove` |

`comments` are the inline review comments on a diff. `reviews` are the review objects themselves —
approve, request changes, comment:

```php
$github->pulls->reviewRequests->create($owner, $repo, $pullId, ['octocat'], ['core-team']);

$review = $github->pulls->reviews->create($owner, $repo, $pullId, $commitId, 'Looks good', 'APPROVE');
$github->pulls->reviews->dismiss($owner, $repo, $pullId, $review->id, 'Superseded by a rebase');
```

`create()` accepts an `$event` of `APPROVE`, `REQUEST_CHANGES` or `COMMENT`. Omit it to leave the
review pending, then call `submit()` later.

## Reactions

`$github->reactions` — for each of four targets there is a `createFor…`, `listFor…` and
`deleteFor…` method:

| Target | Methods |
|---|---|
| Issue | `createForIssue`, `listForIssue`, `deleteForIssue` |
| Issue comment | `createForIssueComment`, `listForIssueComment`, `deleteForIssueComment` |
| Commit comment | `createForCommitComment`, `listForCommitComment`, `deleteForCommitComment` |
| PR review comment | `createForPullRequestReviewComment`, `listForPullRequestReviewComment`, `deleteForPullRequestReviewComment` |

```php
$github->reactions->createForIssue($owner, $repo, $issueNumber, '+1');
$github->reactions->listForIssue($owner, $repo, $issueNumber, 'heart');
```

Valid content values are `+1`, `-1`, `laugh`, `confused`, `heart`, `hooray`, `rocket` and `eyes`.
The `createFor…` methods check this before sending and raise an `InvalidArgumentException` on
anything else; on `listFor…` the argument is an optional filter.

## Repositories

`$github->repositories` — `getListOwn`, `getListUser`, `getListOrg`, `getList`, `create`, `get`,
`edit`, `getListContributors`, `getListLanguages`, `getListTeams`, `getListTags`, `delete`

| Sub-package | Methods |
|---|---|
| `branches` | `getList`, `get`, plus the branch-protection set below |
| `collaborators` | `getList`, `get`, `add`, `remove` |
| `comments` | `getListRepository`, `getList`, `get`, `edit`, `delete`, `create` |
| `commits` | `getList`, `get`, `getSha`, `compare` |
| `contents` | `getReadme`, `get`, `getArchiveLink`, `create`, `update`, `delete` |
| `deployments` | `getList`, `create`, `getDeploymentStatuses`, `createStatus` |
| `downloads` | `getList`, `get`, `create`, `upload`, `delete` — **removed API, see below** |
| `forks` | `create`, `getList` |
| `hooks` | `create`, `delete`, `edit`, `get`, `getList`, `ping`, `test` |
| `keys` | `getList`, `get`, `create`, `edit`, `delete` |
| `merging` | `perform` |
| `pages` | `getInfo`, `getList`, `getLatest` |
| `releases` | `create`, `delete`, `edit`, `get`, `getLatest`, `getByTag`, `getList`, `getListAssets`, `getAsset`, `editAsset`, `deleteAsset` |
| `statistics` | `getListContributors`, `getActivityData`, `getCodeFrequency`, `getParticipation`, `getPunchCard` |
| `statuses` | `create`, `getList`, `getCombinedStatus` |

### Branch protection

`$github->repositories->branches` covers the protection endpoints:

| Concern | Methods |
|---|---|
| Whole protection object | `getProtection`, `updateProtection`, `removeProtection` |
| Required status checks | `getRequiredStatusChecks`, `updateRequiredStatusChecks`, `removeRequiredStatusChecks` |
| Required reviews | `getRequiredPullRequestReviews`, `updateRequiredPullRequestReviews`, `removeRequiredPullRequestReviews` |
| Admin enforcement | `getAdminEnforcement`, `addAdminEnforcement`, `removeAdminEnforcement` |
| Push restrictions | `getRestrictions`, `removeRestrictions`, `getRestrictionEntries`, `addRestrictionEntries`, `setRestrictionEntries`, `removeRestrictionEntries` |

```php
$github->repositories->branches->updateRequiredStatusChecks($owner, $repo, 'main', true, ['ci/build']);
$github->repositories->branches->addAdminEnforcement($owner, $repo, 'main');
$github->repositories->branches->addRestrictionEntries($owner, $repo, 'main', 'teams', ['core-team']);
```

The restriction `$type` must be `users`, `teams` or `apps`; anything else raises an
`InvalidArgumentException` before the request is sent. Push restrictions are an organisation-only
feature, so on a personal repository GitHub answers `403`.

### `downloads` is dead code

GitHub removed the Repository Downloads API in 2020 and every method in
`$github->repositories->downloads` now returns `404`. The class is deprecated and scheduled for
removal in 5.0. Use release assets instead:

```php
$release = $github->repositories->releases->getLatest($owner, $repo);
$assets  = $github->repositories->releases->getListAssets($owner, $repo, $release->id);
```

## Users

`$github->users` — `get`, `getAuthenticatedUser`, `edit`, `getList`

| Sub-package | Methods |
|---|---|
| `emails` | `getList`, `add`, `delete` |
| `followers` | `getList`, `getListFollowedBy`, `check`, `checkUserFollowing`, `follow`, `unfollow` |
| `keys` | `getListUser`, `getList`, `get`, `create`, `edit`, `delete` |

## Organisations

`$github->orgs` — `getList`, `get`, `edit`

| Sub-package | Methods |
|---|---|
| `hooks` | `getList`, `get`, `create`, `edit`, `ping`, `delete` |
| `members` | `getList`, `check`, `remove`, `getListPublic`, `checkPublic`, `publicize`, `conceal`, `getMembership`, `updateMembership`, `removeMembership`, `listMemberships`, `listOrganizationMembership`, `editOrganizationMembership` |
| `teams` | `getList`, `get`, `create`, `edit`, `delete`, `getListMembers`, `isMember`, `addMember`, `removeMember`, `getTeamMembership`, `addTeamMembership`, `removeTeamMembership`, `getListRepos`, `checkRepo`, `addRepo`, `removeRepo`, `getUserTeams` |

## Search

`$github->search` — `issues`, `repositories`, `users`, `email`

```php
$github->search->repositories('joomla', 'php', 'stars', 'desc');
$github->search->issues('repo:joomla/joomla-cms is:open label:bug');
```

These map to the search endpoints with simple keyword parameters. Code search and commit search are
not implemented.

## Utility packages

| Package | Methods | Notes |
|---|---|---|
| `emojis` | `getList` | The emoji-to-image-URL map |
| `gitignore` | `getList`, `get` | `.gitignore` templates by name |
| `markdown` | `render` | `render($text, $mode = 'gfm', $context = null)` |
| `meta` | `getMeta` | Service IP ranges and metadata |
| `zen` | `get` | Returns a plain string, not JSON |
| `graphql` | `execute` | Raw GraphQL v4 passthrough |

## What is not here

The client tracks GitHub's pre-2020 REST surface. Entire categories have no representation:

* **Actions** — workflows, runs, jobs, artifacts, secrets, runners, caches
* **Apps** — GitHub Apps, installations, installation access tokens, device flow
* **Checks** — check runs and check suites
* **Security** — code scanning, secret scanning, Dependabot alerts, dependency graph / SBOM
* **Projects** — classic and Projects v2
* **Packages**, **Codespaces**, **Copilot**, **Migrations**, **Licenses**, **Interaction limits**
* **SCIM**, Enterprise Admin, Billing

Smaller gaps inside packages that do exist:

* `Repositories::create()` / `edit()` do not expose `topics`, `visibility`, template flags,
  `delete_branch_on_merge`, the merge-strategy toggles, or rulesets
* `Repositories\Statistics` has no traffic endpoints (views, clones, referrers) and no community
  profile
* `Users` has no GPG keys, SSH signing keys, social accounts or blocking
* `Issues` has no timeline API and no sub-issues
* `Orgs` has no secrets, custom roles, custom properties or security managers

For anything on those lists, use `$github->graphql->execute()` where GraphQL covers it, or issue
the request directly through `Joomla\Http\Http`.
