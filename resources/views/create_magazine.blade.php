@extends('app')

@section('content')
    
        <!--main content start-->
        <section id="main-content">
            
            <section class="container-fluid">

                <div class="" style="margin-top: 90px;">
                    <div class="panel-heading" style="margin-bottom: 20px;">
                            Create Magazine
                    </div>

                    @if(Session::has('response'))
                        <div class="panel-heading" style="margin-bottom: 20px;">
                                {{ Session::get('response') }}
                        </div>
                    @endif

                     <form method="POST" action="{{ URL('/magazine') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Magazine Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required >
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="start_date" class="col-md-4 col-form-label text-right">Start Date</label>

                                <div class="col-md-6">
                                    <input id="start_date" type="date" class="form-control {{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" value="{{ old('start_date') }}" required >
                                    @if ($errors->has('start_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="end_date" class="col-md-4 col-form-label text-right">End Date</label>

                                <div class="col-md-6">
                                    <input id="end_date" type="date" class="form-control {{ $errors->has('end_date') ? ' is-invalid' : '' }}" name="end_date" value="{{ old('end_date') }}" required >
                                    @if ($errors->has('end_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="final_close_date" class="col-md-4 col-form-label text-right">Final Close Date</label>

                                <div class="col-md-6">
                                    <input id="final_close_date" type="date" class="form-control {{ $errors->has('final_close_date') ? ' is-invalid' : '' }}" name="final_close_date" value="{{ old('final_close_date') }}" required >
                                    @if ($errors->has('final_close_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('final_close_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right"></label>

                                <div class="col-md-6">
                                    <input type="submit" class="form-control" name="submit" value="Save" >
                                </div>
                            </div>

                     </form>

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

