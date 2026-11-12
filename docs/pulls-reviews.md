# Pull Request Reviews

The `Pulls\Reviews` and `Pulls\ReviewRequests` sub-packages cover the
[pull request reviews](https://docs.github.com/rest/pulls/reviews) and
[review requests](https://docs.github.com/rest/pulls/review-requests) endpoints of the GitHub REST API. They are
reached through the pulls package as `$github->pulls->reviews` and `$github->pulls->reviewRequests`.

```php
use Joomla\Github\Github;

$github = new Github($options);

// Ask two people for a review, then approve the pull request.
$github->pulls->reviewRequests->request('joomla', 'joomla-cms', 42, ['octocat', 'hubot']);
$github->pulls->reviews->create('joomla', 'joomla-cms', 42, ['event' => 'APPROVE', 'body' => 'Looks good.']);

// Read all reviews, page by page.
$reviews = $github->pulls->reviews->getList('joomla', 'joomla-cms', 42, 1, 100);
```

`$options` holds optional request-body fields. Required fields are explicit parameters and win over `$options`.

## Pulls\Reviews

| Method | Endpoint |
|--------|----------|
| getList($owner, $repo, $pullNumber, $page, $limit) | GET /repos/{owner}/{repo}/pulls/{pull_number}/reviews |
| create($owner, $repo, $pullNumber, $options) | POST /repos/{owner}/{repo}/pulls/{pull_number}/reviews |
| get($owner, $repo, $pullNumber, $reviewId) | GET /repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id} |
| edit($owner, $repo, $pullNumber, $reviewId, $body) | PUT /repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id} |
| delete($owner, $repo, $pullNumber, $reviewId) | DELETE /repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id} |
| getListComments($owner, $repo, $pullNumber, $reviewId, $page, $limit) | GET /repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id}/comments |
| dismiss($owner, $repo, $pullNumber, $reviewId, $message, $options) | PUT /repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id}/dismissals |
| submit($owner, $repo, $pullNumber, $reviewId, $event, $options) | POST /repos/{owner}/{repo}/pulls/{pull_number}/reviews/{review_id}/events |

`create()` without an `event` option creates a pending review; submit it later with `submit()`. `delete()` only
works for pending reviews and returns the deleted review.

## Pulls\ReviewRequests

| Method | Endpoint |
|--------|----------|
| getList($owner, $repo, $pullNumber) | GET /repos/{owner}/{repo}/pulls/{pull_number}/requested_reviewers |
| request($owner, $repo, $pullNumber, $reviewers, $teamReviewers) | POST /repos/{owner}/{repo}/pulls/{pull_number}/requested_reviewers |
| remove($owner, $repo, $pullNumber, $reviewers, $teamReviewers) | DELETE /repos/{owner}/{repo}/pulls/{pull_number}/requested_reviewers |
| rerequest($owner, $repo, $pullNumber, $reviewers, $teamReviewers) | POST /repos/{owner}/{repo}/pulls/{pull_number}/requested_reviewers/rerequest |

`$reviewers` is a list of user logins and `$teamReviewers` a list of team slugs. For `request()` and `rerequest()`
the API needs at least one of the two; empty lists are left out of the request body.

Review comments themselves (as opposed to the reviews they belong to) are handled by `$github->pulls->comments`.
