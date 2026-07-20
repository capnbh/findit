<?php

use App\Models\CasePerson;
use App\Models\CaseRecord;
use App\Models\Building;
use App\Models\Person;
use App\Services\Cases\CaseLoader;
use Database\Seeders\DevelopmentFixtureSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('creates the cases, people, and case_people tables with the expected columns', function () {
    expect(Schema::hasTable('cases'))->toBeTrue();
    expect(Schema::hasTable('people'))->toBeTrue();
    expect(Schema::hasTable('case_people'))->toBeTrue();
    expect(Schema::hasTable('buildings'))->toBeTrue();

    expect(Schema::hasColumns('cases', ['id', 'vine_id', 'title', 'created_at', 'updated_at']))->toBeTrue();
    expect(Schema::hasColumns('people', ['id', 'vine_id', 'first_name', 'last_name', 'name', 'is_player_character', 'primary_building_id', 'created_at', 'updated_at']))->toBeTrue();
    expect(Schema::hasColumns('case_people', ['id', 'case_id', 'person_id', 'role']))->toBeTrue();
    expect(Schema::hasColumns('buildings', ['id', 'vine_id', 'official_name', 'common_name', 'building_type', 'development_fixture', 'created_at', 'updated_at']))->toBeTrue();
});

it('persists the case, people, and case person relationships', function () {
    $case = CaseRecord::create([
        'vine_id' => 'CAS-TEST-000001',
        'title' => 'Relationship Test Case',
    ]);

    $person = Person::create([
        'vine_id' => 'PER-TEST-000001',
        'name' => 'Test Person',
    ]);

    $casePerson = CasePerson::create([
        'case_id' => $case->id,
        'person_id' => $person->id,
        'role' => 'test role',
    ]);

    expect($case->casePeople)->toHaveCount(1);
    expect($case->casePeople->first()->person->is($person))->toBeTrue();
    expect($casePerson->caseRecord->is($case))->toBeTrue();
    expect($casePerson->person->is($person))->toBeTrue();
});

it('persists the building relationship on people', function () {
    $building = Building::create([
        'vine_id' => 'BLD-TEST-000001',
        'official_name' => 'Test Headquarters',
        'common_name' => 'Test HQ',
        'building_type' => null,
        'development_fixture' => true,
    ]);

    $person = Person::create([
        'vine_id' => 'PERSON-TEST-000001',
        'first_name' => 'Test',
        'last_name' => 'Detective',
        'name' => 'Test Detective',
        'is_player_character' => true,
        'primary_building_id' => $building->id,
    ]);

    expect($person->primaryBuilding->is($building))->toBeTrue();
    expect($building->people)->toHaveCount(1);
    expect($building->people->first()->is($person))->toBeTrue();
});

it('seeds the canonical player detective and headquarters fixture', function () {
    $this->seed(DevelopmentFixtureSeeder::class);

    $detective = Person::query()->where('vine_id', 'PERSON-SAPD-000010')->firstOrFail();
    $building = Building::query()->where('vine_id', 'BLD-000015')->firstOrFail();

    expect($detective->first_name)->toBe('place');
    expect($detective->last_name)->toBe('holder');
    expect($detective->name)->toBe('place holder');
    expect($detective->is_player_character)->toBeTrue();
    expect($detective->primaryBuilding->is($building))->toBeTrue();
    expect($building->official_name)->toBe('San Aurelio Police Headquarters');
    expect($building->common_name)->toBe('SAPD Headquarters');
    expect($building->development_fixture)->toBeTrue();
    expect($building->people)->toHaveCount(1);
});

it('loads CAS-000001 with linked people through the case loader', function () {
    $this->seed(DevelopmentFixtureSeeder::class);

    $case = app(CaseLoader::class)->load('CAS-000001');

    expect($case->vine_id)->toBe('CAS-000001');
    expect($case->title)->toBe('The Missing Mask');
    expect($case->relationLoaded('casePeople'))->toBeTrue();
    expect($case->casePeople)->toHaveCount(3);
    expect($case->casePeople->map(fn (CasePerson $casePerson) => $casePerson->person->vine_id)->all())->toBe([
        'PERSON-SAPD-000010',
        'PER-DEV-000002',
        'PER-DEV-000003',
    ]);
    expect($case->casePeople->first()->person->is_player_character)->toBeTrue();
    expect($case->casePeople->first()->person->primaryBuilding?->vine_id)->toBe('BLD-000015');
    expect($case->casePeople->first()->person->relationLoaded('primaryBuilding'))->toBeTrue();
});
