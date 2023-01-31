<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory, Filterable;

    protected $table = 'about_us';

    public function getStatus()
    {

        return
            '<div class="custom-control custom-switch custom-switch-on-success">'.
            '<input type="checkbox" class="custom-control-input change-status" value="'. $this->status.'"'.
            'data-id="'.$this->id .'"'.
            ($this->status == 1 ? "checked" : null) .' id="customSwitch'. $this->id .'">'.
            '<label class="custom-control-label"
                  for="customSwitch' .$this->id .'"></label>'.
            '</div>';
    }

    public function getAction()
    {
        return '<a class="btn-action btn btn-color-blue btn-icon btn-sm" title="Sửa" href="' .route('about-us.edit',$this->id).'"><i class="fa fa-edit"></i></a>
                <button type="submit" class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item" data-id="' . $this->id .'"><i class="fa fa-trash"></i></button>';
    }

    public static function uploadImage($inputFile, $urlFileInDB = null)
    {
        $folderUploads = '/public/about_us';

        return uploadFile($inputFile, $folderUploads, $urlFileInDB);
    }

}
