# Dependency Graph

The Dependency Graph package covers the GitHub REST API for the dependency graph: the dependency review diff between two commits, the submission of dependency snapshots and the SBOM report export. It is reached as `$github->dependencyGraph`, e.g. `$github->dependencyGraph->compare('joomla', 'joomla-cms', '5.3-dev', '6.0-dev')`.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$github = new Github(new Registry(['gh.token' => 'your-token']));

// Dependency changes between two branches (requests GET .../compare/5.3-dev...6.0-dev)
$diff = $github->dependencyGraph->compare('joomla', 'joomla-cms', '5.3-dev', '6.0-dev');

// Request an SBOM and poll until the download URL is available
$report = $github->dependencyGraph->generateSbomReport('joomla', 'joomla-cms');
$uuid   = basename($report->sbom_url);

while (($url = $github->dependencyGraph->fetchSbomReport('joomla', 'joomla-cms', $uuid)) === '') {
    sleep(5);
}
```

## DependencyGraph (`$github->dependencyGraph`)

| Method | Endpoint |
| --- | --- |
| compare($owner, $repo, $base, $head, $filters) | GET /repos/{owner}/{repo}/dependency-graph/compare/{basehead} |
| createSnapshot($owner, $repo, $version, $job, $sha, $ref, $detector, $scanned, $options) | POST /repos/{owner}/{repo}/dependency-graph/snapshots |
| generateSbomReport($owner, $repo) | GET /repos/{owner}/{repo}/dependency-graph/sbom/generate-report |
| fetchSbomReport($owner, $repo, $sbomUuid) | GET /repos/{owner}/{repo}/dependency-graph/sbom/fetch-report/{sbom_uuid} |

## Notes

- `compare()` takes the base and head refs as two arguments; each is URL-encoded on its own and they are joined with `...`, as the `{basehead}` path segment requires.
- The deprecated `GET /repos/{owner}/{repo}/dependency-graph/sbom` (`dependency-graph/export-sbom`) is not covered; use `generateSbomReport()` and `fetchSbomReport()` instead.
