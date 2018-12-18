<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param $video
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.messages.index')
            ->with('rows', Message::query()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function create()
    {
        return view('admin.messages.create')->with('status', (new Message())->getStatusOption());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $Message = new Message($request->data());
            $Message->save();
            return redirect()->to(route('admin.messages.index'))->with('message', '添加成功');
        } catch (\Exception $exception) {
            return redirect()->to(route('admin.messages.index'))->with('message', '添加失败');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param Message $Message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Message $Message)
    {
        return view('admin.messages.edit')
            ->with('row', $Message)
            ->with('status', (new Message())->getStatusOption());
    }

    /**
     * @param MessageRequest $request
     * @param Message $message
     * @return array
     */
    public function update(MessageRequest $request, Message $message)
    {
        $config = config('wechat.mini_program.default');
        $to = str_replace($config['app_id'] . '|', '', $message->from_user_name);
        $app = Factory::miniProgram($config);
        $app->server->push(function ($message) use ($app, $request, $to) {

//                Message::query()->create(
//                    [
//                        'to_user_name' => $message["ToUserName"],
//                        'from_user_name' => $message["FromUserName"],
//                        'create_time' => $message["CreateTime"],
//                        'msg_type' => $message["MsgType"],
//                        'content' => $message["Content"] ?? '',
//                        'pic_url' => $message["PicUrl"] ?? '',
//                        'media_id' => $message["MediaId"] ?? '',
//                        'title' => $message["Title"] ?? '',
//                        'app_id' => $message["AppId"] ?? '',
//                        'page_path' => $message["PagePath"] ?? '',
//                        'thumb_url' => $message["ThumbUrl"] ?? '',
//                        'thumb_media_id' => $message["ThumbMediaId"] ?? '',
//                        'event' => $message["Event"] ?? '',
//                        'session_from' => $message["SessionFrom"] ?? ''
//                    ]
//                );
            $app->customer_service->message(new Text($request->input('message')))->to($to)->send();
        });
        $app->server->serve();
        return Helper::success("", "已回复" . $to);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Message = Message::query()->findOrFail($id);
            $Message->delete();
            return redirect()->to(route('admin.Message.index'))->with('message', '删除成功');
        } catch (\Exception $exception) {
            return redirect()->to(route('admin.Message.index'))->with('message', '删除失败');
        }
    }
}
