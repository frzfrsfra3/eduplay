        <div class="container">

            <div class="alert alert-info col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <strong>{{$exerciseset->title}}</strong> has {{$countofcorrectanswer+$countofbadanswer}} questions.
            </div>

            <div class="alert alert-success col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <strong>you have answer on </strong>{{$countofcorrectanswer}} questions corectly!
            </div>


            <div class="alert alert-danger col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <strong>you have answer </strong>on {{$countofbadanswer}} badly questions !
            </div>

            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-6"> </div>
            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-6">

                <form method="GET" action="{{ route('signup') }}" accept-charset="UTF-8" id="create_passage_form" name="continue_form" class="form-horizontal">
                    {{ csrf_field() }}

                <button id="continue"
                        type="submit"
                        class="nextquestion btn btn-edubtn" title="Continue" onclick=""       >
                    Continue
                </button>
                </form>
            </div>

        </div>






