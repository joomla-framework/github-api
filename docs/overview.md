# Github API package

TODO

## The SHA of a commit reference

`$github->repositories->commits->getSha($owner, $repo, $ref)` returns the SHA-1 of a branch, tag or commit as a
plain string. It asks GitHub for the `application/vnd.github.sha` media type; before, it returned the JSON of the
whole commit as a string.
