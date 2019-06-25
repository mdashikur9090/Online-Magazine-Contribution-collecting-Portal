@extends('app')

@section('content')
    
    <!--main content start-->
    <section id="main-content">
        
        <section class="container-fluid">
            <div class="row text-center" style="margin-top: 100px;">
            	<div class="panel-heading" style="margin-bottom: 30px;">
                    Messages
                </div>

				@if( Auth::user()->role==4)
                        @foreach( $allMessages as $message)
                        	<div class="row">
                        		<div class="col-md-2">
                        			{{-- <a href="{{ URL('/message/seen').'/'.$message->id }}"> --}}
                        			<span class="photo"><img alt="avatar" src="{{ asset('images/avater.png') }}"></span>
                        		</div>
                        		<div class="col-md-2">
                        			<h5><span class="from">{{ $message->name }}</span></h5>
                        		</div>
                        		<div class="col-md-6">
                        			{{ $message->message }}
                        		</div>
                        		<div class="col-md-2">
                        			{{ $message->created_at }}
                        		</div>
                        	</div>
                        @endforeach
				@endif

            </div>
        </section>
		

        <!-- footer -->
        <div class="footer" style="margin-top: 700px; >
            <div class="wthree-copyright">
                <p>© 2019 Visitors. All rights reserved</p>
            </div>
        </div>
        <!-- / footer -->
    </section>
    <!--main content end-->
    
@endsection

