<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $case->vine_id }} - {{ $case->title }}</title>
        <style>
            :root {
                color-scheme: light;
                --bg: #f6f1e8;
                --panel: #ffffff;
                --text: #1f2933;
                --muted: #627080;
                --accent: #6b4e16;
                --border: #d8c7aa;
            }

            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                background: linear-gradient(160deg, #f8f4eb 0%, #efe2c6 100%);
                color: var(--text);
            }

            main {
                max-width: 900px;
                margin: 0 auto;
                padding: 48px 20px 64px;
            }

            .card {
                background: var(--panel);
                border: 1px solid var(--border);
                border-radius: 18px;
                box-shadow: 0 20px 50px rgba(38, 28, 13, 0.08);
                padding: 28px;
            }

            .eyebrow {
                text-transform: uppercase;
                letter-spacing: 0.14em;
                font-size: 12px;
                color: var(--accent);
                margin: 0 0 10px;
                font-weight: 700;
            }

            h1 {
                margin: 0 0 6px;
                font-size: clamp(2rem, 4vw, 3rem);
            }

            .meta {
                color: var(--muted);
                margin: 0 0 24px;
            }

            .section {
                margin-top: 28px;
                padding-top: 20px;
                border-top: 1px solid #eadfc7;
            }

            .section h2 {
                margin: 0 0 12px;
                font-size: 1.05rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .summary {
                display: grid;
                gap: 12px;
                margin: 0;
            }

            .summary div {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .summary dt {
                font-weight: 700;
                color: var(--accent);
            }

            .summary dd {
                margin: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 12px;
            }

            th, td {
                text-align: left;
                padding: 12px 10px;
                border-bottom: 1px solid #eadfc7;
                vertical-align: top;
            }

            th {
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--muted);
            }

            .role {
                font-weight: 600;
            }

            pre {
                margin: 0;
                padding: 16px;
                overflow-x: auto;
                background: #f8f4eb;
                border: 1px solid #eadfc7;
                border-radius: 12px;
                white-space: pre-wrap;
                word-break: break-word;
            }

            .debug-grid {
                display: grid;
                gap: 12px;
            }

            .debug-item {
                display: grid;
                gap: 4px;
            }

            .debug-label {
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--muted);
                font-weight: 700;
            }
        </style>
    </head>
    <body>
        @php
            $linkedPeople = $case->casePeople;
            $leadInvestigator = $linkedPeople->firstWhere('role', 'Lead Investigator');
            $uniqueBuildings = $linkedPeople
                ->pluck('person.primaryBuilding')
                ->filter()
                ->unique('id')
                ->values();
            $rawJson = json_encode(
                $case->toArray(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );
            $routeName = request()->route()?->getName();
        @endphp
        <main>
            <section class="card">
                <p class="eyebrow">Development Case Fixture</p>
                <h1>{{ $case->title }}</h1>
                <p class="meta">Case VINE ID: <strong>{{ $case->vine_id }}</strong></p>

                <section class="section" aria-labelledby="case-heading">
                    <h2 id="case-heading">Case</h2>
                    <dl class="summary">
                        <div>
                            <dt>Case VINE ID</dt>
                            <dd>{{ $case->vine_id }}</dd>
                        </div>
                        <div>
                            <dt>Case Title</dt>
                            <dd>{{ $case->title }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="section" aria-labelledby="people-heading">
                    <h2 id="people-heading">People</h2>
                    <p class="meta">Total linked people: {{ $linkedPeople->count() }}</p>

                    @if ($leadInvestigator)
                        <dl class="summary">
                            <div>
                                <dt>Lead Investigator</dt>
                                <dd>{{ $leadInvestigator->person->vine_id }}</dd>
                            </div>
                            <div>
                                <dt>Name</dt>
                                <dd>{{ $leadInvestigator->person->name }}</dd>
                            </div>
                            <div>
                                <dt>Player Character</dt>
                                <dd>{{ $leadInvestigator->person->is_player_character ? 'YES' : 'NO' }}</dd>
                            </div>
                            <div>
                                <dt>Role</dt>
                                <dd>{{ $leadInvestigator->role }}</dd>
                            </div>
                            <div>
                                <dt>Assigned Building</dt>
                                <dd>
                                    {{ $leadInvestigator->person->primaryBuilding?->vine_id ?? 'unassigned' }}
                                    -
                                    {{ $leadInvestigator->person->primaryBuilding?->official_name ?? 'unassigned' }}
                                </dd>
                            </div>
                        </dl>
                    @endif

                    <table aria-label="Linked people">
                        <thead>
                            <tr>
                                <th>Case People Record ID</th>
                                <th>Person VINE ID</th>
                                <th>Name</th>
                                <th>Player Character</th>
                                <th>Case Role</th>
                                <th>Assigned Building</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($linkedPeople as $casePerson)
                                <tr class="person-row">
                                    <td>{{ $casePerson->id }}</td>
                                    <td>{{ $casePerson->person->vine_id }}</td>
                                    <td>{{ $casePerson->person->name }}</td>
                                    <td>{{ $casePerson->person->is_player_character ? 'YES' : 'NO' }}</td>
                                    <td class="role">{{ $casePerson->role }}</td>
                                    <td>
                                        {{ $casePerson->person->primaryBuilding?->vine_id ?? 'unassigned' }}
                                        -
                                        {{ $casePerson->person->primaryBuilding?->official_name ?? 'unassigned' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

                <section class="section" aria-labelledby="relationships-heading">
                    <h2 id="relationships-heading">Relationships</h2>
                    <dl class="summary">
                        <div>
                            <dt>Relationship Type</dt>
                            <dd>Case &rarr; People</dd>
                        </div>
                        <div>
                            <dt>Total Case People Links</dt>
                            <dd>{{ $linkedPeople->count() }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="section" aria-labelledby="buildings-heading">
                    <h2 id="buildings-heading">Buildings</h2>
                    <p class="meta">Unique buildings loaded: {{ $uniqueBuildings->count() }}</p>

                    <table aria-label="Loaded buildings">
                        <thead>
                            <tr>
                                <th>VINE ID</th>
                                <th>Official Name</th>
                                <th>Common Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uniqueBuildings as $building)
                                <tr class="building-row">
                                    <td>{{ $building->vine_id }}</td>
                                    <td>{{ $building->official_name }}</td>
                                    <td>{{ $building->common_name ?? 'unassigned' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

                <section class="section" aria-labelledby="raw-data-heading">
                    <h2 id="raw-data-heading">Raw Data</h2>
                    <pre>{{ $rawJson }}</pre>
                </section>

                <section class="section" aria-labelledby="debug-heading">
                    <h2 id="debug-heading">Debug Information</h2>
                    <div class="debug-grid">
                        <div class="debug-item">
                            <div class="debug-label">Application Environment</div>
                            <div>{{ app()->environment() }}</div>
                        </div>
                        <div class="debug-item">
                            <div class="debug-label">Database Connection Name</div>
                            <div>{{ config('database.default') }}</div>
                        </div>
                        <div class="debug-item">
                            <div class="debug-label">Route Name</div>
                            <div>{{ $routeName ?? 'unassigned' }}</div>
                        </div>
                        <div class="debug-item">
                            <div class="debug-label">Loaded Case Model Class</div>
                            <div>{{ $case::class }}</div>
                        </div>
                        <div class="debug-item">
                            <div class="debug-label">Linked People Count</div>
                            <div>{{ $linkedPeople->count() }}</div>
                        </div>
                    </div>
                </section>
            </section>
        </main>
    </body>
</html>
