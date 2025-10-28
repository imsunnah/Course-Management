<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
        $courseId=$this->route('course')->id ?? null;
        return [
            'title' => 'required|string|max:250|unique:courses,title,' . $courseId,
            'feature_video' => 'nullable|file|mimes:mp4,mov,avi|max:102400',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.contents.*.title' => 'required|string|max:255',
            'modules.*.contents.*.file' => 'nullable|file|mimes:mp4,mov,avi,mp3,pdf,jpg,png|max:51200',
        ];
    }
}
