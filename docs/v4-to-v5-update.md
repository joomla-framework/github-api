## Updating from v4 to v5

The following changes were made to the Github API package between v4 and v5.

### Wrappers for removed GitHub endpoints removed

The following methods and classes wrapped endpoints that GitHub has removed or replaced, so they could not work
against the live API. They were deprecated in 4.x and are removed.

| Removed | Use instead |
|---|---|
| `Package\Authorization::create()`, `delete()`, `deleteGrant()`, `edit()`, `get()`, `getGrant()`, `getList()`, `getListGrants()` (OAuth Authorizations API) | A personal access token or GitHub App token in the `gh.token` option |
| `Package\Authorization::revokeGrantForApplication()` | `DELETE /applications/{client_id}/grant` |
| `Package\Repositories\Downloads` and `$github->repositories->downloads` | `Package\Repositories\Releases` and its assets |
| `Package\Search::issues()`, `repositories()`, `users()`, `email()` (legacy search API) | `Package\Search::getIssues()`, `getRepositories()`, `getUsers()`; there is no email search |
| `Package\Activity\Watching::check()`, `watch()`, `unwatch()` | `getSubscription()`, `setSubscription()`, `deleteSubscription()` |
| `Package\Orgs\Teams::get()`, `edit()`, `delete()`, `getListMembers()`, `getListRepos()`, `checkRepo()`, `addRepo()`, `removeRepo()` (`/teams/{team_id}` routes) | The `…BySlug()` methods, e.g. `getBySlug($org, $slug)` |
| `Package\Orgs\Teams::isMember()`, `addMember()`, `removeMember()`, `getTeamMembership()`, `addTeamMembership()`, `removeTeamMembership()` | `getMembershipBySlug()`, `addMembershipBySlug()`, `removeMembershipBySlug()` |
| `Package\Orgs\Hooks::edit()` (created a new hook) | `Package\Orgs\Hooks::editHook($org, $id, ...)` |
| `Package\Users\Keys::edit()` (GitHub has no endpoint to update a key) | Delete the key and create a new one |

`Authorization::getRateLimit()`, `getAuthorizationLink()` and `requestToken()` are kept.
