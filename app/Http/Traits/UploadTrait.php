<?php
namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
       
        if (is_null($filename))
        {
            $name=Str::random(16).$uploadedFile->getClientOriginalName();
        }
        else
        {
            $name=$filename;
        }


        $image_path = $uploadedFile->storeAs($folder, $name, $disk);

        return  $image_path;
    }
    

public function uploadPublic(UploadedFile $uploadedFile, $folder = null)
{
     $name=time().$uploadedFile->getClientOriginalName();
     $destenation=public_path().'/'.$folder;
     $uploadedFile->move($destenation,$name);
     return $folder.'/'.$name;
}
public function uploadMulti(array $uploadedFiles, $folder = null)
{
    foreach($uploadedFiles as $file)
     {
        $name=time().$file->getClientOriginalName();
     $destenation=public_path().'/'.$folder;
     $file->move($destenation,$name);
        $pathes[]=$folder.'/'.$name;
     }
     return $pathes;
}

}