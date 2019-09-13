<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'session_length' => 'required|numeric|digits_between:0,59',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'booking_starts_at' => 'required|date',
            'booking_ends_at' => 'required|date|after_or_equal:booking_starts_at',
            'booking_information' => 'required',
            'email_confirmation' => 'required',
            'email_reminder' => 'required',
            'sms_reminder' => 'required',
        ];
    }

    /**
 * Get custom attributes for validator errors.
 *
 * @return array
 */
public function attributes()
{
    return [
        'title' => 'Titel',
        'session_length' => 'Längen på mötestiden',
        'starts_at' => 'Tillfällets början',
        'ends_at' => 'Tillfällets slut',
        'booking_starts_at' => 'Bokningens öppning',
        'booking_ends_at' => 'Bokningens slut',
        'booking_information' => 'Bokningsinformationen',
        'email_confirmation' => 'Bekräftelsemailet',
        'email_reminder' => 'Påminnelsemailet',
        'sms_reminder' => 'Påminnelse-SMS:et',
    ];
}
}
