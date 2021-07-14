@extends('layouts.app')
@section('header_styles')

    <script src= "{{asset("assets/editorjs/plugins-Render-Client.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js"></script>

@endsection

@section('content')

    <div>
        <div id="preview"> </div>
    </div>

    <script id="sample_template" type="text/html">
        <%#.%>
        <div class="QuestionItem">
            <div class="Question">
                <div class="SectionHeaderDiv"><span class="SectionHeader">Problem Description:</span></div>
                <%#Problem_Description.Sections%>
                <%& Value%>
                <%/Problem_Description.Sections%>
            </div>
            <%#Questions%>
            <div class="QuestionContainer">
                <div class="Question">
                    <div class="SectionHeaderDiv"><span class="SectionHeader">Question Description:</span></div>
                    <%#Question_Description.Sections%>
                    <%& Value%>
                    <%/Question_Description.Sections%>
                </div>

                <div class="Answers">
                    <div>Answers: choose one answer</div>
                    <%#Answers.Choices%>
                    <div class="Answer">
                        <div class="SectionHeaderDiv"><span class="SectionHeader">Answer:</span></div>
                        <%#Sections%>
                        <%& Value%>
                        <%/Sections%>
                    </div>
                    <%/Answers.Choices%>
                </div>
                <div class="Hints">
                    <div>Hints:</div>
                    <%#Hints.HintList%>
                    <div class="Hint">
                        <div class="SectionHeaderDiv"><span class="SectionHeader">Hint:</span></div>
                        <%#Sections%>
                        <%& Value%>
                        <%/Sections%>
                    </div>
                    <%/Hints.HintList%>
                </div>
            </div>
            <%/Questions%>
        </div>
        <%/.%>
    </script>
    <script type='text/javascript'>

        // function for rendering the template in client side with mustache
        function renderToHtml_E(Q) {
            var template = document.getElementById('sample_template').innerHTML;

            var output = Mustache.render(template, Q, {}, tags=['<%','%>']);
            console.log("\n------------Mustache--------\n");
            console.log(output);
            return output;
        }

        var previewFrame = document.getElementById('preview')

        // call mustache then call renderToHtml
        function pRun() {
            // data is the json variable of the question passed to this view
            var static_parserOutputObj={!! ($data)!!};

            // use the renderPluginsinObj function from plugins-Render-Client.js to render plugins
            var static_plugin_parserOutputObj = renderPluginsinObj(static_parserOutputObj);
            console.log("\n----------------renderpluginobjects-----------\n");

            //static_plugin_parserOutputObj=JSON.stringify(static_plugin_parserOutputObj);
            console.log(static_plugin_parserOutputObj);

            //call function that use mustache to replace the variables in the HTML with their values
            previewFrame.innerHTML = renderToHtml_E(static_plugin_parserOutputObj);
        }

        pRun()

    </script>

@endsection