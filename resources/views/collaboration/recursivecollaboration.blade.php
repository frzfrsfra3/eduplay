@extends('layouts.app')
@section('header_styles')
    <!-- Knowledgemap CSS  ============================================ -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/knowledgemap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/exam.css') }}">


@endsection


@section('content')

    @php
        $color = array(
            1 => "#3ec1de",
            2 => "#49abe1",
            3 => "#5a87e5",

            );

    @endphp

                      <div class=" scroll-list-collaboration scroll-style " >
                        <ol id="ol_categories"   class="simple_with_animation1 " class="list-group list-group-flush" style="padding:0 ; margin:0 7px 0 0 ;">
                            starting to display something
                            @foreach ($firstchildrenSkills as  $firstchildSkill)
                                {{ $firstchildSkill->skill_name}}
                           @endforeach
                        </ol>
                      </div>

@endsection
