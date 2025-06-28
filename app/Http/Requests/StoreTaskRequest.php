<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // تحديد قواعد الـ Validation
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:tomorrow',
            'priority' => 'nullable|in:Low,Medium,High',
            'user_id' => 'required|exists:users,id'
        ];
    }
}
