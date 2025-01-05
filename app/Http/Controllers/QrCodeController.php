<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class QrCodeController extends Controller
{
    public static function generateQrCode($url)
    {
        $client = new Client();

        $response = $client->post('https://qr.ranggasenjari.my.id/qr-code-generator', [
            'headers' => [
                'Authorization' => 'Bearer a7d8d5479c9bad1538c160bad446e179',
            ],
            'multipart' => [
                [
                    'name' => 'type',
                    'contents' => 'url',
                ],
                [
                    'name' => 'url',
                    'contents' => $url,
                ],
                [
                    'name' => 'name',
                    'contents' => 'prokum',
                ],
                [
                    'name' => 'style',
                    'contents' => 'dot',
                ],
                [
                    'name' => 'inner_eye_style',
                    'contents' => 'leaf',
                ],
                [
                    'name'     => 'qr_code_logo',
                    'contents' => Psr7\Utils::tryFopen('assets/admin/images/logo_qr.png', 'r')
                ],
                [
                    'name' => 'qr_code_logo_size',
                    'contents' => 29,
                ],
                [
                    'name' => 'outer_eye_style',
                    'contents' => 'leaf',
                ],
                [
                    'name' => 'foreground_type',
                    'contents' => 'gradient',
                ],
                [
                    'name' => 'foreground_gradient_style',
                    'contents' => 'diagonal',
                ],
                [
                    'name' => 'foreground_gradient_one',
                    'contents' => '#124CAF',
                ],
                [
                    'name' => 'foreground_gradient_two',
                    'contents' => '#56DCFF',
                ],
                [
                    'name' => 'background_color',
                    'contents' => '#ffffff',
                ],
                [
                    'name' => 'custom_eyes_color',
                    'contents' => 'on',
                ],
                [
                    'name' => 'eyes_inner_color',
                    'contents' => '#C2B40B',
                ],
                [
                    'name' => 'eyes_outer_color',
                    'contents' => '#187C02',
                ],
                [
                    'name' => 'size',
                    'contents' => '210',
                ],
                [
                    'name' => 'margin',
                    'contents' => '0',
                ],
                [
                    'name' => 'frame',
                    'contents' => 'round_bottom_text',
                ],
                [
                    'name' => 'frame_text',
                    'contents' => 'QR Tautan',
                ],
                [
                    'name' => 'frame_text_size',
                    'contents' => '0',
                ],
                [
                    'name' => 'frame_text_font',
                    'contents' => 'verdana',
                ],
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);
            // $data = $response->getBody();
            return $data['details']['data'];
        //    dump($data);
        }

        return null;
    }
}
