@extends('front.layout.layout')
@section('content')
<style>
   #categoryFilter
   {
   border: 1px solid #e6e6e6;
   width: 100%;
   max-width: 150px;
   padding: 10px;
   float: right;
   color: #2e2e2e;
   }

   .sidebar {
   float: left;
   width:100%;
}

.sidebar-heading {
   padding: 10px;
   margin-top: 0;
   margin-bottom: 0;
   font-size:16px;
   color:#E78002;
}

.filter-item {
   border-right: 1px solid #eee;
   border-left: 1px solid #eee;
}

.filter-item-inner {
   border-bottom: 1px solid #eee;
}

.filter-item-inner-heading {
   position: relative;
   padding: 10px;
   padding-right: 30px;
   margin-top: 0;
   margin-bottom: 0;
   font-size: 1.2em;
   cursor: pointer;
   color:#000;
}

.filter-item-inner-heading.minus:after,
.filter-item-inner-heading.plus:after {
   position: absolute;
   top: 33%;
   right: 7.5%;
   font-size: .6em;
}

.filter-item-inner-heading.minus:after {
   content: "▲";
   color:#f48d1f;
}

.filter-item-inner-heading.plus:after {
   content: "▼";
   color: #f48d1f;
}

.filter-attribute-list {
   overflow: hidden;
}

.filter-attribute-list-inner {
   padding: 0 10px 15px;
}

.filter-attribute-label
{
   font-weight: normal;
   vertical-align: middle;
   margin-left: 3px;;
}

.filter-attribute-item {
   padding-left: 10px;
   margin-top: 5px;
}

.filter-attribute-item:first-child {
   margin-top: 0;
}
.event-item
{
   margin-top:0;
   margin-bottom:20px;
}
 .filter-mobile {
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 999999;
    background-color: #fff;
    margin: 0;
    max-width: 100%;
    left: 0;
    padding: 0px 20px;
    box-shadow: 5px 5px 20px 0 rgb(0 0 0 / 20%);
    border-top: 1px solid #00000026;
    display: none;
}
.sort-by-list
{
   width:100%;
   max-width:200px;
   margin-left:auto;
}  
.sort-by-list label 
{
    font-weight: 500;
    margin-top: 12px;
    margin-right: 0;
    color: #000;
}
.filter-text-area
{
   .filter-text-area 
    display: inline-block;
    float: right;
    margin-right: 19px;
    margin-top: 12px;
}
.filter-text-area:hover
{
   color:#fff;
}
.clear-all-link
{
   border: 1px solid #e78002;
   padding: 4px 7px;
   color: #e78002;
}
.clear-all-link:hover
{
   color: #e78002;
}
.apply-filter-text
{
   margin-right:10px;
   background-color: #E78002;
    color: #fff;
    /* padding: 5px 10px; */
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 999999;
    left: 0;
    text-align: center;
    padding: 1.2rem 0;
}
.sidebar-heading
{
   display:inline-block;
}
.filter-title-area
{
   background-color: #eee;

}
.filter-text-area
{
   display:none;
}
.left-aarow-icon
{
   display:none;
}

div#appendProductListing .event-item 
{
    height: 430px !important;
    overflow-x:hidden;
    overflow-y: hidden;
}

@media only screen and (max-width: 768px) {
  #appendProductListing
{
padding:0px 10px 0 20px;
}  
  .sidebar
  {
   display:none;
  }
  .left-aarow-icon
  {
    display: inline-block;
    margin-right: 6px;
    font-size: 14px;
    font-weight: normal;
    color: #e78002;
    width: 10px;
  }
  .filter-mobile 
  {
    display: block;
  }
  .sort-by-list
  {
   margin-left:0;
  }
  .venue-sec
  {
      margin-bottom:0 !important;
  }
     .sec-content .img-fullwidth
    {
       margin-top:0 !important;
    }
    .sort-by-list
    {
      margin-bottom:20px;
    }
    .filter-btn
    {
      padding: 11px;
      display: block;
      margin: 0 auto;
      font-size: 16px;
      text-align: center;
    }
    .filter-btn:hover
    {
      color:#E78002;
    }

    .sidebar
    {
      position: fixed !important;
      top: 0px;
      left: 0px !important;
      padding: 15px;
      background: #fff;
      height: 100%;
      overflow-y: scroll;
      z-index: 99999;
    }
    .filter-text-area
    {
       display:block;
    }



}

</style>
<div class="page-wrapper listing-page">
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="images/venue.png" alt="">
         </div>
         <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="{{ url('/') }}">Min side</a></li>
                  <li><a href="#">{{ $categoryDetails['categoryDetails']['name'] }}</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <section style="margin-bottom:30px;" class="venue-sec">
      <div class="auto-container">
         <div class="row clearfix">
            <!--Column-->
            <div class="col-md-8 col-sm-8 col-6 col-w-mobile">
               <h1 class="font-20 title text-black font-weight-700">{{ $categoryDetails['categoryDetails']['name'] }}</h1>
               <p class="details pt-5 text-black">Viser <span id="UpdateProCount">{{ count($categoryProducts) }}</span> resultater i henhold til søkekriteriene dine.</p>
            </div>
            <div class="col-sm-4 col-6">
                @if(!isset($_GET['q']) && empty($_GET['q'] ))
               <div class="sort-by-list">
                   <label>Sorter etter:</label>
                   <select name="sort" id="categoryFilter" class="getsort">
                      <option data-display="Select">Velg</option>
                      <option value="lth">-Pris: Lav til høy</option>
                      <option value="htl">-Pris: Høy til lav</option>
                      <option value="newest">-Nyeste først</option>
                      <option value="oldest">-Eldste først </option>
                      <!-- <option value="discount">Discount</option> -->
                      <!-- <option value="best-seller">Best Seller</option> -->
                      <!-- <option value="featured">Featured</option> -->
                      <option value="popular">-Mest populære</option>
                   </select>
                </div>
                @endif
            </div>
         </div>
      </div>
   </section>
   <section class="">
    <div class="auto-container pb-35 mb-4">
        <div class="row">
            @if(!isset($_GET['q']) && empty($_GET['q'] ))
            <div class="col-sm-3">
                @include('front.products.filters')
            </div>
            <div class="col-sm-9">
                <div class="sec-content">
                  <div class="row" id="appendProductListing">
                     @include('front.products.products_listing')
                  </div>
               </div>
            </div>
            @else
            <div class="col-sm-12">
                <div class="sec-content">
                  <div class="row" id="appendProductListing">
                     @include('front.products.products_listing')
                  </div>
               </div>
            </div>
            @endif
            <div class="filter-mobile">
                <a class="filter-btn" href="#"><i class="fa fa-filter" aria-hidden="true"></i> Filter</a>
            </div>
        </div>
        @if(!isset($_GET['q']) && empty($_GET['q'] ))
        <div class="auto-container text-center">
            <nav aria-label="Page navigation example">
                @if(isset($_GET['sort']))
                    <div>{{ $categoryProducts->appends(['sort'=>$_GET['sort']])->links() }}</div>
                @else
                    <div>
                        {{$categoryProducts->links('vendor.pagination.bootstrap-4')}}
                    </div>
                @endif
            </nav>
        </div>
        @endif
</section>
</div>
@stop
@section('javascript')
@parent
<!-- <script>
    /////// j
    
    //// filter accordion
    function accordion(section, heading, list) {
       $(section).each(function() {
          var that = this,
                listHeight = $(this).find(list).height();
    
          $(this).find(heading).click(function() {
             $(this).toggleClass("plus");
             $(that).find(list).toggle({
                "height": "0"
             }, 250);
          });
       });
    };
    accordion('.filter-item', '.filter-item-inner-heading', '.filter-attribute-list');
    
    $(".filter-btn").click(function()
    {
      $(".sidebar").toggle();
    });
</script> -->
<script>
  $(document).ready(function () {
   // Monitor sidebar visibility
   $(".filter-btn").click(function () {
      // Toggle the sidebar visibility
      $(".sidebar").toggle();

      // Check if the sidebar is visible
      if ($(".sidebar").css("display") === "block") {
         // Remove the z-index from .filter-mobile
         $(".filter-mobile").css("z-index", "auto");
      } else {
         // Reset the z-index for .filter-mobile
         $(".filter-mobile").css("z-index", "999999");
      }
   });
});

</script>
<script type="text/javascript">
   jQuery(document).ready(function($){
     //Add to Wishlist
     $(document).on('click','.addWishList',function(){
       $('.PleaseWaitDiv').show();
       var proid = $(this).data('productid');
       $.ajax({
         data : {
           "_token": "{{ csrf_token() }}",
           "proid":proid
         },
         type : 'post',
         url : '/add-to-wishlist',
         success:function(resp){ 
           if(resp.status){
             if(resp.message ==='set'){
               $('a[data-productid='+proid+']').children().removeClass('fa-heart-o');
               $('a[data-productid='+proid+']').children().addClass('fa-heart');
             }else if(resp.message ==='unset'){
               $('a[data-productid='+proid+']').children().removeClass('fa-heart');
               $('a[data-productid='+proid+']').children().addClass('fa-heart-o');
             }
           }else{
             alert(resp.message);
             window.location.reload();
           }
           $('.PleaseWaitDiv').hide();
         },
         error:function(){
           //Nothing to do
         }
       }); 
     });
   
     //Filter Products
       var queryStringObject = {};
       if($('.filtertrue').length > 0) {
           $(".filterAjax").each( function () {
               var name = $(this).attr('name');
               queryStringObject[name] = [];
               $.each($("input[name='"+$(this).attr('name')+"']:checked"), function(){
                   queryStringObject[name].push($(this).val());
               });
               if(queryStringObject[name].length == 0){
                   delete queryStringObject[name];
               }
           });
           var value = $('.getsort option:selected').val();
           var name= $('.getsort').attr('name');
           queryStringObject[name] = [value];
           if(value==""){
               delete queryStringObject[name];
           }
       }
       $(".filterAjax").click(function(){
           var name = $(this).attr('name');
           /* alert(name); */
           queryStringObject[name] = [];
           $.each($("input[name='"+$(this).attr('name')+"']:checked"), function(){
               queryStringObject[name].push($(this).val());
           });
           if(queryStringObject[name].length == 0){
               delete queryStringObject[name];
           }
           filterproducts(queryStringObject);
       });
       
       $(document).on('change','.getsort',function(){
           var value = $(this).val();
           var name= $(this).attr('name');
           queryStringObject[name] = [value];
           if(value==""){
               delete queryStringObject[name];
           }
           filterproducts(queryStringObject);
       });
   });
   
     function filterproducts(queryStringObject){
       if( window.innerWidth < 575 ) {
         //nothing to do
       }else{
         /*$(".PleaseWaitDiv").show();*/
       }
         let searchParams = new URLSearchParams(window.location.search);
       if(searchParams.has('q')){
           let parameterQuery = searchParams.get('q');
           var queryString = "?q="+parameterQuery;
       }else{
           var queryString = "";
       }
         for (var key in queryStringObject) {
             if(queryString==''){
                 queryString +="?"+key+"=";
             }else{
                 queryString +="&"+key+"=";
             }
             var queryValue = "";
             for (var i in queryStringObject[key]) {
                 if(queryValue==''){
                     queryValue += queryStringObject[key][i];
                 } else {
                     queryValue += "~"+queryStringObject[key][i];
                 }
             }
             queryString += queryValue;
         }
         if (history.pushState) {
             var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + queryString;
             window.history.pushState({path:newurl},'',newurl);
         }
         if (newurl.indexOf("?") >= 0) {
             newurl = newurl+"&json=";
         }else{
             newurl = newurl+"?json=";
         }
         $.ajax({
             url : newurl,
             type : 'get',
             dataType:'json',
             success:function(resp){
                 $("#appendProductListing").html(resp.view);
                 $("#appendProductPagination").html(resp.pagination_view);
                 /* alert(resp.totalProducts); */
                 $("#UpdateProCount").text(resp.totalProducts);
                 $(".PleaseWaitDiv").hide();
   
                 $("img").lazyload({
                 effect : "fadeIn",
                 combined: true,
                 // placeholder: "Loading ..",
                 });
                 $(window).resize();
             },
             error:function(){}
         });
     }
     /*/*fix sidebar position*/
   
     function debounce(func,time){var time=time||100;var timer;return function(event){if(timer){clearTimeout(timer)};timer=setTimeout(func,time,event);};}
     $(function() {
       $("#price-range").slider({range: true, min: 50, max: 5000, values: [50, 5000],
         slide: function(event, ui) {
             $("#priceRange").val(ui.values[0] + "-" + ui.values[1]);
         },
         change: function() {
             debounce(function() {
                 $("input[name='price']").val($("#priceRange").val()).click();
             }, 100)();
         }
       });
       $("#priceRange").val($("#price-range").slider("values", 0) + "-" + $("#price-range").slider("values", 1));
     });
   
     $(document).on('click','#pricesort',function(){  
         var minprice = parseInt($('#from_range').val());
         var maxprice= parseInt($('#to_range').val());
         /*if (isNaN( $("#minprice").val() )) {
             alert("Please enter valid Min Price");
             return false;
         }*/
         queryStringObject["price"] = [minprice+"-"+maxprice];
         if(minprice==""&& maxprice==""){
             delete queryStringObject["price"];
         }
         $("#priceRange").val(minprice + "-" + maxprice);
   
         debounce(function() {
                 $("input[name='price']").val($("#priceRange").val()).click();
             }, 100)();
             
         RefreshFilters("yes");
         // filterproducts(queryStringObject);
     });
   
</script>
<script type="text/javascript">
   $(document).on('click','#FiltersBtn',function(){
     $('#FilterActions').show();
   })
   $(document).on('click','#ApplyBtn',function(){
     $('#FilterActions').hide();
   })
</script>
<script src="{{asset('front/js/frontend_js/rang_slider.js') }}"></script> 
<script src="{{asset('front/js/frontend_js/jquery-ui.min.js') }}"></script>
@stop