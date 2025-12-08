<?php

declare(strict_types=1);

namespace Marvel\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CmsPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
    * @return array<string, mixed>
    */
    public function rules(): array
    {
        return [
            'slug' => [
                'required',
                'string',
                'max:191',
                Rule::unique('cms_pages', 'slug')->ignore($this->route('id') ?? $this->route('cms_page')),
            ],
            'title' => ['required', 'string', 'max:191'],
            'content' => ['nullable', 'array'],
            'content.*.type' => ['required_with:content', 'string'],
            'content.*.order' => ['required_with:content', 'integer'],
            'content.*.props' => ['nullable', 'array'],
            'meta' => ['nullable', 'array'],
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

