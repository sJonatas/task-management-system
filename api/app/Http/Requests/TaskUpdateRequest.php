<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
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
        return [
            'title' => 'nullable|string|max:100|min:2',
            'description' => 'string|nullable|max:500',
            'status' => ['nullable', 'string', Rule::in(StatusEnum::cases())],
            'priority' => ['nullable', 'string', Rule::in(PriorityEnum::cases())],
            'dueDate' => 'date|nullable|after_or_equal:today',
        ];
    }
}
