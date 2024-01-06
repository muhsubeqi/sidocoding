<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GoogleDrive
{
    public static function getData($filename)
    {
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!
        return $file;
    }

    public static function getAllData()
    {
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

        return $contents;
    }

    public static function delete($filename)
    {
        try {
            $dir = '/';
            $recursive = false; // Get subdirectories also?
            $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
            $file = $contents
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                ->first(); // there can be duplicate file names!
            Storage::disk('google')->delete($file['path']);

            $response = [
                "status" => true,
                "message" => "success delete",
                "name" => $file['name'],
            ];
            return $response;
        } catch (\Throwable $th) {
            $response = [
                "status" => false,
                "message" => "failed delete",
                "name" => null,
            ];
            return $response;
        }
    }

    public static function download($filename)
    {
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!
        $rawData = Storage::disk('google')->get($file['path']);
        return response($rawData, 200)
            ->header('ContentType', $file['mimetype'])
            ->header('Content-Disposition', "attachment; filename=$filename");
    }

    public static function link($path)
    {
        $link = null;
        if ($path != null) {
            $link = "https://drive.google.com/file/d/" . $path . "/view";
        }
        return $link;
    }

    public static function upload($file, $type)
    {
        try {
            
            $namaOriginal = $file->getClientOriginalName();
            $namaFile = $type . '-' . date('YmdHis') . '-' . $namaOriginal;
            $content = file_get_contents($file->getRealPath());
            // $content = File::get($file->getRealPath());
            Storage::disk('google')->put($namaFile, $content);

            $response = [
                "status" => true,
                "message" => "success upload",
                "name" => $namaFile,
            ];
            return $response;
        } catch (\Throwable $th) {
            $response = [
                "status" => false,
                "message" => $th->getMessage(),
                "name" => null,
            ];
            return $response;
        }
    }

    public function edit($newfile, $oldfile)
    {
        try {
            $file = $newfile;
            $extensi = $file->extension();
            $namaDokumen = 'File' . date('YmdHis') . uniqid() . '.' . $extensi;
            $content = File::get($file->getRealPath());
            $upload = Storage::disk('google')->put($namaDokumen, $content);
            if ($upload) {
                if ($oldfile != null) {
                    $dir = '/';
                    $recursive = false; // Get subdirectories also?
                    $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
                    $file = $contents
                        ->where('type', '=', 'file')
                        ->where('filename', '=', pathinfo($oldfile, PATHINFO_FILENAME))
                        ->where('extension', '=', pathinfo($oldfile, PATHINFO_EXTENSION))
                        ->first(); // there can be duplicate file names!
                    Storage::disk('google')->delete($file['path']);
                }
            }
            $response = [
                "status" => true,
                "message" => "success edit",
            ];
            return $response;
        } catch (\Throwable $th) {
            $response = [
                "status" => false,
                "message" => "failed edit",
            ];
            return $response;
        }
    }

}