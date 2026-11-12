# Codespaces

The `Codespaces` package covers the [GitHub Codespaces REST API](https://docs.github.com/rest/codespaces): the
codespaces of the authenticated user (list, create, start, stop, export, publish, ...), the codespaces of an
organization, the available machine types, and codespaces secrets at user, repository and organization level.
It is reached through `$github->codespaces`; the sub-packages are reached as properties of it, for example
`$github->codespaces->repositorySecrets->getList('joomla', 'joomla-cms')`.

Codespace and secret names are URL-encoded by the package, so pass them as they are.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$options = new Registry();
$options->set('gh.token', 'your-token');

$github = new Github($options);

// List the codespaces of the authenticated user for one repository
$codespaces = $github->codespaces->getList(['repository_id' => 1296269]);

// Create a codespace on the default branch of a repository and stop it again
$codespace = $github->codespaces->createForRepo('joomla', 'joomla-cms', ['machine' => 'standardLinux32gb']);
$github->codespaces->stop($codespace->name);

// Store a repository secret for codespaces (the value must be encrypted with the repository public key)
$key = $github->codespaces->repositorySecrets->getPublicKey('joomla', 'joomla-cms');
$github->codespaces->repositorySecrets->createOrUpdate(
    'joomla',
    'joomla-cms',
    'MY_SECRET',
    ['encrypted_value' => $encryptedValue, 'key_id' => $key->key_id]
);
```

`$options` holds optional request-body fields and `$filters` optional query parameters; the accepted keys are
listed in each method's docblock. Paginated methods take `$page` and `$limit` (items per page) as last arguments.
Methods answered with `204 No Content` return nothing; `createOrUpdate()` returns `null` when an existing secret
was updated (204) and the response object when it was created (201).

### Codespaces (`$github->codespaces`)

| Method | Endpoint |
| --- | --- |
| getList($filters, $page, $limit) | GET /user/codespaces |
| create($repositoryId, $options) | POST /user/codespaces |
| get($codespaceName) | GET /user/codespaces/{codespace_name} |
| edit($codespaceName, $options) | PATCH /user/codespaces/{codespace_name} |
| delete($codespaceName) | DELETE /user/codespaces/{codespace_name} |
| export($codespaceName) | POST /user/codespaces/{codespace_name}/exports |
| getExport($codespaceName, $exportId) | GET /user/codespaces/{codespace_name}/exports/{export_id} |
| publish($codespaceName, $options) | POST /user/codespaces/{codespace_name}/publish |
| start($codespaceName) | POST /user/codespaces/{codespace_name}/start |
| stop($codespaceName) | POST /user/codespaces/{codespace_name}/stop |
| getListForRepo($owner, $repo, $page, $limit) | GET /repos/{owner}/{repo}/codespaces |
| createForRepo($owner, $repo, $options) | POST /repos/{owner}/{repo}/codespaces |
| getListDevcontainers($owner, $repo, $page, $limit) | GET /repos/{owner}/{repo}/codespaces/devcontainers |
| getDefaultAttributes($owner, $repo, $filters) | GET /repos/{owner}/{repo}/codespaces/new |
| checkPermissions($owner, $repo, $ref, $devcontainerPath) | GET /repos/{owner}/{repo}/codespaces/permissions_check |
| createForPull($owner, $repo, $pullNumber, $options) | POST /repos/{owner}/{repo}/pulls/{pull_number}/codespaces |

### Codespaces\Machines (`$github->codespaces->machines`)

| Method | Endpoint |
| --- | --- |
| getListForRepo($owner, $repo, $filters) | GET /repos/{owner}/{repo}/codespaces/machines |
| getListForCodespace($codespaceName) | GET /user/codespaces/{codespace_name}/machines |

### Codespaces\Organizations (`$github->codespaces->organizations`)

| Method | Endpoint |
| --- | --- |
| getList($org, $page, $limit) | GET /orgs/{org}/codespaces |
| getListForUser($org, $username, $page, $limit) | GET /orgs/{org}/members/{username}/codespaces |
| delete($org, $username, $codespaceName) | DELETE /orgs/{org}/members/{username}/codespaces/{codespace_name} |
| stop($org, $username, $codespaceName) | POST /orgs/{org}/members/{username}/codespaces/{codespace_name}/stop |

### Codespaces\OrganizationSecrets (`$github->codespaces->organizationSecrets`)

| Method | Endpoint |
| --- | --- |
| getList($org, $page, $limit) | GET /orgs/{org}/codespaces/secrets |
| getPublicKey($org) | GET /orgs/{org}/codespaces/secrets/public-key |
| get($org, $secretName) | GET /orgs/{org}/codespaces/secrets/{secret_name} |
| createOrUpdate($org, $secretName, $visibility, $options) | PUT /orgs/{org}/codespaces/secrets/{secret_name} |
| delete($org, $secretName) | DELETE /orgs/{org}/codespaces/secrets/{secret_name} |
| getListSelectedRepositories($org, $secretName, $page, $limit) | GET /orgs/{org}/codespaces/secrets/{secret_name}/repositories |
| setSelectedRepositories($org, $secretName, $selectedRepositoryIds) | PUT /orgs/{org}/codespaces/secrets/{secret_name}/repositories |
| addSelectedRepository($org, $secretName, $repositoryId) | PUT /orgs/{org}/codespaces/secrets/{secret_name}/repositories/{repository_id} |
| removeSelectedRepository($org, $secretName, $repositoryId) | DELETE /orgs/{org}/codespaces/secrets/{secret_name}/repositories/{repository_id} |

### Codespaces\RepositorySecrets (`$github->codespaces->repositorySecrets`)

| Method | Endpoint |
| --- | --- |
| getList($owner, $repo, $page, $limit) | GET /repos/{owner}/{repo}/codespaces/secrets |
| getPublicKey($owner, $repo) | GET /repos/{owner}/{repo}/codespaces/secrets/public-key |
| get($owner, $repo, $secretName) | GET /repos/{owner}/{repo}/codespaces/secrets/{secret_name} |
| createOrUpdate($owner, $repo, $secretName, $options) | PUT /repos/{owner}/{repo}/codespaces/secrets/{secret_name} |
| delete($owner, $repo, $secretName) | DELETE /repos/{owner}/{repo}/codespaces/secrets/{secret_name} |

### Codespaces\Secrets (`$github->codespaces->secrets`)

| Method | Endpoint |
| --- | --- |
| getList($page, $limit) | GET /user/codespaces/secrets |
| getPublicKey() | GET /user/codespaces/secrets/public-key |
| get($secretName) | GET /user/codespaces/secrets/{secret_name} |
| createOrUpdate($secretName, $keyId, $options) | PUT /user/codespaces/secrets/{secret_name} |
| delete($secretName) | DELETE /user/codespaces/secrets/{secret_name} |
| getListSelectedRepositories($secretName) | GET /user/codespaces/secrets/{secret_name}/repositories |
| setSelectedRepositories($secretName, $selectedRepositoryIds) | PUT /user/codespaces/secrets/{secret_name}/repositories |
| addSelectedRepository($secretName, $repositoryId) | PUT /user/codespaces/secrets/{secret_name}/repositories/{repository_id} |
| removeSelectedRepository($secretName, $repositoryId) | DELETE /user/codespaces/secrets/{secret_name}/repositories/{repository_id} |

## Notes

* `create()` sends the first body variant of `POST /user/codespaces` (`repository_id` plus optional fields).
  To create a codespace from a pull request (the second variant) use `createForPull()`.
* The deprecated organization access operations (`PUT /orgs/{org}/codespaces/access` and
  `POST|DELETE /orgs/{org}/codespaces/access/selected_users`) are not included.
