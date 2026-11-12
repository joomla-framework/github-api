# Checks

The Checks package covers the [GitHub Checks API](https://docs.github.com/rest/checks): check runs and check suites
reported against a commit. It is reached as `$github->checks`, which is a container for the sub-packages
`$github->checks->runs` and `$github->checks->suites`, for example
`$github->checks->runs->getListForRef('joomla', 'joomla-cms', '5.3-dev')`.

Reading check runs and suites works with any token that can read the repository. Creating and updating check runs,
creating check suites, changing the check suite preferences and rerequesting runs or suites are only allowed for
GitHub Apps, so these calls need an installation access token of a GitHub App (passed as `gh.token`).

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$options = new Registry();
$options->set('gh.token', $installationToken);

$github = new Github($options);

// Start a check run for a commit and complete it later
$run = $github->checks->runs->create('joomla', 'joomla-cms', 'code-style', $sha, ['status' => 'in_progress']);

$github->checks->runs->edit(
    'joomla',
    'joomla-cms',
    $run->id,
    ['status' => 'completed', 'conclusion' => 'success', 'output' => ['title' => 'Code style', 'summary' => 'No issues']]
);

// List the latest check runs for a branch
$runs = $github->checks->runs->getListForRef('joomla', 'joomla-cms', '5.3-dev', ['filter' => 'latest']);
```

Optional request body fields are passed in `$options` and optional query parameters in `$filters`; the
docblock of each method lists the accepted keys. Git references are URL-encoded, so branch names containing
`/` can be passed as they are.

## Runs (`$github->checks->runs`)

| Method | Endpoint |
| --- | --- |
| create($owner, $repo, $name, $headSha, $options) | POST /repos/{owner}/{repo}/check-runs |
| get($owner, $repo, $checkRunId) | GET /repos/{owner}/{repo}/check-runs/{check_run_id} |
| edit($owner, $repo, $checkRunId, $options) | PATCH /repos/{owner}/{repo}/check-runs/{check_run_id} |
| getListAnnotations($owner, $repo, $checkRunId, $page, $limit) | GET /repos/{owner}/{repo}/check-runs/{check_run_id}/annotations |
| rerequest($owner, $repo, $checkRunId) | POST /repos/{owner}/{repo}/check-runs/{check_run_id}/rerequest |
| getListForSuite($owner, $repo, $checkSuiteId, $filters, $page, $limit) | GET /repos/{owner}/{repo}/check-suites/{check_suite_id}/check-runs |
| getListForRef($owner, $repo, $ref, $filters, $page, $limit) | GET /repos/{owner}/{repo}/commits/{ref}/check-runs |

## Suites (`$github->checks->suites`)

| Method | Endpoint |
| --- | --- |
| create($owner, $repo, $headSha) | POST /repos/{owner}/{repo}/check-suites |
| setPreferences($owner, $repo, $options) | PATCH /repos/{owner}/{repo}/check-suites/preferences |
| get($owner, $repo, $checkSuiteId) | GET /repos/{owner}/{repo}/check-suites/{check_suite_id} |
| rerequest($owner, $repo, $checkSuiteId) | POST /repos/{owner}/{repo}/check-suites/{check_suite_id}/rerequest |
| getListForRef($owner, $repo, $ref, $filters, $page, $limit) | GET /repos/{owner}/{repo}/commits/{ref}/check-suites |
