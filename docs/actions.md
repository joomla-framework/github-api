# Actions

The Actions package covers the GitHub Actions REST API: workflows, workflow runs and jobs, artifacts, caches,
concurrency groups, secrets and variables, self-hosted and GitHub-hosted runners, runner groups, OpenID Connect
subject claim customisation, permissions and policies. `$github->actions` is a container; each part of the API is a
sub-package reached through it, for example `$github->actions->workflows->getList('joomla', 'joomla-cms')`.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$github = new Github(new Registry(['gh.token' => 'your-token']));

// List the workflow runs of a repository, filtered by branch and status, 50 per page.
$runs = $github->actions->runs->getListForRepo('joomla', 'joomla-cms', ['branch' => '5.4-dev', 'status' => 'failure'], 1, 50);

// Re-run the failed jobs of one run with debug logging.
$github->actions->runs->rerunFailedJobs('joomla', 'joomla-cms', $runs->workflow_runs[0]->id, ['enable_debug_logging' => true]);

// Get the download URL of the run's logs (GitHub answers with a redirect).
$url = $github->actions->runs->downloadLogs('joomla', 'joomla-cms', $runs->workflow_runs[0]->id);
```

Conventions used by all classes:

- `$options` holds optional request-body fields, `$filters` optional query parameters (booleans are sent as
  `true`/`false`); `$page` and `$limit` select the page and the page size of paginated lists.
- Free-form path segments (secret, variable, environment, label and concurrency group names, workflow file names,
  versions) are URL-encoded by the methods; pass them unencoded.
- Methods for operations that answer `204 No Content` return nothing. The `download*` methods return the URL from the
  `Location` header of GitHub's `302` redirect instead of following it; the URL is short-lived.
- The concurrency group lists are cursor-paginated: they take `$limit` (per page) and the cursor parameters (`after`, plus `before` for a run)
  as filters, but no `$page`.
- `Secrets::createOrUpdate*()` expect the value already encrypted with the public key returned by the matching
  `getPublicKey*()` method (LibSodium sealed box); this package does not encrypt.

Enterprise-level endpoints (`/enterprises/...`) and operations GitHub marks as deprecated are not included.

### Artifacts (`$github->actions->artifacts`)

| Method | Endpoint |
| --- | --- |
| `getListForRepo($owner, $repo, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/artifacts` |
| `getListForRun($owner, $repo, $runId, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/artifacts` |
| `get($owner, $repo, $artifactId)` | `GET /repos/{owner}/{repo}/actions/artifacts/{artifact_id}` |
| `delete($owner, $repo, $artifactId)` | `DELETE /repos/{owner}/{repo}/actions/artifacts/{artifact_id}` |
| `download($owner, $repo, $artifactId, $archiveFormat)` | `GET /repos/{owner}/{repo}/actions/artifacts/{artifact_id}/{archive_format}` |

### Cache (`$github->actions->cache`)

| Method | Endpoint |
| --- | --- |
| `getRetentionLimitForOrg($org)` | `GET /organizations/{org}/actions/cache/retention-limit` |
| `setRetentionLimitForOrg($org, $options)` | `PUT /organizations/{org}/actions/cache/retention-limit` |
| `getStorageLimitForOrg($org)` | `GET /organizations/{org}/actions/cache/storage-limit` |
| `setStorageLimitForOrg($org, $options)` | `PUT /organizations/{org}/actions/cache/storage-limit` |
| `getUsageForOrg($org)` | `GET /orgs/{org}/actions/cache/usage` |
| `getListUsageByRepoForOrg($org, $page, $limit)` | `GET /orgs/{org}/actions/cache/usage-by-repository` |
| `getRetentionLimitForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/cache/retention-limit` |
| `setRetentionLimitForRepo($owner, $repo, $options)` | `PUT /repos/{owner}/{repo}/actions/cache/retention-limit` |
| `getStorageLimitForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/cache/storage-limit` |
| `setStorageLimitForRepo($owner, $repo, $options)` | `PUT /repos/{owner}/{repo}/actions/cache/storage-limit` |
| `getUsageForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/cache/usage` |
| `getListForRepo($owner, $repo, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/caches` |
| `deleteByKeyForRepo($owner, $repo, $key, $filters)` | `DELETE /repos/{owner}/{repo}/actions/caches` |
| `deleteForRepo($owner, $repo, $cacheId)` | `DELETE /repos/{owner}/{repo}/actions/caches/{cache_id}` |

### ConcurrencyGroups (`$github->actions->concurrencyGroups`)

| Method | Endpoint |
| --- | --- |
| `getListForRepo($owner, $repo, $filters, $limit)` | `GET /repos/{owner}/{repo}/actions/concurrency_groups` |
| `get($owner, $repo, $concurrencyGroupName, $filters)` | `GET /repos/{owner}/{repo}/actions/concurrency_groups/{concurrency_group_name}` |
| `getListForRun($owner, $repo, $runId, $filters, $limit)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/concurrency_groups` |

### HostedRunners (`$github->actions->hostedRunners`)

| Method | Endpoint |
| --- | --- |
| `getList($org, $page, $limit)` | `GET /orgs/{org}/actions/hosted-runners` |
| `create($org, $name, $image, $size, $runnerGroupId, $options)` | `POST /orgs/{org}/actions/hosted-runners` |
| `get($org, $hostedRunnerId)` | `GET /orgs/{org}/actions/hosted-runners/{hosted_runner_id}` |
| `edit($org, $hostedRunnerId, $options)` | `PATCH /orgs/{org}/actions/hosted-runners/{hosted_runner_id}` |
| `delete($org, $hostedRunnerId)` | `DELETE /orgs/{org}/actions/hosted-runners/{hosted_runner_id}` |
| `getListCustomImages($org)` | `GET /orgs/{org}/actions/hosted-runners/images/custom` |
| `getCustomImage($org, $imageDefinitionId)` | `GET /orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}` |
| `deleteCustomImage($org, $imageDefinitionId)` | `DELETE /orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}` |
| `getListCustomImageVersions($org, $imageDefinitionId)` | `GET /orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}/versions` |
| `getCustomImageVersion($org, $imageDefinitionId, $version)` | `GET /orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}/versions/{version}` |
| `deleteCustomImageVersion($org, $imageDefinitionId, $version)` | `DELETE /orgs/{org}/actions/hosted-runners/images/custom/{image_definition_id}/versions/{version}` |
| `getGithubOwnedImages($org)` | `GET /orgs/{org}/actions/hosted-runners/images/github-owned` |
| `getPartnerImages($org)` | `GET /orgs/{org}/actions/hosted-runners/images/partner` |
| `getLimits($org)` | `GET /orgs/{org}/actions/hosted-runners/limits` |
| `getMachineSizes($org)` | `GET /orgs/{org}/actions/hosted-runners/machine-sizes` |
| `getPlatforms($org)` | `GET /orgs/{org}/actions/hosted-runners/platforms` |

### Oidc (`$github->actions->oidc`)

| Method | Endpoint |
| --- | --- |
| `getListCustomPropertyInclusionsForOrg($org)` | `GET /orgs/{org}/actions/oidc/customization/properties/repo` |
| `createCustomPropertyInclusionForOrg($org, $customPropertyName)` | `POST /orgs/{org}/actions/oidc/customization/properties/repo` |
| `deleteCustomPropertyInclusionForOrg($org, $customPropertyName)` | `DELETE /orgs/{org}/actions/oidc/customization/properties/repo/{custom_property_name}` |
| `getCustomSubClaimForOrg($org)` | `GET /orgs/{org}/actions/oidc/customization/sub` |
| `editCustomSubClaimForOrg($org, $options)` | `PUT /orgs/{org}/actions/oidc/customization/sub` |
| `getCustomSubClaimForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/oidc/customization/sub` |
| `setCustomSubClaimForRepo($owner, $repo, $useDefault, $options)` | `PUT /repos/{owner}/{repo}/actions/oidc/customization/sub` |

### Permissions (`$github->actions->permissions`)

| Method | Endpoint |
| --- | --- |
| `getForOrg($org)` | `GET /orgs/{org}/actions/permissions` |
| `setForOrg($org, $enabledRepositories, $options)` | `PUT /orgs/{org}/actions/permissions` |
| `getArtifactAndLogRetentionForOrg($org)` | `GET /orgs/{org}/actions/permissions/artifact-and-log-retention` |
| `setArtifactAndLogRetentionForOrg($org, $days)` | `PUT /orgs/{org}/actions/permissions/artifact-and-log-retention` |
| `getForkPrContributorApprovalForOrg($org)` | `GET /orgs/{org}/actions/permissions/fork-pr-contributor-approval` |
| `setForkPrContributorApprovalForOrg($org, $approvalPolicy)` | `PUT /orgs/{org}/actions/permissions/fork-pr-contributor-approval` |
| `getPrivateRepoForkPrWorkflowsForOrg($org)` | `GET /orgs/{org}/actions/permissions/fork-pr-workflows-private-repos` |
| `setPrivateRepoForkPrWorkflowsForOrg($org, $runWorkflowsFromForkPullRequests, $options)` | `PUT /orgs/{org}/actions/permissions/fork-pr-workflows-private-repos` |
| `getListSelectedRepositoriesForOrg($org, $page, $limit)` | `GET /orgs/{org}/actions/permissions/repositories` |
| `setSelectedRepositoriesForOrg($org, $selectedRepositoryIds)` | `PUT /orgs/{org}/actions/permissions/repositories` |
| `enableRepositoryForOrg($org, $repositoryId)` | `PUT /orgs/{org}/actions/permissions/repositories/{repository_id}` |
| `disableRepositoryForOrg($org, $repositoryId)` | `DELETE /orgs/{org}/actions/permissions/repositories/{repository_id}` |
| `getAllowedActionsForOrg($org)` | `GET /orgs/{org}/actions/permissions/selected-actions` |
| `setAllowedActionsForOrg($org, $options)` | `PUT /orgs/{org}/actions/permissions/selected-actions` |
| `getSelfHostedRunnersForOrg($org)` | `GET /orgs/{org}/actions/permissions/self-hosted-runners` |
| `setSelfHostedRunnersForOrg($org, $enabledRepositories)` | `PUT /orgs/{org}/actions/permissions/self-hosted-runners` |
| `getListSelfHostedRunnersRepositoriesForOrg($org, $page, $limit)` | `GET /orgs/{org}/actions/permissions/self-hosted-runners/repositories` |
| `setSelfHostedRunnersRepositoriesForOrg($org, $selectedRepositoryIds)` | `PUT /orgs/{org}/actions/permissions/self-hosted-runners/repositories` |
| `enableSelfHostedRunnersRepositoryForOrg($org, $repositoryId)` | `PUT /orgs/{org}/actions/permissions/self-hosted-runners/repositories/{repository_id}` |
| `disableSelfHostedRunnersRepositoryForOrg($org, $repositoryId)` | `DELETE /orgs/{org}/actions/permissions/self-hosted-runners/repositories/{repository_id}` |
| `getDefaultWorkflowPermissionsForOrg($org)` | `GET /orgs/{org}/actions/permissions/workflow` |
| `setDefaultWorkflowPermissionsForOrg($org, $options)` | `PUT /orgs/{org}/actions/permissions/workflow` |
| `getForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/permissions` |
| `setForRepo($owner, $repo, $enabled, $options)` | `PUT /repos/{owner}/{repo}/actions/permissions` |
| `getWorkflowAccessForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/permissions/access` |
| `setWorkflowAccessForRepo($owner, $repo, $accessLevel)` | `PUT /repos/{owner}/{repo}/actions/permissions/access` |
| `getArtifactAndLogRetentionForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/permissions/artifact-and-log-retention` |
| `setArtifactAndLogRetentionForRepo($owner, $repo, $days)` | `PUT /repos/{owner}/{repo}/actions/permissions/artifact-and-log-retention` |
| `getForkPrContributorApprovalForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/permissions/fork-pr-contributor-approval` |
| `setForkPrContributorApprovalForRepo($owner, $repo, $approvalPolicy)` | `PUT /repos/{owner}/{repo}/actions/permissions/fork-pr-contributor-approval` |
| `getPrivateRepoForkPrWorkflowsForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/permissions/fork-pr-workflows-private-repos` |
| `setPrivateRepoForkPrWorkflowsForRepo($owner, $repo, $runWorkflowsFromForkPullRequests, $options)` | `PUT /repos/{owner}/{repo}/actions/permissions/fork-pr-workflows-private-repos` |
| `getAllowedActionsForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/permissions/selected-actions` |
| `setAllowedActionsForRepo($owner, $repo, $options)` | `PUT /repos/{owner}/{repo}/actions/permissions/selected-actions` |
| `getDefaultWorkflowPermissionsForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/permissions/workflow` |
| `setDefaultWorkflowPermissionsForRepo($owner, $repo, $options)` | `PUT /repos/{owner}/{repo}/actions/permissions/workflow` |

### Policies (`$github->actions->policies`)

| Method | Endpoint |
| --- | --- |
| `getListForOrg($org, $filters, $page, $limit)` | `GET /orgs/{org}/actions/policies` |
| `createForOrg($org, $name, $enforcement, $options)` | `POST /orgs/{org}/actions/policies` |
| `getForOrg($org, $policyId)` | `GET /orgs/{org}/actions/policies/{policy_id}` |
| `editForOrg($org, $policyId, $options)` | `PUT /orgs/{org}/actions/policies/{policy_id}` |
| `deleteForOrg($org, $policyId)` | `DELETE /orgs/{org}/actions/policies/{policy_id}` |
| `getListForRepo($owner, $repo, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/policies` |
| `createForRepo($owner, $repo, $name, $enforcement, $options)` | `POST /repos/{owner}/{repo}/actions/policies` |
| `getForRepo($owner, $repo, $policyId)` | `GET /repos/{owner}/{repo}/actions/policies/{policy_id}` |
| `editForRepo($owner, $repo, $policyId, $options)` | `PUT /repos/{owner}/{repo}/actions/policies/{policy_id}` |
| `deleteForRepo($owner, $repo, $policyId)` | `DELETE /repos/{owner}/{repo}/actions/policies/{policy_id}` |

### Secrets (`$github->actions->secrets`)

| Method | Endpoint |
| --- | --- |
| `getListForOrg($org, $page, $limit)` | `GET /orgs/{org}/actions/secrets` |
| `getPublicKeyForOrg($org)` | `GET /orgs/{org}/actions/secrets/public-key` |
| `getForOrg($org, $secretName)` | `GET /orgs/{org}/actions/secrets/{secret_name}` |
| `createOrUpdateForOrg($org, $secretName, $encryptedValue, $keyId, $visibility, $options)` | `PUT /orgs/{org}/actions/secrets/{secret_name}` |
| `deleteForOrg($org, $secretName)` | `DELETE /orgs/{org}/actions/secrets/{secret_name}` |
| `getListSelectedRepositoriesForOrg($org, $secretName, $page, $limit)` | `GET /orgs/{org}/actions/secrets/{secret_name}/repositories` |
| `setSelectedRepositoriesForOrg($org, $secretName, $selectedRepositoryIds)` | `PUT /orgs/{org}/actions/secrets/{secret_name}/repositories` |
| `addSelectedRepositoryForOrg($org, $secretName, $repositoryId)` | `PUT /orgs/{org}/actions/secrets/{secret_name}/repositories/{repository_id}` |
| `removeSelectedRepositoryForOrg($org, $secretName, $repositoryId)` | `DELETE /orgs/{org}/actions/secrets/{secret_name}/repositories/{repository_id}` |
| `getListOrganizationSecretsForRepo($owner, $repo, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/organization-secrets` |
| `getListForRepo($owner, $repo, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/secrets` |
| `getPublicKeyForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/secrets/public-key` |
| `getForRepo($owner, $repo, $secretName)` | `GET /repos/{owner}/{repo}/actions/secrets/{secret_name}` |
| `createOrUpdateForRepo($owner, $repo, $secretName, $encryptedValue, $keyId)` | `PUT /repos/{owner}/{repo}/actions/secrets/{secret_name}` |
| `deleteForRepo($owner, $repo, $secretName)` | `DELETE /repos/{owner}/{repo}/actions/secrets/{secret_name}` |
| `getListForEnvironment($owner, $repo, $environmentName, $page, $limit)` | `GET /repos/{owner}/{repo}/environments/{environment_name}/secrets` |
| `getPublicKeyForEnvironment($owner, $repo, $environmentName)` | `GET /repos/{owner}/{repo}/environments/{environment_name}/secrets/public-key` |
| `getForEnvironment($owner, $repo, $environmentName, $secretName)` | `GET /repos/{owner}/{repo}/environments/{environment_name}/secrets/{secret_name}` |
| `createOrUpdateForEnvironment($owner, $repo, $environmentName, $secretName, $encryptedValue, $keyId)` | `PUT /repos/{owner}/{repo}/environments/{environment_name}/secrets/{secret_name}` |
| `deleteForEnvironment($owner, $repo, $environmentName, $secretName)` | `DELETE /repos/{owner}/{repo}/environments/{environment_name}/secrets/{secret_name}` |

### Variables (`$github->actions->variables`)

| Method | Endpoint |
| --- | --- |
| `getListForOrg($org, $page, $limit)` | `GET /orgs/{org}/actions/variables` |
| `createForOrg($org, $name, $value, $visibility, $options)` | `POST /orgs/{org}/actions/variables` |
| `getForOrg($org, $name)` | `GET /orgs/{org}/actions/variables/{name}` |
| `editForOrg($org, $name, $options)` | `PATCH /orgs/{org}/actions/variables/{name}` |
| `deleteForOrg($org, $name)` | `DELETE /orgs/{org}/actions/variables/{name}` |
| `getListSelectedRepositoriesForOrg($org, $name, $page, $limit)` | `GET /orgs/{org}/actions/variables/{name}/repositories` |
| `setSelectedRepositoriesForOrg($org, $name, $selectedRepositoryIds)` | `PUT /orgs/{org}/actions/variables/{name}/repositories` |
| `addSelectedRepositoryForOrg($org, $name, $repositoryId)` | `PUT /orgs/{org}/actions/variables/{name}/repositories/{repository_id}` |
| `removeSelectedRepositoryForOrg($org, $name, $repositoryId)` | `DELETE /orgs/{org}/actions/variables/{name}/repositories/{repository_id}` |
| `getListOrganizationVariablesForRepo($owner, $repo, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/organization-variables` |
| `getListForRepo($owner, $repo, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/variables` |
| `createForRepo($owner, $repo, $name, $value)` | `POST /repos/{owner}/{repo}/actions/variables` |
| `getForRepo($owner, $repo, $name)` | `GET /repos/{owner}/{repo}/actions/variables/{name}` |
| `editForRepo($owner, $repo, $name, $options)` | `PATCH /repos/{owner}/{repo}/actions/variables/{name}` |
| `deleteForRepo($owner, $repo, $name)` | `DELETE /repos/{owner}/{repo}/actions/variables/{name}` |
| `getListForEnvironment($owner, $repo, $environmentName, $page, $limit)` | `GET /repos/{owner}/{repo}/environments/{environment_name}/variables` |
| `createForEnvironment($owner, $repo, $environmentName, $name, $value)` | `POST /repos/{owner}/{repo}/environments/{environment_name}/variables` |
| `getForEnvironment($owner, $repo, $environmentName, $name)` | `GET /repos/{owner}/{repo}/environments/{environment_name}/variables/{name}` |
| `editForEnvironment($owner, $repo, $environmentName, $name, $options)` | `PATCH /repos/{owner}/{repo}/environments/{environment_name}/variables/{name}` |
| `deleteForEnvironment($owner, $repo, $environmentName, $name)` | `DELETE /repos/{owner}/{repo}/environments/{environment_name}/variables/{name}` |

### RunnerGroups (`$github->actions->runnerGroups`)

| Method | Endpoint |
| --- | --- |
| `getList($org, $filters, $page, $limit)` | `GET /orgs/{org}/actions/runner-groups` |
| `create($org, $name, $options)` | `POST /orgs/{org}/actions/runner-groups` |
| `get($org, $runnerGroupId)` | `GET /orgs/{org}/actions/runner-groups/{runner_group_id}` |
| `edit($org, $runnerGroupId, $name, $options)` | `PATCH /orgs/{org}/actions/runner-groups/{runner_group_id}` |
| `delete($org, $runnerGroupId)` | `DELETE /orgs/{org}/actions/runner-groups/{runner_group_id}` |
| `getListHostedRunners($org, $runnerGroupId, $page, $limit)` | `GET /orgs/{org}/actions/runner-groups/{runner_group_id}/hosted-runners` |
| `getListRepositories($org, $runnerGroupId, $page, $limit)` | `GET /orgs/{org}/actions/runner-groups/{runner_group_id}/repositories` |
| `setRepositories($org, $runnerGroupId, $selectedRepositoryIds)` | `PUT /orgs/{org}/actions/runner-groups/{runner_group_id}/repositories` |
| `addRepository($org, $runnerGroupId, $repositoryId)` | `PUT /orgs/{org}/actions/runner-groups/{runner_group_id}/repositories/{repository_id}` |
| `removeRepository($org, $runnerGroupId, $repositoryId)` | `DELETE /orgs/{org}/actions/runner-groups/{runner_group_id}/repositories/{repository_id}` |
| `getListRunners($org, $runnerGroupId, $page, $limit)` | `GET /orgs/{org}/actions/runner-groups/{runner_group_id}/runners` |
| `setRunners($org, $runnerGroupId, $runners)` | `PUT /orgs/{org}/actions/runner-groups/{runner_group_id}/runners` |
| `addRunner($org, $runnerGroupId, $runnerId)` | `PUT /orgs/{org}/actions/runner-groups/{runner_group_id}/runners/{runner_id}` |
| `removeRunner($org, $runnerGroupId, $runnerId)` | `DELETE /orgs/{org}/actions/runner-groups/{runner_group_id}/runners/{runner_id}` |

### Runners (`$github->actions->runners`)

| Method | Endpoint |
| --- | --- |
| `getListForOrg($org, $filters, $page, $limit)` | `GET /orgs/{org}/actions/runners` |
| `getVersionDeprecationForOrg($org, $version)` | `GET /orgs/{org}/actions/runners/deprecations/{version}` |
| `getListApplicationsForOrg($org)` | `GET /orgs/{org}/actions/runners/downloads` |
| `generateJitConfigForOrg($org, $name, $runnerGroupId, $labels, $options)` | `POST /orgs/{org}/actions/runners/generate-jitconfig` |
| `createRegistrationTokenForOrg($org)` | `POST /orgs/{org}/actions/runners/registration-token` |
| `createRemoveTokenForOrg($org)` | `POST /orgs/{org}/actions/runners/remove-token` |
| `getForOrg($org, $runnerId)` | `GET /orgs/{org}/actions/runners/{runner_id}` |
| `deleteForOrg($org, $runnerId)` | `DELETE /orgs/{org}/actions/runners/{runner_id}` |
| `getListLabelsForOrg($org, $runnerId)` | `GET /orgs/{org}/actions/runners/{runner_id}/labels` |
| `addLabelsForOrg($org, $runnerId, $labels)` | `POST /orgs/{org}/actions/runners/{runner_id}/labels` |
| `setLabelsForOrg($org, $runnerId, $labels)` | `PUT /orgs/{org}/actions/runners/{runner_id}/labels` |
| `removeAllLabelsForOrg($org, $runnerId)` | `DELETE /orgs/{org}/actions/runners/{runner_id}/labels` |
| `removeLabelForOrg($org, $runnerId, $name)` | `DELETE /orgs/{org}/actions/runners/{runner_id}/labels/{name}` |
| `getListForRepo($owner, $repo, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/runners` |
| `getVersionDeprecationForRepo($owner, $repo, $version)` | `GET /repos/{owner}/{repo}/actions/runners/deprecations/{version}` |
| `getListApplicationsForRepo($owner, $repo)` | `GET /repos/{owner}/{repo}/actions/runners/downloads` |
| `generateJitConfigForRepo($owner, $repo, $name, $runnerGroupId, $labels, $options)` | `POST /repos/{owner}/{repo}/actions/runners/generate-jitconfig` |
| `createRegistrationTokenForRepo($owner, $repo)` | `POST /repos/{owner}/{repo}/actions/runners/registration-token` |
| `createRemoveTokenForRepo($owner, $repo)` | `POST /repos/{owner}/{repo}/actions/runners/remove-token` |
| `getForRepo($owner, $repo, $runnerId)` | `GET /repos/{owner}/{repo}/actions/runners/{runner_id}` |
| `deleteForRepo($owner, $repo, $runnerId)` | `DELETE /repos/{owner}/{repo}/actions/runners/{runner_id}` |
| `getListLabelsForRepo($owner, $repo, $runnerId)` | `GET /repos/{owner}/{repo}/actions/runners/{runner_id}/labels` |
| `addLabelsForRepo($owner, $repo, $runnerId, $labels)` | `POST /repos/{owner}/{repo}/actions/runners/{runner_id}/labels` |
| `setLabelsForRepo($owner, $repo, $runnerId, $labels)` | `PUT /repos/{owner}/{repo}/actions/runners/{runner_id}/labels` |
| `removeAllLabelsForRepo($owner, $repo, $runnerId)` | `DELETE /repos/{owner}/{repo}/actions/runners/{runner_id}/labels` |
| `removeLabelForRepo($owner, $repo, $runnerId, $name)` | `DELETE /repos/{owner}/{repo}/actions/runners/{runner_id}/labels/{name}` |

### Jobs (`$github->actions->jobs`)

| Method | Endpoint |
| --- | --- |
| `get($owner, $repo, $jobId)` | `GET /repos/{owner}/{repo}/actions/jobs/{job_id}` |
| `downloadLogs($owner, $repo, $jobId)` | `GET /repos/{owner}/{repo}/actions/jobs/{job_id}/logs` |
| `downloadStepLogs($owner, $repo, $jobId, $stepNumber)` | `GET /repos/{owner}/{repo}/actions/jobs/{job_id}/steps/{step_number}/logs` |
| `getListForRun($owner, $repo, $runId, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/jobs` |
| `getListForRunAttempt($owner, $repo, $runId, $attemptNumber, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/attempts/{attempt_number}/jobs` |

### Runs (`$github->actions->runs`)

| Method | Endpoint |
| --- | --- |
| `getListForRepo($owner, $repo, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/runs` |
| `getListForWorkflow($owner, $repo, $workflowId, $filters, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/workflows/{workflow_id}/runs` |
| `get($owner, $repo, $runId, $filters)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}` |
| `delete($owner, $repo, $runId)` | `DELETE /repos/{owner}/{repo}/actions/runs/{run_id}` |
| `getReviews($owner, $repo, $runId)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/approvals` |
| `approve($owner, $repo, $runId)` | `POST /repos/{owner}/{repo}/actions/runs/{run_id}/approve` |
| `getAttempt($owner, $repo, $runId, $attemptNumber, $filters)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/attempts/{attempt_number}` |
| `downloadAttemptLogs($owner, $repo, $runId, $attemptNumber)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/attempts/{attempt_number}/logs` |
| `cancel($owner, $repo, $runId)` | `POST /repos/{owner}/{repo}/actions/runs/{run_id}/cancel` |
| `forceCancel($owner, $repo, $runId)` | `POST /repos/{owner}/{repo}/actions/runs/{run_id}/force-cancel` |
| `reviewCustomGates($owner, $repo, $runId, $environmentName, $options)` | `POST /repos/{owner}/{repo}/actions/runs/{run_id}/deployment_protection_rule` |
| `downloadLogs($owner, $repo, $runId)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/logs` |
| `deleteLogs($owner, $repo, $runId)` | `DELETE /repos/{owner}/{repo}/actions/runs/{run_id}/logs` |
| `getPendingDeployments($owner, $repo, $runId)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/pending_deployments` |
| `reviewPendingDeployments($owner, $repo, $runId, $environmentIds, $state, $comment)` | `POST /repos/{owner}/{repo}/actions/runs/{run_id}/pending_deployments` |
| `rerun($owner, $repo, $runId, $options)` | `POST /repos/{owner}/{repo}/actions/runs/{run_id}/rerun` |
| `rerunFailedJobs($owner, $repo, $runId, $options)` | `POST /repos/{owner}/{repo}/actions/runs/{run_id}/rerun-failed-jobs` |
| `rerunJob($owner, $repo, $jobId, $options)` | `POST /repos/{owner}/{repo}/actions/jobs/{job_id}/rerun` |
| `getUsage($owner, $repo, $runId)` | `GET /repos/{owner}/{repo}/actions/runs/{run_id}/timing` |

### Workflows (`$github->actions->workflows`)

| Method | Endpoint |
| --- | --- |
| `getList($owner, $repo, $page, $limit)` | `GET /repos/{owner}/{repo}/actions/workflows` |
| `get($owner, $repo, $workflowId)` | `GET /repos/{owner}/{repo}/actions/workflows/{workflow_id}` |
| `disable($owner, $repo, $workflowId)` | `PUT /repos/{owner}/{repo}/actions/workflows/{workflow_id}/disable` |
| `enable($owner, $repo, $workflowId)` | `PUT /repos/{owner}/{repo}/actions/workflows/{workflow_id}/enable` |
| `createDispatch($owner, $repo, $workflowId, $ref, $options)` | `POST /repos/{owner}/{repo}/actions/workflows/{workflow_id}/dispatches` |
| `getUsage($owner, $repo, $workflowId)` | `GET /repos/{owner}/{repo}/actions/workflows/{workflow_id}/timing` |
