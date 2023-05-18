<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageValidationRequest;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\RegistrationOfImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\Undefined;

class ControllerImageStorage extends Controller
{
    public function GetImages(Request $request){
        try{
            if(!$request->input('id')){
                $images = RegistrationOfImage::whereNull('removed_at')->get();
                return response()->json($images, 200);
            }
            $id = $request->input('id'); 
            $image = RegistrationOfImage::findOrFail($id);
            return response()->json($image, 200);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Image not found'
            ], 404);
        }catch (\Exception $e){
            return response()->json([
                'error' => 'An error occurred while fetching the image'
            ], 500);
        }
    }

    public function createImage(ImageValidationRequest $request){
        try{
            $file = $request->file('image');
            $folder = $request->input('folder');
            $path = public_path('img/' . $folder);
            $filenameOrinal = $file->getClientOriginalName();
            $filename = pathinfo($filenameOrinal, PATHINFO_FILENAME) .'.webp';

            if (file_exists($path . '/' . $filename)) {
                $existingFiles = scandir($path);
                $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
                $suffix = 1;
                
                // Buscar el siguiente sufijo disponible
                while (in_array($filename, $existingFiles)) {
                    $filename = $filenameWithoutExtension . '_' . $suffix . '.webp';
                    $suffix++;
                }
            }

            // Se crea un nuevo objeto Imagick a partir de la ruta del archivo
            $image = new \Imagick($file->getRealPath());

            // Se divide el archivo GIF en múltiples cuadros o fotogramas individuales
            $image = $image->coalesceImages();

            //Se estable el formato de salida en webP
            $image->setFormat('webp');

            // Se guarda cada fotograma como una imagen webP en la ruta especifica 
            $image->writeImages($path . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp', true);

            $url = asset('img/' . $folder . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp');

            // Se guarda la información de las imagenes en la base de datos
            $SaveInformationImage = new RegistrationOfImage; 
            $SaveInformationImage->name = $filename; 
            $SaveInformationImage->url = $url; 
            $SaveInformationImage->folder = "/$folder";
            $SaveInformationImage->save();

            return response()->json([
                'message' => 'Image uploaded successfully',
                'database' => $SaveInformationImage
            ], 200);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Invalid file'
            ], 400);
        }catch (\Exception $e){
            return response()->json([
                'error' => 'An error occurred while uploading the image'
            ], 500);
        }
    }

    public function DeleteImage(Request $request){
        try{
            $id = $request->input("id");
            $image = RegistrationOfImage::find($id);
            $path = public_path('img/' . $image->folder . '/' . $image->name);
            if (file_exists($path)) {
                unlink($path);
                $image->removed_at = now();
                $image->save();
                return response()->json(['message' => 'Image deleted successfully'], 200);
            }
            return response()->json([
                'message' => 'Image not found'
            ], 404);
        }catch (ModelNotFoundException $e){
            return response()->json([
                'error' => 'The Image did not deleted'
            ], 500);
        }catch (\Exception $e){
            return response()->json([
                'error' => 'An error occurred while deleting the image'
            ], 500);
        }
    }

    public function PatchImage(ImageValidationRequest $request, $id)
    {
        try {
            $image = RegistrationOfImage::find($id);
            $newName = $image->name;

            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            if($request->input('name')){
                $newName = $request->input('name') . ".webp";
                $path = 'img/' . $image->folder;

                // Actualizar el nombre de la imagen si es diferente al nombre actual
                if ($newName !== $image->name && !file_exists($path . '/' . $newName)) {
                    $oldPath = public_path($path . '/' . $image->name);
                    $newPath = public_path($path . '/' . $newName);

                    // Renombrar el archivo en el sistema de archivos
                    if (file_exists($oldPath)) {
                        rename($oldPath, $newPath);
                    }
                }
                else{
                    return response()->json(['error' => 'The name already exists'], 409);
                }
            }

            // Actualizar la imagen si se cambia 
            if ($request->HasFile('image')) {
                $newImage = $request->file('image');
                $path = public_path('img/' . $image->folder);
                $oldPath = public_path('img/' . $image->folder . '/' . $image->name);
                $nameImage = $newImage->getClientOriginalName();
                $newName = pathinfo($nameImage, PATHINFO_FILENAME) .'.webp';
                if (file_exists($path . '/' . $newName)) {
                    $existingFiles = scandir($path);
                    $filenameWithoutExtension = pathinfo($newName, PATHINFO_FILENAME);
                    $suffix = 1;
                    
                    // Buscar el siguiente sufijo disponible
                    while (in_array($newName, $existingFiles)) {
                        $newName = $filenameWithoutExtension . '_' . $suffix . '.webp';
                        $suffix++;
                    }
                }

                // Se crea un nuevo objeto Imagick a partir de la ruta del archivo
                $UpdateImage = new \Imagick($newImage->getRealPath());

                // Se divide el archivo GIF en múltiples cuadros o fotogramas individuales
                $UpdateImage = $UpdateImage->coalesceImages();

                //Se estable el formato de salida en webP
                $UpdateImage->setFormat('webp');

                // Se guarda cada fotograma como una imagen webP en la ruta especifica 
                $UpdateImage->writeImages($path . '/' . pathinfo($newName, PATHINFO_FILENAME) . '.webp', true);

                // Borrar la imagen anterior del sistema de archivos
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Actualizar la información de la imagen en la base de datos
            $image->name = $newName;
            $image->url = url('img/' . $image->folder . '/' . $newName);

            $image->save();

            return response()->json(['message' => 'Image updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
