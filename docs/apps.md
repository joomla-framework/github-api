# Apps

The Apps package covers the [GitHub Apps API](https://docs.github.com/rest/apps): the authenticated app and its
installations, installation access tokens, app installations visible to a user, GitHub Marketplace listings,
OAuth application tokens and the app webhook. It is reached as `$github->apps`; the operations of the `apps`
section live on that class, the others in the sub-packages `$github->apps->installations`,
`$github->apps->marketplace`, `$github->apps->oauthApplications` and `$github->apps->webhooks`, for example
`$github->apps->installations->getListRepositories()`.

## Authentication

Most of these endpoints do not accept a normal user token. The library itself only knows two ways to
authenticate: `gh.token` (sent as `Authorization: token <value>`) and `api.username` / `api.password`
(HTTP Basic auth, used only when `gh.token` is not set). The credentials each operation needs are noted in the
method docblocks and summarised here.

| Credential | Operations | How to provide it |
| --- | --- | --- |
| JSON Web Token (JWT) of the app | `Apps`: getAuthenticated, getListInstallationRequests, getListInstallations, getInstallation, deleteInstallation, createInstallationAccessToken, suspendInstallation, unsuspendInstallation, getInstallationForOrg, getInstallationForRepo, getInstallationForUser; all of `Webhooks`; the `/marketplace_listing/*` methods of `Marketplace` | An `Authorization: Bearer <jwt>` header set on the HTTP client (see below). **Passing the JWT as `gh.token` does not work**: GitHub accepts the `token` scheme for ordinary tokens, but [for a JWT it requires `Bearer`](https://docs.github.com/rest/authentication/authenticating-to-the-rest-api). |
| Client ID and client secret (Basic auth) | `Apps`: scopeToken; all of `OauthApplications` | Set `api.username` to the client ID and `api.password` to the client secret, and do not set `gh.token`. |
| Installation access token | `Installations`: getListRepositories, revokeAccessToken | `gh.token` (GitHub accepts it with the `token` scheme). Create the token with `createInstallationAccessToken()`. |
| User access token / personal access token | `Installations`: getListForAuthenticatedUser, getListRepositoriesForAuthenticatedUser, addRepository, removeRepository; `Marketplace`: getListSubscriptionsForAuthenticatedUser(Stubbed) | `gh.token`. |
| None | `Apps`: getBySlug (public apps), createFromManifest (the temporary code is the credential) | — |

The JWT has to be signed by the caller with the app's private key (RS256, `iss` = client ID or app ID, at most
10 minutes valid); the library does not create it. Because the library never overwrites an `Authorization`
header that is already configured on the HTTP client, a Bearer header can be set through the `headers` option.
Use a separate `Github` object for the JWT calls, since the header then applies to every request of that client:

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

// Authenticate as the app (JWT) to create an installation access token
$appOptions = new Registry();
$appOptions->set('headers', ['Authorization' => 'Bearer ' . $jwt]);

$app   = new Github($appOptions);
$token = $app->apps->createInstallationAccessToken($installationId, ['repositories' => ['joomla-cms']]);

// Use the installation access token as a normal token
$options = new Registry();
$options->set('gh.token', $token->token);

$github = new Github($options);
$repos  = $github->apps->installations->getListRepositories();

// OAuth app endpoints use Basic auth with the client ID and secret
$oauthOptions = new Registry();
$oauthOptions->set('api.username', $clientId);
$oauthOptions->set('api.password', $clientSecret);

$check = (new Github($oauthOptions))->apps->oauthApplications->checkToken($clientId, $userToken);
```

When you pass your own `Joomla\Http\Http` client to `Github`, set the header on that client instead
(`new Http(['headers' => ['Authorization' => 'Bearer ' . $jwt]])`).

Optional request body fields are passed in `$options` and optional query parameters in `$filters`; the
docblock of each method lists the accepted keys. `Webhooks::getListDeliveries()` uses cursor-based pagination:
pass the `cursor` filter taken from the `Link` response header; only `$limit` (`per_page`) is used by GitHub.

## Apps (`$github->apps`)

| Method | Endpoint |
| --- | --- |
| getAuthenticated() | GET /app |
| createFromManifest($code) | POST /app-manifests/{code}/conversions |
| getListInstallationRequests($page, $limit) | GET /app/installation-requests |
| getListInstallations($filters, $page, $limit) | GET /app/installations |
| getInstallation($installationId) | GET /app/installations/{installation_id} |
| deleteInstallation($installationId) | DELETE /app/installations/{installation_id} |
| createInstallationAccessToken($installationId, $options) | POST /app/installations/{installation_id}/access_tokens |
| suspendInstallation($installationId) | PUT /app/installations/{installation_id}/suspended |
| unsuspendInstallation($installationId) | DELETE /app/installations/{installation_id}/suspended |
| scopeToken($clientId, $accessToken, $options) | POST /applications/{client_id}/token/scoped |
| getBySlug($appSlug) | GET /apps/{app_slug} |
| getInstallationForOrg($org) | GET /orgs/{org}/installation |
| getInstallationForRepo($owner, $repo) | GET /repos/{owner}/{repo}/installation |
| getInstallationForUser($username) | GET /users/{username}/installation |

## Installations (`$github->apps->installations`)

| Method | Endpoint |
| --- | --- |
| getListRepositories($page, $limit) | GET /installation/repositories |
| revokeAccessToken() | DELETE /installation/token |
| getListForAuthenticatedUser($page, $limit) | GET /user/installations |
| getListRepositoriesForAuthenticatedUser($installationId, $page, $limit) | GET /user/installations/{installation_id}/repositories |
| addRepository($installationId, $repositoryId) | PUT /user/installations/{installation_id}/repositories/{repository_id} |
| removeRepository($installationId, $repositoryId) | DELETE /user/installations/{installation_id}/repositories/{repository_id} |

## Marketplace (`$github->apps->marketplace`)

| Method | Endpoint |
| --- | --- |
| getSubscriptionPlanForAccount($accountId) | GET /marketplace_listing/accounts/{account_id} |
| getListPlans($page, $limit) | GET /marketplace_listing/plans |
| getListAccountsForPlan($planId, $filters, $page, $limit) | GET /marketplace_listing/plans/{plan_id}/accounts |
| getSubscriptionPlanForAccountStubbed($accountId) | GET /marketplace_listing/stubbed/accounts/{account_id} |
| getListPlansStubbed($page, $limit) | GET /marketplace_listing/stubbed/plans |
| getListAccountsForPlanStubbed($planId, $filters, $page, $limit) | GET /marketplace_listing/stubbed/plans/{plan_id}/accounts |
| getListSubscriptionsForAuthenticatedUser($page, $limit) | GET /user/marketplace_purchases |
| getListSubscriptionsForAuthenticatedUserStubbed($page, $limit) | GET /user/marketplace_purchases/stubbed |

The `*Stubbed` methods call the stubbed endpoints that return test data for apps that are not yet listed.

## OAuth applications (`$github->apps->oauthApplications`)

| Method | Endpoint |
| --- | --- |
| deleteAuthorization($clientId, $accessToken) | DELETE /applications/{client_id}/grant |
| checkToken($clientId, $accessToken) | POST /applications/{client_id}/token |
| resetToken($clientId, $accessToken) | PATCH /applications/{client_id}/token |
| deleteToken($clientId, $accessToken) | DELETE /applications/{client_id}/token |

The delete operations send the access token in the request body of the `DELETE` request, as GitHub requires.

## Webhooks (`$github->apps->webhooks`)

| Method | Endpoint |
| --- | --- |
| getConfig() | GET /app/hook/config |
| editConfig($options) | PATCH /app/hook/config |
| getListDeliveries($filters, $page, $limit) | GET /app/hook/deliveries |
| getDelivery($deliveryId) | GET /app/hook/deliveries/{delivery_id} |
| redeliver($deliveryId) | POST /app/hook/deliveries/{delivery_id}/attempts |
