# Github API package

TODO

## Teams

GitHub addresses teams by organization and slug (`/orgs/{org}/teams/{team_slug}`); the `/teams/{team_id}` routes are
legacy. `$github->orgs->teams` has a `…BySlug()` method for each of them:

| Method | Replaces |
|---|---|
| `getBySlug($org, $slug)` | `get($id)` |
| `editBySlug($org, $slug, $name, $description, $privacy)` | `edit($id, ...)` |
| `deleteBySlug($org, $slug)` | `delete($id)` |
| `getListMembersBySlug($org, $slug, $page, $limit)` | `getListMembers($id)` |
| `getMembershipBySlug($org, $slug, $user)` | `getTeamMembership($id, $user)`, `isMember($id, $user)` |
| `addMembershipBySlug($org, $slug, $user, $role)` | `addTeamMembership($id, $user, $role)`, `addMember($id, $user)` |
| `removeMembershipBySlug($org, $slug, $user)` | `removeTeamMembership($id, $user)`, `removeMember($id, $user)` |
| `getListReposBySlug($org, $slug, $page, $limit)` | `getListRepos($id)` |
| `checkRepoBySlug($org, $slug, $owner, $repo)` | `checkRepo($id, $owner, $repo)` |
| `addRepoBySlug($org, $slug, $owner, $repo, $permission)` | `addRepo($id, $org, $repo)` |
| `removeRepoBySlug($org, $slug, $owner, $repo)` | `removeRepo($id, $owner, $repo)` |

The methods in the right column are deprecated and will be removed in 5.0. `getList($org)`, `create($org, ...)` and
`getUserTeams()` already use the current routes.
