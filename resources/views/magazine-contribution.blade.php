@extends('app')

@section('content')
    
        <!--main content start-->
        <section id="main-content">
            
            <section class="container-fluid">
                <div class="" style="margin-top: 100px;">

                    <!--make carbon object of date for comparision-->
                    <?php 
                        $current_date = \Carbon\Carbon::now('+6:00');
                        $end_date = \Carbon\Carbon::parse($magazine->end_date);
                        $final_end_date = \Carbon\Carbon::parse($magazine->final_end_date);
                        $end_date->hour = 23;
                        $final_end_date->hour = 23;
                        $end_date->minute = 59;
                        $final_end_date->minute = 59;
                        $end_date->minute = 59;
                        $final_end_date->minute = 59;
                    ?>

                    @if(Auth::user()->role==1) <!--for Administrator-->

                        <div class="panel-heading">
                            Submited Contribution
                        </div>
                        <!--Submited contribution Table-->
                        <table class="table">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <th>Student ID</th>
                                <th>Date</th>
                                <th>Doc or Imagee</th>
                                <th>Comments</th>
                                <th>Published Status</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($contributions as $contribution)
                                    <tr>
                                        <td> {{ $no+=1 }} </td>
                                        <td>{{ $contribution->student_id }}</td>
                                        <td>{{ $contribution->created_at }}</td>
                                        <td class="downloads">
                                            @if(substr( $contribution->doc_or_image, -5) ==".docx")
                                                <img src="{{ asset('images/docx.png') }}" width="100px" height="100px"  alt="">
                                            @else
                                                <img src="{{ URL('contributions').'/'.$contribution->doc_or_image }}" width="100px" height="100px"  alt="">
                                            @endif
                                        </td>
                                        <td>{{ $contribution->comment }}</td>
                                        <td>
                                            @if( $contribution->published_status == 1 )
                                                Selected
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @elseif(Auth::user()->role==2) <!--for marketing manager-->

                        <div class="panel-heading">
                            Submited Contribution
                        </div>
                        <!--Submited contribution Table-->
                        <table class="table">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Date & Time</th>
                                <th>Doc or Imagee</th>
                                <th>Comments</th>
                                <th>Published Status</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($contributions as $contribution)
                                    <tr>
                                        <td> {{ $no+=1 }} </td>
                                        <td>{{ $contribution->student_id }}</td>
                                        <td>{{ $contribution->studentInfo->first_name." ".$contribution->studentInfo->last_name }}</td>
                                        <td>{{ $contribution->created_at }}</td>
                                        <td class="downloads">
                                            @if(substr( $contribution->doc_or_image, -5) ==".docx")
                                                <img src="{{ asset('images/docx.png') }}" width="100px" height="100px"  alt="">
                                            @else
                                                <img src="{{ URL('contributions').'/'.$contribution->doc_or_image }}" width="100px" height="100px"  alt="">
                                            @endif
                                        </td>
                                        <td>{{ $contribution->comment }}</td>
                                        <td>
                                            @if( $contribution->published_status == 1 )
                                                Selected
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <!--If final close date is over then marketing manager can download all the contribution as zip file -->
                                @if( $current_date->greaterThan($final_end_date) )
                                    <tr>
                                        <td colspan="7"><a href="{{ URL('/magazine/download/'.$magazine->id) }}"><button type="button" hre class="btn btn-secondary btn-lg btn-block">Download</button></a></td>
                                    </tr>
                                @endif
                                
                            </tbody>
                        </table>


                    @elseif(Auth::user()->role==3) <!--for marketing coordinator-->

                        <div class="panel-heading">
                            Submited Contribution
                        </div>
                        @if(session()->has('message_status'))
                            <div class="text-center">
                                <h3 style="color: green">{{session('message_status')}}</h3>
                            </div>
                        @endif
                        <!--Submited contribution Table-->
                        <form action="{{ URL('update_published_status') }}" method="POST">
                            @csrf
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>NO</th>
                                    <th>Date</th>
                                    <th>Student Name</th>
                                    <th>Doc Or Image</th>
                                    <th>Comments</th>
                                    <th>Published Status</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @php($no = 0)
                                    @foreach($contributions as $contribution)
                                        <tr>
                                            <td>{{ $no+=1 }}</td>
                                            <td>{{ $contribution->created_at }}</td>
                                            <td>{{ $contribution->studentInfo->first_name." ".$contribution->studentInfo->last_name }}</td>
                                            <td class="downloads">
                                                @if(substr( $contribution->doc_or_image, -5) ==".docx")
                                                    <img src="{{ asset('images/docx.png') }}" width="100px" height="100px"  alt="">
                                                @else
                                                    <img src="{{ URL('contributions').'/'.$contribution->doc_or_image }}" width="100px" height="100px"  alt="">
                                                @endif
                                            </td>
                                            <td>{{ $contribution->comment }}</td>
                                            <td>
                                                <!--for update published status-->
                                                <?php $i=$loop->index; ?> 
                                                <input type="hidden" name="contribution_id[]" value="{{ $contribution->id }}">
                                                <input type="hidden" name="magazine_id" value="{{ $magazine->id }}">
                                                @if( $contribution->published_status == 1 )
                                                    <input type="hidden" name="published_status[{{$i}}]" value=0>
                                                    <input name="published_status[{{$i}}]" type="checkbox" value=1 checked >
                                                @else
                                                    <input type="hidden" name="published_status[{{$i}}]" value=0>
                                                    <input name="published_status[{{$i}}]" type="checkbox" value=1>
                                                @endif
                                            </td>
                                            <td>
                                                @if( $current_date->lessThan($final_end_date) )
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendMessageToStudent_{{ $contribution->id }}">
                                                        <i class="material-icons btn-primary">send</i>
                                                    </button>
                                                @endif
                                                <!--make carbon object of date for comparision-->
                                                <?php 
                                                    $commnent_end_date = \Carbon\Carbon::parse($contribution->created_at);
                                                    $commnent_end_date->addDays(14);
                                                ?>
                                                @if( $current_date->lessThan($commnent_end_date) )
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#commnetModal_{{ $contribution->id }}">
                                                        <i class="material-icons btn-primary">insert_comment</i>
                                                    </button>
                                                @endif
                                                
                                            </td>
                                        </tr>

                                    @endforeach
                                        <tr>

                                            <td colspan="7">
                                                <button type="Submit" hre class="btn btn-secondary btn-lg btn-block">Update Published Status</button>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </form>

                        
                        @foreach($contributions as $contribution)

                        <!--make carbon object of date for comparision-->
                        @if( $current_date->lessThan($final_end_date) )

                            <!--START modal-->
                            <div class="modal fade" id="sendMessageToStudent_{{ $contribution->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Send Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="{{ URL('message') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="m_coordinator_id" value="{{$contribution->studentInfo->facultyInfo->marketing_coordinator_id}}">
                                        <input type="hidden" name="student_id" value="{{$contribution->studentInfo->facultyInfo->marketing_coordinator_id}}">
                                        <input type="hidden" name="magazine_id" value="{{$contribution->magazine_id}}">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="message" class="col-md-4 col-form-label text-md-right">Message</label>
                                                <div class="col-md-8">
                                                <textarea  id="message" name="message" class="form-control" required></textarea>
                                            </div>
                                            </div>           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!--End modal-->

                        @endif

                            
                            <!--make carbon object of date for comparision-->
                            <?php 
                                $commnent_end_date = \Carbon\Carbon::parse($contribution->created_at);
                                $commnent_end_date->addDays(14);
                            ?>
                            @if( $current_date->lessThan($commnent_end_date) )
                                <!--Start modal-->
                                <div class="modal fade" id="commnetModal_{{ $contribution->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Post Comment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form action="{{ URL('contribution/'.$magazine->id.'/comment') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="contribution_id" value="{{ $contribution->id }}">
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label for="comment" class="col-md-4 col-form-label text-md-right">Comment</label>
                                                    <div class="col-md-8">
                                                    <textarea id="comment" class="form-control" name="comment" required></textarea>
                                                </div>
                                                </div>           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                <!--End modal-->
                            @endif    
                        @endforeach
                        


                    @else <!--For student-->

                        <div class="panel-heading">
                            Submited Contribution
                        </div>
                        <!--Submited contribution Table-->
                        <table class="table">
                            <thead>
                              <tr>
                                <th>NO</th>
                                <th>Date</th>
                                <th>Doc Or Image</th>
                                <th>Comments</th>
                                <th>Published Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php($no = 0)
                                @foreach($contributions as $contribution)                           
                                    <tr>
                                        <td>{{ $no+=1 }}</td>
                                        <td>{{ $contribution->created_at }}</td>
                                        <td class="downloads">
                                            @if(substr( $contribution->doc_or_image, -5) ==".docx")
                                                <img src="{{ asset('images/docx.png') }}" width="100px" height="100px"  alt="">
                                            @else
                                                <img src="{{ URL('contributions').'/'.$contribution->doc_or_image }}" width="100px" height="100px"  alt="">
                                            @endif
                                        </td>
                                        <td>{{ $contribution->comment }}</td>
                                        <td>
                                            @if( $contribution->published_status == 1 )
                                                Selected
                                            @endif
                                        </td>
                                        <td>
                                            @if( $current_date->lessThan($final_end_date) )
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editmodal_{{ $contribution->id }}">
                                                    <i class="material-icons btn-primary">edit</i>
                                                </button>
                                            @endif
                                            
                                        </td>


                                    </tr>

                                    
                                @endforeach

                            </tbody>
                        </table>

                        @if( $current_date->lessThan($final_end_date))
                            @foreach($contributions as $contribution)
                                <!--START modal-->
                                <div class="modal fade" id="editmodal_{{ $contribution->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form action="{{ route('contribution.update', $contribution->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label for="doc_or_img" class="col-md-4 col-form-label text-md-right">Doc File</label>
                                                    <div class="col-md-8">
                                                    <input id="doc_or_img" type="file" class="form-control" name="doc_or_img" required >
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
                        @endif


                        <!--check new enty is allowd or not-->
                        @if( $current_date->lessThan($end_date) )

                            <!--New Contribution Heading-->
                            <div class="panel-heading">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4 text-center">
                                    New Contribution
                                </div>
                                <div class="col-md-4 text-right">
                                    <button onclick="addRow()">Add Row</button>
                                </div>
                            </div>
                            <!--Contribution Form-->
                            <form method="POST" action="{{ URL('/contribution') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="magazine_id" value="{{$magazine->id}}">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th colspan="3">Doc Or Image</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody id="newContriutionTbody">
                                        <tr>
                                            <td colspan="3">
                                                <input type="file" name="doc_or_img[]" required >
                                                @if ($errors->has('doc_or_img'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('doc_or_img') }}</strong>
                                                    </span>
                                                @endif
                                            </td>
                                            <td><i onclick="removeRow($(this))" class="material-icons btn-primary">close</i></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <input type="checkbox" name="atc" value="atc" required > I have read term and condition of this company.
                                                @if ($errors->has('atc'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('atc') }}</strong>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <button id="btnSubmit" class="btn" type="submit">Submit Contribution</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                        @else
                            <!--New Contribution Heading-->
                            <div class="panel-heading">
                                <div class="col-md-12 text-center">
                                    New Contribution time is over.
                                </div>
                            </div>

                        @endif
                    
                        

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

@section('modal-or-js')



    <script>
        function addRow(){

            var markup ="<tr>"+
                            "<td colspan='3'><input type='file' name='doc_or_img[]' required></td>"+
                            "<td><i onclick='removeRow($(this))' class='material-icons btn-primary'>close</i></td>"+
                        "</tr>"


            $("#newContriutionTbody tr").eq(-2).before(markup);

            //enable button
            $('#btnSubmit').prop("disabled",false);

        }

        function removeRow(row){
            var x = document.getElementById("newContriutionTbody").rows.length;

            if ( x > 3 ) {
                row.closest('tr').remove();
            }else{
                row.closest('tr').remove();
                $('#btnSubmit').prop("disabled",true);
            }
              
          }

        function edit(id){
            
        }

            
    </script>
        

@endsection

