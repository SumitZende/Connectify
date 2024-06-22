<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    public  static array $extensions=[
                    'jpg','jpeg','png','gif','webp','img','svg','jfif',
                    'mp3','wav','mp4',
                    'doc','docx','pdf','csv','xls','xlsx',
                    'ppt','pptx',
                    'zip'
                ];
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body'=>['nullable','string'],
            'attachments' => 'array|max:10',
            'attachments.*'=>[
                'file',
                File::types(self::$extensions)
            ],
            'user_id'=>['numeric'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id'=> auth()->user()->id,
            'body' => $this->input('body') ?:  ''
            ]);

    }

    public  function  messages()
    {

        return[
            'attachments.*'=>'Invalid extension'
        ];
    }

}
