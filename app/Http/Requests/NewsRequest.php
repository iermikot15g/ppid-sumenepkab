<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ];

        // Untuk galeri dan infografis, thumbnail wajib
        if ($this->isMethod('post')) {
            $rules['thumbnail'] = 'required|image|mimes:jpeg,png,jpg|max:5120';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['thumbnail'] = 'nullable|image|mimes:jpeg,png,jpg|max:5120';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'thumbnail.required' => 'Gambar thumbnail wajib diupload.',
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.max' => 'Ukuran gambar maksimal 5MB.',
            'event_date.date' => 'Format tanggal tidak valid.',
        ];
    }
}