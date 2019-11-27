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

    public static function SavePostFile(UploadedFile $file, ?string $FilePath = '', ?string $file_name = null): stdClass
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
            $json_data->SavedFileName = $file_name ? $file_name : $file->hashName();
            $json_data->SavedFileName .= ".$json_data->ClientOriginalExtension";
            $json_data->SavedFilePath = $FilePath;
            
            $FullPath = "$json_data->SavedFilePath/$json_data->SavedFileName";
            $json_data->FullPath = $FullPath;

            // Remove file wheter exist
            if (Storage::disk('chats_files')->exists($FullPath)) {
                Storage::disk('chats_files')->delete($FullPath);
            }

            // Save file indo our dir
            if (!$file->storeAs($json_data->SavedFilePath, $json_data->SavedFileName, 'chats_files')) {
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
