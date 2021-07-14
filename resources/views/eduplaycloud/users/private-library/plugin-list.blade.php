<div class="col-md-12" style="height:500px;overflow-y:auto;">
        <span style="color:#00b2f0 !important;"><b>(1) @lang('simple_editor.clock')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_clock \Attr {display:'inline' caption:'(1)'} {03:34:40}_</pre></p>
        {{-- <hr>
        <span style="color:#00b2f0 !important;"><b>(2) Graph</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_functionplot{
                {
                    "data": [{
                        "fn": "x^2"
                    }]
                }
            }_</pre></p>  --}}
        <hr>
        {{-- <span style="color:#00b2f0 !important;">(3) Music</span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_music{
                X: 24
                T:Clouds Thicken
                C:Paul Rosen
                S:Copyright 2005, Paul Rosen
                M:6/8
                L:1/8
                Q:3/8=116
                R:Creepy Jig
                K:Em
                |:"Em"EEE E2G|"C7"_B2A G2F|"Em"EEE E2G|                    "C7"_B2A "B7"=B3|"Em"EEE E2G|
                "C7"_B2A G2F|"Em"GFE "D (Bm7)"F2D|                    1"Em"E3-E3:|2"Em"E3-E2B|:"Em"e2e gfe|
                "G"g2ab3|"Em"gfeg2e|"D"fedB2A|"Em"e2e gfe|                    "G"g2ab3|"Em"gfe"D"f2d|"Em"e3-e3:|
        }_</pre></p>
        <hr> --}}
        <span style="color:#00b2f0 !important;"><b>(2) @lang('simple_editor.chess')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_chess \Attr {display:'inline' caption:'(1)'}{ r1bqkbnr/pppp1ppp/2n5/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R }_</pre></p>
        <hr>
        <span style="color:#00b2f0 !important;"><b>(3) @lang('simple_editor.video')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_video{ https://www.youtube.com/embed/YFD2PPAqNbw }_</pre></p>
        <hr>
        <span style="color:#00b2f0 !important;"><b>(4) @lang('simple_editor.audio')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_audio \Attr{ display:'inline' caption:'audio 1'} {  src:{{ asset('test.mp3') }}}_</pre></p>
        <hr>
        <span style="color:#00b2f0 !important;"><b>(5) @lang('simple_editor.image')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_image \Attr {display:'block' caption:'(fig.1)' repeat:'1'}  { src:{{ asset('assets/images/eduplay_logo.png') }} }_</pre></p>
        <hr>
        <span style="color:#00b2f0 !important;"><b>(6) @lang('simple_editor.table')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_table \Attr {class:'normalBTable' caption:'(table 1)'} {
                Head1 | Head2 | Head3 ;
                Row1  | value | value ;
                Row2  | value | value ;
                }_</pre></p>
        <hr>
        <span style="color:#00b2f0 !important;"><b>(7) @lang('simple_editor.textbox')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_textBox \Attr {display:'inline' caption:'result: ' } {dffdfs}_</pre></p>
        <hr>
        {{-- <span style="color:#00b2f0 !important;"><b>(8) Canvas</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_jsxgraph \Attr{height:'300'}{
                // - uncomment the lines that you want to activate and delete the others
                b=board {boundingbox:[-0.5,10,10,-0.5],  axis: true };
                p1= point[1,1],{size: 4, face: 'x',name:'A'};
                p2= point[-4,5],{size: 4, face: 'x',name:'B'};
                p3= point[3,0.5],{size: 1, face: 'o',name:'C',visible:false};
                
                // circle commands 
                // ci=circle[p2,p3],{strokeColor:"#00ff00",strokeWidth:2};
                ci=circle[[1,1],0.5];       // center and radius
                // ci=circle[[1,1],[2,2]];   // diameter
                // el=ellipse[p1,p2,p3];
                // cii=semicircle[p1,p3];
                // pol = polygon[[-2, -3], [-4, 1], [0, 4], [5, 1]], { name:'pol2', withLabel: true  };
                // cur=curve[[0,1,2,3,5],[0,2,1,4,0]],  {dash:1,firstArrow:true,lastArrow:true};
                // regHex2 = regularpolygon[p2,p1,6],{color:'yellow'};

                //  a =angle[p1, p2, p3];
                // li1 =line [p1,p2], {dash:0, strokeColor:"black", firstArrow:true, lastArrow:true};
                // li2 =line[p2,p3], {straightFirst:false,lastArrow:true};
                // ref='reflection',[p2,li1],{name:'reflection'}
                // graph = functiongraph [function(x){ return 0.5*x*x-2*x;}, -2, 4];
                // t=axis[[0,0],[50,2]],{strokeColor:'red'};
                
                // l1 = segment[[0.0, 3.0], [3.0, 3.0]];
                // mp1 = midpoint [p1, p2];
                // mp2 = midpoint [l1];
                // theLine = line[p1,p2];
                // thePoint = point[2,3],{name:'ptOnParallelLine'};
                // yy=parallel[theLine,thePoint],{color:'green'};
                    
                // l1 =line[p2, p3];
                // i = intersection[c1, l1, 0];
                // txt=text[0,15,"Hello World"], {anchor: p1};
            
                // im =image["https://cdn.pixabay.com/photo/2015/04/21/07/22/drawing-732830_960_720.png", [0, 0], [5, 5]];       
            }_</pre></p>
        <hr> --}}
        <span style="color:#00b2f0 !important;"><b>(8) @lang('simple_editor.flowChart')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_flow{
                graph LR
                A-->B
                }_</pre></p>
        <hr>
        <span style="color:#00b2f0 !important;"><b>(9) @lang('simple_editor.math')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_math \Attr {caption:'(1)'} {
            \begin{matrix} a &amp; b \\ c
                                                &amp; d \end{matrix}
+
\begin{pmatrix} a &amp; b \\ c
                                                &amp; d \end{pmatrix}
+
\begin{bmatrix} a &amp; b \\ c
                                                &amp; d \end{bmatrix}

        }_</pre></p>
        <hr>
        <span style="color:#00b2f0 !important;"><b>(10) @lang('simple_editor.chart')</b></span>
        <p class="enter_youremil" style="font-size:20px !important;font-weight:0 !important;"><pre>\Plugin_chart \Attr{height:'250'}{
            {
                "type": "bar",
                "data": {
                        "labels": ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                        "datasets": [{
                            "label": "# of Votes",
                            "data": [12, 19, 3, 5, 2, 3],
                            "backgroundColor": [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)"
                            ],
                            "borderColor": [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            "borderWidth": 1
                        }]
                    },
                    "options": {
                        "scales": {
                            "yAxes": [{
                                "ticks": {
                                    "beginAtZero":true
                                }
                            }]
                        }
                    }
                }
            
        }_</pre></p>
        <hr>
    </div>