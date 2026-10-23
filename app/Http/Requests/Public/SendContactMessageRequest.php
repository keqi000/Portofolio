<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class SendContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_name' => ['required', 'string', 'max:100'],
            'sender_email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:200'],
            'message_body' => ['required', 'string', 'min:10', 'max:3000'],
            // Honeypot field: Must be present and empty (bots usually fill it)
            'website_hp' => ['nullable', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'sender_name.required' => 'Mohon masukkan nama Anda.',
            'sender_email.required' => 'Mohon masukkan alamat email aktif.',
            'sender_email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Mohon tentukan subjek pesan atau topik diskusi.',
            'message_body.required' => 'Pesan tidak boleh kosong.',
            'message_body.min' => 'Pesan terlalu pendek, minimal 10 karakter.',
        ];
    }
}

