<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadS3Controller extends Controller
{
    /**
     * @param string $mimeType
     * @return string|null
     */
    public static function mimeTypeToExtension(string $mimeType): null|string
    {
        $mimeTypes = [
            /** Image  **/
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/svg+xml' => 'svg',
            'image/tiff' => 'tiff',
            'image/webp' => 'webp',

            /** Text  **/
            'text/plain' => 'txt',
            'text/html' => 'html',
            'text/css' => 'css',
            'text/javascript' => 'js',
            'text/xml' => 'xml',

            /** Application  **/
            'application/pdf' => 'pdf',
            'application/json' => 'json',
            'application/zip' => 'zip',
            'application/x-rar-compressed' => 'rar',
            'application/x-msdownload' => 'exe',
            'application/x-sh' => 'sh',
            'application/rtf' => 'rtf',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/java-archive' => 'jar',
            'application/x-tar' => 'tar',
            'application/x-7z-compressed' => '7z',

            /** Audio  **/
            'audio/mpeg' => 'mp3',
            'audio/ogg' => 'ogg',
            'audio/wav' => 'wav',
            'audio/webm' => 'weba',
            'audio/aac' => 'aac',

            /** Video  **/
            'video/mp4' => 'mp4',
            'video/mpeg' => 'mpeg',
            'video/ogg' => 'ogv',
            'video/webm' => 'webm',
            'video/avi' => 'avi',
            'video/quicktime' => 'mov',
            'video/x-ms-wmv' => 'wmv',
            'video/x-flv' => 'flv',
            'video/x-matroska' => 'mkv'
        ];

        return $mimeTypes[$mimeType] ?? null;
    }


    public static function uuidFromChecksum(string $checksum): string
    {
        $uuid = sprintf('%08s-%04s-%04x-%04x-%12s',
            substr($checksum, 0, 8),
            substr($checksum, 8, 4),
            hexdec(substr($checksum, 12, 4)) & 0x0fff | 0x5000,
            hexdec(substr($checksum, 16, 4)) & 0x3fff | 0x8000,
            substr($checksum, 20, 12)
        );
        return $uuid;
    }
}