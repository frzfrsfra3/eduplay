@extends('authenticated.layouts.default')

@section('header_styles')
<style>
    .no-more-tbl-task table{width: 100%;}
    .no-more-tbl-task table tr th{
      font-family: 'Open Sans', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: #000000;
      }
    .no-more-tbl-task table tr th, .no-more-tbl-task table tr td {
      border-bottom: 1px solid #e7e7e7;
      padding: 12px 15px 12px 15px;
      vertical-align: top;
    }
    .no-more-tbl-task table tr td {
        font-family: 'Raleway', sans-serif;
        font-weight: 500;
        font-size: 14px;
        color: #000000;
    }
    .no-more-tbl-task table tr td:first-child{
        font-family: 'Open Sans', sans-serif;
        font-weight: 700;
    }
    .share_code{
      display: inline-block;
      width: 30px;
      height: 33px;
      background: url(../image/sprite.svg) no-repeat -131px -208px;
      background-size: 600px;
      background-color: black;
    }

    @media only screen and (max-width: 800px) {

      /* Force table to not be like tables anymore */
      #no-more-tables table, 
      #no-more-tables thead, 
      #no-more-tables tbody, 
      #no-more-tables th, 
      #no-more-tables td, 
      #no-more-tables tr { 
          display: block; 
      }
    
      /* Hide table headers (but not display: none;, for accessibility) */
      #no-more-tables thead tr { 
          position: absolute;
          top: -9999px;
          left: -9999px;
      }
    
      #no-more-tables tr { border: 1px solid #ccc; }
    
      #no-more-tables td { 
          /* Behave  like a "row" */
          border: none;
          border-bottom: 1px solid #eee; 
          position: relative;
          padding-left: 50%; 
          white-space: normal;
          text-align:left;
      }
    
      #no-more-tables td:before { 
          /* Now like a table header */
          position: absolute;
          /* Top/left values mimic padding */
          top: 6px;
          left: 6px;
          width: 45%; 
          padding-right: 10px; 
          white-space: nowrap;
          text-align:left;
          font-weight: bold;
      }
    
      /*
      Label the data
      */
      #no-more-tables td:before { content: attr(data-title); }

    }
</style>
@endsection
@section('content')
<!---Content-->


<!--Download Model-->
<div class="modal fade default_modal wht_bg_mdl" id="download_games" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>Game is not installed in your device</h3>
                            <a class="btn-login" target="_blank" href=
                            @switch($deepLink_game)
                                @case('eduplayquiz')"https://play.google.com/store/apps/details?id=com.edupackage" @break
                            @endswitch
                            >Get in Play store</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="work_page mrgn_top_secn text-ar-right">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="my_private_libray">
					<div class="tbs_of_report tbs_of_report-as mrgn-bt-50">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">@lang('messages.my_assignment')
							<span class="caret"></span></button>
							@include('eduplaycloud.users.private-library.menu')
						</div>
					</div>
          <div class="clearfix"></div>
              @if(Session::has('success_message'))
                  <div class="alert alert-success">
                      <span class="glyphicon glyphicon-ok"></span>
                      {!! session('success_message') !!}
                      <button type="button" class="close" data-dismiss="alert" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              @endif
              <div id="error_msg"></div>

              <div class="clearfix"></div>
              {{--  Filter code started  --}}
              <div class="main_detail_fltr pad_lfsd_20">
                  <div class="title_with_shrtby">
                      <div class="float-sm-left filtr_with_titile">
                          <h4 class="exersc_title">@lang('exercisesets.my_codes')</h4>
                      </div>
                  </div>
              </div>
              {{--  Filter code end  --}}   
              <!--End filer form-->
              {{--  Task code started   --}}
              <div class="pad_lfsd_20 mrgn-bt-45" id="filter-pending_task">
                @if ( Auth::check() )
                @if(count($gameCodes) > 0)
                  <div id="no-more-tables" class="no-more-tbl-task">
                      <table class="table-condensed cf">
                          <thead class="cf">
                              <tr>
                                  <th>@lang('messages.code')</th>
                                  <th></th>
                                  <th>@lang('messages.discipline')</th>
                                  <th class="numeric">@lang('messages.curriculum')</th>
                                  <th class="numeric">@lang('messages.grade')</th>
                                  <th class="numeric">@lang('messages.exercises')</th>
                                  <th class="numeric">@lang('messages.action')</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($gameCodes as $code)
                            <tr>
                              <td data-title="@lang('messages.code')">{{ $code->code }}
                              </td>
                              <td>
                                  {{ route('games.my.codes-deeplink' , ['game' => 'eduplayquiz' , 'code' => $code->code , 'codetype' => 'preference-code']) }}
                                  <a  class="btn-login" href="https://www.eduplaycloud.com/eduplayquiz/code/preference-code/{{  $code->code }}"> Open in game </a>
                              </td>
                              <td data-title="@lang('messages.discipline')">{{ @$code->topic->topic_name }}</td>
                              <td data-title="@lang('messages.curriculum')">{{ optional($code->discipline)->discipline_name }}</td>
                              <td data-title="@lang('messages.grade')">{{ optional($code->grade)->grade_name }}</td>
                              <td data-title="@lang('messages.exercises')">
                                    @foreach($code->getExercises() as $exercises)
                                    {{-- <pre> --}}
                                        {{ $exercises->title }} <br/>
                                    {{-- </pre> --}}
                                    @endforeach
                              </td>
                              <td data-title="@lang('messages.action')">
                                 <form id="remove_game_code_{{$code->id}}" method="POST" action="{{route('games.generate.destroy', [$code->id])}}">
                                  @if(Auth::user()->hasRole('Teacher'))
                                    <i class="fa fa-share-alt fa-lg pointer code_share" aria-hidden="true" data-title="@lang('messages.share')"
                                    data-toggle="modal" data-target="#share_model" data-code="{{$code->code}}" data-dismiss="modal"
                                    ></i>
                                  @endif
                                      {{ csrf_field() }}
                                      {{ method_field('DELETE') }}
                                      <i class="fa fa-trash fa-lg pointer" aria-hidden="true" id="code_delete" data-code_id="{{$code->id}}" data-title="@lang('messages.delete')"></i>
                                  </form>
                              </td>
                            </tr>
                          @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                    @endif 


                    <div class="col-md-12">
                        <div class="float-right">
                            {{ $gameCodes->links() }}
                        </div>
                    </div>
                @else
                    <li>
                        <div class="col-lg-12">
                            <P>@lang('messages.no_data_found')!</P>
                        </div>
                    </li>
                @endif              
              </div>

				</div>
			</div>
		</div>
	</div>
</div>
<!---End Content-->

<!--invite_model-->
<div class="modal fade default_modal wht_bg_mdl" id="share_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt invite_mdl text-ar-right">
                                <h3>@lang('classcourse.enter_email_address')</h3>
                                <form class="def_form" method='post' action>
                                    <div class="form-group">
                                        <input type="email" type="text" autocomplete value="" id="addlearner" name="addlearner" class="form-control" placeholder="@lang('classcourse.email_address')">
                                        <label for="email" id='email-err' generated="true" class="error"></label>
                                        <input type="hidden" id="share_code_id" value="">
                                    </div>
                                    <div>
                                        <div id="result">
                                            
                                        </div>
                                    </div>
                                    {{-- <div class="form-group mrgn-tp-30">
                                        <button type="button" data-toggle="modal" data-target="#okay_mdl" data-dismiss="modal" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.send_request')</button>
                                    </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@endsection
<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>

  $(document).on('click','.code_share', function(){
    $('#share_code_id').val($(this).attr('data-code'));
  });


  $(document).ready(function(){

    @if ( $deepLink_code != null )
        $('#download_games').modal('show');
    @endif
        $('#addlearner').keyup(function(){
            $('#addlearner').removeClass('error');
            $('#email-err').text('');
            var name = $('#addlearner').val();
            if (!ValidateEmail($("#addlearner").val())) {
                $('#addlearner').addClass('error');
                $('#email-err').text('@lang("messages.enter_valid_email")');
                return false;
            } else {

                $.ajax({
                    type: 'GET',
                    dataType: "html",
                    url: "{{ route('games.learner.list') }}",
                    data: {ajax: 1, name: name,code: $('#share_code_id').val()},
                    success: function (response) {
                        // console.log(response);
                        $('#result').html(response);
                    },
                    error: function (response) {
                        // console.log(response)
                    }
                });
            }
        });


      function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
      };
  });

  //This function for share code by email sending.
  function shareCodeToLearner(element){
       $('.main_loader').show();
      var code = $(element).attr('data-code');
      var email = $(element).attr('data-email');

      $.ajax({
          type: "POST",
          url: "{{ route('games.code.share') }}",
          data: {
              "_token": "{{ csrf_token() }}",
              "email": email,
              "code": code
          },
          success: function (response) {

              if(response.status){


                var msg =  '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                            + response.msg
                            +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            +'<span aria-hidden="true">&times;</span>'
                            +'</button>'
                            +'</div>';
              } else {
                var msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                          +response.msg
                          +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                          +'<span aria-hidden="true">&times;</span>'
                          +'</button>'
                          +'</div>';
              }

              $('#error_msg').html(msg);
              $('.main_loader').hide();
              
              setTimeout(function(){
                location.reload();
              }, 2000);
          },
          error: function (err) {
               $('.main_loader').hide();
              // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

          }
      })

      $('#share_model').modal('hide');
  }




$(document).on('click','#code_delete',function(){

      var codeID = $(this).attr('data-code_id');

       swal({
          title: '@lang("exerciseset_show.game_code")' ,
          text: "@lang('messages.sure_delete_code')",
          icon: "warning",
          buttons: [
            '@lang("exercisesets.cancel_it")',
            '@lang("exercisesets.sure")'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $('#remove_game_code_'+ codeID).submit();
            } 
        });
});

  </script>
  @endpush