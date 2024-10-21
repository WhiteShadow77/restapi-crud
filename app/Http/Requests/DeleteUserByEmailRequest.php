<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class DeleteUserByEmailRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge(['email' => $this->route('email')]);
    }

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
            'email' => 'required|email|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $description = $validator->errors()->first();

        $responseService = App::make(ResponseService::class);
        $responseService->errorResponseWithException($description);
    }
}
