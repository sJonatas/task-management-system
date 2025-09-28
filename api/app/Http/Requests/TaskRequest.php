<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'string|nullable|max:500',
            'status' => ['required', 'string', Rule::in(StatusEnum::cases())],
            'priority' => ['required', 'string', Rule::in(PriorityEnum::cases())],
            'dueDate' => 'date|nullable|after_or_equal:today',
        ];
    }
}
