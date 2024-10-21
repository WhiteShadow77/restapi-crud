<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use App\Enums\CategoryStatusType;

class StoreTaskRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' =>  'required|string|max:255',
            'status' =>  [
                'sometimes',
                Rule::in([(CategoryStatusType::IN_PROGRESS)->name, (CategoryStatusType::DONE)->name])
            ],
            'category' =>  'sometimes',
            'category.id' =>  'sometimes|numeric|min:1',
            'category.type' =>  'sometimes|string|max:255',
            'category.name' =>  'sometimes|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $description = $validator->errors()->first();

        $responseService = App::make(ResponseService::class);
        $responseService->errorResponseWithException($description);
    }
}
