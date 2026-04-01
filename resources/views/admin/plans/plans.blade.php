@extends('admin.layout.layout')
@section('content')
<style>
    tfoot {
        display: table-header-group;
    }
    .plansearch th input{
        width: 100%;
    }
    .hideColumn input{
        display: none;
    }
    .planActive font{
        vertical-align: super !important;
        display: inline-flex;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Plans</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <!-- <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-edit-plan') }}" class="btn btn-block btn-primary">Add Plan</a> -->
                        @if(Session::has('success_message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="plans" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:10% !important;">
                                            ID
                                        </th>
                                        <th>
                                            Plan Name
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Responses
                                        </th>
                                        <th>
                                            Profiles
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot class="plansearch">
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Plan Name
                                        </th>
                                        <th class="hideColumn">
                                            Price
                                        </th>
                                        <th class="hideColumn">
                                            Responses
                                        </th>
                                        <th class="hideColumn">
                                            Profiles
                                        </th>
                                        <th class="hideColumn">
                                            Status
                                        </th>
                                        <th class="hideColumn">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                  @foreach($plans as $plan)
                                    <tr>
                                        <td>
                                            {{ $plan['id'] }}
                                        </td>
                                        <td>
                                            {{ $plan['name'] }}
                                        </td>
                                        <td>
                                            {{ $plan['price'] }}
                                        </td>
                                        <td>
                                            {{ $plan['responses_limit'] }}
                                        </td>
                                        <td>
                                            {{ $plan['products_limit'] }}
                                        </td>
                                        <td class="planActive">
                                            @if($plan['status']==1)
                                              <a class="updatePlanStatus" id="plan-{{ $plan['id'] }}" plan_id="{{ $plan['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a><span style="margin-top:0px !important;">Active</span>
                                            @else
                                              <a class="updatePlanStatus" id="plan-{{ $plan['id'] }}" plan_id="{{ $plan['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a><span style="margin-top:0px !important;">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-plan/'.$plan['id']) }}"><i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <?php /* <a title="Plan" class="confirmDelete" href="{{ url('admin/delete-plan/'.$plan['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> */ ?>
                                            <!-- <a href="javascript:void(0)" class="confirmDelete" module="plan" moduleid="{{ $plan['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> -->
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