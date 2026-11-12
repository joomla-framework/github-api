# Github API package

TODO

## Responses and errors

The package methods decode the JSON body of GitHub's answer and return it. An answer with an empty body, such as
`204 No Content`, returns `null`. An unexpected status code, or a body that is not valid JSON (for example an HTML
error page of a proxy), raises a `Joomla\Http\Exception\UnexpectedResponseException`; its `getResponse()` gives
access to the response.

Some endpoints have more than one successful status code: `$github->activity->notifications->markRead()` and
`markReadRepository()` accept `202 Accepted` (GitHub marks the notifications asynchronously) as well as `205`, and
`$github->repositories->collaborators->add()` accepts `201` (an invitation was sent) as well as `204`.
`$github->repositories->delete()` expects `204`.

`$github->repositories->contents->getArchiveLink()` returns the archive URL from the `Location` header of GitHub's
redirect. This needs an HTTP transport that does not follow redirects (option `follow_location` set to `false`);
otherwise the transport downloads the archive and the method throws an `UnexpectedResponseException`.
