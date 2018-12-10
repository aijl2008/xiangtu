<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            "title:required",
            //"url" => "required|unique:videos",
            "url" => "required",
        ];
    }


    public function messages()
    {
        return [
            "title.required" => "视频名称必须提供",
            "url.required" => "视频地址必须提供",
            "url.unique" => "该视频已经存在了"
        ];
    }

    public function all($keys = NULL)
    {
        $data = [];
        foreach ([
                     "wechat_id" => "int",
                     "title" => "string",
                     "cover_url" => "string",
                     "file_id" => "string",
                     "url" => "string",
                     "uploaded_at" => "int",
                     "played_number" => "int",
                     "liked_number" => "int",
                     "shared_wechat_number" => "int",
                     "shared_moment_number" => "int",
                     "visibility" => "int",
                     "classification_id" => "int",
                     "status" => "int"
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

        foreach ([
                     "uploaded_at" => date("Y-m-d H:i:s"),
                     "played_number" => 0,
                     "liked_number" => 0,
                     "shared_wechat_number" => 0,
                     "shared_moment_number" => 0,
                     "visibility" => 1,
                     "status" => 1,
                     "cover_url" => "",
                     "file_id" => 0,
                     "classification_id" => 0
                 ] as $field => $value) {
            if (!key_exists($field, $data)) {
                $data[$field] = $value;
            }
        }
        return $data;
    }
}
