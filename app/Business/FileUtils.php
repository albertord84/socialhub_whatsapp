<?php
namespace App\Business;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FileUtils extends Business
{
    public function __construct()
    {
        base::__construct();
    }

    public static function SavePostFile(UploadedFile $file, ?string $FilePath = '', ?string $chat_id = null): stdClass
    {
        $json_data = new \StdClass();
        try {
            // Criate file structure
            $json_data->ClientOriginalName = $file->getClientOriginalName();
            $json_data->ClientOriginalExtension = $file->getClientOriginalExtension();
            $json_data->ClientMimeType = $file->getClientMimeType();
            $json_data->guessClientExtension = $file->guessClientExtension();
            $json_data->getSize = $file->getSize();
            $json_data->isValid = $file->isValid();
            $json_data->MaxFilesize = $file->getMaxFilesize();
            $json_data->SavedFileName = $chat_id ? $chat_id : time();
            $json_data->SavedFileName .= ".$json_data->ClientOriginalExtension";
            $json_data->SavedFilePath = $FilePath;

            $FullPath = $json_data->SavedFilePath . $json_data->SavedFileName;

            // Remove file wheter exist
            if (Storage::exists($FullPath)) {
                Storage::delete($FullPath);
            }

            // Save file indo our dir
            if (!$file->move($json_data->SavedFilePath, $json_data->SavedFileName)) {
                $json_data->msg = "Error moving uploading file! ";
                $json_data->error = true;
                // Flash::success('Error movendo o arquivo.');
            }
        } catch (\Throwable $th) {
            $json_data->msg = $th->getMessage();
            $json_data->error = true;
            // Flash::success('Error movendo o arquivo.');
        }
        return $json_data;
    }

    

}
