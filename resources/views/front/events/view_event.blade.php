<?php use App\Models\Category; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="{{ asset('front/images/venue.png') }}" alt="">
         </div>
      </div>
   </section>
   <section class="">
      <div class="container pt-0 pb-0">
         <!--Section Title-->
         <div class="product-details-page-content view-detail-data pt-40">
            <div class="row product-details-box">
               <div class="col-lg-5 img-holder">
                  <img class="img-responsive" src="{{ asset('front/images/events/'.$eventDetails['image']) }}" alt="">
               </div>
               <div class="col-lg-7 detail-area">
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <strong>Success: </strong> {{ Session::get('success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <strong> </strong> {{ Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <strong> </strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                   <div  class="event-details">
                     <h4>Tittel:</h4>
                     <p>
                        {{ $eventDetails['title']}}
                     </p>
                     <h4>Beskrivelse:</h4>
                     <p>
                        {{ $eventDetails['description']}}
                     </p>
                      <h4 class="datetimetitle"><span class="fa fa-calendar">
                      </span>Startdato og klokkeslett:
                     </h4>
                     <p class="data-style">
                        {{ $eventDetails['start_date']}}
                     </p>
                     <!-- Hr line start here -->
                     <span class="hr-line"></span>
                     <h4><span class="fa fa-calendar">
                      </span class="data-style">Sluttdato og klokkeslett
                     </h4>
                     <p class="data-style">
                        {{ $eventDetails['end_date']}}
                     </p>
                     <p>&nbsp;</p>
                     <h4>Er du interessert?</h4>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <form action="{{ url('user/attend-event') }}" class="post-form-form" method="post" enctype="multipart/form-data">@csrf
                              <input type="hidden" name="event_id" value="{{ $eventDetails['id']}}">
                           <div class="radio-check">
                              <input type="radio" name="is_interested" value="yes" id="yes" required>
                              <label class="role" for="yes">Ja</label>
                              <input type="radio" name="is_interested" value="no" id="no">
                              <label class="role" for="no">Nei</label>
                              <input type="radio" name="is_interested" value="notsure" id="notsure">
                              <label class="role" for="notsure">Ikke sikker</label>
                           </div>
                        @if(Auth::check())
                           <button type="submit" class="buy-now-btn buy-btn detail-eform" href="javascript:void(0)">Send inn</button>
                        @else
                           <a class="buy-now-btn buy-btn" data-toggle="modal" data-target="#loginModal">Send inn</a>
                        @endif
                           </form>
                        </div>
                     </div>
                   </div>
                   
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection