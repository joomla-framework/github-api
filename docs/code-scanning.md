# Code Scanning

The Code Scanning package covers the GitHub REST API for code scanning: alerts and their instances, autofixes, analyses, SARIF uploads, the default setup, CodeQL databases, CodeQL variant analyses and the AI scan settings. It is reached as `$github->codeScanning`, with one sub-package per resource, e.g. `$github->codeScanning->alerts->getListForRepo('joomla', 'joomla-cms')`.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$github = new Github(new Registry(['gh.token' => 'your-token']));

// Open alerts on the main branch
$alerts = $github->codeScanning->alerts->getListForRepo('joomla', 'joomla-cms', ['state' => 'open', 'ref' => 'refs/heads/main']);

// Upload a SARIF file produced by a third-party tool
$upload = $github->codeScanning->sarifs->upload(
    'joomla',
    'joomla-cms',
    $commitSha,
    'refs/heads/main',
    base64_encode(gzencode(file_get_contents('results.sarif')))
);
$status = $github->codeScanning->sarifs->get('joomla', 'joomla-cms', $upload->id);
```

## Alerts (`$github->codeScanning->alerts`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $filters, $page, $limit) | GET /orgs/{org}/code-scanning/alerts |
| getListForRepo($owner, $repo, $filters, $page, $limit) | GET /repos/{owner}/{repo}/code-scanning/alerts |
| get($owner, $repo, $alertNumber) | GET /repos/{owner}/{repo}/code-scanning/alerts/{alert_number} |
| edit($owner, $repo, $alertNumber, $options) | PATCH /repos/{owner}/{repo}/code-scanning/alerts/{alert_number} |
| getInstances($owner, $repo, $alertNumber, $filters, $page, $limit) | GET /repos/{owner}/{repo}/code-scanning/alerts/{alert_number}/instances |

## Autofix (`$github->codeScanning->autofix`)

| Method | Endpoint |
| --- | --- |
| get($owner, $repo, $alertNumber) | GET /repos/{owner}/{repo}/code-scanning/alerts/{alert_number}/autofix |
| create($owner, $repo, $alertNumber) | POST /repos/{owner}/{repo}/code-scanning/alerts/{alert_number}/autofix |
| commit($owner, $repo, $alertNumber, $options) | POST /repos/{owner}/{repo}/code-scanning/alerts/{alert_number}/autofix/commits |

## Analyses (`$github->codeScanning->analyses`)

| Method | Endpoint |
| --- | --- |
| getList($owner, $repo, $filters, $page, $limit) | GET /repos/{owner}/{repo}/code-scanning/analyses |
| get($owner, $repo, $analysisId) | GET /repos/{owner}/{repo}/code-scanning/analyses/{analysis_id} |
| delete($owner, $repo, $analysisId, $filters) | DELETE /repos/{owner}/{repo}/code-scanning/analyses/{analysis_id} |

## Sarifs (`$github->codeScanning->sarifs`)

| Method | Endpoint |
| --- | --- |
| upload($owner, $repo, $commitSha, $ref, $sarif, $options) | POST /repos/{owner}/{repo}/code-scanning/sarifs |
| get($owner, $repo, $sarifId) | GET /repos/{owner}/{repo}/code-scanning/sarifs/{sarif_id} |

## DefaultSetup (`$github->codeScanning->defaultSetup`)

| Method | Endpoint |
| --- | --- |
| get($owner, $repo) | GET /repos/{owner}/{repo}/code-scanning/default-setup |
| edit($owner, $repo, $options) | PATCH /repos/{owner}/{repo}/code-scanning/default-setup |

## CodeqlDatabases (`$github->codeScanning->codeqlDatabases`)

| Method | Endpoint |
| --- | --- |
| getList($owner, $repo) | GET /repos/{owner}/{repo}/code-scanning/codeql/databases |
| get($owner, $repo, $language) | GET /repos/{owner}/{repo}/code-scanning/codeql/databases/{language} |
| delete($owner, $repo, $language) | DELETE /repos/{owner}/{repo}/code-scanning/codeql/databases/{language} |

## VariantAnalyses (`$github->codeScanning->variantAnalyses`)

| Method | Endpoint |
| --- | --- |
| create($owner, $repo, $language, $queryPack, $options) | POST /repos/{owner}/{repo}/code-scanning/codeql/variant-analyses |
| get($owner, $repo, $variantAnalysisId) | GET /repos/{owner}/{repo}/code-scanning/codeql/variant-analyses/{codeql_variant_analysis_id} |
| getRepoTask($owner, $repo, $variantAnalysisId, $repoOwner, $repoName) | GET /repos/{owner}/{repo}/code-scanning/codeql/variant-analyses/{codeql_variant_analysis_id}/repos/{repo_owner}/{repo_name} |

## AiScan (`$github->codeScanning->aiScan`)

| Method | Endpoint |
| --- | --- |
| getForOrg($org) | GET /orgs/{org}/code-scanning/ai-scan |
| editForOrg($org, $options) | PATCH /orgs/{org}/code-scanning/ai-scan |
| getForRepo($owner, $repo) | GET /repos/{owner}/{repo}/code-scanning/ai-scan |
| editForRepo($owner, $repo, $options) | PATCH /repos/{owner}/{repo}/code-scanning/ai-scan |

## Notes

- `Analyses::get()` and `CodeqlDatabases::get()` return the JSON metadata. The SARIF (`application/sarif+json`) and database (`application/zip`) downloads need a different `Accept` header, which this library does not set per request, so they are not offered as separate methods.
- The enterprise endpoints (`/enterprises/...`) are not covered.
