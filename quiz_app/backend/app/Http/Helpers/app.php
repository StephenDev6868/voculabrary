<?php

if (!function_exists('getParentCategory')) {
    function getParentCategory($data, $parent = 0, $str= '', $select = 0) {
        foreach($data as $item){
            $id = $item->id;
            $name = $item->name;

            if($item->parent_id == $parent)
            {
                if ($select != 0 && $id == $select)
                {
                    echo "<option value='$id' selected='selected'>$str $name</option>";
                }
                else {
                    echo "<option value='$id'>$str $name</option>";
                }
                getParentCategory($data, $id, $str."|--", $select);
            }
        }
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($inputFile, $folderUploads, $urlFileInDB = null)
    {
        $fileName = date('Y_m_d') . '_' . Time() . '_' . $inputFile->getClientOriginalName();
        $urlFile = $inputFile->storeAs($folderUploads, $fileName);
        //delete file in db and update
        if ($urlFileInDB) {
            \Illuminate\Support\Facades\Storage::delete($urlFileInDB);
        }

        return $urlFile;
    }
}

if (!function_exists('strSlugName')) {
    function strSlugName($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }
}

function getUrlFile($link)
{
    return asset(\Illuminate\Support\Facades\Storage::url($link));
}

function formatYMD($date)
{
    if (!empty($date)) {
        return \DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }
}

function formatPrice($price){
    return number_format($price, 0, '.', ',');
}

if (!function_exists('canPermission')) {
    function canPermission($permission)
    {
        if (!auth::user()->can($permission)) {
            return abort(403);
        }
    }
}

if (!function_exists('canPermissionAjax')) {
    function canPermissionAjax($permission)
    {
        if (!auth::user()->can($permission)) {

            return abort(403, 'Bạn không có quyền thực hiện tác vụ này!');
        }
    }
}



