<?php

use Database\Seeders\DevelopmentFixtureSeeder;

beforeEach(function () {
    $this->seed(DevelopmentFixtureSeeder::class);
});

it('renders the development case inspection page', function () {
    $response = $this->get('/dev/cases/CAS-000001');

    $response->assertOk();
    $response->assertSeeText('CAS-000001');
    $response->assertSeeText('The Missing Mask');
    $response->assertSeeText('Lead Investigator');
    $response->assertSeeText('PERSON-SAPD-000010');
    $response->assertSeeText('place holder');
    $response->assertSeeText('Player Character');
    $response->assertSeeText('YES');
    $response->assertSeeText('Role');
    $response->assertSeeText('Lead Investigator');
    $response->assertSeeText('Assigned Building');
    $response->assertSeeText('BLD-000015');
    $response->assertSeeText('San Aurelio Police Headquarters');
    $response->assertSeeText('SAPD Headquarters');
    $response->assertSeeText('Case');
    $response->assertSeeText('People');
    $response->assertSeeText('Relationships');
    $response->assertSeeText('Buildings');
    $response->assertSeeText('Raw Data');
    $response->assertSeeText('Debug Information');
    $response->assertSeeText('Total linked people: 3');
    $response->assertSeeText('Unique buildings loaded: 1');
    $response->assertSeeText('Relationship Type');
    $response->assertSeeText('Case → People');
    $response->assertSeeText('Total Case People Links');
    $response->assertSeeText('App\\Models\\CaseRecord');
    $response->assertSeeText('testing');
    $response->assertSeeText('sqlite');
    $response->assertSeeText('dev.cases.show');
    $response->assertSeeText('"case_people": [');
    $response->assertSeeText('"vine_id": "CAS-000001"');
    $response->assertSeeText('"title": "The Missing Mask"');
    $response->assertSeeText('"primary_building": {');
    $response->assertSeeText('"vine_id": "BLD-000015"');
    $response->assertSeeText('"official_name": "San Aurelio Police Headquarters"');
    $response->assertSeeText('"role": "Lead Investigator"');
    $response->assertSeeText('"role": "DEV FIXTURE - witness"');
    $response->assertSeeText('"role": "DEV FIXTURE - suspect"');
    $response->assertSeeText('Case People Record ID');
    $response->assertSeeText('PERSON-SAPD-000010');
    $response->assertSeeText('place holder');
    $response->assertSeeText('PER-DEV-000002');
    $response->assertSeeText('DEV FIXTURE - Bram Holt');
    $response->assertSeeText('PER-DEV-000003');
    $response->assertSeeText('DEV FIXTURE - Cora Bell');
    $response->assertSeeText('VINE ID');
    $response->assertSeeText('Official Name');
    $response->assertSeeText('Common Name');

    expect(substr_count($response->getContent(), 'class="person-row"'))->toBe(3);
    expect(substr_count($response->getContent(), 'class="building-row"'))->toBe(1);
    expect(substr_count($response->getContent(), 'PERSON-SAPD-000010') >= 3)->toBeTrue();
    expect(str_contains($response->getContent(), 'BLD-000015'))->toBeTrue();
});

it('returns a 404 for a nonexistent vine id', function () {
    $this->get('/dev/cases/CAS-999999')->assertNotFound();
});
