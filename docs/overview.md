# Github API package

TODO

## OAuth web application flow

`$github->authorization->getAuthorizationLink($clientId, $redirectUri, $scope, $state)` returns the URL to send the
user to; all values are percent-encoded. `$github->authorization->requestToken($clientId, $clientSecret, $code)`
exchanges the code for a token and returns the decoded answer (`access_token`, `scope`, `token_type`). Without a
`$format`, JSON is requested; before, GitHub answered form-encoded and the method returned `null`.
