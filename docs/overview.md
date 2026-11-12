# Github API package

TODO

## Encoding of URL values

Values that end up in the request URL are percent-encoded:

* Query values, e.g. the `$ref` of `$github->repositories->contents->get()`, the `$path` and `$author` of
  `$github->repositories->commits->getList()` or a `since` date (its `+` used to be sent as is, which GitHub reads as
  a space).
* Path values that can contain reserved characters: file paths, branch, tag and Git reference names, commit SHAs and
  references, label names, `.gitignore` template names and search keywords. A `/` in a file path, branch or reference
  name is kept as the separator; the other characters of each segment are encoded.

Pass these values unencoded. Owner, repository, user and organisation names are not encoded; GitHub only allows
letters, digits, `-`, `_` and `.` in them.
