<!DOCTYPE HTML>
<html @if ($hasRTL) dir="rtl" @endif >
    <head>
      <style>
          @if ($hasRTL) 
          body { 
              text-align : right;
              direction: rtl;
          }
          @endif 
          .ans_list {margin: 0;padding: 0;}
          .ans_list li {
              display: block;
              position: relative;
              padding-left: 30px;
              margin-bottom: 1px;
              padding-top: 10px;
              padding-bottom: 10px;
          }
          .ans_list li.slected {border: solid 1px #ccc;}
          .optn_list {margin: 0 0 40px 0;padding: 0;}
          .optn_list li {
              position: relative;
              margin-bottom: 15px;
              display: block;
              max-width: 100%;
          }
          .optn_list {
              counter-reset: list;
          }
          .optn_list > li {
              list-style: none;
          }
          .optn_list > li:before {
              content: counter(list, upper-alpha) " ";
              counter-increment: list;
              position: absolute;
              left: 15px;
              top: 0px;
              font-size: 16px;
              color: #757575;
              font-weight: 700;
          }
          .optn_list > li .option_name {display: block;margin-bottom: 5px;}
          .optn_list > li .coorect_prvew {
              position: absolute;
          }
          .optn_list li input[type='radio']{
              position: absolute;
              left: 0;
              top: 0;
              width: 100%;
              height: 100%;
              opacity: 0;
              cursor: pointer;
          }
          .optn_list li label {
              /* display: block;
              border: 1px solid #00b2f0; */
              border-radius: 35px;
              text-align: center;
              padding: 8px 20px 8px 30px;
              background-color: #fff;
              font-family: 'Raleway', sans-serif;
              font-weight: 600;
              font-size: 13px;
              color: #000000;
          }
          .optn_list .is_crct_ans + label {background-color: #155724 !important;color: #fff;border-color: #155724 !important;}
          .optn_list .is_incrct_ans + label {background-color: #721c24 !important;color: #fff;border-color: #721c24 !important;}
          .optn_list li label span{float: left;}
          .optn_list li input[type='radio']:checked + label, .optn_list li input[type='radio']:hover + label{background-color: #00b2f0;color: #fff;}
          .detil-pg-ans.optn_list li{max-width: 100%;}
          .detil-pg-ans.optn_list > li:before {
              left: 62px;
              top: 10px;
          }
          .detil-pg-ans .tb_rt_cntnt{
              padding-left: 60px;
              display: block;
              margin-bottom: 4px;
          }
          @media screen and (max-width: 575px) {
              .deatil_panneel_privt .Section {overflow-x: auto !important;}
          }
          @media screen and (max-width: 767px) {
              .detil-pg-ans.optn_list > li:before {left: 45px;}
          }
      </style>
            
    </head>
  <body>
    <div>
      <input type="hidden" id="site_url" value="{{ URL('/') }}">
      {{-- <input type="hidden" class="json_question" value="{{ $question->paramRenderQuestion()}}"> --}}
      <input type="hidden" class="json_question" value="{{ $question }}">
      <div id="preview">
      </div>
      <!-- <div id="templates" style="display: none;"></div> -->
    </div>
    {{-- <script src="javascripts/app-js/plugins-Render-Client.js"></script> --}}
    <script id="question_list_template" type="text/html">
      @{{#.}}
      @{{#Questions}}
      
      <div class="deatil_panneel_privt inner_pannel panel panel-default">
          <div class="panel-heading @{{^key}} active @{{/key}}" role="tab" id="headingOne">
                    <div class="panel-title">
                          @{{#Question_Description.Sections}}
                              <p>@{{& Value}}</p>
                          @{{/Question_Description.Sections}}
                    </div>
                  <div class="right_btn_secn">
                      @{{# Parameters}}
                          @{{#value}}
                              @{{#filepath}}
                              <a href="@{{&filepath}}"  class="gray_download_btn"></a>
                              @{{/filepath}}
                          @{{/value}}
                      @{{/ Parameters}}
                      <a href="javascript:;" class="gray_edit_btn" id="edit_que_btn_@{{&question_id}}" data-queid="@{{&question_id}}" onclick="editQuestion(this.id)"></a>
                      <form method="POST" id="delete_que_form" action="{!!url('/questions/question')!!}/@{{&question_id}}" accept-charset="UTF-8" class="dlt_clss">
                          <input name="_method" value="DELETE" type="hidden">
                          @csrf
                          <a href="javascript:;" class="gray_delete_btn" id="delete_que_btn_@{{&question_id}}" data-queid="@{{&question_id}}" onclick="deleteQuestion(this.id)"></a>
                      </form>
                  </div>
              </div>
          </div>
          <div id="collapse_@{{&question_id}}" class="panel-collapse collapse @{{^key}} show @{{/key}}" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                  <div id="preview_ans_option_div">
                      <ul class="detil-pg-ans ans_list optn_list">
                          @{{#Answers.Choices}}
                          <li> @{{#Attributes}}
                                  @{{#IsCorrect}}
                                      <span class="right_answr"></span>
                                  @{{/IsCorrect}}
                                  @{{^IsCorrect}}
                                      <span class="wrong_answr"></span>
                                  @{{/IsCorrect}}
                              @{{/Attributes}}
                              <div class="lang-dir tb_rt_cntnt ">     
                                  @{{#Sections}}
                                  <div class="nw_p">@{{& Value}}</div>
                                  @{{/Sections}} 
                                  <style>
                                        .mermaid .label{font-family:trebuchet ms,verdana,arial;color:#333}.node circle,.node ellipse,.node polygon,.node rect{fill:#cde498;stroke:#13540c;stroke-width:1px}.node.clickable{cursor:pointer}.arrowheadPath{fill:green}.edgePath .path{stroke:green;stroke-width:1.5px}.edgeLabel{background-color:#e8e8e8}.cluster rect{fill:#cdffb2!important;rx:4!important;stroke:#6eaa49!important;stroke-width:1px!important}.cluster text{fill:#333}.actor{stroke:#13540c;fill:#cde498}text.actor{fill:#000;stroke:none}.actor-line{stroke:grey}.messageLine0{marker-end:"url(#arrowhead)"}.messageLine0,.messageLine1{stroke-width:1.5;stroke-dasharray:"2 2";stroke:#333}#arrowhead{fill:#333}#crosshead path{fill:#333!important;stroke:#333!important}.messageText{fill:#333;stroke:none}.labelBox{stroke:#326932;fill:#cde498}.labelText,.loopText{fill:#000;stroke:none}.loopLine{stroke-width:2;stroke-dasharray:"2 2";marker-end:"url(#arrowhead)";stroke:#326932}.note{stroke:#6eaa49;fill:#fff5ad}.noteText{fill:#000;stroke:none;font-family:trebuchet ms,verdana,arial;font-size:14px}.section{stroke:none;opacity:1}.section0,.section2{fill:#6eaa49}.section1,.section3{fill:#fff;opacity:.2}.sectionTitle0,.sectionTitle1,.sectionTitle2,.sectionTitle3{fill:#333}.sectionTitle{text-anchor:start;font-size:11px;text-height:14px}.grid .tick{stroke:#d3d3d3;opacity:.3;shape-rendering:crispEdges}.grid path{stroke-width:0}.today{fill:none;stroke:red;stroke-width:2px}.task{stroke-width:2}.taskText{text-anchor:middle;font-size:11px}.taskTextOutsideRight{fill:#000;text-anchor:start;font-size:11px}.taskTextOutsideLeft{fill:#000;text-anchor:end;font-size:11px}.taskText0,.taskText1,.taskText2,.taskText3{fill:#fff}.task0,.task1,.task2,.task3{fill:#487e3a;stroke:#13540c}.taskTextOutside0,.taskTextOutside1,.taskTextOutside2,.taskTextOutside3{fill:#000}.active0,.active1,.active2,.active3{fill:#cde498;stroke:#13540c}.activeText0,.activeText1,.activeText2,.activeText3{fill:#000!important}.done0,.done1,.done2,.done3{stroke:grey;fill:#d3d3d3;stroke-width:2}.doneText0,.doneText1,.doneText2,.doneText3{fill:#000!important}.crit0,.crit1,.crit2,.crit3{stroke:#f88;fill:red;stroke-width:2}.activeCrit0,.activeCrit1,.activeCrit2,.activeCrit3{stroke:#f88;fill:#cde498;stroke-width:2}.doneCrit0,.doneCrit1,.doneCrit2,.doneCrit3{stroke:#f88;fill:#d3d3d3;stroke-width:2;cursor:pointer;shape-rendering:crispEdges}.activeCritText0,.activeCritText1,.activeCritText2,.activeCritText3,.doneCritText0,.doneCritText1,.doneCritText2,.doneCritText3{fill:#000!important}.titleText{text-anchor:middle;font-size:18px;fill:#000}g.classGroup text{fill:#13540c;stroke:none;font-family:trebuchet ms,verdana,arial;font-size:10px}g.classGroup rect{fill:#cde498;stroke:#13540c}g.classGroup line{stroke:#13540c;stroke-width:1}svg .classLabel .box{stroke:none;stroke-width:0;fill:#cde498;opacity:.5}svg .classLabel .label{fill:#13540c;font-size:10px}.relation{stroke:#13540c;stroke-width:1;fill:none}#compositionEnd,#compositionStart,.composition{fill:#13540c;stroke:#13540c;stroke-width:1}#aggregationEnd,#aggregationStart,.aggregation{fill:#cde498;stroke:#13540c;stroke-width:1}#dependencyEnd,#dependencyStart,#extensionEnd,#extensionStart{fill:#13540c;stroke:#13540c;stroke-width:1}.node text{font-size:14px}.node text,div.mermaidTooltip{font-family:trebuchet ms,verdana,arial}div.mermaidTooltip{position:absolute;text-align:center;max-width:200px;padding:2px;font-size:12px;background:#cdffb2;border:1px solid #6eaa49;border-radius:2px;pointer-events:none;z-index:100}
                                      svg {
                                        color: rgb(0, 0, 0);
                                        font: normal normal 400 normal 16px / normal "Times New Roman";
                                      }
                                        </style>
                              </div>
                              
                          </li>
                          @{{/Answers.Choices}}
                      </ul>
                  </div>
              </div>
          </div>
      </div>
      
      @{{/Questions}}
      @{{/.}}
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script>
        var site_url = $('#site_url').val();
    </script>
    <script src="{{ asset('assets/eduplaycloud/customs/js/editor-playground/app-js/plugins-Render-Client.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/plugin.css') }} ">
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/d3/d3.min.3.js') }} "></script>
    <!-- abcjs -->
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/abcjs/abcjs_basic_5.1.1-min.js') }}  "></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/abcjs/abcjs_init.js') }} "></script>
    <!-- mermaid -->
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/mermaid/mermaid.min.js') }}  "></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/mermaid/mermaid_init.js') }}"></script>
    <!-- table -->
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/table/table.css') }} ">
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/table/table.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/table/table_init.js') }} "></script>
    <!-- katex -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.10.0/dist/katex.min.css" integrity="sha384-9eLZqc9ds8eNjO3TmqPeYcDj8n+Qfa4nuSiGYa6DjLNcv9BtN69ZIulL9+8CqC9Y"
      crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.10.0/dist/katex.min.js" integrity="sha384-K3vbOmF2BtaVai+Qk37uypf7VrgBubhQreNQe9aGsz9lB63dIFiQVlJbr92dw2Lx"
      crossorigin="anonymous"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/katex/katex_init.js') }}"></script>
    <!-- clock -->
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/clock/clock.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/clock/clock_init.js') }}"></script>
    <!-- chess -->
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/chess/chessboard.js') }} "></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/chess/chess_init.js') }} "></script>
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/chess/chessboard-0.3.0.min.css') }}">
    <!-- chartjs -->
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/chartjs/chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/chartjs/chart_init.js') }} "></script>
    <!-- functionplot -->
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/functionplot/functionplot.js') }} "></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/functionplot/functionplot_init.js') }} "></script>
    <!-- jsxgraph -->
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/jsxgraph/canvasparser.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/jsxgraph/jsxgraphcore.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/jsxgraph/jsxgraph.css') }} ">
    <script src="{{ asset('assets/eduplaycloud/customs/editor-playground/vendor/plugins/jsxgraph/jsxgraph_init.js') }} "></script>
    <script src="{{ asset('assets/eduplaycloud/customs/js/editor-playground/client/renderQuestion.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/js/editor-playground/client/pageScript.Practice.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js"></script>
    <!-- rendering the template -->

    <script type='text/javascript'>      


    $(document).ready(function(){
      //-------------------------------Question display with render js plug in-----------------------------------------------

      var json_question = jQuery.parseJSON( $('.json_question').val());            
        
      pRunQuestionListPreview(json_question);
      
      
      function renderToHtml_qList(Q) {

        var template = document.getElementById('question_list_template').innerHTML;
        var output = Mustache.render(template, Q);
        return output;

      }
      
      function pRunQuestionListPreview(list) {
        var data = list;    
        var previewFrame = document.getElementById('preview');
        
        // var static_parserOutputObj = get through api;
        var static_parserOutputObjExamDetail = data;
        var static_plugin_parserOutputObj = renderPluginsinObj(static_parserOutputObjExamDetail);
        var finalObj = static_plugin_parserOutputObj;
        if(previewFrame != undefined) {
            previewFrame.innerHTML = renderToHtml_qList(finalObj);
        }
      }
    });
      </script>
</body>
</html>