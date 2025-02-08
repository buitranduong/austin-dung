<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Model;

class FileCertificate extends Model
{
    protected $table = 'certificate_files';
    protected $fillable = ['name','content'];
}
