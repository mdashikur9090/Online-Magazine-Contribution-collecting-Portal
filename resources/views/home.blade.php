@extends('app')

@section('content')

    <!--main content start-->
    <section id="main-content">
        
        <section class="container-fluid">
            <div class="alert alert-success text-center" style="margin-top: 100px;">
                
                @if(Auth::user()->role == 1)
                    You Are login as Adminstrator.
                @elseif(Auth::user()->role == 2)
                    You Are login as Marketing Manager.
                @elseif(Auth::user()->role == 3)
                    You Are login as Marketing Coordinator.
                @elseif(Auth::user()->role == 4)
                    You Are login as student.
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
