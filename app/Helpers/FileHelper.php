<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Guarda un archivo base64 recibido en formato JSON con validaciones.
     *
     * @param array $fileData
     * @param string $path Carpeta donde se guardará
     * @param int $maxSizeKB Tamaño máximo en KB (por defecto: 5MB)
     * @param array $allowedTypes Tipos permitidos ('jpeg', 'png', 'pdf', etc.)
     * @return string|null Ruta del archivo o null si hubo error
     */
    public static function saveFile($fileData, string $path = 'uploads', int $maxSizeKB = 5120, array $allowedTypes = ['jpeg', 'jpg', 'png', 'gif', 'webp', 'pdf']): ?array
    {
        
        if($fileData->hasFile('avatar'))
        {
            $file = $fileData->file('avatar');
            
            $extension = $fileData->file('avatar')->getClientOriginalExtension();
             // Nombre único 
            $filename = Str::random(10) . '.' . $extension;           
            Storage::putFileAs('public/'.$path, $file, $filename);
        }                  
        // Guardar en disco
       // Storage::disk('public')->put("{$path}/{$filename}");
        

        /* return "{$path}/{$filename}"; */
        return [
        'file_name' => $filename,
        'file_path' => "{$path}/{$filename}",
        ];
    }   
}
