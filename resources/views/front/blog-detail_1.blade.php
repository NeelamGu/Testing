@extends('front.layout.layout')
@section('content')
<div class="page-wrapper detailBlog">
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="{{ asset('front/images/blogHero_2.png') }}" alt="">
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
                      <h2>7 tips til deg som får gjester på 17. mai</h2>
               <p>Skal du være vert på nasjonaldagen? Her er noen enkle tips som gjør feiringen både minneverdig og
                  stressfri!</p>
                     <h2>1. Planlegg menyen i god tid</h2>
                     <!-- <span>En guide til priser og hva du får for pengene</span> -->
                     <p>Gå for noe som kan lages på forhånd, som spekemat, potetsalat, rundstykker eller en
                        stor 17. mai-kake. Husk nok kaffe og is!
                     </p>
                     <p>Evt bestill kaken her: <a href="https://samling.no/Kaker-og-sotsaker"
                           target="_blank">https://samling.no/Kaker-og-sotsaker</a></p>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="blogDetailImg">
                     <img src="{{ asset('front/images/heroRight_1.png') }}" alt="">
                  </div>
                  <p style="margin-top: 14px;font-size: 14px;">Dessert fra Jørstad`s hjemmebakeri</p>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="bottomSec">
      <div class="auto-container pb-35">
         <div class="row ">
            <div class="col-12">
               <div class="packageDetail">
                  <h2>2. Lag en velkomstdrink eller bobler til frokost</h2>
               <p>Et glass med prosecco eller en frisk alkoholfri drikk setter stemningen med én gang.</p>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetail">
                  <h2>3. Be gjestene ta med en matrett</h2>
               <p>Det gjør planleggingen enklere, og alle får bidra med noe godt til bordet. Koordiner gjerne på forhånd!</p>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetailImg vertical">
                  <div class="row m-0" >
                     <div class="col-12">
                        <img src="{{ asset('front/images/12.png') }}" alt="">
                        <img src="{{ asset('front/images/13.png') }}" alt="">
                     </div>
                     <p style="margin-top: 14px;font-size: 14px;">Bord pyntet av If a table could talk. </p>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetail">
                  <h2>4. Pynt enkelt og stemningsfullt</h2>
                  <p>Bruk flagg, ballonger og blomster i rødt, hvitt og blått. En liten bukett på bordet og servietter i
                     nasjonalfargene gjør mye.</p>
                  <p>Eller bestill dekorering her: <a href="https://samling.no/Blomster-og-dekor"
                        target="_blank">https://samling.no/Blomster-og-dekor</a></p>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetailImg vertical">
                  <div class="row m-0">
                     <div class="col-12">
                        <img src="{{ asset('front/images/14.png') }}" alt="">
                        <img src="{{ asset('front/images/15.png') }}" alt="">
                     </div>
                     <p style="margin-top: 14px;font-size: 14px;">Bordkort, kaketopper og kvistpynt laget av KK familyart.</p>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetail">
                  <h2>5. Lag en tidsplan for dagen</h2>
                  <div class="bottomList">
                     <p>Spesielt viktig hvis dere skal rekke barnetog, russetog eller TV-sendinger. Del gjerne planen
                        med gjestene!</p>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetail">
                  <h2>6. Lag en liten aktivitetsplan for barna</h2>
                  <div class="bottomList">
                     <p>Hagespill, 17. mai-quiz eller skattejakt med flagg som premie – det holder barna engasjert og
                        glade.</p>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetail">
                  <h2>7. Slapp av og nyt dagen</h2>
                  <div class="bottomList">
                     <p>Ingen forventer et perfekt opplegg – det viktigste er god stemning og hyggelig selskap!</p>
                  </div>
               </div>
            </div>
            <div class="col-12">
               <div class="packageDetail">
                  <h2>God 17. mai – og lykke til med selskapet!</h2>
               </div>
            </div>
         </div>
      </div>
   </section>

   <!--Main Footer-->
</div>
@endsection