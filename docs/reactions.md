# Reactions

The `Reactions` package covers the [reactions](https://docs.github.com/rest/reactions) endpoints of the GitHub REST
API: listing, adding and deleting emoji reactions on commit comments, issues, issue comments, pull request review
comments and releases. It is reached as `$github->reactions`, for example
`$github->reactions->getListForIssue('joomla', 'joomla-cms', 42)`.

```php
use Joomla\Github\Github;

$github = new Github($options);

// Add a rocket to issue #42 and list all "heart" reactions on it.
$github->reactions->createForIssue('joomla', 'joomla-cms', 42, 'rocket');
$hearts = $github->reactions->getListForIssue('joomla', 'joomla-cms', 42, ['content' => 'heart'], 1, 100);
```

The reaction types are `+1`, `-1`, `laugh`, `confused`, `heart`, `hooray`, `rocket` and `eyes` (releases only accept
`+1`, `laugh`, `heart`, `hooray`, `rocket` and `eyes`). `$filters` accepts the `content` key to list only one reaction
type. The `createFor*()` methods return the reaction both when it is new (HTTP 201) and when the same reaction already
existed (HTTP 200).

## Reactions

| Method | Endpoint |
|--------|----------|
| getListForCommitComment($owner, $repo, $commentId, $filters, $page, $limit) | GET /repos/{owner}/{repo}/comments/{comment_id}/reactions |
| createForCommitComment($owner, $repo, $commentId, $content) | POST /repos/{owner}/{repo}/comments/{comment_id}/reactions |
| deleteForCommitComment($owner, $repo, $commentId, $reactionId) | DELETE /repos/{owner}/{repo}/comments/{comment_id}/reactions/{reaction_id} |
| getListForIssueComment($owner, $repo, $commentId, $filters, $page, $limit) | GET /repos/{owner}/{repo}/issues/comments/{comment_id}/reactions |
| createForIssueComment($owner, $repo, $commentId, $content) | POST /repos/{owner}/{repo}/issues/comments/{comment_id}/reactions |
| deleteForIssueComment($owner, $repo, $commentId, $reactionId) | DELETE /repos/{owner}/{repo}/issues/comments/{comment_id}/reactions/{reaction_id} |
| getListForIssue($owner, $repo, $issueNumber, $filters, $page, $limit) | GET /repos/{owner}/{repo}/issues/{issue_number}/reactions |
| createForIssue($owner, $repo, $issueNumber, $content) | POST /repos/{owner}/{repo}/issues/{issue_number}/reactions |
| deleteForIssue($owner, $repo, $issueNumber, $reactionId) | DELETE /repos/{owner}/{repo}/issues/{issue_number}/reactions/{reaction_id} |
| getListForPullRequestReviewComment($owner, $repo, $commentId, $filters, $page, $limit) | GET /repos/{owner}/{repo}/pulls/comments/{comment_id}/reactions |
| createForPullRequestReviewComment($owner, $repo, $commentId, $content) | POST /repos/{owner}/{repo}/pulls/comments/{comment_id}/reactions |
| deleteForPullRequestReviewComment($owner, $repo, $commentId, $reactionId) | DELETE /repos/{owner}/{repo}/pulls/comments/{comment_id}/reactions/{reaction_id} |
| getListForRelease($owner, $repo, $releaseId, $filters, $page, $limit) | GET /repos/{owner}/{repo}/releases/{release_id}/reactions |
| createForRelease($owner, $repo, $releaseId, $content) | POST /repos/{owner}/{repo}/releases/{release_id}/reactions |
| deleteForRelease($owner, $repo, $releaseId, $reactionId) | DELETE /repos/{owner}/{repo}/releases/{release_id}/reactions/{reaction_id} |

## Left out

Reactions on team discussions and team discussion comments are not included: those endpoints are no longer part of
GitHub's current OpenAPI description.
