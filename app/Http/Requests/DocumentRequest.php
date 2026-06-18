<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'doc_number' => 'nullable|string|max:100',
            'officer_name' => 'nullable|string|max:255',
            'classification' => 'required|in:open,excluded',
            'status' => 'required|in:published,unpublished',
        ];

        // Untuk store (create), file wajib
        if ($this->isMethod('post')) {
            $rules['file'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:25600';
        }

        // Untuk update, file opsional
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['file'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:25600';
            $rules['status'] = 'required|in:published,unpublished,archived';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul dokumen wajib diisi.',
            'category_id.required' => 'Kategori dokumen wajib dipilih.',
            'year.required' => 'Tahun dokumen wajib diisi.',
            'classification.required' => 'Klasifikasi dokumen wajib dipilih.',
            'status.required' => 'Status dokumen wajib dipilih.',
            'file.required' => 'File dokumen wajib diupload.',
            'file.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file maksimal 25MB.',
        ];
    }
}