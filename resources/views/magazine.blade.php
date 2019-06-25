@extends('app')

@section('content')
    
    <!--main content start-->
    <section id="main-content">
        
        <section class="container-fluid">
            <div class="row text-center" style="margin-top: 100px;">
                <div class="panel-heading">
                	Magazine
				</div>

				@if( Auth::user()->role==1 || Auth::user()->role==2)

					<table class="table text-center" >
						<thead>
							<tr>
								<th class="text-center">Name</th>
								<th class="text-center">Start Data</th>
								<th class="text-center">Close Date</th>
								<th class="text-center">Final Close Date</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($magazines as $magazine)
								<tr>
									<td>{{ $magazine->name }}</td>
									<td>{{ $magazine->start_date }}</td>
									<td>{{ $magazine->end_date }}</td>
									<td>{{ $magazine->final_end_date }}</td>
									<td> 
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editmodal_{{ $magazine->id }}">
                                            <i class="material-icons btn-primary">edit</i>
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                           <a href="{{ url('magazine/'.$magazine->id) }}">
												<i class="material-icons btn-primary">arrow_right_alt</i>
											</a>
                                        </button>
										
									</td>
								</tr>
							@endforeach
							
						</tbody>
					</table>

						@foreach($magazines as $magazine)
						<!--START modal-->
                            <div class="modal fade" id="editmodal_{{ $magazine->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="{{ route('magazine.update', $magazine->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="form-group row">
						    					<label for="name" class="col-md-4 col-form-label text-md-right">Magazine Name</label>

						    					<div class="col-md-6">
						    						<input id="name" type="text" class="form-control" name="name" value="{{ $magazine->name }}" required >
						    					</div>
						    				</div>
						    				
						    				<div class="form-group row">
						    					<label for="start_date" class="col-md-4 col-form-label text-md-right">Start Date</label>

						    					<div class="col-md-6">
						    						<input id="start_date" type="date" class="form-control" name="start_date" value="{{ $magazine->start_date }}" required >
						    					</div>
						    				</div>
						    				
						    				<div class="form-group row">
						    					<label for="end_date" class="col-md-4 col-form-label text-md-right">End Date</label>

						    					<div class="col-md-6">
						    						<input id="end_date" type="date" class="form-control" name="end_date" value="{{ $magazine->end_date }}" required >
						    					</div>
						    				</div>
						    				
						    				<div class="form-group row">
						    					<label for="final_close_date" class="col-md-4 col-form-label text-md-right">Final Close Date</label>

						    					<div class="col-md-6">
						    						<input id="final_close_date" type="date" class="form-control" name="final_close_date" value="{{ $magazine->final_end_date }}" required >
						    					</div>
    										</div>          
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!--End modal-->

                        @endforeach

				@else

					<table class="table text-center" >
						<thead>
							<tr>
								<th class="text-center">Name</th>
								<th class="text-center">Start Data</th>
								<th class="text-center">Close Date</th>
								<th class="text-center">Final Close Date</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($magazines as $magazine)
								<tr>
									<td>{{ $magazine->name }}</td>
									<td>{{ $magazine->start_date }}</td>
									<td>{{ $magazine->end_date }}</td>
									<td>{{ $magazine->final_end_date }}</td>
									<td> 
										<button type="button" class="btn btn-primary">
											<a href="{{ url('magazine/'.$magazine->id) }}">
												<i class="material-icons btn-primary">arrow_right_alt</i>
											</a>
										</button>
									</td>
								</tr>
							@endforeach
							
						</tbody>
					</table>
				@endif

				


            </div>
        </section>
		

        <!-- footer -->
        <div class="footer" style="margin-top: 600px; >
            <div class="wthree-copyright">
                <p>© 2019 Visitors. All rights reserved</p>
            </div>
        </div>
        <!-- / footer -->
    </section>
    <!--main content end-->
    
@endsection

