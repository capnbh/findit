<?php

use App\Services\Cases\CaseLoader;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/dev/cases/{vineId}', function (string $vineId, CaseLoader $caseLoader) {
    $case = $caseLoader->load($vineId);

    return view('dev.cases.show', [
        'case' => $case,
    ]);
})->name('dev.cases.show');

require __DIR__.'/settings.php';
