@extends('app')

@section('content')
    
        <!--main content start-->
        <section id="main-content">
            
            <section class="container-fluid">

                <div class="" style="margin-top: 90px;">

                    <div class="col-md-12 chart_agile_right">
                        <div class="panel-heading">
                            Percentage of contributions by each Faculty for any academic year.
                        </div>
                        <div class="chart_agile_top">
                            <div class="chart_agile_bottom">
                                <div id="graph4"></div>

                                    @php
                                        $totalContributionForthisYear=0;
                                        foreach ($fContributionforPercentage as $keycount) {
                                            $totalContributionForthisYear+=$keycount->totalContribution;
                                        }
                                    @endphp

                                <script>
                                    Morris.Donut({
                                      element: 'graph4',
                                      data: [

                                        @foreach($fContributionforPercentage as $fNameAndContribution)
                                                {value: {{ $fNameAndContribution->totalContribution }}, 
                                                label: '{{ $fNameAndContribution->name }}', 
                                                formatted: 'approx.'+{{ number_format((float)$fNameAndContribution->totalContribution*100/$totalContributionForthisYear, 2, '.', '') }}+'%' },
                                        @endforeach
                                        
                                        
                                      ],
                                      formatter: function (x, data) { return data.formatted; }
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                    
                     <div class="col-md-6 floatcharts_w3layouts_left">
                            <div class="panel-heading">
                                Number of contributions within each Faculty for each academic year.
                            </div>
                            <div class="floatcharts_w3layouts_top">
                                <div class="floatcharts_w3layouts_bottom">
                                    <div id="noContributions"></div>
                                    <script>
                                        // Use Morris.Bar
                                        Morris.Bar({
                                              element: 'noContributions',
                                              data: [

                                                    @foreach($noContributionsEachFacultyEAY as $eachMagazine)

                                                        @if ( count($eachMagazine) > 0 )
                                                            {x: '{{ $eachMagazine[0]->magazine_name }}', 
                                                                @foreach($eachMagazine as $FNandCon)
                                                                    {{ $FNandCon->name }} : {{ $FNandCon->contributions_number }},
                                                                @endforeach
                                                            },
                                                        @endif

                                                    @endforeach


                                                
                                              ],
                                              xkey: 'x',
                                              ykeys: [  
                                                        @foreach($noContributionsEachFacultyEAY[0] as $facultyName)
                                                            '{{ $facultyName->name }}',
                                                        @endforeach
                                                     ],

                                              labels: [ 
                                                        @foreach($noContributionsEachFacultyEAY[0] as $facultyName)
                                                            '{{ $facultyName->name }}',
                                                        @endforeach
                                                      ],

                                              stacked: true
                                        });
                                    </script>

                                </div>

                            </div>
                    </div>


                    <div class="col-md-6 floatcharts_w3layouts_left">
                        <div class="panel-heading">
                            Number of contributors within each Faculty for each academic year.
                        </div>
                        <div class="floatcharts_w3layouts_top">
                            <div class="floatcharts_w3layouts_bottom">
                                <div id="graph5"></div>
                                <script>
                                    // Use Morris.Bar
                                    Morris.Bar({
                                          element: 'graph5',
                                          data: [

                                                @foreach($noContributorsEachFacultyEAY as $eachMagazine)

                                                    @if ( count($eachMagazine) > 0 )
                                                        {x: '{{ $eachMagazine[0]->magazine_name }}', 
                                                            @foreach($eachMagazine as $FNandCon)
                                                                {{ $FNandCon->name }} : {{ $FNandCon->totalContribution }},
                                                            @endforeach
                                                        },
                                                    @endif

                                                @endforeach


                                            
                                          ],
                                          xkey: 'x',
                                          ykeys: [  
                                                    @foreach($noContributorsEachFacultyEAY[0] as $facultyName)
                                                        '{{ $facultyName->name }}',
                                                    @endforeach
                                                 ],

                                          labels: [ 
                                                    @foreach($noContributorsEachFacultyEAY[0] as $facultyName)
                                                        '{{ $facultyName->name }}',
                                                    @endforeach
                                                  ],

                                          stacked: true
                                    });
                                </script>

                            </div>

                        </div>
                    </div>

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

