# Roadmap

## Phase 1
Stabilize the starter app and document the baseline architecture.
- keep auth flows working
- keep settings pages intact
- document the current database schema
- add smoke tests for the main routes

## Phase 2
Define the product domain.
- decide whether the app is a game, tracker, or workflow tool
- identify the primary entity model
- define the user actions and success conditions
- add the first non-auth tables and migrations

## Phase 3
Build the first real feature set.
- create the core interactive screen
- persist state in the database
- add a results or history view
- introduce validation and business rules

## Phase 4
Improve quality and operability.
- add feature coverage for the core flow
- tighten auth and authorization rules
- add telemetry or logging for important actions
- review performance and accessibility

## Open Questions
- What is the actual domain of the app?
- Is the authenticated dashboard the primary product surface?
- Should this evolve into a session-based game, a finder tool, or a tracker?

## Milestone Rule
Do not expand the roadmap with implementation details until the core domain is
decided. That prevents the codebase from drifting into generic starter-kit work.
