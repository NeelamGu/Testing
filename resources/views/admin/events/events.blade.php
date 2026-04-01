<?php use App\Models\Category; ?>
<?php use App\Models\Event; ?>
@extends('admin.layout.layout')
@section('content')
<style>
    .enquiries-table td
    {
       white-space: inherit;
    }
   .modal.reply-modal .modal-header
{
    border: none
}

.modal.reply-modal .close
{
    right: 22px;
    position: absolute;
    color: #000;
}

.modal.reply-modal .close span
{
    font-size: 30px;
    color: #000 !important;
    font-weight: bold;
}

.modal.reply-modal h4
{
    display: block;
    width: 100%;
    font-size: 28px;
    text-transform: uppercase;
    text-align: center;
    color: #E78002;
}

.modal.reply-modal .modal-body
{
    padding-top: 0 !important;
}

.modal.reply-modal .normal-btn
{
    width: 100%;
    position: relative;
    padding: 9px 25px;
    line-height: 24px;
    max-width: 200px;
    text-transform: uppercase;
    background: #000;
    color: #ffffff !important;
    font-size: 14px;
    border: 2px solid #ffffff !important;
    font-family: 'robotoregular', sans-serif;
    display: inline-block;
    margin-top: 19px !important;
}
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Events</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        @if(Session::has('success_message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="events" class="enquiries-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Image
                                        </th>
                                        <th>
                                            Start Date
                                        </th>
                                        <th>
                                            End Date
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($events as $event)
                                    <tr>
                                        <td>
                                            {{ $event['id'] }}
                                        </td>
                                        <td style="line-height: 20px;">
                                            @php $getEventURL = Event::getEventURL($event['title']) @endphp
                                            <a style="text-decoration: underline;" target="_blank" href="{{ url('event/'.$getEventURL.'/'.$event['id']) }}">{{ $event['title'] }}</a>
                                        </td>
                                        <td style="line-height: 20px;">
                                            {{ $event['description'] }}
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{ url('front/images/events/'.$event['image']) }}"><img src="{{ asset('front/images/events/'.$event['image']) }}"></a>
                                        </td>
                                        <td style="line-height: 20px;">
                                            {{ $event['start_date'] }}
                                        </td> 
                                        <td style="line-height: 20px;">
                                            {{ $event['end_date'] }}
                                        </td>                                 
                                        <td>
                                           @if($event['status']==1)
                                              <a class="updateEventStatus" id="event-{{ $event['id'] }}" event_id="{{ $event['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                            @else
                                              <a class="updateEventStatus" id="event-{{ $event['id'] }}" event_id="{{ $event['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>
                                            @endif
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
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date("Y"); ?>. All rights reserved.</span>
        </div>
    </footer>
    <!-- partial -->
</div>




@endsection