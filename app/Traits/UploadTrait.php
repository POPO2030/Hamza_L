<?php
namespace App\Traits;
use Illuminate\Support\Facades\File;

trait UploadTrait
{

    private function getMonthlyFolderPath($basePath)
    {
        $folderName = date('m-Y'); // Get current month and year (e.g., 03-2025)
        $path = $basePath . '/' . $folderName; // Append the folder structure

        // Ensure the directory exists
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true, true);
        }

        return $path;
    }

    public function upload_file($file, $basePath, $i)
    {
        $folderName = date('m-Y'); 
        $path = $basePath . $folderName; 

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $file_ext = $file->getClientOriginalExtension();
        $file_name = time() . $i . '.' . $file_ext;

        $file->move($path, $file_name);

        return "$folderName/$file_name"; 
    }

    public function upload_one_file($file, $basePath)
    {
        $path = $this->getMonthlyFolderPath($basePath); 
        $file_name = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path($path), $file_name);
        return "$path/$file_name";
    }

    public function upload_img($file, $basePath)
    {
        $folderName = date('m-Y'); 
        $path = public_path(rtrim($basePath, '/') . '/' . $folderName); // Ensure no duplicate slashes

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $file_ext = $file->getClientOriginalExtension();
        $file_name = time() . '.' . $file_ext;

        $file->move($path, $file_name);

        return "$folderName/$file_name"; // Return only the folder and file name
    }
}

