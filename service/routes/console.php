<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {


    try {
        $file = '/Users/ajl/Downloads/地铁.mp4';
        (new class ()
        {
            protected $secret_id = 'AKIDQkCVchFLyUt9HDFXyJVaYegWAdx6FoNz';
            protected $secret_key = 'Op7MVbXIrFTt13wdAWgehTBJI5iGk3A5';
            protected $api = 'https://vod.api.qcloud.com/v2/index.php';
            protected $guzzle = null;

            function __construct()
            {
                $this->guzzle = new \GuzzleHttp\Client();
            }

            function upload($file)
            {


                $common_params = [
                    "SecretId" => $this->secret_id,
                    "Timestamp" => time(),
                    "Nonce" => rand(),
                    "Region" => "bj",
                    "SignatureMethod" => "HmacSHA256"
                ];

                $query = [
                    "Action" => "ApplyUpload",
                    "videoType" => "mp4"
                ];

                $params = array_merge($common_params, $query);
                $signature = $this->signature($params);
                $ApplyUpload = $this->send('GET', $this->api . '?' . http_build_query(array_merge($params, ['Signature' => $signature])));
                print('ApplyUpload Success');
                print(var_export($ApplyUpload, true));

                /**
                 * start upload
                 */
                $url = "https://{$ApplyUpload->storageRegion}.file.myqcloud.com/files/v2/{$ApplyUpload->storageAppId}/{$ApplyUpload->storageBucket}{$ApplyUpload->video->storagePath}";
                $Uploaded = $this->send('POST', $url, [
                    'headers' => [
                        'Authorization' => $ApplyUpload->video->storageSignature
                    ],
                    'multipart' => [
                        [
                            'name' => 'op',
                            'contents' => 'upload'
                        ],
                        [
                            'name' => 'filecontent',
                            'contents' => fopen($file, 'r')
                        ]
                    ]
                ]);
                print("Upload Success");
                print(var_export($Uploaded, true));

                /**
                 * CommitUpload
                 */


                $query = [
                    "Action" => "CommitUpload",
                    "vodSessionKey" => $ApplyUpload->vodSessionKey
                ];
                $params = array_merge($common_params, $query);
                $signature = $this->signature($params);
                $CommitUpload = $this->send("GET", $this->api . '?' . http_build_query(array_merge($params, ['Signature' => $signature])));
                print('CommitUpload Success');
                print(var_export($CommitUpload, true));


                $query = [
                    "Action" => "GetVideoInfo",
                    "fileId" => $Uploaded->data->vid
                ];
                $params = array_merge($common_params, $query);
                $signature = $this->signature($params);
                $CommitUpload = $this->send("GET", $this->api . '?' . http_build_query(array_merge($params, ['Signature' => $signature])));
                print('GetVideoInfo Success');
                print(var_export($CommitUpload, true));
            }

            function send($method, $url, $options = [])
            {
                $parsed_url = parse_url($url);
                print_r($parsed_url);
                if (isset($parsed_url['query'])) {
                    parse_str($parsed_url['query'], $query);
                    print_r($query);
                }
                if (!empty($options)) {
                    print_r($options);
                }
                $res = $this->guzzle->request($method, $url, $options);
                print($content = $res->getBody()->getContents());
                return json_decode($content);
            }

            function signature($params)
            {
                $parsedUrl = parse_url($this->api);
                ksort($params);
                $signature_original_string = "GET{$parsedUrl['host']}{$parsedUrl['path']}?" . http_build_query($params);
                return base64_encode(hash_hmac('sha256', $signature_original_string, $this->secret_key, true));
            }
        })->upload($file);


    } catch (\Exception $e) {
        $this->error($e->getMessage());
    }


})->describe('Display an inspiring quote');
