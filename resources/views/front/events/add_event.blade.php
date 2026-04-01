<?php use App\Models\Category; ?>
<?php use App\Models\Event; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               <div class="info-box p-xs-15">
                  <ul class="account-sidebar">
                     <li>
                        <a href="{{url('user/account')}}">
                           <span class="fa fa-user"></span>
                           <p >Profil</p>
                        </a>
                     </li>
                     <li>
                         <a href="{{url('user/select-category')}}">
                             <span class="fa fa-plus"></span>
                             <p></span>Ny annonse</p>
                         </a>
                     </li>
                     <li>
                          <a href="{{url('/user/add-event')}}">
                              <span class="fa fa-calendar"></span>
                              <p class="active-list">Legg til hendelse</p>
                          </a>
                      </li>
                     <li>
                        <a href="{{url('user/enquiries')}}">
                           <span class="fa fa-comment"></span>
                           <p>Forespørsler</p>
                        </a>
                     </li>
                     <li>
                        <a href="{{url('user/update-password')}}">
                           <img src="{{ asset('front/images/icons/change-password.svg') }}" alt="">
                           <p>Bytt passord</p>
                        </a>
                     </li>
                     <li>
                        <a href="{{url('user/logout')}}">
                           <img src="{{ asset('front/images/icons/log-out.svg') }}" alt="">
                           <p>Logg ut</p>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <!--Content Side-->
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="sec-title account-heading">
                  <h3 style="margin-bottom:15px;" class="font-20 text-black account-title">Legg til hendelse</h3>
               </div>
               <div class="form-box p-xs-15 account-form">
                  @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <strong> </strong> {{ Session::get('error_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif

                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <strong>Suksess: </strong> {{ Session::get('success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  <form action="{{ url('user/add-event') }}" class="post-form-form" method="post" enctype="multipart/form-data">@csrf
                     <div class="row clearfix">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Legg til tittel</div>
                           <input type="text" name="title" placeholder="" required>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Beskrivelse</div>
                           <textarea name="description" style="height:70px;" name="w3review" required></textarea>
                        </div>
                        <div class="form-group for col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Last opp bilde</div>
                           <input class="form-control" type="file" id="myFile" name="filename" required>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Startdato og klokkeslett</div>
                           <input class="form-control" type="datetime-local" id="" name="start_date" required>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Sluttdato og klokkeslett</div>
                           <input class="form-control" type="datetime-local" id="" name="end_date" required>
                        </div>
                        <!-- <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Are You Interested?</div>
                           <div class="radio-check">
                              <input type="radio" name="interested" value="yes" id="yes" required>
                              <label class="role" for="yes">Yes</label>
                              <input type="radio" name="interested" value="no" id="no">
                              <label class="role" for="no">No</label>
                              <input type="radio" name="interested" value="notsure" id="notsure">
                              <label class="role" for="notsure">Not Sure</label>
                           </div>
                        </div> -->
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 ">
                           <button class="save-btn" type="submit" name="submit-form">
                           Send inn</button>
                        </div>
                     </div>
                  </form>
                  <div class="row accTabsInfo order-tale-tabs add-post-table">
                     <div class="col-sm-12 col-12 mt-3">
                        <div class="sec-title account-heading">
                           <h3 style="margin-bottom:15px;" class="font-20 text-black account-title">Dine hendelser</h3>
                        </div>
                        <div class="table-responsive table-data">
                           <table class="table table-hover  tbl_res table-responsive">
                              <thead>
                                 <tr class="">
                                    <th width="15%">Tittel</th>
                                    <th width="22%">Beskrivelse</th>
                                    <th width="14%">Bilde</th>
                                    <th width="11%">Startdato</th>
                                    <th width="11%">Sluttdato</th>
                                    <th width="10%">Status</th>
                                    <th width="14%"></th>
                                    <th width="10%"></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($events as $event)
                                 <tr>
                                    <td>{{ $event['title'] }}</td>
                                    <td>{{ $event['description'] }}</td>
                                    <td><img style="width: 100px;" src="{{ asset('front/images/events/'.$event['image']) }}"></td>
                                    <td>{{ $event['start_date'] }}</td>
                                    <td>{{ $event['end_date'] }}</td>
                                    <td>
                                       @if($event['status']==1)
                                          <font color='green'>Aktiv</font><br>
                                          @php $getEventURL = Event::getEventURL($event['title']) @endphp
                                            <a style="text-decoration: underline;" target="_blank" href="{{ url('event/'.$getEventURL.'/'.$event['id']) }}">Event Link</a>
                                       @else
                                          <font color='red'>Inaktiv</font>
                                       @endif
                                    </td>
                                     <td>
                                       @php $interested = Event::interestedUsers($event['id']) @endphp
                                       {{ $interested['interestedUsers']}} Interessert<br>
                                       {{ $interested['notInterestedUsers']}} Ikke interessert<br>
                                       {{ $interested['notSureUsers']}} Ikke sikker<br>
                                    </td>
                                    <td>
                                       <a href="javascript:void(0)" class="confirmDelete" module="event" moduleid="{{ $event['id'] }}"><button class="add-post-btn"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--Main Footer-->
</div>
@endsection