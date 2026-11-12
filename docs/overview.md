# Github API package

TODO

## Creating, updating and deleting files

`$github->repositories->contents->create()`, `update()` and `delete()` commit to the repository's default branch
when no `$branch` is given. Before, they always sent `master`, which fails for repositories whose default branch is
`main`, GitHub's default for new repositories since 2020.
