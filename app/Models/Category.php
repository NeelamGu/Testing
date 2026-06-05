<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id')->select('id','name');
    }

    /*public function parentcategory(){
        return $this->belongsTo('App\Models\Category','parent_id')->select('id','category_name');
    }*/

    public function parentcategory(){
        return $this->hasOne('App\Models\Category','id','parent_id')->select('id','category_name','url')->orderby('id','ASC')->where('status',1);
    }

    public function subcategories(){
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public static function categoryDetails($url){
        $categoryDetails = Category::select('id','parent_id','category_name as name','url','description','meta_title','meta_description','meta_keywords')->with(['subcategories'=>function($query){
            $query->select('id','parent_id','category_name as name','url','description');
        }])->where('url',$url)->first()->toArray();
        /*dd($categoryDetails);*/
        $catIds = array();
        $catIds[] = $categoryDetails['id'];

        if($categoryDetails['parent_id']==0){
            // Only Show Main Category in Breadcrumb
            $breadcrumbs = '<li class="is-marked">
                <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['name'].'</a>
            </li>';
        }else{
            // Show Main and Sub Cateogory in Breadcrumb
            $parentCategory = Category::select('category_name as name','url')->where('id',$categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<li class="has-separator">
                <a href="'.url($parentCategory['url']).'">'.$parentCategory['name'].'</a>
            </li><li class="is-marked">
                <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['name'].'</a>
            </li>';
        }


        foreach ($categoryDetails['subcategories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
        }

        $resp = array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
        return $resp;
    }

    public static function getCategoryName($category_id){
        $getCategoryName = Category::select('category_name')->where('id',$category_id)->first();
        return $getCategoryName->category_name;
    }

    public static function getCategoryImage($category_id){
        $getCategoryImage = Category::select('category_image')->where('id',$category_id)->first();
        return $getCategoryImage->category_image;
    }

    public static function getMainCategoryImage($category_id){
        $category = Category::select('id','parent_id','category_image')->where('id',$category_id)->first();
        if(!$category){
            return '';
        }

        $fallbackImage = trim((string)($category->category_image ?? ''));
        $safetyCounter = 0;

        while((int)($category->parent_id ?? 0) !== 0 && $safetyCounter < 20){
            $parent = Category::select('id','parent_id','category_image')->where('id',$category->parent_id)->first();
            if(!$parent){
                break;
            }
            $category = $parent;
            $safetyCounter++;
        }

        $mainImage = trim((string)($category->category_image ?? ''));
        if($mainImage !== ''){
            return $mainImage;
        }

        return $fallbackImage;
    }

    public static function getCatIds($id,$urltype){
        if($urltype=="section"){
            $getCatIds = Category::select('id')->where('section_id',$id)->groupBy('id')->pluck('id');    
        }else{
            $getCatIds = array();
        }
        return $getCatIds;
    }
}
