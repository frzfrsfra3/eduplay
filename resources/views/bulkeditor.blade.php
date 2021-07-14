@extends('layouts.app')

@section('header_styles')
    <link href="{{asset("assets/css/codemirror.css")}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/layout.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset("assets/css/beautify-json.css")}}" rel="stylesheet" type="text/css">
    <link href="{{asset("assets/css/chessboard-0.3.0.min.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!--
  <link href="css/playground.css" rel="stylesheet" type="text/css">
  <link href="{{asset("assets/css/codemirror-monokai.css")}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.9.0/dist/katex.min.css" integrity="sha384-TEMocfGvRuD1rIAacqrknm5BQZ7W7uWitoih+jMNFXQIbNl16bO8OZmylH/Vi/Ei"
  crossorigin="anonymous">
  -->
@endsection

@section('top')
    <div class="panel-heading clearfix">
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="col-xl-12 col-lg-12 col-sm-12 col-sm-12"> Multiple Questions Creation
        <div id="leftpanel" class="col-xl-6 col-lg-6 col-sm-6 col-sm-12">
            <div id="toolbar">

                <i title="Question" class="fa fa-bolt question-icon" data-start-modifier="\Q \M:'15' \T:'20' \D:'easy' \tag:'Skill2' {
              " data-end-modifier=" }"></i>
                <!-- to be adjusted -->
                <i title="Question-Parameter" class="fa fa-building question-icon" data-start-modifier="\Q \M:'10' \T:'20' \D:'easy' \tag:'Skill2'
              \param:'{
                        name: random.string(name),
                        city: random.string(city)
                }'
            {

                " data-end-modifier="}">
                </i>

                <i title="Answer" class="fa fa-font question-icon" data-start-modifier="\A " data-end-modifier=""></i>
                <i class="dividor">|</i>
                <i title="Image" class="fa fa-image" id="image-icon" data-sample="image"
                   data-sample-url="http://mdp.tylingsoft.com/icon.png"></i>
                <i title="Table" class="fa fa-table" id="table-icon" data-sample="
              header 1 | header 2
              - | -
              row 1 col 1 | row 1 col 2
            row 2 col 1 | row 2 col 2"></i>
                <i class="dividor">|</i>
                <i title="Mathematical formula" class="fa fa-superscript" id="math-icon"
                   data-sample="\oint_C x^3\, dx + 4y^2\, dy2 = \left(
                \frac{\left(3-x\right) \times 2}{3-x}
                \right) ">
                </i>
                <i title="Flowchart" class="fa fa-long-arrow-right mermaid-icon" data-sample="graph LR
              A-->B"></i>
                <i title="Sequence diagram" class="fa fa-exchange mermaid-icon"
                   data-sample="sequenceDiagram
                            A->>B: How are you?
                            B->>A: Great!
                            ">
                </i>
                <i title="Gantt diagram" class="fa fa-sliders mermaid-icon"
                   data-sample="gantt
                dateFormat YYYY-MM-DD
                section S1
                T1: 2014-01-01, 9d
                section S2
                T2: 2014-01-11, 9d
                section S3
                T3: 2014-01-02, 9d">
                </i>
                <i title="Chess" class="fa fa-address-book  plugin-icon"
                   data-sample='\chess{
                   {
                     "position": "r1bqkbnr/pppp1ppp/2n5/1B2p3/4P3/5N2/PPPP1PPP/RNBQK2R"
                    }
                                   }_'>
                </i>
                <i title="Music" class="fa fa-music  plugin-icon"
                   data-sample='\music{
                   X: 24
                   T:Clouds Thicken
                   C:Paul Rosen
                   S:Copyright 2005, Paul Rosen
                   M:6/8
                   L:1/8
                   Q:3/8=116
                   R:Creepy Jig
                   K:Em
                   |:"Em"EEE E2G|"C7"_B2A G2F|"Em"EEE E2G|\
                   "C7"_B2A "B7"=B3|"Em"EEE E2G|
                   "C7"_B2A G2F|"Em"GFE "D (Bm7)"F2D|\
                   1"Em"E3-E3:|2"Em"E3-E2B|:"Em"e2e gfe|
                   "G"g2ab3|"Em"gfeg2e|"D"fedB2A|"Em"e2e gfe|\
                   "G"g2ab3|"Em"gfe"D"f2d|"Em"e3-e3:|
                   }_'>
                </i>
                <i title="Clock" class="fa fa-clock-o  plugin-icon"
                   data-sample='\clock{ {"Hours":12,"Minutes":5,"Seconds":15} }_'>
                </i>
                <button id="dialogbox" title="dialogbox"  type="button"
                                                         onclick="" data-toggle="modal" data-target="#dialogboxmodal" >
                    box   </button>
            </div>
            <div><textarea id="exerciseSet-editor" style="min-height: 400px; min-width: 400px ">
                paste your questions here          </textarea>
            </div>
        </div>
        <div id="maincontent" class="col-xl-6 col-lg-6 col-sm-6 col-sm-12">
            <div id='renderContainer'>
                <ul class='nav nav-tabs' id='myTab' role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link" id="preview-tab" data-toggle="tab" href="#preview" role="tab"
                           aria-controls="preview" aria-selected="true">Preview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="HTML-output-tab" data-toggle="tab" href="#HTML-output" role="tab"
                           aria-controls="HTML-output" aria-selected="false">HTML Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="parser-output-tab" data-toggle="tab" href="#parser-output"
                           role="tab" aria-controls="parser-output"
                           aria-selected="false">Parsed results</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show" id="preview" role="tabpanel" aria-labelledby="preview-tab">...
                    </div>
                    <div class="tab-pane fade" id="HTML-output" role="tabpanel" aria-labelledby="HTML-output-tab">....
                    </div>
                    <div class="tab-pane fade" id="parser-output" class="jsonContainer" role="tabpanel"
                         aria-labelledby="parser-output-tab">.....
                    </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal --------------------------------------------------------------------------------------------------------------------------------------->
    <div class="modal fade" id="dialogboxmodal" role="dialog">
        @include ('bulkmodal')
    </div>
    <!-- Modal ---------------------------------------------------------------------------------------------------------------------------------------------->


@endsection

@section('footer_scripts')
    <script src="{{asset("assets/js/editortoolbar.js")}}"> </script>
    <script src="{{asset("assets/js/codemirror.js")}}"></script>
    <script src="{{asset("assets/js/codemirror-mode-stex.js")}}"></script>
    <script src="{{asset("assets/js/utilityfunctions.js")}}"></script>
    <script src="{{asset("assets/js/stemplateengine.js")}}"></script>
    <script src="{{asset("assets/js/parser-ExerciseSet.js")}}"></script>
    <script src="{{asset("assets/js/parser-content.js")}}"></script>
    <script src="{{asset("assets/js/parser-Parameter.js")}}"></script>
    <script src="{{asset("assets/js/parameterLanguage.js")}}"></script>

    <script src="{{asset("assets/js/plugins.js")}}"></script>
    <script src="{{asset("assets/js/plugins-init.js")}}"></script>
    <script src="{{asset("assets/js/clock.js")}}"></script>
    <script src="{{asset("assets/js/chessboard-0.3.0.min.js")}}"></script>
    <script src="{{asset("assets/js/math.min.js")}}"></script>

    <script src="{{asset("assets/js/jquery.beautify-json.js")}}"></script>
    <!-- <script src="{{asset("assets/js/bootstrap.bundle.min.js")}}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.13.0/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/function-plot/1.18.1/function-plot.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/markdown-it/8.4.1/markdown-it.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/7.1.2/mermaid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/latest.js?config=AM_CHTML"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.9.0/dist/katex.min.js" integrity="sha384-jmxIlussZWB7qCuB+PgKG1uLjjxbVVIayPJwi6cG6Zb4YKq0JIw+OMnkkEC7kYCq"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Faker/3.1.0/faker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/abcjs/3.1.1/abcjs_basic-min.js"></script>

    <script> registerToolBarEvents(); </script>

    <script src="{{asset("assets/js/editorfunctions.js")}}"></script>

    <script>
        var textArea = document.getElementById('exerciseSet-editor');

        var editor = CodeMirror.fromTextArea(textArea,
                            {
                                value: textArea.value.replace(/^      /mg, ''),
                                autofocus: true,
                                lineWrapping: true,
                                lineNumbers: true,
                                tabSize: 4,
                                indentUnit: 4
                            }
                          );

        var previewFrame = document.getElementById('preview')
        var HTMLOutput = document.getElementById('HTML-output')
        var parserOutput = document.getElementById('parser-output')

        var md = window.markdownit();
        var _var = [];

        //compile(editor.getValue(), previewFrame, parserOutput)
        editor.refresh()
        editor.on('change', function (e) {
                compile(editor.getValue(), previewFrame, parserOutput)
            })
  </script>
    <script>
        $('#btnSave').click(function() {


            var clocktext='\\Q    \\param:\'{\n' +
                '                        name: random.string(name),\n' +
                '                        city: random.string(city)\n' +
                '                }\' {  \\clock{ {  \"Hours\":'+ $('#hours').val() +',\"Minutes\":'+$('#minutes').val()  +',\"Seconds\":'+ $('#seconds').val() +'} }_ }';


            $("textarea#exerciseSet-editor").val(clocktext);

            $('#dialogboxmodal').modal('hide');
            editor.replaceSelection(clocktext)
            editor.focus()
            editor.refresh()
            compile(clocktext, previewFrame, parserOutput)

        });

    </script>

@endsection
