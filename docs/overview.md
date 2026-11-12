# Github API package

TODO

## Public keys of the authenticated user

`$github->users->keys->getList()`, `get()`, `create()` and `delete()` manage the keys of the authenticated user
(`/user/keys`); `getListUser($user)` lists the public keys of any user. `edit()` is deprecated: GitHub has no endpoint
to update a key, so delete it and create a new one instead.
