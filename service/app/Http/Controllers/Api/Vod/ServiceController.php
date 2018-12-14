<?php

namespace App\Http\Controllers\Api\Vod;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Video;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    function event()
    {
        try {
            $content = file_get_contents("php://input");
            Log::debug($content);
            $decoded = json_decode($content);
            Task::query()->create(
                [
                    'version' => $decoded->version,
                    'type' => $decoded->eventType,
                    'code' => $decoded->data->errCode ?? '',
                    'message' => $decoded->data->message ?? '',
                    'status' => $decoded->data->status ?? '',
                    'data' => print_r($decoded->data, true)
                ]
            );
            if ('CreateSnapshotByTimeOffsetComplete' == $decoded->eventType) {
                $url = $decoded->data->picInfo[0]->url ?? null;
                if ($url) {
                    Video::query()
                        ->where('file_id', $decoded->data->fileId)
                        ->where('cover_url', '')
                        ->update(
                            [
                                'cover_url' => $url
                            ]
                        );
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }
        return '{"version":"4.0","eventType":"TestEvent","data":{"event_time":' . time() . ',"data":"xiangtu"}}';
    }
}
