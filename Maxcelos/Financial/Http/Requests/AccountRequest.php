<?php

namespace Maxcelos\Financial\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Maxcelos\Foundation\Rules\UuidExists;
use Maxcelos\People\Entities\User;

class AccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return $this->storeRules();
        } elseif ($this->method() == 'PUT') {
            return $this->updateRules();
        }

        return [
            //
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    private function storeRules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'nullable|sometimes|max:255',
            'amount' => 'required|numeric|min:0',
            'accountable_id' => [
                'nullable', 'sometimes', new UuidExists(User::class)
            ]
        ];
    }

    private function updateRules()
    {
        return [
            'name' => 'nullable|sometimes|max:255',
            'description' => 'nullable|sometimes|max:255',
            'amount' => 'nullable|sometimes|numeric|min:0',
            'accountable_id' => [
                'nullable', 'sometimes', new UuidExists(User::class)
            ]
        ];
    }
}
