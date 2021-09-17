<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaimInsert extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $pdfMax = config('fileSizeLimit.claims_create_pdf_max_size') * 1024;
        return [
            'risk_category' => 'required|int',
            'serial_number' => 'required',
            'number_of_sales' => 'required',
            'description' => 'required',
            // 'pdf_name' => 'mimetypes:application/pdf'
        ];
    }
}
