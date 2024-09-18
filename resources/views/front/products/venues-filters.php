<?php include 'include/header.php'; ?>
<style>
   #categoryFilter
   {
   border: 1px solid #e6e6e6;
   width: 100%;
   max-width: 150px;
   padding: 10px;
   margin-top: 17px;
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
   background-color: #eee;
   font-size: 1.6em;
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

.filter-attribute-item {
   padding-left: 10px;
   margin-top: 5px;
}

.filter-attribute-item:first-child {
   margin-top: 0;
}


</style>
<div class="page-wrapper">
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
               <li><a href="index.html">Home</a></li>
               <li><a href="#">Venues</a></li>
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
         <div class="col-md-8 col-sm-8 col-xs-12 ">
            <h4 class="title text-black font-weight-700">Banquet Halls</h4>
            <p class="details pt-5 text-black">Showing 21550 results as per your search criteria.</p>
         </div>
         <div class="col-sm-4">
            <select id="categoryFilter">
               <option value="lastest">Lastest</option>
               <option value="a">Price</option>
            </select>
         </div>
      </div>
   </div>
</section>
<section class="">
   <div class="auto-container pb-35 mb-4">
      <div class="row">
         <div class="col-sm-3">
            <main class="main" role="main">
   <div class="wrapper cf">
      <aside class="sidebar">
         <h2 class="sidebar-heading">
            Filter by
         </h2>

         <ul class="filter ul-reset">
            <li class="filter-item">
               <section class="filter-item-inner">
                  <h2 class="filter-item-inner-heading minus">
                     Size
                  </h2>
                  <ul class="filter-attribute-list ul-reset">
                     <div class="filter-attribute-list-inner">
                        <li class="filter-attribute-item">
                           <input type="checkbox" id="colour-attribute-1" class="filter-attribute-checkbox ib-m">
                           <label for="colour-attribute-1" class="filter-attribute-label ib-m">
                              Small
                           </label>
                        </li>
                        <li class="filter-attribute-item">
                           <input type="checkbox" id="colour-attribute-2" class="filter-attribute-checkbox ib-m">
                           <label for="colour-attribute-2" class="filter-attribute-label ib-m">
                              Medium
                           </label>
                        </li>
                        <li class="filter-attribute-item">
                           <input type="checkbox" id="colour-attribute-3" class="filter-attribute-checkbox ib-m">
                           <label for="colour-attribute-3" class="filter-attribute-label ib-m">
                              Large
                           </label>
                        </li>
                     </div>
                  </ul>
               </section>
            </li>
             <li class="filter-item">
               <section class="filter-item-inner">
                  <h2 class="filter-item-inner-heading minus">
                     City
                  </h2>
                  <ul class="filter-attribute-list ul-reset">
                     <div class="filter-attribute-list-inner">
                        <li class="filter-attribute-item">
                           <input type="checkbox" id="colour-attribute-1" class="filter-attribute-checkbox ib-m">
                           <label for="colour-attribute-1" class="filter-attribute-label ib-m">
                              Mumbai
                           </label>
                        </li>
                        <li class="filter-attribute-item">
                           <input type="checkbox" id="colour-attribute-2" class="filter-attribute-checkbox ib-m">
                           <label for="colour-attribute-2" class="filter-attribute-label ib-m">
                              Delhi
                           </label>
                        </li>
                        <li class="filter-attribute-item">
                           <input type="checkbox" id="colour-attribute-3" class="filter-attribute-checkbox ib-m">
                           <label for="colour-attribute-3" class="filter-attribute-label ib-m">
                              Bangalore
                           </label>
                        </li>
                     </div>
                  </ul>
               </section>
            </li>
         </ul>
      </aside>
   </div>
</main>
         </div>
         <div class="col-sm-9">
            <div class="sec-content">
               <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product1.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!-- <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product2.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                              <!-- <p class="pl-30">Non Veg <span
                                 style="display: block; font-size: 20px; color: #000;">KR 2299</span></p> -->
                           </div>
                           <!-- <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product3.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!-- <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product4.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!-- <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product5.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!-- <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product6.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!-- <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product7.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!--  <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product8.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!-- <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                     <div class="event-item">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="images/product9.jpg" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <div class="" style="display: flex; justify-content:space-between;">
                              <a href="detail.html">
                                 <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                              </a>
                           </div>
                           <address class="text-dark font-14 mb-10">
                              <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                              <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                              Farmhouses</span>
                           </address>
                           <div class="" style="display: flex; justify-content:;">
                              <p class="price">
                                 <i class="fa fa-inr margin-r-5"></i>
                                 <span style="font-size:20px; color: #000;"> 1,200</span>
                              </p>
                           </div>
                           <!--  <div class="" style="display: flex; justify-content:;">
                              <p class="box">100-700 pax</p>
                              <p class="box ml-20">Indoor</p>
                              <p class="box ml-20">+4More</p>
                              </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="auto-container text-center">
         <nav aria-label="Page navigation example">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  </a>
               </li>
               <li class="page-item"><a class="page-link" href="#">1</a></li>
               <li class="page-item"><a class="page-link" href="#">2</a></li>
               <li class="page-item"><a class="page-link" href="#">3</a></li>
               <li class="page-item"><a class="page-link" href="#">4</a></li>
               <li class="page-item"><a class="page-link" href="#">5</a></li>
               <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  </a>
               </li>
            </ul>
         </nav>
      </div>
</section>
<?php include 'include/footer.php'; ?>
<script>
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
</script>
</div>
<!--End pagewrapper-->