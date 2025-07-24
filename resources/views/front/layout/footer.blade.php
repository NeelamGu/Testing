<!--Main Footer-->
<footer class="main-footer footer-area">
   <!--Footer Upper-->
   <div class="footer-upper">
      <!--Go Up Button-->
      <div class="container">
         <div class="row">
            <!-- <div class="col-md-3 col-sm-6 col-xs-12 column">
               <div class="footer-widget about-widget">
                  <h2>OM EVENTPLANLEGGEREN </h2>
                  <div class="text">
                     <p>Phasellus at quam tristique, cursus tellus vitae, convallis neque. Sed a lacinia
                        sapien. Etiam dignissim sit amet felis ac sagittis. Sed libero arcu, pharetra et
                        ante in elementum. Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Quae.
                     </p>
                  </div>
               </div>
               </div> -->
            <div class="col-sm-6 col-xs-12 column">
               <div class="footer-widget links">
                  <h2>Nyttige lenker</h2>
                  <ul>
                     <!-- <li><a href="{{ url('/')}}">Hjem</a></li> -->
                     <li><a href="{{ url('/about')}}">Om Samling</a></li>
                     <li>
                        <!-- <a data-toggle="modal" data-target="#customerlogin" href="javascript:void(0)">Leverandør innlogging</a> -->
                     </li>
                     <li><a href="{{ url('/blog')}}">Blogg</a></li>
                     <li><a href="{{ url('/contact')}}">Kundeservice</a></li>
                     <li><a href="{{ url('/privacy-policy')}}">Personvern</a></li>
                     <li><a href="{{ url('/terms-conditions')}}">Vilkår og betingelser for bruker</a></li>
                     <!-- <li><a href="{{ url('/supplier-terms-conditions')}}">Vilkår og betingelser for leverandør</a></li> -->
                     <li><a href="{{ url('/cookie-policy')}}">Cookies Policy</a></li>
                  </ul>
               </div>
            </div>
            <div class=" col-sm-6 col-xs-12 column">
               <div class="footer-widget twitter-feed">
                  <h2>Følg oss</h2>
                  <div class="social-links">
                     <a target="_blank" href="https://www.facebook.com/profile.php?id=61555971146343&sk=about" class="icon fa fa-facebook-f"></a>
                     <a target="_blank" href="https://www.instagram.com/samling.no?igsh=MXgxOTZrZ25sdGNrOQ%3D%3D&utm_source=qr" class="icon fa fa-instagram"></a>
                     <a target="_blank" href="https://www.tiktok.com/@samling.no?_t=8jKC5OhZ9H7&_r=1"><img src="{{ asset('front/images/icons/tiktok.png') }}"></a>                  
                  </div>
                  <p class="org-num">Org.nr: 932341956</p>
               </div>
            </div>
            <?php /* <div class="col-sm-5 col-xs-12 column">
               <div class="footer-widget newsletter-widget">
                  <h2>Abonner på vårt nyhetsbrev</h2>
                  <div class="text">
                     <p>Vi vil holde deg oppdatert om de nyeste trendene innen fest og samling, men lover å ikke spamme deg!
                     </p>
                  </div>
                  <br>
                  <div class="form-box">
                     <form action="javascript:;" autocomplete="off" name="subscribeForm" id="Subscribe" method="post">
                        <div class="form-group">
                           <input type="email" id="subscriber" name="email" value="" placeholder="E-postadresse"
                              required>
                           <button type="submit" class="btn-submit subscribe-btn-submit">
                           Abonner
                           </button>
                           <span class="alert alert-success SuccessFader" style="display: none; float: left; width: 100%;"></span>
                           <span class="alert alert-danger FailureFader" style="display: none; float: left; width: 100%;"></span>
                        </div>
                     </form>
                  </div>
               </div>
            </div> */ ?>
         </div>
         <!--  <div class="row">
            <div class="contact-info">
               <ul>
                  <li>
                     <div class="info-title"><span class="fa fa-phone"></span> Ring oss når som helst</div>
                     <div class="info-title"><span class="fa fa-phone"></span> SAMLING.NO AS Org.nr</div>
                     <p class="info">(+064)-342-68372</p>
                  </li>
                  <li>
                     <div class="info-title"><span class="fa fa-clock-o"></span> Åpningstider</div>
                     <p class="info">8:00 am - 6:00 pm</p>
                  </li>
                  <li>
                     <div class="info-title"><span class="fa fa-at"></span> Send oss ​​en e-post på</div>
                     <p class="info">event@planner-wedding.com
                     </p>
                  </li>
               </ul>
            </div>
            </div> -->
      </div>
   </div>
   <!--Footer Bottom-->
   <div class="footer-bottom">
      <div class="auto-container">
         <!--Copyright-->
         <div class="copyright">Opphavsrett <?php echo date("Y"); ?> Alle rettigheter forbeholdt</div>
      </div>
   </div>
   <!-- Enquery Form Button Start here -->
   <!-- Cookie policy Popup Start here -->
   <div class="card cookie-alert">
      <div class="card-body">
         <p class="card-text">Dette nettstedet bruker informasjonskapsler (cookies) for å gi deg en bedre kundeopplevelse. Fortsetter du å benytte dette nettstedet, aksepterer du bruk av våre informasjonskapsler. Du kan 
            lese mer om våre informasjonskapsler <a class="learn-cookie-btn" href="{{ url('/cookie-policy') }}">her.</a>  
         </p>
         <div class="btn-toolbar justify-content-end">
            <!-- <a href="{{ url('/cookie-policy') }}" target="_blank" class="btn learn-cookie-btn btn-link">Learn more</a> -->
            <a href="#" class="btn btn-primary accept-cookies">Godta</a>
         </div>
      </div>
   </div>
   <!-- End Here -->
</footer>
<!-- @if(!isset(Auth::guard('admin')->user()->type))
   <div class="enquery-form">
      <a href="{{ url('enquire-us') }}">Rask forespørsel</a>
   </div>
   @endif -->