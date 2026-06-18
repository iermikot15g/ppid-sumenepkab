<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpdServiceRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|url|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ];

        if ($this->isMethod('post')) {
            $rules['opd_id'] = 'required|exists:opds,id';
        }

        $rules['icon'] = 'nullable|image|mimes:jpg,jpeg,png|max:1024';

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama layanan wajib diisi.',
            'url.required' => 'URL layanan wajib diisi.',
            'url.url' => 'Format URL tidak valid.',
            'opd_id.required' => 'OPD wajib dipilih.',
            'icon.image' => 'File harus berupa gambar.',
            'icon.max' => 'Ukuran icon maksimal 1MB.',
        ];
    }
}