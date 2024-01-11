<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:20',
        ];
    }
    public function validationData():array
    {
        $data = $this->all();
        unset($data['_token']);
        $response = Http::scoring()->get('/score-leads');
        if($response->successful()){
            $response = $response->json();
            $data['scoring'] =$response['score'];
        }else{
            $data['scoring'] ='No disponible'; 
        }
        return array_merge($data,[
            'scoring'=>$data['scoring']
        ]);
    }
}
