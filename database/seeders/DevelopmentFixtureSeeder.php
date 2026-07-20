<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\CasePerson;
use App\Models\CaseRecord;
use App\Models\Person;
use Illuminate\Database\Seeder;

class DevelopmentFixtureSeeder extends Seeder
{
    public function run(): void
    {
        $case = CaseRecord::query()->updateOrCreate(
            ['vine_id' => 'CAS-000001'],
            ['title' => 'The Missing Mask'],
        );

        $building = Building::query()->updateOrCreate(
            ['vine_id' => 'BLD-000015'],
            [
                'official_name' => 'San Aurelio Police Headquarters',
                'common_name' => 'SAPD Headquarters',
                'building_type' => null,
                'development_fixture' => true,
            ],
        );

        Person::query()->where('vine_id', 'PER-DEV-000001')->delete();

        $people = [
            [
                'vine_id' => 'PERSON-SAPD-000010',
                'first_name' => 'place',
                'last_name' => 'holder',
                'name' => 'place holder',
                'is_player_character' => true,
                'primary_building_id' => $building->id,
                'role' => 'Lead Investigator',
            ],
            [
                'vine_id' => 'PER-DEV-000002',
                'name' => 'DEV FIXTURE - Bram Holt',
                'role' => 'DEV FIXTURE - witness',
            ],
            [
                'vine_id' => 'PER-DEV-000003',
                'name' => 'DEV FIXTURE - Cora Bell',
                'role' => 'DEV FIXTURE - suspect',
            ],
        ];

        foreach ($people as $personData) {
            $person = Person::query()->updateOrCreate(
                ['vine_id' => $personData['vine_id']],
                [
                    'first_name' => $personData['first_name'] ?? null,
                    'last_name' => $personData['last_name'] ?? null,
                    'name' => $personData['name'],
                    'is_player_character' => $personData['is_player_character'] ?? false,
                    'primary_building_id' => $personData['primary_building_id'] ?? null,
                ],
            );

            CasePerson::query()->updateOrCreate(
                [
                    'case_id' => $case->id,
                    'person_id' => $person->id,
                ],
                [
                    'role' => $personData['role'],
                ],
            );
        }
    }
}
