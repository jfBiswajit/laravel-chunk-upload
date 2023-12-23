<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class FileUploadController extends Controller
{
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
    }

    public function create()
    {
        return view('file-upload');
    }

    public function store(Request $request)
    {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            return $this->saveFile($save->getFile());
        }

        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);

        $mime = str_replace('/', '-', $file->getMimeType());

        $dateFolder = date("Y-m-W");

        $filePath = "upload/{$mime}/{$dateFolder}";
        $finalPath = storage_path("app/public/" . $filePath);

        $file->move($finalPath, $fileName);

        return response()->json([
            'path' => asset('storage/' . $filePath),
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName());
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
}
