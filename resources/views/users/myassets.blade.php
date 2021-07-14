@extends('authenticated.layouts.default')

@section('content')
<!---Content-->
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
					<div class="pad_lfsd_20 ">
					<h4 class="exersc_title">@lang('myassest.my_assets')</h4>
					@if(isset($images) || isset($csvs) || isset($audios) || isset($file_size))
					<div class="storage-sectin prltv as_chnge">
						<div class="row">
							<div class="col-md-8 ">
							
								<div class="size_cmb_prgs">
									<div class="top-size">
										<h4>@lang('myassest.storage')</h4>
										<p>{{ round($file_size)  }} @lang('myassest.MB_of') {{ $userQuota }} MB </p>
									</div>
									<div class="progress custm-prgres">
										<div class="progress-bar" style="width:{{ $file_size  }}%"></div>
									</div>
								</div>
							</div>
							{{--  My Assest Form  --}}
							<div class="col-md-4 text-right ex_pdng">
								<form id="myAssestForm" method="POST" enctype="multipart/form-data">
									<div class="assts-inpt-btn">
										<span>@lang('myassest.upload_files')</span>
										<input title="@lang('myassest.no_file_chosen')" type="file" name="img[]" id="img" accept="image/*,audio/*,.csv,text/csv" required>
										{{--  <button type="submit" name="myAssestSubmit" id="myAssestSubmit" >submit</button>  --}}
									</div>
									<p id="error1" style="display:none; color:#FF0000;">
										@lang('myassest.error1')</p>
								</form>
							</div>
							<ul id="sizeError" style="display:none; color:#FF0000;">@lang('myassest.files_error')</ul>
							{{--  My Assest Form End  --}}
						</div>
						<ul class="tabs-storage nav nav-pills mb-3" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link" id="pills-csv-tab" data-toggle="pill" href="#pills-csv" role="tab" aria-controls="pills-csv" aria-selected="true" title="@lang('myassest.CSV')"><i class="csv-icn-tb"></i></a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" id="pills-images-tab" data-toggle="pill" href="#pills-images" role="tab" aria-controls="pills-images" aria-selected="false" title="@lang('myassest.Images')"><i class="img-icn-tb"></i></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-audio-tab" data-toggle="pill" href="#pills-audio" role="tab" aria-controls="pills-audio" aria-selected="false" title="@lang('myassest.Audio')"><i class="audio-icn-tb"></i></a>
								</li>
							</ul>
					</div>
					
					<div class="inner-strg-tab tab-content" id="pills-tabContent">
						<div class="tab-pane fade" id="pills-csv" role="tabpanel" aria-labelledby="pills-csv-tab">
							<h5>@lang('myassest.CSV')</h5>
									<div id="no-more-tables-tabs" class="main-table">
										<table class="col-md-12 table-condensed cf">
											<thead class="cf">
											<tr>
												<th>@lang('myassest.name')</th>
												<th>@lang('myassest.uploaded_date')</th>
												<th>@lang('myassest.file_size')</th>
												<th>@lang('myassest.action')</th>
											</tr>
											<tr><th class="bg-none" colspan="4"></th></tr>
											</thead>
											<tbody>
											@forelse ($csvs as $csv)
											<tr>
												<td data-title="@lang('myassest.name')"><img class="icn-left" src="{{ asset('assets/eduplaycloud/image/csv-img.png')}}">{{ $csv->getFilename() }}</td>
												<td data-title="@lang('myassest.uploaded_date')">{{ date('d-m-Y',$csv->getCTime()) }}</td>
												<td data-title="@lang('myassest.file_size')">{{ number_format($csv->getSize()/1024,2)  }} Kb</td>
												<td data-title="@lang('myassest.action')">
													<a class="downlod-file-btn" href="{{ route('myassetsDownload',[$csv->getFilename(),$csv->getExtension()]) }}"><i></i></a>
													<a class="delete-file-btn" href="javascript:void(0)" onclick="deleteData('{{ route('myassetsDelete',[$csv->getFilename(),$csv->getExtension()]) }}');"><i></i></a>
												</td>
											</tr>
											@empty
											<tr><td colspan="4"><p>@lang('myassest.no_data_available')</p></td></tr>
											@endforelse
											</tbody>
										</table>
									</div>
						</div>
						<div class="tab-pane fade show active" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab">
							<h5>@lang('myassest.Images')</h5>
							<div id="no-more-tables-tabs" class="main-table">
								<table class="col-md-12 table-condensed cf">
									<thead class="cf">
									<tr>
										<th>@lang('myassest.name')</th>
										<th>@lang('myassest.uploaded_date')</th>
										<th>@lang('myassest.file_size')</th>
										<th>@lang('myassest.action')</th>
									</tr>
									<tr><th class="bg-none" colspan="4"></th></tr>
									</thead>
									<tbody>
									@forelse ($images as $image)
										<tr>
											<td data-title="@lang('myassest.name')"><img class="image-left-mrgn" src="{{ asset('assets/eduplaycloud/upload/exercisesset/user-'.$userid)}}/image/{{ $image->getFilename() }}" height="50" width="50"/>{{ $image->getFilename() }} </td>
											<td data-title="@lang('myassest.uploaded_date')">{{ date('d-m-Y',$image->getCTime()) }} </td>
											<td data-title="@lang('myassest.file_size')">{{ number_format($image->getSize()/1024,2) }} Kb</td>
											<td data-title="@lang('myassest.action')">
												<a class="downlod-file-btn" href="{{ route('myassetsDownload',[$image->getFilename(),$image->getExtension()]) }}"><i></i></a>
												<a class="delete-file-btn" href="javascript:void(0)" onclick="deleteData('{{ route('myassetsDelete',[$image->getFilename(),$image->getExtension()]) }}');"><i></i></a>
											</td>
										</tr>
									@empty
										<tr><td colspan="4"><p>@lang('myassest.no_data_available')</p></td></tr>
									@endforelse
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-audio" role="tabpanel" aria-labelledby="pills-audio-tab">
							<h5>@lang('myassest.Audio')</h5>
							<div id="no-more-tables-tabs" class="main-table">
								<table class="col-md-12 table-condensed cf">
									<thead class="cf">
									<tr>
										<th>@lang('myassest.name')</th>
										<th>@lang('myassest.play')</th>
										<th>@lang('myassest.uploaded_date')</th>
										<th>@lang('myassest.file_size')</th>
										<th>@lang('myassest.action')</th>
									</tr>
									<tr><th class="bg-none" colspan="4"></th></tr>
									</thead>
									<tbody>
									@forelse ($audios as $audio)
										<tr>
											<td data-title="@lang('myassest.name')">
												<img class="audio-icn-left" src="{{ asset('assets/eduplaycloud/image/audio-img.png')}}">{{ $audio->getFilename() }}
											</td>
											<td data-title="@lang('myassest.play')">
												<audio controls>
													<source src="{{ asset('assets/eduplaycloud/upload/exercisesset/user-'.$userid)}}/audio/{{ $audio->getFilename() }}" type="audio/mpeg">
												</audio>
											</td>
											<td data-title="@lang('myassest.uploaded_date')">{{ date('d-m-Y',$audio->getCTime()) }} </td>
											<td data-title="@lang('myassest.file_size')">{{ number_format($audio->getSize()/1024,2) }} Kb</td>
											<td data-title="@lang('myassest.action')">
												<a class="downlod-file-btn" href="{{ route('myassetsDownload',[$audio->getFilename(),$audio->getExtension()]) }}"><i></i></a>
												<a class="delete-file-btn" href="javascript:void(0)" onclick="deleteData('{{ route('myassetsDelete',[$audio->getFilename(),$audio->getExtension()]) }}');"><i></i></a>
											</td>
										</tr>
									@empty
										<tr><td colspan="5"><p>@lang('myassest.no_data_available')</p></td></tr>
									@endforelse
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
					@else
						<p>@lang('myassest.no_data_available')</p>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<!---End Content-->

@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')

@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')

<script>
	@if(isset($images) || isset($csvs) || isset($audios) || isset($file_size))
	var AvailableSize =  {{ Auth::user()->quota }} - ({{ $file_size  }} * 1000);
	var uploadSize = 0;
	var names = new FormData();
  var csv = false;

	$('INPUT[type="file"]').change(function () {
		//alert(this.files.length);
		//alert($(this).get(0).files.length);

		for (var i = 0; i < $(this).get(0).files.length; ++i) {
			//alert(this.files[i].size);
			//alert(this.files[i].name);

			//return false;
			//var ext =  $('#img').val().split('.').pop().toLowerCase();
			var ext =  this.files[i].name.split('.').pop().toLowerCase();
			//alert(ext);
			switch (ext) {
				case 'jpg':
				case 'jpeg':
				case 'png':
				case 'gif':
					$('#myAssestSubmit').attr('disabled', false);
					$('#error1').slideUp("slow");
					var path = 'image';
					//checkFileSize(this.files[i].name,path,this.files[i].size,120000) // 120000
					checkFileSize(this.files[i],path, {{ env('MY_ASSETS_IMAGE_SIZE', 120000) }}) // 120000

					//uploadSize += this.files[i].size;
					break;
				case 'csv':
					var path = 'csv';
					$('#myAssestSubmit').attr('disabled', false);
					$('#error1').slideUp("slow");
					checkFileSize(this.files[i],path,{{ env('MY_ASSETS_CSV_SIZE', 120000) }}) // 120000

          csv = true;
          checkFileExistsOrNot(this.files[i]);
					//uploadSize += this.files[i].size;
					break;
				case 'mp3':
					var path = 'audio';
					$('#myAssestSubmit').attr('disabled', false);
					$('#error1').slideUp("slow");
					checkFileSize(this.files[i],path,{{ env('MY_ASSETS_AUDIO_SIZE', 2000000) }}) // 2000000
					//uploadSize += this.files[i].size;
					break;
				default:
				$('#error1').slideDown("slow");
					this.value = '';
			}
		}
		// Total space validation
		if(AvailableSize <= ( uploadSize/1024 ) ){
			//alert('Not enough storage please check !!');
			
			swal("@lang('myassest.not_enough_storage')", {
				icon: "error",
			}).then(function(){ 
				location.reload();
			});
		}
		else {
        //alert(names);
        if(!csv){
          fileUpload();
        }        
      }
		//console.log(AvailableSize +'-'+( uploadSize/1024 ));
	});

  function fileUpload(){
    $('.main_loader').show();
     $.ajax({
      type: "POST",
      data: names,
      url: "{{route('myassetsUpload')}}",
      processData: false,
      contentType: false,
      success: function(){
        $('.main_loader').hide();
        swal("@lang('myassest.uploded_successfully')", {
          icon: "success",
        }).then(function(){ 
          location.reload();
        });
      },
      error: function (jqXHR, exception) {
         $('.main_loader').hide();
      },
    })

  }

	// Function for size
	function checkFileSize(file,path,maxSize) {
		//console.log(path,elementSize, maxSize);
		if(file.size > maxSize)
		{
			//alert(path+' file size should not more than '+(maxSize / 1000)+'KB');
			$('#sizeError').append("<li>"+file.name+' of '+path+"@lang('myassest.file_size_more_than') "+(maxSize / 1000)+'KB'+"</li>");
			$('#sizeError').slideDown("slow");
		}else{
			names.append('userfiles[]', file);
			//names.push(file);
			//console.log(uploadSize+'-'+name+" size img");
			uploadSize += file.size;
		}
	}

  //File exists or not check and effected qeustion count get.

  function checkFileExistsOrNot(file){

    var name = file.name;
     $.ajax({
        type: "GET",
        data: {'name' : name},
        url: "{{route('myassets.csv.exists')}}",
        success: function(response){
          //console.log(response);
          if(response.exists){
              swal({
                text: "@lang('myassest.file_replace_meg_1') "+response.question_count+" @lang('myassest.file_replace_meg_2')",
                icon: "warning",
                buttons: ["@lang('myassest.cancel')","@lang('myassest.replaced')"],
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  fileUpload();
                } else {
                  location.reload();
                }
              });
          } else {
             fileUpload();
          }
        }
      })
  }


	function deleteData(url){
		swal({
			title: "@lang('myassest.Are_you_sure')",
			text: "@lang('myassest.once_deleted')",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url : url,
					type : "get",
					success: function(){
						swal("@lang('myassest.file_deleted')", {
						icon: "success",
						}).then(function(){ 
							location.reload();
							}
						 );
					},
					error : function(){
						swal({
							title: 'Opps...',
							text : data.message,
							type : 'error',
							timer : '1500'
						})
					}
				})
			} else {
				//swal("@lang('myassest.file_safe')");
			}
		});
	}
	var anchor = '';

	// Tab selected code
	$(document).ready(function() {
		if (location.hash) {
			var data = location.hash.split('#');

			// console.log(data[1]);
			// console.log(data.length);
			// $("a[href='" + location.hash + "']").tab("show");
			$(".nav-item a[href='#" + data[1] + "']").tab("show");
			if(data.length > 2){
				$(".sub-tabs a[href='#" + data[2] + "']").tab("show");
			}
		}
		$(document.body).on("click", "a[data-toggle]", function(event) {
			location.hash = this.getAttribute("href");
		});
	});

	$(window).on("popstate", function() {
		$("a[href='" + anchor + "']").tab("show");
	});

	@endif
</script>
@endpush