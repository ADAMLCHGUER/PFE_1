<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ville extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'image',
        'description',
        'populaire',
    ];

    protected $casts = [
        'populaire' => 'boolean',
    ];
    
    // Add these methods to handle file uploads
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "villes";

        // If a new file is uploaded, delete the old one
        if ($value == null) {
            // Delete old file from disk
            if (isset($this->attributes[$attribute_name]) && $this->attributes[$attribute_name] != null) {
                Storage::disk($disk)->delete($this->attributes[$attribute_name]);
            }
            // Set null in the database
            $this->attributes[$attribute_name] = null;
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        if (request()->hasFile($attribute_name) && request()->file($attribute_name)->isValid()) {
            // 1. Delete old file if exists
            if (isset($this->attributes[$attribute_name]) && $this->attributes[$attribute_name] != null) {
                Storage::disk($disk)->delete($this->attributes[$attribute_name]);
            }
            // 2. Generate a filename.
            $file = request()->file($attribute_name);
            $new_file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();

            // 3. Store the file on disk.
            Storage::disk($disk)->put($destination_path.'/'.$new_file_name, file_get_contents($file));

            // 4. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$new_file_name;
        }
    }
}