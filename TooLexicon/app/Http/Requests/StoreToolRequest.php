<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToolRequest extends FormRequest
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
            // toolテーブル
            'official_name' => ['required', 'string', 'max:255'],
            'category'      => ['nullable', 'string'],
            'image_url'     => ['nullable', 'url'],
            'amazon_url'    => ['nullable', 'url'],
            'monotaro_url'  => ['nullable', 'url'],
            'usage'         => ['nullable', 'string'],
            'safety_notes'  => ['nullable', 'string'],

            // tool_namesテーブル（複数保存対応）
            'tool_names' => ['required', 'array', 'min:1'],
            'tool_names.*.name' => ['required', 'string', 'max:255'],
            'tool_names.*.is_primary' => ['nullable', 'boolean'],
        ];
    }
}
