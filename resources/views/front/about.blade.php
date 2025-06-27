@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <!--End Main Header -->
   <!-- Static Banner Parallax Background-->
   <section class="about-us">
      <section class="main-slider default-banner">
         <div>
            <div class="carousel-inner bg-none" role="listbox">
               <img class="detail-bg-banner" src="{{ asset('front/images/background/about-bg.jpg') }}" alt="">
            </div>
         </div>
      </section>
   </section>
   <div class="about-text">
      <div class="auto-container">
         <div class="row">
            <div class="col-sm-12">
               <div class="text-area-about">
                  <div class="sec-title style-two">
                     <h1 class="text-thm">About Us</h1>
                  </div>
                  <h4>GJØR DET UFORGLEMMELIG</h4>
                  <p>
                     Velkommen til Samling, din fremste destinasjon for alle dine behov innen arrangementstjenester. Med en lidenskap for å skape uforglemmelige opplevelser, er vi dedikert til å hjelpe deg med å omskape din visjon til virkelighet.
                  </p>
                  <p>
                     Vi skal være førstevalget og en “one-stop-shop” for ethvert arrangement. Enten du planlegger en bedriftskonferanse, et bryllup, en bursdagsfest eller en annen spesiell begivenhet, har vi deg dekket.
                  </p>
                  <p>
                     Alt fra kaker til konfetti, fra blomster til ballonger, finner du her. Om du er en brud som ser etter din drømmekjole, en far som ønsker å overraske din datter med hennes favoritt bursdagskake eller om du skal holde en minnestund for en nær, vil vi være en del av din begivenhet. Vi tilbyr deg et bredt spekter av tjenester for å hjelpe deg med å skape en sømløs og uforglemmelig begivenhet. Planlegg din store dag med oss. Start med å beskrive dine behov i oppdragsskjemaet, motta deretter flere tilbud fra dyktige, lokale leverandører, sammenlign tilbudene og finn den rette leverandøren som passer din stil og budsjett. Slik sparer du både tid og penger. Det er gratis og uforpliktende. Ved å velge lokale tilbydere, vil du få helt unike produkter og samtidig bidra til et mer bærekraftig samfunn ved å redusere behov for langtransport. Du kan også finne den rette leverandøren ved å søke i ønsket kategorifelt. Eller finn inspirasjon og skap et "moodboard" ved å samle alle dine favoritter på ett sted.
                  </p>
                  <p class="supplier-text"><b>For leverandører: </b></p>
                  <p>
                     Samling vil løfte frem lokale bedrifter i hele landet.  Vi ønsker å samle alt fra hobbybakeren som ikke har egen nettside til det store veletablerte selskapslokalet, under ett tak.
                  </p>
                  <p>
                     Leverer du tjenester eller produkter som kan brukes ved samlinger? Ønsker du mer synlighet og flere potensielle kunder uten å bruke en formue på markedsføring? Vår anbudstjeneste videresender kun relevante kunder som trenger hjelp/varer i ditt dekningsområde.Høres interessant ut? <a class="about-p-link" href="{{ url('/vendor/register') }}">Registrer deg som leverandør her.</a>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection