# Case 001

## Title
Authentication starter flow

## Goal
Validate the baseline user journey for the current Laravel starter app:
visit the site, create an account, sign in, reach the dashboard, and edit
account settings.

## Scope
Included:
- landing page
- registration
- login
- password reset
- dashboard access after authentication
- settings pages

Excluded:
- gameplay
- domain-specific records
- analytics
- third-party integrations

## Steps
1. Open the home page.
2. Register a new user.
3. Confirm the account flow if required.
4. Log in with the new account.
5. Verify the dashboard loads.
6. Open the settings area and confirm profile and security pages work.

## Expected Result
- The user can move through the auth flow without errors.
- The authenticated shell renders correctly.
- The dashboard is accessible only to authenticated and verified users.
- Account settings can be viewed and updated.

## Implementation Notes
This case maps directly to the existing Fortify routes and Blade views.
It is a good first regression target before adding any domain-specific logic.
