@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="{{ asset('front/images/blogMain.png') }}" alt="">
         </div>
         <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="{{ url('/')}}">Min side</a></li>
                  <li><a href="#">Blogg</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <section class="blog-sec">
      <div class="auto-container pt-20">
         <div class="row clearfix">
            <!--Column-->
            <!-- <div class="col-md-12 col-sm-12 col-xs-12 ">
               <h4 class="title blog-title text-black font-30 text-center font-weight-700">Flerfarget utsmykket Lehengas
                  Det vil <br> Stjel dine hjerter!</h4>
            </div> -->
         </div>
      </div>
   </section>
   <section class="blog-page-section">
      <div class="auto-container pb-35">
         <div class="sec-content">
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item blogListing">
                     <a href="{{ url('blog-detail')}}">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blogHero.png') }}"
                              alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <address class="text-dark font-14 mb-10">
                              <span class="">18. feb 2025</span>
                           </address>
                           <div class="">
                              <h4 class="text-thm pb-5 font-weight-700">Hva koster en bryllupsfotograf og videograf?
                              </h4>
                           </div>
                           <div class="">
                              <p class="">En guide til priser og hva du får for pengene.
                              </p>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item blogListing">
                     <a href="{{ url('blog-detail_1')}}">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blogHero_2.png') }}"
                              alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <address class="text-dark font-14 mb-10">
                              <span class="">12. mai 2025</span>
                           </address>
                           <div class="">
                              <h4 class="text-thm pb-5 font-weight-700">7 tips til deg som får gjester på 17. mai</h4>
                           </div>
                           <div class="">
                              <p class="">Skal du være vert på nasjonaldagen?.
                              </p>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item blogListing">
                      <a href="{{ url('blog-detail_2')}}">
                        <div class="event-thumb">
                           <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blog3.jpg') }}" alt="">
                        </div>
                        <div class="event-details bg-white p-20">
                           <address class="text-dark font-14 mb-10">
                              <span class="">16. juli 2025</span>
                           </address>
                           <div class="">
                              <h4 class="text-thm pb-5 font-weight-700">Hva koster det å være en bryllupsgjest?</h4>
                           </div>
                           <div class="">
                              <p class="">Å være bryllupsgjest er en ære – men det kan også være en betydelig investering.  
                              </p>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
            <!-- <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blog12.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <address class="text-dark font-14 mb-10">
                           <span class="">BY Sakshi | 20 Oct, 2022 | 322 views | 7 min read </span>
                        </address>
                        <div class="">
                           <h4 class="text-thm pb-5 font-weight-700">Breathtaking Destination Wedding With A <br> Bride Who Rocked Blue</h4>
                        </div>
                        <div class="">
                           <p class="">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
                              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam 
                              erat, sed diam voluptua. 
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blog11.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <address class="text-dark font-14 mb-10">
                           <span class="">BY Sakshi | 20 Oct, 2022 | 322 views | 7 min read </span>
                        </address>
                        <div class="">
                           <h4 class="text-thm pb-5 font-weight-700">Breathtaking Destination Wedding With A <br> Bride Who Rocked Blue</h4>
                        </div>
                        <div class="">
                           <p class="">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
                              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam 
                              erat, sed diam voluptua. 
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blog6.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <address class="text-dark font-14 mb-10">
                           <span class="">BY Sakshi | 20 Oct, 2022 | 322 views | 7 min read </span>
                        </address>
                        <div class="">
                           <h4 class="text-thm pb-5 font-weight-700">Breathtaking Destination Wedding With A <br> Bride Who Rocked Blue</h4>
                        </div>
                        <div class="">
                           <p class="">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
                              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam 
                              erat, sed diam voluptua. 
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blog10.jpg') }}" alt="" height="332px">
                     </div>
                     <div class="event-details bg-white p-20">
                        <address class="text-dark font-14 mb-10">
                           <span class="">BY Sakshi | 20 Oct, 2022 | 322 views | 7 min read </span>
                        </address>
                        <div class="">
                           <h4 class="text-thm pb-5 font-weight-700">Breathtaking Destination Wedding With A <br> Bride Who Rocked Blue</h4>
                        </div>
                        <div class="">
                           <p class="">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
                              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam 
                              erat, sed diam voluptua. 
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blog8.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <address class="text-dark font-14 mb-10">
                           <span class="">BY Sakshi | 20 Oct, 2022 | 322 views | 7 min read </span>
                        </address>
                        <div class="">
                           <h4 class="text-thm pb-5 font-weight-700">Breathtaking Destination Wedding With A <br> Bride Who Rocked Blue</h4>
                        </div>
                        <div class="">
                           <p class="">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
                              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam 
                              erat, sed diam voluptua. 
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/blog9.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <address class="text-dark font-14 mb-10">
                           <span class="">BY Sakshi | 20 Oct, 2022 | 322 views | 7 min read </span>
                        </address>
                        <div class="">
                           <h4 class="text-thm pb-5 font-weight-700">Breathtaking Destination Wedding With A <br> Bride Who Rocked Blue</h4>
                        </div>
                        <div class="">
                           <p class="">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
                              nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam 
                              erat, sed diam voluptua. 
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div> -->
         </div>
      </div>
      <!-- <div class="auto-container text-center">
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
      </div> -->
   </section>
   <!--Main Footer-->
</div>
@endsection