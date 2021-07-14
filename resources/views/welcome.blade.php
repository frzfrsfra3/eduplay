{{--  @extends('layouts.app')  --}}
@extends('guest.layouts.default')
{{-- Page title --}}
@section('title')
Home
@parent
@stop
{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
     <!-- Main Banner -->
    	<div class="service-point2-area">
			<div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12" id="homepage">
					<div class="service-point2-text" >
						<h4>STREAMLINE EDUCATION THROUGH GAMING</h4>
						<p>Play, Learn and Teach your desired Dsicipline; <BR>Monitor your kids' progress through our inter active, fun based knowledge<BR> development platform.<BR><BR></p>
                        <p><a class="btn btn-savebuttonalign" href="{{route('topics.topic.index')}}"> Get Started</a></p>
					</div>
				</div>
		</div>
    <!--- End Main Banner --->
      	<!-- section about -->
    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-title">Our Value Proposition</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 about-box">
                    <div class="col-md-4 col-sm-4 about-box">
                        <div class="about-content">
                            <div class="about-content-student">

                                <img class="img-responsive" src="{{ asset('assets/images') }}/learner.png" alt="Image">
                            </div>
                            <h4>For Students</h4>
                            <p>Explore various disciplines, create your own exercise sets in a private library, and practice various skills across different domains.
                            <center><button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" type="button" class="btn btn-orangebutton-homepage dropdown-toggle text-uppercase" onClick="javascript:viewProfileTypeInfo('students');"> Learn More </button></center>
                            </p>
                        </div></div>
                    <div class="col-md-4  col-sm-4 about-box">
                        <div class="about-content">
                            <div class="about-content-teacher">
                                <img class="img-responsive" src="{{ asset('assets/images') }}/teacher.png" alt="Image">
                            </div>
                            <h4>For Teachers</h4>
                            <p> Create personalized educational classes/contents in private library, publish them through the public library, and manage your learners.
                            <center><button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" type="button" class="btn btn-orangebutton-homepage dropdown-toggle text-uppercase" onClick="javascript:viewProfileTypeInfo('teachers');"> Learn More </button></center>
                            </p>
                        </div>
                    </div>


                    <div class="col-md-4  col-sm-4 about-box"><div class="about-content">
                            <div class="about-content-parent">
                                <img class="img-responsive" src="{{ asset('assets/images') }}/parent.png" alt="Image">
                            </div>
                            <h4>For Parents</h4>
                            <p> Organize your children's gaming and other online activities, invite them to learn a class, create exercise sets, and monitor their progress.
                            <center><button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" type="button" class="btn btn-orangebutton-homepage dropdown-toggle text-uppercase" onClick="javascript:viewProfileTypeInfo('parents');"> Learn More </button></center>
                            </p>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </section>
    <!-- section services -->
    <!--Section Educloud -->
    <!-- section services -->
    <section id="services" class="services">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="section-title">HOW EDUPLAYCLOUD WORKS</h1>
                    <p class="section-text">We are focused towards creating an interactive educational platform. Starting from your signing up with EduPlayCloud to exploring/learning different class materials, we're focused towards making things easier for you. Here's a step-by-step guide to how we help you plug-and-play with EduPlayCloud.</p>
                </div>
            </div>
            <div class="space-30"></div>
            <img class="img-responsive" src="{{ asset('assets/images') }}/eduplay.png" />
        </div>
    </div>
</section>
    <!-- End Section EduCloud -->
    <!-- Section Benefits -->
    <!-- section benefits -->
<section id="services" class="services margin-top-20">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="section-title">WHY YOU NEED EDUPLAYCLOUD</h1>
                <p class="section-text">Learning has no bounds and it's very important to learn new things everyday. EduplayCloud is focused towards creating an interactive learning platform that unifies the learners, parents, and teachers.</p>
            </div>
        </div>
        <div class="">
            <div class="col-md-3 col-sm-3 about-box">
                <div class="about-benefit">
                    <img class="img-responsive" src="{{url(asset('assets/images/gamified.png'))}}" alt="Image">
                    <h4>Mastery independent progress</h4>
                    <p>EduplayCloud creates a progressive learning environment that allows the learners to progress through the class even if they haven't mastered the previous levels.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 about-box">
                <div class="about-benefit">
                    <img class="img-responsive" src="{{url(asset('assets/images/global.png'))}}" alt="Image">
                    <h4>Create long-lasting classes</h4>
                    <p>Teachers need not worry about creating/ losing your lecture materials and contents. Create and upload your class on EduPlayCloud and access it from anywhere, at anytime.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 about-box">
                <div class="about-benefit">
                    <img class="img-responsive" src="{{url(asset('assets/images/multi-lang.png'))}}" alt="Image">
                    <h4>Oversee kids online activity</h4>
                    <p>Parents can stop worrying about your children's online activity. Monitor their online activity, create personalized educational contents, and instantly access their reports.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 about-box">
                <div class="about-benefit">
                    <img class="img-responsive" src="{{url(asset('assets/images/lean-work.png'))}}" alt="Image">
                    <h4>International Curriculum</h4>
                    <p>EduplayCloud offers extended international learning contents that help every student to attain world class knowledge through easy learning.</p>
                </div>
            </div>

        </div>
    </div>
</section>
    <!-- End Section Benefits -->
    <!-- Testimonials -->
    <!-- section Testimonials -->
<section id="services" class="services margin-bottom-40">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="section-title">Did you know</h1>
                <!--p class="section-text"></p-->
            </div>
        </div>
        <div class="col-md-12 col-lg-12">
            <div class="col-md-1 col-lg-1">&nbsp;</div>
            <div class="col-md-10 col-lg-10" data-wow-delay="200000.2s">
                <div class="carousel" data-ride="carousel" id="quote-carousel">
                    <!-- Carousel Slides / Quotes -->
                    <div class="carousel-inner carousel-inner-border text-center">
                        <!-- Quote 1 -->
                        <div class="item active">
                            <blockquote>
                                <div class="row">
                                    <div class="col-sm-12">

                                        <p>Education is not the learning of facts, but the training of the mind to think.</p>

                                    </div>
                                </div>
                            </blockquote>
                            <img class="testimonialsimg" src="{{ asset('assets/images') }}/albert-einsten.jpg" />
                            <div class="testimonial-name">-	Albert Einstein<br/>
                                <!--span>CEO, Managing Director</span-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1 col-lg-1">&nbsp;</div>
        </div>
    </div>
</section>
    <!-- End Testimonials -->
    <!-- End Container -->

@stop