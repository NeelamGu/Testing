@extends('front.layout.layout')
@section('content')
<div class="page-wrapper detailBlog">
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="{{ asset('front/images/blogHero.png') }}" alt="">
         </div>
         <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="{{ url('/')}}">Min side</a></li>
                  <li><a href="#">Blogg</a></li>
               </ul>
            </div>
         </div>
      </div>
   </section>
   <section class="blog-page-section detail">
      <div class="auto-container pb-35">
         <div class="sec-content">
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="blogDetail">
                     <h2>Hva koster en bryllupsfotograf og videograf?</h2>
                     <span>En guide til priser og hva du får for pengene</span>
                     <p>Å finne den rette bryllupsfotografen og videografen er en viktig del av planleggingen for den
                        store dagen. Prisene varierer avhengig av erfaring, stil, og hva som er inkludert i pakken. Her
                        er en oversikt over hva du kan forvente når du skal booke en bryllupsfotograf og videograf.</p>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="blogDetailImg">
                     <img src="{{ asset('front/images/heroRight.png') }}" alt="">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="package">
      <div class="auto-container">
         <div class="packageDetail">
            <h2>Prisnivåer for bryllupsfotografering og videografi</h2>
            <div class="packList">
               <div class="packItem">
                  <h4>5.000 - 15.000 kr</h4>
                  <ul>
                     <li>Nyere fotografer eller hobbyfotografer/videografer</li>
                     <li>Enkel dekning av seremonien eller noen timer</li>
                     <li>Færre redigerte bilder/videoer</li>
                     <li>Ingen eller begrenset album/utskrifter</li>
                  </ul>
               </div>
               <div class="packItem">
                  <h4>15.000 - 30.000 kr</h4>
                  <ul>
                     <li>Valg mellom en nyoppstartet/hobbyfotograf for heldagsfotografering eller en erfaren
                        fotograf for halvdag</li>
                     <li>Vielse + portretter med produkter fra en erfaren fotograf</li>
                     <li>Profesjonell redigering og utvalg av bilder/videoer</li>
                     <li>Enkel dronevideo kan være inkludert eller tilbys som tillegg</li>
                  </ul>
               </div>
               <div class="packItem">
                  <h4>30.000 - 60.000+ kr</h4>
                  <ul>
                     <li>Erfaren fotograf/videograf for heldagsdekning</li>
                     <li>Høyt anerkjent fotograf/videograf med unik stil</li>
                     <li>Tjenester som forlovelsesfotografering og highlight-video</li>
                     <li>Bilder, eksklusive album og kinokvalitet video</li>
                     <li>Flere fotografer/videografer for ulike vinkler og øyeblikk</li>
                     <li>Profesjonell dronevideo for spektakulære luftopptak</li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="packageDetailImg">
            <div class="row">
               <div class="col-lg-6 col-md-6 col-sm-6">
                  <img src="{{ asset('front/images/museum.png') }}" alt="">
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6">
                  <img src="{{ asset('front/images/people.png') }}" alt="">
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="bottomSec">
      <div class="auto-container pb-35">
         <div class="row">
            <div class="col-12">
               <div class="packageDetail">
                  <h2>Hva påvirker prisen?</h2>
                  <div class="bottomList">
                     <ul>
                        <li><strong>Erfaring og omdømme:</strong> Jo mer erfaren fotografen/videografen er, desto høyere
                           pris.</li>
                        <li><strong>Dekningstid:</strong> Halvdags- eller heldagsfotografering/videografi påvirker
                           prisen.</li>
                        <li><strong>Redigering og etterarbeid:</strong> Profesjonell etterbehandling av bilder og
                           videoer tar tid og koster mer.</li>
                        <li><strong>Album, utskrifter og videoformat:</strong> Inkludert eller som tilleggstjeneste.
                        </li>
                        <li><strong>Reiseutgifter:</strong> Fotografer/videografer utenfor nærområdet kan ta ekstra for
                           reise og overnatting.</li>
                        <li><strong>Bruk av drone:</strong> Luftopptak krever spesialutstyr og tillatelser, noe som kan
                           øke prisen.</li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetailImg vertical">
                  <div class="row">
                     <div class="col-12">
                        <img src="{{ asset('front/images/verticalImg_1.png') }}" alt="">
                        <img src="{{ asset('front/images/verticalImg_2.png') }}" alt="">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetail">
                  <h2>Hvordan velge riktig bryllupsfotograf og videograf?</h2>
                  <div class="bottomList">
                     <ul>
                        <li>Nyere fotografer eller hobbyfotografer/videografer</li>
                        <li>Enkel dekning av seremonien eller noen timer</li>
                        <li>Færre redigerte bilder/videoer</li>
                        <li>Ingen eller begrenset album/utskrifter</li>
                     </ul>
                     <p>En bryllupsfotograf og videograf er en investering i minner for livet. Velg noen som fanger
                        øyeblikkene slik dere ønsker å huske dem!</p>
                     <p>Under kategori Foto og video på Samling.no finner du et bredt utvalg av fotografer og
                        videografer
                        som kan forevige din store dag. Enten du ser etter en budsjettvennlig løsning eller en
                        prisvinnende
                        ekspert, vil du finne dyktige fagfolk som matcher dine behov.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!--Main Footer-->
</div>
@endsection