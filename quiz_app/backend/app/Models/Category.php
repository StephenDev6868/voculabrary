<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, NodeTrait, Filterable;

    protected $table = 'categories';

    const STATUS_ACTIVE = 1;


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
        return '<a class="btn-action btn btn-color-blue btn-icon btn-sm" title="Sửa" href="' .route('category.edit',$this->id).'"><i class="fa fa-edit"></i></a>
                <button type="submit" class="btn btn-action btn-color-red btn-icon btn-ligh btn-sm btn-remove-item" data-id="' . $this->id .'"><i class="fa fa-trash"></i></button>';
    }

    public static function uploadImage($inputFile, $urlFileInDB = null)
    {
        $folderUploads = '/public/categories';

        return uploadFile($inputFile, $folderUploads, $urlFileInDB);
    }

    public function getType()
    {
        if ($this->type == 1) {

            return '<small class="badge badge-info">Sản phẩm</small>';
        } else {

            return '<small class="badge badge-info">Bài viết</small>';
        }
    }

    public static function getCategoryByName($name)
    {
        return Category::where('name', 'LIKE', "%$name%")->where('status', 1)
            ->select('id', 'name', 'description', 'created_at', 'updated_at')->first();
    }

}
