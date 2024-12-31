@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Subscribers</h4>
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
                            <table id="subscribers" class="table table-bordered">
                                <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Email</th>
                                      <th>Subscribed on</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($subscribers as $subscriber)
                                    
                                    <tr>
                                      <td>{{ $subscriber['id'] }}</td>
                                      <td>{{ $subscriber['email'] }}</td>
                                      <td>{{ date("F j, Y", strtotime($subscriber['created_at'])); }}</td>
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