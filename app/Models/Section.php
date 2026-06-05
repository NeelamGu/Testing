<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public static function sections(){
        $getSections = Section::with('categories')->where('status',1)->get()->toArray();
        return $getSections;
    }

    public static function mainSections(){
        $getSections = Section::with('categories')->where('id',1)->where('status',1)->get()->toArray();
        return $getSections;
    }

    public function categories(){
        return $this->hasMany('App\Models\Category','section_id')->where(['parent_id'=>0,'status'=>1])->with('subcategories');
    }

    public static function getCategoryName($category_id){
        $getCategoryName = Category::select('category_name')->where('id',$category_id)->first();
        return $getCategoryName->category_name;
    }
}
