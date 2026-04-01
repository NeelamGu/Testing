@extends('front.layout.layout')
@section('content')
<div class="page-wrapper detailBlog">
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="{{ asset('front/images/blogHero_3.jpg') }}" alt="Hero Image">
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
      <div class="auto-container">
         <div class="sec-content pb-35">
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="blogDetail">
                     <h2>Hva koster det å være en bryllupsgjest?</h2>
                     <p>Bryllupssesongen er i gang, og når invitasjonene begynner å tikke inn, følger også spørsmålet: Hva koster det egentlig å være bryllupsgjest?  Å være bryllupsgjest er en ære – men gaver, reise, antrekk og utdrikningslag kan til sammen bli en betydelig sum – og i år er temaet igjen oppe til diskusjon i både medier og lunsjpauser.</p>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="blogDetailImg">
                     <img src="{{ asset('front/images/blog-main-one.jpg') }}" alt="main one image">
                  </div>
               </div>
            </div>
         </div>
         <div class="sec-content pb-35">
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="blogDetailImg">
                     <img src="{{ asset('front/images/blog-main-two.jpg') }}" alt="second image">
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="blogDetail ">
                     <h2>Hvor mye gir vi i gave?</h2>
                     <p>KK publiserte nylig en landsdekkende undersøkelse gjennomført av SpareBank 1 Østlandet blant 1000 personer over 18 år. Undersøkelsen viste at gjennomsnittet på en bryllupsgave ligger på rundt 1700 kroner. Hvor mye man gir, avhenger ofte av hvor nær man er brudeparet:</p>
                     <ul class="blog-sub-points">
                        <li><strong>Nær familie :</strong>ca. 2500 kr</li>
                        <li><strong>Forlovere :</strong>ca. 2000 kr</li>
                        <li><strong>Andre familiemedlemmer :</strong>ca. 1750 kr</li>
                        <li><strong>Venner og bekjente :</strong>ca. 1300 kr</li>
                     </ul>
                     <p>Jo tettere bånd du har til brudeparet, jo dyrere gave er det vanlig å gi.</p>
                     <p>Dersom bryllupet innebærer høye kostnader for gjestene – som reise, overnatting eller kleskoder – reduserer mange gavebeløpet tilsvarende.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
      <section class="package">
      <div class="auto-container">
         <div class="packageDetail ">
            <div class="packList">
               <div class="packItem">
                  <h4>Er det forventet å gi penger?</h4>
                  <p>Pengegaver er blitt mer vanlig enn før, og mange brudepar ønsker seg dette hvis de allerede har det meste av kjøkkenutstyr og interiør. Noen setter opp gavekontoer eller oppgir VIPPS-nummer. For å gjøre pengegaven mer personlig, kan du kombinere den med et fint kort, en blomsterbukett eller en symbolsk gave.</p>
               </div>
               <div class="packItem">
                  <h4>Du kan også gi tjenester</h4>
                 <p>En meningsfull og ofte verdifull gave er å tilby din egen kompetanse eller tid. Kanskje du er frisør og kan gi hårstyling til bruden? Eller fotograf og kan bidra med bilder til utdrikningslaget? Hvis du baker, kan du lage kaker til kakebordet – eller kanskje du er flink til å lage invitasjoner eller dekorasjoner?</p>
                 <p>Tjenestegaver kan spare brudeparet for både tid og penger, og viser omtanke på en helt spesiell måte. Pass bare på at avtalen er tydelig og at dere er enige om omfang og tidspunkt.</p>
               </div>
               <div class="packItem">
                  <h4>Hva hvis du ikke har råd?</h4>
                  <p>Det er fullt mulig å gi en mindre gave eller noe personlig laget. Et gavekort på tjenester, hjelp til bryllupsdagen eller en felles gave sammen med andre gjester er fine alternativer. Det viktigste er ikke prislappen – men at du viser omtanke.</p>
               </div>
            </div>
         </div>
         <div class="packageDetailImg vertical">
            <div class="row">
               <div class="col-lg-12">
                  <img src="{{ asset('front/images/girlDrinks.jpg') }}" alt="">
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="bottomSec">
      <div class="auto-container pb-35">
         <div class="row ">
            <div class="col-12">
               <div class="packageDetail ">
                  <h2>Andre kostnader som følger med:</h2>
               <p>I tillegg til gave kommer ofte andre utgifter. Her er ett grovt overslag over andre potensielle kostnader:</p>
               </div>
                  <ul class="blog-sub-points">
               <li><strong>Utdrikningslag :</strong> 500-2000 kr</li>
               <li><strong>Reise og overnatting :</strong> 1000-4000 kr</li>
               <li><strong>Antrekk og tilbehør :</strong> 500-3000 kr</li>
               <li><strong>Barnevakt og annet raktisk :</strong> 500-1000 kr</li>
            </ul>
            <p>For mange kan det totale beløpet ende på mellom 3 000 og 10 000 kr per bryllup – spesielt hvis det er utenbys eller i utlandet.</p>
            <ul class="blog-sub-points">
                <h2>Våre tips:</h2>
               <li><strong>Sett opp et budsjett :</strong>  Har du mange bryllup samme sesong, lønner det seg å planlegge økonomien i forkant.</li>
               <li><strong>Spleis på gave :</strong> Gå sammen med flere for å gi en større og kanskje mer verdifull gave.</li>
               <li><strong>Tenk personlig :</strong> En gave med omtanke veier tyngre enn en dyr gave uten mening.</li>
               <li><strong>Bruk det du har :</strong> Har du et antrekk fra før, bruk det! Ingen forventer nytt for hvert bryllup.</li>
               <li><strong>Snakk med brudeparet :</strong> Er du usikker, så spør. De fleste vil forstå dersom økonomien er stram.</li>
            </ul>
            <p>Å være bryllupsgjest skal først og fremst være en hyggelig og minneverdig opplevelse – ikke en økonomisk byrde. Gi det du kan med hjertet, og nyt feiringen sammen med de du er glad i.</p>
            </div>
            <div class="col-12">
               <div class="packageDetailImg vertical">
                  <div class="row m-0" >
                     <div class="col-12">
                        <img src="{{ asset('front/images/blog-btm_one.jpg') }}" alt="image one">
                        <img src="{{ asset('front/images/blog-btm_two.jpg') }}" alt="image two">
                     </div>
                     <p style="margin-top: 14px;font-size: 16px;">Ønsker du å gi en personlig gave? På Samling.no finner du bl.a. <a href="https://samling.no/product/kk-family-art/9">Kk family art</a>, <a href="https://samling.no/product/vrprintogdesign/51">Vr print og design</a>, <a href="https://samling.no/product/kala-design/38">Kala design</a> - alle lager unike produkter med gravering eller trykk.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>     

   <!--Main Footer-->
</div>
@endsection