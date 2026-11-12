# Projects

The Projects package covers the [REST API for Projects](https://docs.github.com/rest/projects) (Projects v2,
the `projectsV2` endpoints) of organisations and users: projects, draft items, fields, items and views. It is
reached as `$github->projects`; the project operations live on that class, the others in the sub-packages
`$github->projects->drafts`, `$github->projects->fields`, `$github->projects->items` and
`$github->projects->views`, for example `$github->projects->items->getListForOrg('joomla', 5)`. Methods
for organisation-owned projects end in `ForOrg`, those for user-owned projects in `ForUser`.

```php
use Joomla\Github\Github;
use Joomla\Registry\Registry;

$options = new Registry();
$options->set('gh.token', $token);

$github = new Github($options);

// Find a project and list its open items with two field values
$projects = $github->projects->getListForOrg('joomla', ['q' => 'roadmap']);
$items    = $github->projects->items->getListForOrg('joomla', $projects[0]->number, ['q' => 'is:open', 'fields' => '123,456']);

// Add an issue and set a field value
$item = $github->projects->items->addForOrg('joomla', 5, 'Issue', ['owner' => 'joomla', 'repo' => 'joomla-cms', 'number' => 42]);
$github->projects->items->editForOrg('joomla', 5, $item->id, [['id' => 123, 'value' => 'Done']]);
```

Notes:

* Optional request body fields are passed in `$options` and optional query parameters in `$filters`; the
  docblock of each method lists the accepted keys.
* The list endpoints use cursor-based pagination: pass the `before` / `after` filters taken from the `Link`
  response header. GitHub only uses `$limit` (`per_page`); `$page` is accepted for consistency with the
  rest of the library but has no effect.
* The `fields` filter limits the returned field values by field ID; pass it as a comma-separated string
  (`'123,456'`).
* Most user-scoped paths take the user name (`{username}`), but GitHub addresses the user by numeric ID
  (`{user_id}`) when creating draft items (`POST /user/{user_id}/...`, singular `user`) and views
  (`POST /users/{user_id}/...`). The methods follow the API exactly, so `Drafts::createForUser()` and
  `Views::createForUser()` expect the user ID.
* `Fields::addForOrg()` takes the whole field definition as an array because the request body has several
  variants without a common required field (an existing issue field via `issue_field_id`, or a new field via
  `name` and `data_type`).
* The classic Projects API (projects v1, `/projects/columns` etc.) is no longer part of GitHub's REST API description and is not included;
  GraphQL is available through `$github->graphql`.

## Projects (`$github->projects`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $filters, $page, $limit) | GET /orgs/{org}/projectsV2 |
| getForOrg($org, $projectNumber) | GET /orgs/{org}/projectsV2/{project_number} |
| getListForUser($username, $filters, $page, $limit) | GET /users/{username}/projectsV2 |
| getForUser($username, $projectNumber) | GET /users/{username}/projectsV2/{project_number} |

## Drafts (`$github->projects->drafts`)

| Method | Endpoint |
| --- | --- |
| createForOrg($org, $projectNumber, $title, $options) | POST /orgs/{org}/projectsV2/{project_number}/drafts |
| createForUser($userId, $projectNumber, $title, $options) | POST /user/{user_id}/projectsV2/{project_number}/drafts |

## Fields (`$github->projects->fields`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $projectNumber, $filters, $page, $limit) | GET /orgs/{org}/projectsV2/{project_number}/fields |
| addForOrg($org, $projectNumber, $field) | POST /orgs/{org}/projectsV2/{project_number}/fields |
| getForOrg($org, $projectNumber, $fieldId) | GET /orgs/{org}/projectsV2/{project_number}/fields/{field_id} |
| getListForUser($username, $projectNumber, $filters, $page, $limit) | GET /users/{username}/projectsV2/{project_number}/fields |
| addForUser($username, $projectNumber, $name, $dataType, $options) | POST /users/{username}/projectsV2/{project_number}/fields |
| getForUser($username, $projectNumber, $fieldId) | GET /users/{username}/projectsV2/{project_number}/fields/{field_id} |

## Items (`$github->projects->items`)

| Method | Endpoint |
| --- | --- |
| getListForOrg($org, $projectNumber, $filters, $page, $limit) | GET /orgs/{org}/projectsV2/{project_number}/items |
| addForOrg($org, $projectNumber, $type, $options) | POST /orgs/{org}/projectsV2/{project_number}/items |
| getForOrg($org, $projectNumber, $itemId, $filters) | GET /orgs/{org}/projectsV2/{project_number}/items/{item_id} |
| editForOrg($org, $projectNumber, $itemId, $fields) | PATCH /orgs/{org}/projectsV2/{project_number}/items/{item_id} |
| deleteForOrg($org, $projectNumber, $itemId) | DELETE /orgs/{org}/projectsV2/{project_number}/items/{item_id} |
| getListForOrgView($org, $projectNumber, $viewNumber, $filters, $page, $limit) | GET /orgs/{org}/projectsV2/{project_number}/views/{view_number}/items |
| getListForUser($username, $projectNumber, $filters, $page, $limit) | GET /users/{username}/projectsV2/{project_number}/items |
| addForUser($username, $projectNumber, $type, $options) | POST /users/{username}/projectsV2/{project_number}/items |
| getForUser($username, $projectNumber, $itemId, $filters) | GET /users/{username}/projectsV2/{project_number}/items/{item_id} |
| editForUser($username, $projectNumber, $itemId, $fields) | PATCH /users/{username}/projectsV2/{project_number}/items/{item_id} |
| deleteForUser($username, $projectNumber, $itemId) | DELETE /users/{username}/projectsV2/{project_number}/items/{item_id} |
| getListForUserView($username, $projectNumber, $viewNumber, $filters, $page, $limit) | GET /users/{username}/projectsV2/{project_number}/views/{view_number}/items |

## Views (`$github->projects->views`)

| Method | Endpoint |
| --- | --- |
| createForOrg($org, $projectNumber, $name, $layout, $options) | POST /orgs/{org}/projectsV2/{project_number}/views |
| createForUser($userId, $projectNumber, $name, $layout, $options) | POST /users/{user_id}/projectsV2/{project_number}/views |
