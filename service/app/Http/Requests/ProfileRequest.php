<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/15
 * Time: 下午10:39
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class ProfileRequest extends FormRequest
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
            "nickname" => "required",
            "avatar" => "required"
        ];
    }

    public function messages()
    {
        return [
            "avatar.required" => "用户头像必须提供"
        ];
    }

    public function data()
    {
        return [
            "nickname" => (string)$this->input("nickname"),
            "mobile" => (string)$this->input("mobile"),
            "avatar" => call_user_func(function ($contents) {
                if (substr($contents, 0, 4) == 'http') {
                    return $contents;
                }
                $filename = "avatar/" . md5($this->user('api')->getAuthIdentifier()) . '.jpg';
                Storage::disk('public')->put($filename, $contents);
                return url('/upload/'.$filename);
            }, $this->input("avatar"))
        ];
    }
}