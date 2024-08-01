<?php

use App\Livewire\UploadForm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Livewire\livewire;

it('can upload files', function () {
    Storage::fake();
    $file = UploadedFile::fake()->create('fredrik.pdf', 2012);

    $component = livewire(UploadForm::class)
        ->fillForm([
            'files' => [
                'foobar' => $file,
            ],
        ]);

    $this->assertTrue(true);
});
