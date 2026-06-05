<?php use App\Models\Vendor; ?>
@extends('admin.layout.layout')
@section('content')
<style>
    tfoot {
        display: table-header-group;
    }
    .adminsearch th input{
        width: 100%;
    }
    .hideColumn input{
        display: none;
    }
    .adminActive font{
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
                        <h4 class="card-title">{{ $title }}</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="adminss">
                                <thead>
                                    <tr>
                                        <th style="width:10% !important;">
                                            Admin ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            Plan
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Mobile
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Image
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Login
                                        </th>
                                        <th>
                                            Email<br>Confirmation
                                        </th>
                                        <th>
                                            Registered<br>Date
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot class="adminsearch">
                                    <tr>
                                        <th>
                                            Admin ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            Plan
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Mobile
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th class="hideColumn">
                                            Image
                                        </th>
                                        <th class="hideColumn">
                                            Status
                                        </th>
                                        <th class="hideColumn">
                                            Login
                                        </th>
                                        <th class="hideColumn">
                                            Email<br>Confirmation
                                        </th>
                                        <th>
                                            Registered<br>Date
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                  @foreach($admins as $admin)
                                    <tr>
                                        <td>
                                            {{ $admin['id'] }}
                                        </td>
                                        <td>
                                            {{ $admin['name'] }}
                                        </td>
                                        <td>
                                            {{ ucwords($admin['type']) }}
                                        </td>
                                        <td>
                                            {{ ucwords($admin['vendor_personal']['plan']['name']) }}
                                        </td>
                                        <td>
                                            @if($admin['type']=="vendor")
                                                @php $getVendorCategory = Vendor::getVendorCategory($admin['vendor_id']) @endphp
                                                {{ $getVendorCategory }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $admin['mobile'] }}
                                        </td>
                                        <td>
                                            {{ $admin['email'] }}
                                        </td>
                                        <td>
                                            @if($admin['image']!="")
                                            <img src="{{ asset('admin/images/photos/'.$admin['image']) }}">
                                            @else
                                             <img src="{{ asset('admin/images/photos/no-image.gif') }}">
                                            @endif
                                        </td>
                                        <td class="adminActive">
                                            @if($admin['status']==1)
                                              <a class="updateAdminStatus" id="admin-{{ $admin['id'] }}" admin_id="{{ $admin['id'] }}" href="javascript:void(0)" style="color: #000;"><i style="font-size:18px; color: #000;" class="mdi mdi-bookmark-check" status="Active"></i>Active</a><br>
                                            @else
                                              <a class="updateAdminStatus" id="admin-{{ $admin['id'] }}" admin_id="{{ $admin['id'] }}" href="javascript:void(0)" style="color: #000;"><i style="font-size:18px; color: #000;" class="mdi mdi-bookmark-outline" status="Inactive"></i>Inactive</a><br>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/vendor-login?email='.$admin['email']) }}" style="color: #000;" title="Login to Vendor Account"><i style="font-size:18px; color: #000;" class="mdi mdi-login"></i></a>
                                        </td>
                                        <td>
                                            @if($admin['confirm']=="Yes")
                                                <font color="green">Email Confirmed</font>
                                            @else
                                                <font color="red">Email Not Confirmed</font>
                                            @endif
                                        </td>
                                        <td style="line-height:20px;">
                                            {{ date("Y-m-d", strtotime($admin['created_at'])); }}<br>
                                            ({{ date("d.m.y, H:i", strtotime($admin['created_at'])); }})
                                        </td>
                                        <td>
                                            @if($admin['type']=="vendor")
                                              <a href="{{ url('admin/view-vendor-details/'.$admin['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-document"></i></a>&nbsp;&nbsp;&nbsp;
                                              <a title="Slett" href="javascript:void(0)" class="confirmDelete" module="vendor" moduleid="{{ $admin['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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