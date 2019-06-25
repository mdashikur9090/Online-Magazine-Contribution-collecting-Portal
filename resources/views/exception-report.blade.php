@extends('app')

@section('content')
    
        <!--main content start-->
        <section id="main-content">
            
            <section class="container-fluid">

                <div class="" style="margin-top: 90px;">
                    <div class="panel-heading" style="margin-bottom: 20px;">
                            Contributions without a comment. (Total={{count($conWithoutcommnets)}})
                    </div>
                    <!--Submited contribution Table-->
                        <table class="table">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Faculty Name</th>
                                <th>Submission Date</th>
                                <th>Doc or Imagee</th>
                                <th>Comments</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($conWithoutcommnets as $contribution)
                                    <tr>
                                        <td>{{ $no+=1 }} </td>
                                        <td>{{ $contribution->student_id }}</td>
                                        <td>{{ $contribution->studentInfo->first_name." ".$contribution->studentInfo->last_name }}</td>
                                        <td>{{ $contribution->studentInfo->facultyInfo->name }}</td>
                                        <td>{{ $contribution->created_at }}</td>
                                        <td class="downloads">
                                            <a href="{{ URL('contributions').'/'.$contribution->doc_or_image }}" download>
                                                @if(substr( $contribution->doc_or_image, -5) ==".docx")
                                                    <img src="{{ asset('images/docx.png') }}" width="100px" height="100px"  alt="">
                                                @else
                                                    <img src="{{ URL('contributions').'/'.$contribution->doc_or_image }}" width="100px" height="100px"  alt="">
                                                @endif
                                            </a>
                                        </td>
                                        <td>{{ $contribution->comment }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>








                    <div class="panel-heading" style="margin-bottom: 20px;">
                        Contributions without a comment after 14 days. (Total={{count($expiedCommnets)}})
                    </div>
                    <!--Submited contribution Table-->
                    <table class="table">
                        <thead>
                          <tr>
                            <th>NO</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Faculty Name</th>
                            <th>Submission Date</th>
                            <th>Doc or Imagee</th>
                            <th>Comments</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php($no=0)
                            @foreach($expiedCommnets as $expiredComment)
                                <tr>
                                    <td>{{ $no+=1 }} </td>
                                    <td>{{ $expiredComment->student_id }}</td>
                                    <td>{{ $expiredComment->studentInfo->first_name." ".$expiredComment->studentInfo->last_name }}</td>
                                    <td>{{ $expiredComment->studentInfo->facultyInfo->name }}</td>
                                    <td>{{ $expiredComment->created_at }}</td>
                                    <td class="downloads">
                                        <a href="{{ URL('contributions').'/'.$expiredComment->doc_or_image }}" download>
                                            @if(substr( $expiredComment->doc_or_image, -5) ==".docx")
                                                <img src="{{ asset('images/docx.png') }}" width="100px" height="100px"  alt="">
                                            @else
                                                <img src="{{ URL('contributions').'/'.$expiredComment->doc_or_image }}" width="100px" height="100px"  alt="">
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{ $expiredComment->comment }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                     

                </div>
            </section>
			
			
			
			
            



            <!-- footer -->
            <div class="footer">
                <div class="wthree-copyright">
                    <p>© 2019 Visitors. All rights reserved</p>
                </div>
            </div>
            <!-- / footer -->
        </section>
        <!--main content end-->
    
@endsection

