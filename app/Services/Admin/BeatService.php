<?php

namespace App\Services\Admin;

use Exception;
use App\Traits\ApiResponser;
use App\Models\Admin\Archive;

use Illuminate\Foundation\Validation\ValidatesRequests;

class BeatService
{
    use ValidatesRequests, ApiResponser;
    public function StorePremiumOrFree($request, $parms)
    {
    try {
        if ($request->has("file")) {
            $support = $request->file("file");
            $fileExtention = $support->getClientOriginalExtension();
            $dataFile = [
                "extension" => $support->getMimeType(),
                "filename" => time() . '-' . $support->getClientOriginalName(),
                "size" => $support->getSize(),
                "type" => 'FICHIER'
            ];
            if (in_array($fileExtention, Archive::getAllowedDocuments())) {
                $dataFile['type'] = 'DOCUMENT';
            } else if (in_array($fileExtention, Archive::getAllowedImages())) {
                $dataFile['type'] = 'IMAGE';
            } else if (in_array($fileExtention, Archive::getAllowedVideos())) {
                $dataFile['type'] = 'VIDEO';
            }
            $archive = new Archive;
            if ($parms['premium_file']) {
                $dataFile['path'] = url('storage/premiums/' . $dataFile['filename']);
                $support->storeAs('premiums', $dataFile['filename'], ['disk' => 'local']);
                $support = $archive->create($dataFile);
                $parms["premium_file_id"] = $support->id;
                return $parms;
            }
            if ($parms['free_file']) {
                $dataFile['path'] = url('storage/frees/' . $dataFile['filename']);
                $support->storeAs('frees', $dataFile['filename'], ['disk' => 'public']);
                $support = $archive->create($dataFile);
                $parms["free_file_id"] = $support->id;
               return $parms;
            }
        }
    } catch (Exception $e) {
        \DB::rollBack();
        return $this->errorResponse($e->getMessage(), 401);
    }
    }

   

   
}
