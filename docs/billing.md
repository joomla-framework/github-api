# Billing

The Billing package covers the GitHub billing REST API for organisations and users: budgets and the usage, premium request and AI credit usage reports. It has two sub-packages, `$github->billing->budgets` and `$github->billing->usage`, for example `$github->billing->usage->getReportForOrg('joomla', ['year' => 2026])`. Methods for organisations end in `ForOrg`, methods for users in `ForUser`.

```php
$github = new Joomla\Github\Github($options);

// Usage summary of an organisation for January 2026.
$summary = $github->billing->usage->getSummaryForOrg('joomla', ['year' => 2026, 'month' => 1]);

// List the budgets of an organisation.
$budgets = $github->billing->budgets->getListForOrg('joomla');
```

## Budgets

`$github->billing->budgets` - https://docs.github.com/rest/billing/budgets

| Method | Endpoint |
| --- | --- |
| `getListForOrg($org, $filters, $page, $limit)` | `GET /organizations/{org}/settings/billing/budgets` |
| `createForOrg($org, $options)` | `POST /organizations/{org}/settings/billing/budgets` |
| `getForOrg($org, $budgetId)` | `GET /organizations/{org}/settings/billing/budgets/{budget_id}` |
| `editForOrg($org, $budgetId, $options)` | `PATCH /organizations/{org}/settings/billing/budgets/{budget_id}` |
| `deleteForOrg($org, $budgetId)` | `DELETE /organizations/{org}/settings/billing/budgets/{budget_id}` |

## Usage

`$github->billing->usage` - https://docs.github.com/rest/billing/usage

| Method | Endpoint |
| --- | --- |
| `getAiCreditReportForOrg($org, $filters)` | `GET /organizations/{org}/settings/billing/ai_credit/usage` |
| `getPremiumRequestReportForOrg($org, $filters)` | `GET /organizations/{org}/settings/billing/premium_request/usage` |
| `getReportForOrg($org, $filters)` | `GET /organizations/{org}/settings/billing/usage` |
| `getSummaryForOrg($org, $filters)` | `GET /organizations/{org}/settings/billing/usage/summary` |
| `getAiCreditReportForUser($username, $filters)` | `GET /users/{username}/settings/billing/ai_credit/usage` |
| `getPremiumRequestReportForUser($username, $filters)` | `GET /users/{username}/settings/billing/premium_request/usage` |
| `getReportForUser($username, $filters)` | `GET /users/{username}/settings/billing/usage` |
| `getSummaryForUser($username, $filters)` | `GET /users/{username}/settings/billing/usage/summary` |

Enterprise billing endpoints (`/enterprises/...`) are not included.
