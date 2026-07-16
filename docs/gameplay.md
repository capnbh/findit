# Gameplay

## Current State
There is no implemented gameplay loop in the repository yet.
The current app behavior is a standard authenticated starter experience:
- landing page
- register and login
- password reset
- dashboard entry point
- profile, security, and appearance settings

## Intended Product Flow
If this project becomes a game or interactive product, the expected loop
should be defined before implementation. A clean first pass would be:
1. Start a new session.
2. Present the primary challenge or board.
3. Let the user interact and produce progress.
4. Record the result in the database.
5. Show a summary screen and allow a retry.

## UX Constraints
- Keep the core action obvious on first load.
- Make progress visible and persistent.
- Avoid forcing account creation before the user understands the value.
- Use the authenticated dashboard as the place for long-lived state and history.

## Implementation Gap
The current codebase does not yet contain:
- scoring rules
- rounds or levels
- win/loss conditions
- leaderboards
- saved sessions or gameplay history

## Next Step
Define the game loop or interaction model first, then add the schema and UI
needed to support it. Without that, the repository remains a starter app rather
than a playable product.
