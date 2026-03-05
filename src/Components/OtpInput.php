<?php

namespace HasanAhani\FilamentOtpInput\Components;

use Filament\Forms\Components\Field;
use Filament\Notifications\Notification;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts\CanBeLengthConstrained;
use Filament\Forms\Components\Contracts\HasAffixActions;
use Closure;

class OtpInput extends Field implements CanBeLengthConstrained, HasAffixActions
{
    use Concerns\CanBeAutocapitalized;
    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeLengthConstrained;
    use Concerns\CanBeReadOnly;
    use Concerns\HasAffixes;
    use Concerns\HasExtraInputAttributes;
    use HasExtraAlpineAttributes;

    // Define the default view for the component
    protected string $view = 'filament-otp-input::components.otp-input';

    // Default number of inputs in OTP field
    protected int | Closure | null $numberInput = 4;

    // Right-to-left (RTL) support flag
    protected bool | Closure | null $isRtl = false;

    // Default input type (number)
    protected string | Closure | null $type = 'number';

    // Set the number of input fields for OTP
    public function numberInput(int | Closure $number = 4): static
    {
        $this->numberInput = $number;
        return $this;
    }

    // Get the number of input fields for OTP
    public function getNumberInput(): int
    {
        return $this->evaluate($this->numberInput);
    }

    // Set the input type to password
    public function password(): static
    {
        $this->type = 'password';
        return $this;
    }

    // Set the input type to text
    public function text(): static
    {
        $this->type = 'text';
        return $this;
    }

    // Get the input type (text or password)
    public function getType(): string
    {
        return $this->evaluate($this->type);
    }

    // Enable or disable RTL (right-to-left) layout
    public function rtl(bool | Closure $condition = false): static
    {
        $this->isRtl = $condition;
        return $this;
    }

    // Get the direction for input fields (LTR or RTL)
    public function getInputsContainerDirection(): string
    {
        return $this->evaluate($this->isRtl);
    }

    // Action to trigger when user clicks "Clone"
    public function actionClone($record)
    {
        // Clone the current record
        $clonedRecord = $record->replicate();
        $clonedRecord->save();

        // Redirect to the edit page of the cloned record
        return redirect()->route('filament.resources.' . strtolower(class_basename($record)) . '.edit', ['record' => $clonedRecord->id]);
    }
}