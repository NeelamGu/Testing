@extends('front.layout.layout')
@section('content')
<div class="">
   <!--End Main Header -->
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <!-- <div class="carousel-inner bg-none" role="listbox">
            <img src="images/venue.png" alt="">
            </div> -->
         <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="{{ url('/')}}">Min side</a></li>
                  <li><a href="#">Plans</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <div class="all-plans">
      <div class="auto-container">
         <div class="price-tb-title">
            <h2 class="text-thm pricing-title">Abonnementspakker</h2>
            <div class="row">
               @foreach($plans as $plan)
               <div class="col-sm-3 plans-sec">
                  <div class="plans-section">
                     @if(!empty($plan['image']))
                     <img src="{{ asset('front/images/plan_images/'.$plan['image']) }}">
                     @else
                     <img src="{{ asset('front/images/product_images/small/no-image.png') }}">
                     @endif
                     <div class="plans-text-area">
                        <p class="pack-name">{{ $plan['name'] }}</p>
                        <h4 class="plans-price">{{ $plan['price'] }}kr</h4>
                        <p class="pack-text">{{ $plan['short_description'] }}</p>
                        <div class="pack-details">
                           <?php echo $plan['features']; ?>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
         <div class="plans-register">
            <p>Abonnement velges  etter utfylling av registreringsskjema.</p>
            <a class="b-t-register" href="{{ url('/vendor/register')}}">Registreringsskjema for leverandør</a>
        </div>
         <div class="plans-detail-area">
            <h3>Alle priser er ekskl. mva.</h3>
            <!-- <h2>Profiler</h2>
            <div class="term-list-area">
               <h4><b>Enkel profil</b></h4>
               <ul>
                  <li>Inneholder profilbilde, navn på bedriften og bildegalleri </li>
                  <li>Du mottar forespørsler og ser oppdrag som legges ut, men kan ikke svare</li>
               </ul>
            </div>
            <div class="term-list-area">
               <h4><b>Standard profil</b></h4>
               <ul>
                  <li>Inneholder det meste du trenger for å vise fram din bedrift</li>
                  <li>Kan svare på forespørsler og oppdrag</li>
                  <li>Kan legge til søkeord slik at kunder enklere kan finne deg </li>
                  <li>Kunder kan legge deg til favorittlisten sin</li>
               </ul>
            </div> -->
            <!-- <div class="term-list-area">
               <h4><b>Premium profil</b></h4>
               <ul>
                  <li>En mer attraktiv profilside som inneholder alt du trenger for å vise frem bedriften din</li>
                  <li>Prioritert rangering i leverandøroversikten</li>
                  <li>Kan svare på forespørsler og oppdrag </li>
                  <li>Kan legge til søkeord slik at kunder enklere kan finne deg </li>
                  <li>Kunder kan legge deg til favorittlisten sin</li>
               </ul>
            </div> -->
            <div class="term-list-area">
               <h4 class="title-color"><b>Flere annonser</b></h4>
               <p>Hvis du tilbyr tjenester innen flere kategorier, kan du velge en pakke med flere annonser. Dette fører til at dine annonser vises under de ulike kategoriene du velger, og samtidig vil du se oppdrag fra alle de kategoriene.</p>
            </div>
            <div class="term-list-area">
               <h4 class="title-color"><b>Klipp</b></h4>
               <p>Klipp er antall oppdrag og forespørsler du svarer på per måned.</p>
            </div>
            <div class="term-list-area">
               <h4 class="title-color"><b>Sponsing</b></h4>
               <p>Hvis du ønsker å synliggjøre bedriften din ekstra, kan du velge å sponse. Når du sponser, vil profilen din vises på forsiden av Samling.no under «Sponsede leverandører».
               </p>
            </div>
            <div class="term-list-area">
               <h4 class="title-color"><b>
                  Prøvepakken
                  </b>
               </h4>
               <p>Prøvepakken er for deg som ønsker å utforske Samling.no. Om du er usikker på om denne nettsiden er noe for deg og din bedrift, kan du prøve denne pakken for å se hvordan nettsiden fungerer. Du vil ha en enkel annonse og se forespørsler og oppdrag som er relevante for deg, men du vil ikke kunne svare før du eventuelt oppgraderer til en høyere pakke. En oppgradering  kan du enkelt gjøre på Min konto.</p>
            </div>
         </div>
      </div>
   </div>
   <!--Main Footer-->
</div>
@endsection