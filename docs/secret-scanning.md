# Secret Scanning

The Secret Scanning package covers the GitHub REST API for secret scanning: alerts and their locations, push protection bypasses and the scan history on `$github->secretScanning` itself, custom patterns on `$github->secretScanning->customPatterns` and the organization push protection pattern configurations on `$github->secretScanning->pushProtection`, e.g. `$github->secretScanning->getListForRepo('joomla', 'joomla-cms')`.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$github = new Github(new Registry(['gh.token' => 'your-token']));

// Open alerts of an organization, secrets hidden
$alerts = $github->secretScanning->getListForOrg('joomla', ['state' => 'open', 'hide_secret' => true]);

// Resolve an alert as revoked
$github->secretScanning->edit('joomla', 'joomla-cms', 42, ['state' => 'resolved', 'resolution' => 'revoked']);
```

## SecretScanning (`$github->secretScanning`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $filters, $page, $limit) | GET /orgs/{org}/secret-scanning/alerts |
| getListForRepo($owner, $repo, $filters, $page, $limit) | GET /repos/{owner}/{repo}/secret-scanning/alerts |
| get($owner, $repo, $alertNumber, $filters) | GET /repos/{owner}/{repo}/secret-scanning/alerts/{alert_number} |
| edit($owner, $repo, $alertNumber, $options) | PATCH /repos/{owner}/{repo}/secret-scanning/alerts/{alert_number} |
| getLocations($owner, $repo, $alertNumber, $page, $limit) | GET /repos/{owner}/{repo}/secret-scanning/alerts/{alert_number}/locations |
| createPushProtectionBypass($owner, $repo, $reason, $placeholderId) | POST /repos/{owner}/{repo}/secret-scanning/push-protection-bypasses |
| getScanHistory($owner, $repo) | GET /repos/{owner}/{repo}/secret-scanning/scan-history |

## CustomPatterns (`$github->secretScanning->customPatterns`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $filters) | GET /orgs/{org}/secret-scanning/custom-patterns |
| createForOrg($org, $patterns) | POST /orgs/{org}/secret-scanning/custom-patterns |
| deleteForOrg($org, $patterns, $options) | DELETE /orgs/{org}/secret-scanning/custom-patterns |
| editForOrg($org, $patternId, $customPatternVersion, $options) | PATCH /orgs/{org}/secret-scanning/custom-patterns/{pattern_id} |
| getListForRepo($owner, $repo, $filters) | GET /repos/{owner}/{repo}/secret-scanning/custom-patterns |
| createForRepo($owner, $repo, $patterns) | POST /repos/{owner}/{repo}/secret-scanning/custom-patterns |
| deleteForRepo($owner, $repo, $patterns, $options) | DELETE /repos/{owner}/{repo}/secret-scanning/custom-patterns |
| editForRepo($owner, $repo, $patternId, $customPatternVersion, $options) | PATCH /repos/{owner}/{repo}/secret-scanning/custom-patterns/{pattern_id} |

## PushProtection (`$github->secretScanning->pushProtection`)

| Method | Endpoint |
| --- | --- |
| getPatternConfigurations($org) | GET /orgs/{org}/secret-scanning/pattern-configurations |
| editPatternConfigurations($org, $options) | PATCH /orgs/{org}/secret-scanning/pattern-configurations |

## Notes

- The custom pattern lists are cursor-paginated only: pass `before` / `after` in `$filters`.
- The enterprise endpoints (`/enterprises/...`) are not covered.
