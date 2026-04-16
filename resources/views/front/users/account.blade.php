@extends('front.layout.layout')
@section('content')
@include('front.users.partials.topbar', ['activeTopTab' => 'profile'])
<style>
   .profile-shell {
      margin-top: 4px;
      margin-bottom: 0;
   }
   .contact-section.account-page .column.pull-left {
      overflow: hidden;
   }
   .profile-main {
      background: #f7f3ec;
      border: 1px solid #e8dbc7;
      border-radius: 18px;
      padding: 14px;
      box-shadow: 0 14px 26px rgba(49, 37, 20, 0.07);
      min-height: calc(100dvh - 124px);
      height: auto;
      overflow: visible;
      display: flex;
      flex-direction: column;
      color: #000;
   }
   .profile-heading {
      margin-bottom: 10px;
      flex-shrink: 0;
   }
   .profile-heading h2 {
      margin: 0;
      font-size: 48px;
      line-height: 0.98;
      color: #000;
      font-weight: 800;
      letter-spacing: -0.5px;
   }
   .profile-heading p {
      margin: 8px 0 0;
      color: #000;
      font-size: 15px;
      max-width: 680px;
      line-height: 1.35;
   }
   .profile-grid {
      display: grid;
      grid-template-columns: minmax(0, 1.7fr) minmax(320px, 0.95fr);
      gap: 12px;
      margin-top: 8px;
      align-items: start;
      flex: 1;
      min-height: 0;
   }
   .profile-left-stack,
   .profile-right-stack {
      display: grid;
      gap: 12px;
      align-content: start;
      min-width: 0;
   }
   .profile-right-stack {
      display: flex;
      flex-direction: column;
      height: auto;
   }
   .card-soft {
      border: 1px solid #e9dcc8;
      border-radius: 16px;
      background: #f1ebe2;
      padding: 12px;
      position: relative;
      overflow: hidden;
      color: #000;
   }
   .personal-card {
      margin-bottom: 14px;
   }
   .card-icon-title {
      margin: 0 0 10px;
      color: #000;
      font-size: 18px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
   }
   .card-icon-title i {
      color: #000;
   }
   .field-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px 14px;
   }
   .field-wrap {
      min-width: 0;
   }
   .field-wrap.field-wrap-wide {
      grid-column: span 2;
   }
   .field-wrap label {
      display: block;
      margin: 0 0 6px;
      color: #3d2d16;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      font-weight: 700;
   }
   .field-wrap input {
      width: 100%;
      height: 42px;
      border-radius: 10px;
      border: 1px solid #d7c8b2;
      padding: 9px 12px;
      background: #fbf8f2;
      font-size: 15px;
      color: #20190f;
   }
   .field-wrap input[readonly] {
      background: #f1eadf;
      color: #6b5a46;
   }
   .field-wrap input:focus {
      border-color: #b56908;
      outline: none;
      box-shadow: 0 0 0 3px rgba(181, 105, 8, 0.14);
   }
   .field-wrap p {
      margin: 4px 0 0;
      min-height: 0;
      font-size: 12px;
      line-height: 1.2;
      color: #9f2b1b;
   }
   .field-wrap p:empty {
      display: none;
   }
   .visual-card {
      margin-top: 2px;
   }
   .visual-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 10px;
      align-items: center;
      margin-bottom: 10px;
   }
   .visual-row strong {
      font-size: 16px;
      color: #000;
   }
   .visual-row p {
      margin: 0;
      color: #000;
      font-size: 13px;
   }
   .color-row {
      display: flex;
      align-items: center;
      gap: 8px;
   }
   .color-row input[type="color"] {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 50%;
      padding: 0;
      opacity: 0;
      margin: 0;
      cursor: pointer;
   }
   .preset-dot {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 1px solid rgba(0, 0, 0, 0.18);
      cursor: pointer;
      background: #fff;
      display: inline-block;
   }
   .custom-color-dot {
      width: 34px;
      height: 34px;
      position: relative;
      overflow: hidden;
      border: 2px solid #ffffff;
      box-shadow: 0 0 0 1px #c8b79f;
      background:
         conic-gradient(
            #ff003c 0deg,
            #ff7a00 60deg,
            #ffd500 120deg,
            #00c853 180deg,
            #00b0ff 240deg,
            #7c4dff 300deg,
            #ff003c 360deg
         );
   }
   .custom-color-dot::after {
      content: '';
      position: absolute;
      inset: 6px;
      border-radius: 50%;
      border: 1px solid rgba(255, 255, 255, 0.7);
      background: rgba(255, 255, 255, 0.12);
      pointer-events: none;
   }
   .security-help {
      margin-top: 10px;
      margin-bottom: 4px;
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #000;
      text-decoration: none;
      display: inline-block;
   }
   .security-help:hover {
      color: #000;
   }
   .profile-summary {
      text-align: center;
      padding: 12px 10px;
      background: #f8f5ef;
   }
   .profile-avatar-wrap {
      width: 74px;
      height: 74px;
      margin: 0 auto 8px;
      position: relative;
   }
   .profile-summary img {
      width: 74px;
      height: 74px;
      border-radius: 50%;
      border: 3px solid #fff;
      box-shadow: 0 8px 18px rgba(30, 23, 13, 0.2);
      object-fit: cover;
   }
   .profile-edit-dot {
      position: absolute;
      right: -2px;
      bottom: 0;
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: #a65f03;
      color: #fff;
      border: 2px solid #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      cursor: pointer;
      padding: 0;
      line-height: 1;
   }
   .profile-edit-dot:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(166, 95, 3, 0.2);
   }
   .profile-summary h4 {
      margin: 0;
      color: #000;
      font-size: 21px;
      font-weight: 700;
   }
   .profile-summary p {
      margin: 5px 0 0;
      color: #000;
      font-size: 12px;
   }
   .timeline-title {
      margin: 0;
      font-size: 21px;
      font-weight: 700;
      color: #000;
      display: inline-flex;
      align-items: center;
      gap: 8px;
   }
   .timeline-title i {
      color: #b26407;
      font-size: 17px;
   }
   .timeline-subtitle {
      margin: 6px 0 8px;
      color: #000;
      font-size: 12px;
      line-height: 1.35;
   }
   .timeline-list {
      display: grid;
      gap: 8px;
   }
   .timeline-item {
      position: relative;
      padding: 8px 10px;
      min-height: 0;
      border: 1px solid #e6d8c4;
      border-radius: 12px;
      background: #f8f4ed;
   }
   .timeline-item:after {
      display: none;
   }
   .timeline-icon {
      position: static;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid transparent;
      font-size: 10px;
   }
   .timeline-icon.new {
      background: #f8e8cf;
      color: #8a520a;
      border-color: #ebc68e;
   }
   .timeline-icon.done {
      background: #edf4ef;
      color: #547060;
      border-color: #cfdfd1;
   }
   .timeline-icon.neutral {
      background: #eef1f4;
      color: #667687;
      border-color: #d5dde6;
   }
   .timeline-item-top {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 2px;
   }
   .timeline-item-top strong {
      font-size: 14px;
      color: #000;
      font-weight: 700;
   }
   .timeline-count {
      min-width: 18px;
      height: 18px;
      border-radius: 999px;
      background: #ede3d6;
      color: #000;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: 700;
      padding: 0 5px;
   }
   .timeline-link {
      display: inline-block;
      font-size: 14px;
      color: #000;
      font-weight: 600;
      text-decoration: none;
      line-height: 1.25;
      margin-bottom: 0;
   }
   .timeline-time {
      margin: 2px 0 0;
      color: #000;
      font-size: 11px;
      line-height: 1.35;
   }
   .profile-side-actions {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 8px;
      justify-content: flex-end;
      margin-top: 10px;
      margin-left: 0;
      width: 100%;
      position: sticky;
      bottom: 10px;
      z-index: 2;
      padding: 8px 10px 4px;
      border-radius: 14px;
      background: linear-gradient(180deg, rgba(247, 243, 236, 0), rgba(247, 243, 236, 0.96) 34px);
   }
   .profile-side-actions .save-btn {
      border: 0;
      border-radius: 14px;
      min-height: 48px;
      width: auto;
      min-width: 230px;
      padding: 0 18px;
      font-size: 17px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 8px 16px rgba(70, 43, 12, 0.2);
   }
   .profile-side-actions .save-btn:hover {
      filter: brightness(0.96);
   }
   #account-success,
   #account-error {
      margin: 0 0 8px;
      font-size: 12px;
   }
   @media (max-width: 1199px) {
      .profile-heading h2 {
         font-size: 42px;
      }
      .profile-grid {
         grid-template-columns: minmax(0, 1fr) minmax(300px, 0.9fr);
      }
      .profile-note {
         margin: 8px 0 0;
         color: #6b5d4a;
         font-size: 15px;
         font-weight: 600;
         max-width: 680px;
         line-height: 1.35;
      }
   }
   @media (max-width: 991px) {
      .profile-grid {
         grid-template-columns: 1fr;
      }
      .profile-main {
         height: auto;
         overflow: visible;
      }
      .field-grid {
         grid-template-columns: repeat(2, minmax(0, 1fr));
      }
      .profile-heading h2 {
         font-size: 36px;
      }
   }
   @media (max-width: 767px) {
      .profile-main {
         padding: 10px;
      }
      .profile-heading p {
         font-size: 14px;
      }
      .field-grid {
         grid-template-columns: 1fr;
      }
      .field-wrap.field-wrap-wide {
         grid-column: auto;
      }
      .profile-side-actions .save-btn {
         width: 100%;
         min-width: 0;
      }
      .profile-side-actions {
         width: 100%;
         margin-left: 0;
      }
      .profile-heading h2 {
         font-size: 32px;
      }
      .timeline-title {
         font-size: 21px;
      }
      .timeline-card.is-mobile-top {
         margin-bottom: 12px;
      }
   }
</style>

<div class="page-wrapper">
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'account'])
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="profile-shell">
                  <div class="profile-main">
                     <div class="profile-heading">
                        <h2>Min Profil</h2>
                        <p class="profile-note">{{ $profileNoteMessage ?? 'Velkommen tilbake! Klar for å planlegge noe hyggelig?' }}</p>
                     </div>

                     @if(Session::has('success_message'))
                        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                     @endif
                     @if(Session::has('error_message'))
                        <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
                     @endif
                     @if($errors->any())
                        <div class="alert alert-danger">{!! implode('', $errors->all('<div>:message</div>')) !!}</div>
                     @endif

                     <p id="account-error"></p>
                     <p id="account-success"></p>

                     <div class="profile-grid">
                        <div class="profile-left-stack">
                           <form id="accountForm" action="javascript:;" method="post">@csrf
                              <div class="card-soft personal-card">
                                 <h4 class="card-icon-title"><i class="fa fa-user"></i> Personlig Informasjon</h4>
                                 <div class="field-grid">
                                    <div class="field-wrap">
                                       <label>Fornavn</label>
                                       <input type="text" id="user-first_name" name="first_name" value="{{ Auth::user()->first_name }}">
                                       <p id="account-first_name"></p>
                                    </div>
                                    <div class="field-wrap">
                                       <label>Etternavn</label>
                                       <input type="text" id="user-last_name" name="last_name" value="{{ Auth::user()->last_name }}">
                                       <p id="account-last_name"></p>
                                    </div>
                                    <div class="field-wrap">
                                       <label>E-postadresse</label>
                                       <input type="text" value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                    <div class="field-wrap">
                                       <label>Telefon</label>
                                       <input type="text" id="user-mobile" name="mobile" value="{{ Auth::user()->mobile }}">
                                       <p id="account-mobile"></p>
                                    </div>
                                    <div class="field-wrap field-wrap-wide">
                                       <label>Adresse</label>
                                       <input type="text" id="user-address" name="address" value="{{ Auth::user()->address }}">
                                       <p id="account-address"></p>
                                    </div>
                                    <div class="field-wrap">
                                       <label>Postnummer</label>
                                       <input type="text" id="user-pincode" name="pincode" value="{{ Auth::user()->pincode }}">
                                       <p id="account-pincode"></p>
                                    </div>
                                    <div class="field-wrap">
                                       <label>Poststed</label>
                                       <input type="text" id="user-city" name="city" value="{{ Auth::user()->city }}">
                                       <p id="account-city"></p>
                                    </div>
                                    <div class="field-wrap">
                                       <label>Fylke</label>
                                       <input type="text" id="user-state" name="state" value="{{ Auth::user()->state }}">
                                       <p id="account-state"></p>
                                    </div>
                                 </div>
                              </div>

                              <div class="card-soft visual-card">
                                 <h4 class="card-icon-title"><i class="fa fa-paint-brush"></i> Visuelle Preferanser</h4>
                                 <div class="visual-row">
                                    <div>
                                       <strong>Bakgrunnstone</strong>
                                       <p>Velg en fargetone som passer ditt arbeidsmiljø</p>
                                    </div>
                                    <div class="color-row">
                                       <span class="preset-dot" data-target="bg" data-value="#f8f4ed" style="background:#f8f4ed;"></span>
                                       <span class="preset-dot" data-target="bg" data-value="#efe6d3" style="background:#efe6d3;"></span>
                                       <span class="preset-dot" data-target="bg" data-value="#e7f2ed" style="background:#e7f2ed;"></span>
                                       <span class="preset-dot" data-target="bg" data-value="#e9eef1" style="background:#e9eef1;"></span>
                                       <span class="preset-dot" data-target="bg" data-value="#dfe7f8" style="background:#dfe7f8;"></span>
                                       <span class="preset-dot" data-target="bg" data-value="#f3e5ef" style="background:#f3e5ef;"></span>
                                       <span class="preset-dot" data-target="bg" data-value="#1e1d1a" style="background:#1e1d1a;"></span>
                                       <label class="preset-dot custom-color-dot" title="Velg egendefinert bakgrunnsfarge">
                                          <input type="color" id="user-panel-bg-color" name="panel_bg_color" value="{{ Auth::user()->panel_bg_color ?: '#f8f4ed' }}" aria-label="Velg egendefinert bakgrunnsfarge">
                                       </label>
                                    </div>
                                 </div>
                                 <div class="visual-row" style="margin-bottom:0;">
                                    <div>
                                       <strong>Aksentfarge</strong>
                                       <p>Hovedfarge for knapper og aktive elementer</p>
                                    </div>
                                    <div class="color-row">
                                       <span class="preset-dot" data-target="accent" data-value="#a65f03" style="background:#a65f03;"></span>
                                       <span class="preset-dot" data-target="accent" data-value="#e78002" style="background:#e78002;"></span>
                                       <span class="preset-dot" data-target="accent" data-value="#d64545" style="background:#d64545;"></span>
                                       <span class="preset-dot" data-target="accent" data-value="#1e9f5a" style="background:#1e9f5a;"></span>
                                       <span class="preset-dot" data-target="accent" data-value="#7aa07d" style="background:#7aa07d;"></span>
                                       <span class="preset-dot" data-target="accent" data-value="#6e8ea5" style="background:#6e8ea5;"></span>
                                       <span class="preset-dot" data-target="accent" data-value="#9f6d8d" style="background:#9f6d8d;"></span>
                                       <label class="preset-dot custom-color-dot" title="Velg egendefinert aksentfarge">
                                          <input type="color" id="user-panel-accent-color" name="panel_accent_color" value="{{ Auth::user()->panel_accent_color ?: '#e78002' }}" aria-label="Velg egendefinert aksentfarge">
                                       </label>
                                    </div>
                                 </div>
                                 <p id="account-panel_bg_color" style="display:none;"></p>
                                 <p id="account-panel_accent_color" style="display:none;"></p>
                              </div>

                           </form>
                        </div>

                        <div class="profile-right-stack">
                           <div class="card-soft timeline-card">
                              <h4 class="timeline-title"><i class="fa fa-bell" aria-hidden="true"></i>Nylige oppdateringer</h4>
                              <p class="timeline-subtitle">Her vises varsler når du har fått ny melding</p>
                              @php
                                 $newMessageUpdates = collect($recentEnquiries ?? [])->filter(function($timeline){
                                    return (int)($timeline['unread_vendor'] ?? 0) > 0;
                                 })->take(4);
                              @endphp
                              <div class="timeline-list">
                                 @forelse($newMessageUpdates as $timeline)
                                    @php
                                       $timelineName = $timeline['product']['product_name'] ?? 'Oppdrag';
                                       $timelineDate = !empty($timeline['last_message_at']) ? date('d.m.y H:i', strtotime($timeline['last_message_at'])) : (!empty($timeline['updated_at']) ? date('d.m.y H:i', strtotime($timeline['updated_at'])) : '');
                                       $timelineUnread = (int)($timeline['unread_vendor'] ?? 0);
                                    @endphp
                                    <div class="timeline-item">
                                       <div class="timeline-item-top">
                                          <span class="timeline-icon new"><i class="fa fa-commenting-o"></i></span>
                                          <strong>Ny melding</strong>
                                          <span class="timeline-count">{{ $timelineUnread }}</span>
                                       </div>
                                       <a class="timeline-link" href="{{ url('user/enquiries/'.$timeline['id']) }}">{{ $timelineName }}</a>
                                       <p class="timeline-time">Mottatt {{ $timelineDate }}</p>
                                    </div>
                                 @empty
                                    <div class="timeline-item">
                                       <span class="timeline-icon neutral"><i class="fa fa-info"></i></span>
                                       <div class="timeline-item-top"><strong>Ingen nye meldinger</strong></div>
                                    </div>
                                 @endforelse
                              </div>
                           </div>

                           <div class="card-soft profile-summary">
                              @php
                                 $profileImageRelativePath = 'front/images/user_images/profile-'.Auth::user()->id.'.jpg';
                                 $profileImageAbsolutePath = public_path($profileImageRelativePath);
                                 $profileImageUrl = file_exists($profileImageAbsolutePath)
                                    ? asset($profileImageRelativePath).'?v='.filemtime($profileImageAbsolutePath)
                                    : asset('front/images/profile.png');
                              @endphp
                              <div class="profile-avatar-wrap">
                                 <img id="profileAvatarImage" src="{{ $profileImageUrl }}" alt="Profil">
                                 <button type="button" class="profile-edit-dot" id="profileImageTrigger" aria-label="Endre profilbilde"><i class="fa fa-pencil"></i></button>
                                 <input type="file" id="profileImageInput" accept="image/jpeg,image/jpg,image/png,image/webp" style="display:none;">
                              </div>
                              <h4>{{ Auth::user()->name }}</h4>
                              <p>Medlem siden {{ date('Y', strtotime(Auth::user()->created_at ?? now())) }}</p>
                           </div>

                           <div class="profile-side-actions">
                              <button class="save-btn" type="submit" form="accountForm"><i class="fa fa-save"></i> Lagre endringer</button>
                              <a class="security-help" href="{{ url('user/update-password') }}">Glemt passord?</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   (function () {
      var dots = document.querySelectorAll('.preset-dot');
      var bgInput = document.getElementById('user-panel-bg-color');
      var accentInput = document.getElementById('user-panel-accent-color');
      if (!bgInput || !accentInput) {
         return;
      }
      function getAccentContrastColor(hexColor) {
         var safeHex = (hexColor || '#e78002').replace('#', '');
         if (!/^[0-9a-fA-F]{6}$/.test(safeHex)) {
            safeHex = 'e78002';
         }
         var red = parseInt(safeHex.substring(0, 2), 16);
         var green = parseInt(safeHex.substring(2, 4), 16);
         var blue = parseInt(safeHex.substring(4, 6), 16);
         var yiq = ((red * 299) + (green * 587) + (blue * 114)) / 1000;
         return yiq >= 160 ? '#111111' : '#f8fafc';
      }
      function applyPanelColors() {
         document.documentElement.style.setProperty('--customer-panel-bg', bgInput.value || '#f8f4ed');
         document.documentElement.style.setProperty('--customer-panel-accent', accentInput.value || '#e78002');
         document.documentElement.style.setProperty('--customer-panel-accent-contrast', getAccentContrastColor(accentInput.value));
      }
      bgInput.addEventListener('input', applyPanelColors);
      accentInput.addEventListener('input', applyPanelColors);
      bgInput.addEventListener('change', applyPanelColors);
      accentInput.addEventListener('change', applyPanelColors);
      applyPanelColors();
      if (!dots.length) {
         return;
      }
      for (var i = 0; i < dots.length; i++) {
         dots[i].addEventListener('click', function () {
            var target = this.getAttribute('data-target');
            var value = this.getAttribute('data-value');
            if (target === 'bg' && value) {
               bgInput.value = value;
            }
            if (target === 'accent' && value) {
               accentInput.value = value;
            }
            applyPanelColors();
         });
      }
   })();

   (function () {
      var timelineCard = document.querySelector('.timeline-card');
      var personalCard = document.querySelector('.personal-card');
      var leftStack = document.querySelector('.profile-left-stack');
      var rightStack = document.querySelector('.profile-right-stack');

      if (!timelineCard || !leftStack || !rightStack) {
         return;
      }

      function syncRowAlignment() {
         var isMobile = window.matchMedia('(max-width: 767px)').matches;
         if (isMobile || !personalCard || timelineCard.parentNode !== rightStack) {
            timelineCard.style.minHeight = '';
            return;
         }

         timelineCard.style.minHeight = Math.ceil(personalCard.getBoundingClientRect().height) + 'px';
      }

      function placeTimelineForViewport() {
         var isMobile = window.matchMedia('(max-width: 767px)').matches;
         if (isMobile) {
            if (!timelineCard.classList.contains('is-mobile-top')) {
               leftStack.insertBefore(timelineCard, leftStack.firstChild);
               timelineCard.classList.add('is-mobile-top');
            }
            return;
         }

         if (timelineCard.classList.contains('is-mobile-top')) {
            rightStack.appendChild(timelineCard);
            timelineCard.classList.remove('is-mobile-top');
         }

         syncRowAlignment();
      }

      placeTimelineForViewport();
      window.addEventListener('resize', placeTimelineForViewport);
      window.addEventListener('resize', syncRowAlignment);
      setTimeout(syncRowAlignment, 0);
   })();
</script>
@endsection
