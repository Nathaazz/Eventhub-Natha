<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'description' => ['required', 'string'],

            'venue' => ['required', 'string', 'max:255'],

            'address' => ['required', 'string'],

            'date' => ['required', 'date', 'after_or_equal:today'],

            'start_time' => ['required', 'date_format:H:i'],

            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],

            'max_participants' => ['nullable', 'integer', 'min:1', 'max:10000'],

            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}