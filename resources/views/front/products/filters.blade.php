<?php
   use App\Models\Product;
   use App\Models\ProductsAttribute;
   use App\Models\ProductFilter;
   use App\Models\Category;
   use App\Models\Section;
   $catFilters = array();
   /*echo "<pre>"; print_r($catids); echo "--";*/
   $catseo = Route::getFacadeRoot()->current()->uri();
   if(!isset($_GET['q']) && empty($_GET['q'] )){
        $sectionCount = Section::where(['url'=>$catseo,'status'=>1])->count();
        $categoryCount = Category::where(['url'=>$catseo,'status'=>1])->count();
        if($sectionCount>0){
                $sectionDetails = Section::where(['url'=>$catseo,'status'=>1])->first()->toArray();
                $catids = Category::getCatIds($sectionDetails['id'],'section');
        }else{
            $categoryDetails = Category::with('subcategories')->where(['url'=>$catseo,'status'=>1])->first()->toArray();
            $catIdArr[] = $categoryDetails['id'];
            if(count($categoryDetails['subcategories'])>0){
                $catIds = array();
                foreach ($categoryDetails['subcategories'] as $key => $value) {
                    $catIds[] = $value['id'];
                }  
                $catids = array_merge($catIdArr,$catIds);   
            }else{
                $catids = $catIdArr;    
            }
        }
       //$catids = Category::getOtherCatIds($catids);    
   }
   /*echo "<pre>"; print_r($getOtherCatIds); die;*/
   ?>
   <style>
details > summary {
  padding: 4px;
  width: 200px;
  background-color: #f7ede3;
  border: none;
  box-shadow: 1px 1px 2px #bbbbbb;
  cursor: pointer;
  font-weight: 600;
}

details > p {
  background-color: #eeeeee;
  padding: 4px;
  margin: 0;
  box-shadow: 1px 1px 2px #bbbbbb;
}
</style>
<main class="main" role="main">
    <div class="wrapper cf">
        <aside class="sidebar">
            <div class="filter-title-area">
                <h2 class="sidebar-heading">
                    <a href=""><i class="fa fa-chevron-left left-aarow-icon"></i></a>FILTRE
                </h2>
                <div class="filter-text-area">
                    <a href="" class="apply-filter-text" onclick="closeBtn()">Vis resultater</a>
                    <a href="" class="clear-all-link ">Nullstill</a>
                </div>
            </div>
            <ul class="filter ul-reset">

                <?php /* <li class="filter-item">
                    <section class="filter-item-inner">
                        <h2 class="filter-item-inner-heading minus">
                            hele norge
                        </h2>
                        <ul class="filter-attribute-list ul-reset">
                            <div class="filter-attribute-list-inner">
                                
                                <li class="filter-attribute-item">
                                    <input type="checkbox" id="wholenorway" name="wholenorway" class="filter-attribute-checkbox ib-m filterAjax" value="Yes" @if(!empty($_GET['wholenorway']) && $_GET['wholenorway']=="Yes") checked @endif>
                                    <label for="size-attribute-1" class="filter-attribute-label ib-m">
                                    hele norge
                                    </label>
                                </li>
                            </div>
                        </ul>
                    </section>
                </li> */ ?>


                <?php $sizes = ProductsAttribute::sizes($catids);
                        /*echo "<pre>"; print_r($sizes); die;*/
                ?>
                @if(count($sizes)>0)
                <li class="filter-item">
                    <section class="filter-item-inner">
                        <h2 class="filter-item-inner-heading minus">
                            Størrelse
                        </h2>
                        <ul class="filter-attribute-list ul-reset">
                            <div class="filter-attribute-list-inner">
                                @foreach($sizes as $skey=> $size)
                                <?php if(isset($_GET['size']) && !empty($_GET['size'])){
                                  $explodeSizeArr = explode('~',$_GET['size']);
                                      if(!empty($explodeSizeArr) && in_array(str_replace('/','_',$size->size), $explodeSizeArr)){
                                          $sizechecked  ="checked";
                                      }else{
                                          $sizechecked  ="";
                                      }
                                  }else{
                                  $sizechecked  ="";
                                  }
                                ?>
                                <li class="filter-attribute-item">
                                    <input type="checkbox" id="size{{$skey}}" name="size" class="filter-attribute-checkbox ib-m filterAjax" value="{{ str_replace('/','_',$size->size)}}" {{ $sizechecked }}>
                                    <label for="size-attribute-1" class="filter-attribute-label ib-m">
                                    {{ $size->size }}
                                    </label>
                                </li>
                                @endforeach
                            </div>
                        </ul>
                    </section>
                </li>
                @endif

                <?php $states = Product::states($catids);
                   // echo "<pre>"; print_r($states); die;
                ?>
                
                <li class="filter-item">
                    <section class="filter-item-inner">
                        <h2 class="filter-item-inner-heading minus">
                        Plassering<br><small class="smLoc">(leverandørens adresse)</small>
                        </h2>
                        <ul class="filter-attribute-list ul-reset">
                            <div class="filter-attribute-list-inner">
                                @foreach($states as $skey=> $state)
                                <?php 
                                if(isset($_GET['state1']) && !empty($_GET['state1'])){ 
                                  $explodeCityArr = explode('~',$_GET['state1']);
                                      if(!empty($explodeCityArr) && in_array(str_replace('/','_',$state), $explodeCityArr)){
                                          $statechecked  ="checked";
                                      }else{
                                          $statechecked  ="";
                                      }
                                  }else{
                                  $statechecked  ="";
                                  }
                                ?>
                                <li class="filter-attribute-item">
                                    <input type="checkbox" id="state{{$skey}}" name="state1" class="filter-attribute-checkbox ib-m filterAjax" value="{{ str_replace('/','_',$state)}}" {{ $statechecked }}>
                                    <label for="state-attribute-1" class="filter-attribute-label ib-m">
                                    <strong>{{ ucfirst(strtolower($state)) }}</strong>
                                    </label>
                                </li>
                                <?php $stateCities = Product::stateCities($catids,$state);
                                ?>
                                @foreach($stateCities as $skey=> $city)
                                <?php 
                                if(isset($_GET['city1']) && !empty($_GET['city1'])){ 
                                  $explodeCityArr = explode('~',$_GET['city1']);
                                      if(!empty($explodeCityArr) && in_array(str_replace('/','_',$city), $explodeCityArr)){
                                          $citychecked  ="checked";
                                      }else{
                                          $citychecked  ="";
                                      }
                                  }else{
                                  $citychecked  ="";
                                  }
                                ?>
                                <li class="filter-attribute-item" style="margin-left:10px;">
                                    <input type="checkbox" id="city{{$skey}}" name="city1" class="filter-attribute-checkbox ib-m filterAjax" value="{{ str_replace('/','_',$city)}}" {{ $citychecked }}>
                                    <label for="city-attribute-1" class="filter-attribute-label ib-m">
                                    {{ ucfirst(strtolower($city)) }}
                                    </label>
                                </li>
                                @endforeach
                                @endforeach
                            </div>
                        </ul>
                    </section>
                </li>
                <?php $cities = Product::cities($catids);
                    /*echo "<pre>"; print_r($cities); die;*/
                ?>
                <?php /* <li class="filter-item">
                    <section class="filter-item-inner">
                        <h2 class="filter-item-inner-heading minus">
                            By
                        </h2>
                        <ul class="filter-attribute-list ul-reset">
                            <div class="filter-attribute-list-inner">
                                @foreach($cities as $skey=> $city)
                                <?php 
                                if(isset($_GET['city']) && !empty($_GET['city'])){ 
                                  $explodeCityArr = explode('~',$_GET['city']);
                                      if(!empty($explodeCityArr) && in_array(str_replace('/','_',$city->city), $explodeCityArr)){
                                          $citychecked  ="checked";
                                      }else{
                                          $citychecked  ="";
                                      }
                                  }else{
                                  $citychecked  ="";
                                  }
                                ?>
                                <li class="filter-attribute-item" style="margin-left:10px;">
                                    <input type="checkbox" id="city{{$skey}}" name="city" class="filter-attribute-checkbox ib-m filterAjax" value="{{ str_replace('/','_',$city->city)}}" {{ $citychecked }}>
                                    <label for="city-attribute-1" class="filter-attribute-label ib-m">
                                    {{ $city->city }}
                                    </label>
                                </li>
                                @endforeach
                            </div>
                        </ul>
                    </section>
                </li> */ ?>

                <?php $states = Product::productStates($catids);
                   // echo "<pre>"; print_r($states); die;
                ?>
                <li class="filter-item">
                    
                        <section class="filter-item-inner">
                            <h2 class="filter-item-inner-heading minus">
                            Levering<br><small class="smLoc">(Leverandørens leveringsområde)</small>
                            </h2>
                            
                            <ul class="filter-attribute-list ul-reset">
                                <div class="filter-attribute-list-inner">
                                    <li class="filter-attribute-item">
                                    <input type="checkbox" id="wholenorway" name="wholenorway" class="filter-attribute-checkbox ib-m filterAjax" value="Yes" @if(!empty($_GET['wholenorway']) && $_GET['wholenorway']=="Yes") checked @endif>
                                    <label for="size-attribute-1" class="filter-attribute-label ib-m">
                                    hele norge
                                    </label>
                                </li>
                                    @foreach($states as $skey=> $state)
                                    <?php 
                                    if(isset($_GET['state']) && !empty($_GET['state'])){ 
                                      $explodeCityArr = explode('~',$_GET['state']);
                                          if(!empty($explodeCityArr) && in_array(str_replace('/','_',$state), $explodeCityArr)){
                                              $statechecked  ="checked";
                                          }else{
                                              $statechecked  ="";
                                          }
                                      }else{
                                      $statechecked  ="";
                                      }
                                    ?>
                                    <details>
                                    <summary>{{ ucfirst(strtolower($state)) }}<span style="float:right">&#8597;</span></summary>        
                                    <li class="filter-attribute-item">

                                        <input type="checkbox" id="state{{$skey}}" name="state" class="filter-attribute-checkbox ib-m filterAjax" value="{{ str_replace('/','_',$state)}}" {{ $statechecked }}>
                                        <label for="state-attribute-1" class="filter-attribute-label ib-m">
                                        <strong>{{ ucfirst(strtolower($state)) }}</strong>
                                        </label>

                                    </li>
                                    <?php 
                                    $stateCities = Product::productStateCities($catids,$state);
                                    //dd($stateCities);
                                    ?>
                                    
                                    @foreach($stateCities as $skey=> $city)
                                    <?php 
                                    if(isset($_GET['city']) && !empty($_GET['city'])){ 
                                      $explodeCityArr = explode('~',$_GET['city']);
                                          if(!empty($explodeCityArr) && in_array(str_replace('/','_',$city), $explodeCityArr)){
                                              $citychecked  ="checked";
                                          }else{
                                              $citychecked  ="";
                                          }
                                      }else{
                                      $citychecked  ="";
                                      }
                                    ?>
                                    
                                    <li class="filter-attribute-item" style="margin-left:10px;">
                                        <input type="checkbox" id="city{{$skey}}" name="city" class="filter-attribute-checkbox ib-m filterAjax" value="{{ str_replace('/','_',$city)}}" {{ $citychecked }}>
                                        <label for="city-attribute-1" class="filter-attribute-label ib-m">
                                        {{ ucfirst(strtolower($city)) }}
                                        </label>
                                    </li>
                                    
                                    @endforeach
                                    </details>
                                    @endforeach
                                </div>
                            </ul>

                        </section>
                    
                </li>
                

                @if(isset($categoryDetails['subcategories']) && !empty($categoryDetails['subcategories']))
                <li class="filter-item">
                    <section class="filter-item-inner">
                        <h2 class="filter-item-inner-heading minus">
                             Kategorier
                        </h2>
                        <ul class="filter-attribute-list ul-reset">
                            <div class="filter-attribute-list-inner">
                                @foreach($categoryDetails['subcategories'] as $subcatkey=> $category)
                                  <?php $checkCat="";?>
                                  @if(isset($_GET['category'])) 
                                      <?php $explodeCats = explode('~',$_GET['category']);?>
                                      @if(in_array($category['id'],$explodeCats))
                                          <?php $checkCat="checked";?>
                                      @endif
                                  @endif
                                <li class="filter-attribute-item">
                                    <input type="checkbox" id="category{{$subcatkey}}" name="category" class="filter-attribute-checkbox ib-m filterAjax" value="{{$category['id']}}" {{ $checkCat }}>
                                    <label for="category{{$subcatkey}}" class="filter-attribute-label ib-m">
                                    {{$category['category_name']}}
                                    </label>
                                </li>
                                @endforeach
                            </div>
                        </ul>
                    </section>
                </li>
                @endif

                <li class="filter-item">
                    <section class="filter-item-inner">
                        <h2 class="filter-item-inner-heading minus">
                            Prisnivå
                        </h2>
                        <ul class="filter-attribute-list ul-reset">
                            <div class="filter-attribute-list-inner">
                                
                                <li class="filter-attribute-item">
                                    <input type="checkbox" id="range1" name="range" class="filter-attribute-checkbox ib-m filterAjax" value="Low" @if(isset($_GET['range'])&&$_GET['range']=="Low") checked @endif>
                                    <label for="range1" class="filter-attribute-label ib-m"><span class="price-filter-dollor">$</span></label>
                                </li>
                                <li class="filter-attribute-item">
                                    <input type="checkbox" id="range1" name="range" class="filter-attribute-checkbox ib-m filterAjax" value="Medium" @if(isset($_GET['range'])&&$_GET['range']=="Medium") checked @endif>
                                    <label for="range1" class="filter-attribute-label ib-m"><span class="price-filter-dollor">$$</span></label>
                                </li>
                                <li class="filter-attribute-item">
                                    <input type="checkbox" id="range1" name="range" class="filter-attribute-checkbox ib-m filterAjax" value="High" @if(isset($_GET['range'])&&$_GET['range']=="High") checked @endif>
                                    <label for="range1" class="filter-attribute-label ib-m"><span class="price-filter-dollor">$$$</span></label>
                                </li>
                            </div>
                        </ul>
                    </section>
                </li>
            </ul>
        </aside>
    </div>
</main>
            