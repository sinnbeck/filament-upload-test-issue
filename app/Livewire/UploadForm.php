<?php

namespace App\Livewire;

use Closure;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;

class UploadForm extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    /** @var ?array<string, mixed> */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'name' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                FileUpload::make('files')
                    ->multiple()
                    ->live()
                    ->disk('local')
                    ->multiple()
                    ->minFiles(1)
                    ->maxFiles(10)
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ])
                    ->rule('mimes:pdf,doc,docx')
                    ->rules([
                        fn (): Closure => function (string $attribute, $value, Closure $fail) {
                            $fail('Bad file');
                        },

                    ])
                    ->required()
                    ->afterStateUpdated(function () {
                        //$this->validateOnly('data.files');
                        dump('CALLED');
                    }),
            ])->statePath('data');
    }

    public function render()
    {
        return view('livewire.upload-page');
    }
}
