<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $batch = $this->route('batch');
        $batchId = is_object($batch) ? $batch->id : $batch;
        $currentYear = (int) now()->format('Y');

        return [
            'name' => [
                'required',
                'integer',
                'digits:4',
                'min:2022',
                "max:{$currentYear}",
                Rule::unique('batches', 'name')->ignore($batchId),
            ],
        ];
    }
}
