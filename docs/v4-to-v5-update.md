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

### Native parameter, return and property types

The public and protected methods now declare native parameter types, taken from their doc blocks: names, paths
and SHAs are `string`, IDs and page numbers are `int`, flags are `bool`. Code that calls the methods with
`declare(strict_types=1)` must pass matching types, e.g. `(int) $id` instead of a numeric string. Classes that extend
a package class and override one of its methods must declare compatible signatures.

Some doc blocks were wrong and have been corrected along the way, so the types follow GitHub's API:

* Gist IDs are `string` (they are hex strings such as `aa5a315d61ae9438b18d`).
* `Issues::create()` and `edit()` take the milestone as `int|string|null`.
* `Issues\Milestones::create()` and `edit()` take the title as `string`.
* `Pulls\Comments::create()` takes the position as `int`.
* `Repositories\Releases::edit()` takes `$body` as `string` and `$draft` and `$preRelease` as `bool`.
* `Data\Trees::create()` takes the tree as an array of entries.

Return types are declared where the method always returns the same type (`bool` for the `check…()`/`is…()`
methods, `string`, `void`), and for `AbstractGithubObject::fetchUrl(): Uri`, `processResponse(): mixed`,
`Github::getOption(): mixed` and `Github::setOption(): static`. Methods that return the decoded JSON response have
no return type, because it is an object, an array or `null` depending on the endpoint.

The properties `$options`, `$client`, `$package` and `$hookEvents` are typed; a subclass that redeclares one of them
must use the same type.
