<?php
/**
 * Created by PhpStorm.
 * User: ajl
 * Date: 2018/12/15
 * Time: 下午10:39
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

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
            "avatar" => "url"
        ];
    }

    public function messages()
    {
        return [
            "avatar.url" => "用户头像的格式无效"
        ];
    }

    public function data()
    {
        $data = [];
        foreach ([
                     "nickname" => "string",
                     "mobile" => "string",
                     "avatar" => "string",
                 ] as $field => $type) {
            $value = $this->input($field);
            if (is_null($value)) {
                continue;
            }
            $data[$field] = call_user_func(function ($value, $type) {
                switch ($type) {
                    case "int":
                        return (int)$value;
                        break;
                    case "string":
                        return (string)$value;
                        break;
                    case "boolean":
                        return (boolean)$value;
                        break;
                    default:
                        return $value;
                        break;
                }
            }, $value, $type);
        }
        return $data;
    }
}