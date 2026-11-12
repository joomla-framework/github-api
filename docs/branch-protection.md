# Branches and Branch Protection

The `Repositories\Branches` package covers the [branches](https://docs.github.com/rest/branches/branches) and
[branch protection](https://docs.github.com/rest/branches/branch-protection) endpoints of the GitHub REST API. It is
reached as `$github->repositories->branches`, for example
`$github->repositories->branches->getProtection('joomla', 'joomla-cms', '5.4-dev')`.

```php
use Joomla\Github\Github;

$github = new Github($options);

// Require one approving review and a passing "ci" check, for administrators too; no push restrictions.
$github->repositories->branches->editProtection(
    'joomla',
    'joomla-cms',
    '5.4-dev',
    ['strict' => true, 'contexts' => ['ci']],
    true,
    ['required_approving_review_count' => 1],
    null,
    ['allow_force_pushes' => false]
);

// Add another required status check.
$github->repositories->branches->addStatusCheckContexts('joomla', 'joomla-cms', '5.4-dev', ['lint']);
```

`$options` holds optional request-body fields. Required fields are explicit parameters and win over `$options`. The
branch name is URL-encoded in the new methods, so names such as `feature/x` work as they are.

## Repositories\Branches

| Method | Endpoint |
|--------|----------|
| getList($owner, $repo) | GET /repos/{owner}/{repo}/branches |
| get($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch} |
| rename($owner, $repo, $branch, $newName) | POST /repos/{owner}/{repo}/branches/{branch}/rename |
| mergeUpstream($owner, $repo, $branch) | POST /repos/{owner}/{repo}/merge-upstream |
| getProtection($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection |
| editProtection($owner, $repo, $branch, $requiredStatusChecks, $enforceAdmins, $requiredPullRequestReviews, $restrictions, $options) | PUT /repos/{owner}/{repo}/branches/{branch}/protection |
| deleteProtection($owner, $repo, $branch) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection |
| getAdminEnforcement($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/enforce_admins |
| setAdminEnforcement($owner, $repo, $branch) | POST /repos/{owner}/{repo}/branches/{branch}/protection/enforce_admins |
| deleteAdminEnforcement($owner, $repo, $branch) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/enforce_admins |
| getPullRequestReviewProtection($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/required_pull_request_reviews |
| editPullRequestReviewProtection($owner, $repo, $branch, $options) | PATCH /repos/{owner}/{repo}/branches/{branch}/protection/required_pull_request_reviews |
| deletePullRequestReviewProtection($owner, $repo, $branch) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/required_pull_request_reviews |
| getCommitSignatureProtection($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/required_signatures |
| createCommitSignatureProtection($owner, $repo, $branch) | POST /repos/{owner}/{repo}/branches/{branch}/protection/required_signatures |
| deleteCommitSignatureProtection($owner, $repo, $branch) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/required_signatures |
| getRequiredStatusChecks($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks |
| editRequiredStatusChecks($owner, $repo, $branch, $options) | PATCH /repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks |
| removeRequiredStatusChecks($owner, $repo, $branch) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks |
| getStatusCheckContexts($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks/contexts |
| addStatusCheckContexts($owner, $repo, $branch, $contexts) | POST /repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks/contexts |
| setStatusCheckContexts($owner, $repo, $branch, $contexts) | PUT /repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks/contexts |
| removeStatusCheckContexts($owner, $repo, $branch, $contexts) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/required_status_checks/contexts |
| getAccessRestrictions($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/restrictions |
| deleteAccessRestrictions($owner, $repo, $branch) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/restrictions |
| getAppAccessRestrictions($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/apps |
| addAppAccessRestrictions($owner, $repo, $branch, $apps) | POST /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/apps |
| setAppAccessRestrictions($owner, $repo, $branch, $apps) | PUT /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/apps |
| removeAppAccessRestrictions($owner, $repo, $branch, $apps) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/apps |
| getTeamAccessRestrictions($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/teams |
| addTeamAccessRestrictions($owner, $repo, $branch, $teams) | POST /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/teams |
| setTeamAccessRestrictions($owner, $repo, $branch, $teams) | PUT /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/teams |
| removeTeamAccessRestrictions($owner, $repo, $branch, $teams) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/teams |
| getUserAccessRestrictions($owner, $repo, $branch) | GET /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/users |
| addUserAccessRestrictions($owner, $repo, $branch, $users) | POST /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/users |
| setUserAccessRestrictions($owner, $repo, $branch, $users) | PUT /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/users |
| removeUserAccessRestrictions($owner, $repo, $branch, $users) | DELETE /repos/{owner}/{repo}/branches/{branch}/protection/restrictions/users |

`editProtection()` replaces the whole protection. The API always needs the four settings `required_status_checks`,
`enforce_admins`, `required_pull_request_reviews` and `restrictions`; pass `null` to turn one of them off.

## Left out

- `POST /repos/{owner}/{repo}/merges` (merge a branch) is already available as
  `$github->repositories->merging->perform()`.
- `getList()` and `get()` are unchanged from earlier versions: `getList()` does not take the `protected` filter or
  pagination, and `get()` does not URL-encode the branch name.
- The status-check-contexts and team-restrictions endpoints also accept a bare JSON array as body; the methods always
  send the documented object form (`{"contexts": [...]}`, `{"teams": [...]}`).
