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
      background: transparent;
      border: none;
      border-radius: 0;
      padding: 2px;
      box-shadow: none;
      min-height: calc(100dvh - 124px);
      height: auto;
      overflow: visible;
      display: flex;
      flex-direction: column;
      color: #241a12;
      --profile-accent: var(--customer-panel-accent, #e78002);
      --profile-accent-contrast: var(--customer-panel-accent-contrast, #ffffff);
      --profile-ink: #241a12;
      --profile-muted: #7c6a52;
      --profile-line: #ece2d2;
      --profile-card: #ffffff;
      --profile-small-text: clamp(13px, 0.18vw + 11px, 15px);
      --profile-micro-text: clamp(12px, 0.12vw + 10px, 14px);
   }

   /* ---------- Hero ---------- */
   .profile-heading {
      position: relative;
      overflow: hidden;
      border-radius: 22px;
      padding: 24px 150px 24px 26px;
      margin-bottom: 14px;
      flex-shrink: 0;
      color: var(--profile-accent-contrast);
      background:
         radial-gradient(circle at 86% -30%, rgba(255, 255, 255, 0.38), transparent 46%),
         radial-gradient(circle at 6% 140%, rgba(0, 0, 0, 0.22), transparent 48%),
         linear-gradient(135deg, rgba(255, 255, 255, 0.18), rgba(0, 0, 0, 0.05)),
         var(--profile-accent);
      box-shadow: 0 18px 34px rgba(64, 46, 22, 0.22);
   }
   .hero-avatar {
      position: absolute;
      right: 26px;
      top: 50%;
      transform: translateY(-50%);
      width: 96px;
      height: 96px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid rgba(255, 255, 255, 0.75);
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.24);
      background: #fff;
      z-index: 1;
   }
   .profile-heading .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      margin: 0 0 8px;
      padding: 4px 12px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.22);
      color: var(--profile-accent-contrast);
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 0.14em;
      text-transform: uppercase;
   }
   .profile-heading h2 {
      margin: 0;
      font-size: 44px;
      line-height: 1.02;
      color: var(--profile-accent-contrast);
      font-weight: 800;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
   }
   .profile-heading p {
      margin: 9px 0 0;
      color: var(--profile-accent-contrast);
      opacity: 0.94;
      font-size: 15px;
      max-width: 640px;
      line-height: 1.4;
      position: relative;
      z-index: 1;
   }

   .profile-grid {
      display: grid;
      grid-template-columns: minmax(0, 1.7fr) minmax(320px, 0.95fr);
      gap: 14px;
      margin-top: 4px;
      align-items: start;
      flex: 1;
      min-height: 0;
   }
   .profile-left-stack,
   .profile-right-stack {
      display: grid;
      gap: 14px;
      align-content: start;
      min-width: 0;
   }
   .profile-right-stack {
      display: flex;
      flex-direction: column;
      height: auto;
   }

   /* ---------- Cards ---------- */
   .card-soft {
      border: 1px solid var(--profile-line);
      border-radius: 18px;
      background: var(--profile-card);
      padding: 16px 18px;
      position: relative;
      overflow: hidden;
      color: var(--profile-ink);
      box-shadow: 0 10px 26px rgba(64, 46, 22, 0.08);
   }
   .personal-card {
      margin-bottom: 14px;
   }
   .card-icon-title {
      margin: 0 0 15px;
      padding-bottom: 13px;
      border-bottom: 2px solid #f2e9db;
      color: var(--profile-ink);
      font-size: 18px;
      font-weight: 800;
      display: flex;
      align-items: center;
      gap: 11px;
      letter-spacing: -0.2px;
   }
   .card-icon-title i {
      width: 36px;
      height: 36px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.32), rgba(255, 255, 255, 0)), var(--profile-accent);
      color: var(--profile-accent-contrast);
      font-size: 16px;
      box-shadow: 0 7px 15px rgba(64, 46, 22, 0.2);
   }

   /* ---------- Fields ---------- */
   .field-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
      gap: 12px 14px;
      align-items: start;
   }
   .field-wrap {
      min-width: 0;
      display: flex;
      flex-direction: column;
      gap: 5px;
      overflow: visible;
   }
   .field-wrap label {
      display: block;
      margin: 0;
      color: var(--profile-muted);
      font-size: var(--profile-micro-text);
      text-transform: uppercase;
      letter-spacing: 0.07em;
      font-weight: 800;
      line-height: 1.2;
   }
   .field-wrap input {
      width: 100%;
      height: 44px;
      border-radius: 11px;
      border: 1.5px solid #e5dac8;
      padding: 9px 12px;
      background: #fdfbf8;
      font-size: 14.5px;
      line-height: 1.35;
      color: #2a2016;
      box-sizing: border-box;
      display: block;
      transition: border-color 0.16s ease, box-shadow 0.16s ease, background 0.16s ease;
   }
   .field-wrap input::placeholder {
      color: #b3a894;
   }
   .field-wrap input[readonly],
   .field-wrap input.readonly-email {
      background: #f1ece3;
      color: #7a6a52;
      border-color: #e0d5c3;
      border-style: dashed;
      cursor: not-allowed;
   }
   .field-wrap input.readonly-email:focus {
      border-color: #e0d5c3;
      box-shadow: none;
   }
   .field-wrap input:focus {
      border-color: var(--profile-accent);
      outline: none;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.06);
   }
   .field-wrap p {
      margin: 0;
      min-height: 0;
      font-size: var(--profile-small-text);
      line-height: 1.3;
      color: #c23d28;
      font-weight: 600;
   }
   .field-wrap p:empty {
      display: none;
   }

   /* ---------- Visual preferences ---------- */
   .visual-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 12px;
      align-items: center;
      padding: 12px;
      border-radius: 14px;
      background: #faf6ef;
      border: 1px solid #f0e7d8;
      margin-bottom: 10px;
   }
   .visual-row:last-of-type {
      margin-bottom: 0;
   }
   .visual-row strong {
      font-size: 15.5px;
      color: var(--profile-ink);
      font-weight: 800;
   }
   .visual-row p {
      margin: 3px 0 0;
      color: var(--profile-muted);
      font-size: var(--profile-small-text);
      line-height: 1.3;
   }
   .color-row {
      display: flex;
      align-items: center;
      gap: 9px;
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
      border: 2px solid #fff;
      box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.12), 0 3px 6px rgba(0, 0, 0, 0.12);
      cursor: pointer;
      background: #fff;
      display: inline-block;
      transition: transform 0.14s ease, box-shadow 0.14s ease;
   }
   .preset-dot:hover {
      transform: translateY(-2px) scale(1.08);
      box-shadow: 0 0 0 2px var(--profile-accent), 0 6px 12px rgba(0, 0, 0, 0.18);
   }
   .custom-color-dot {
      width: 34px;
      height: 34px;
      position: relative;
      overflow: hidden;
      border: 2px solid #ffffff;
      box-shadow: 0 0 0 1px #c8b79f, 0 3px 6px rgba(0, 0, 0, 0.12);
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

   /* ---------- Recent updates / timeline ---------- */
   .timeline-title {
      margin: 0 0 4px;
      font-size: 19px;
      font-weight: 800;
      color: var(--profile-ink);
      display: inline-flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.2px;
   }
   .timeline-title i {
      width: 34px;
      height: 34px;
      border-radius: 11px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.32), rgba(255, 255, 255, 0)), var(--profile-accent);
      color: var(--profile-accent-contrast);
      font-size: 15px;
      box-shadow: 0 7px 15px rgba(64, 46, 22, 0.2);
   }
   .timeline-subtitle {
      margin: 8px 0 12px;
      color: var(--profile-muted);
      font-size: var(--profile-small-text);
      line-height: 1.35;
   }
   .timeline-list {
      display: grid;
      gap: 9px;
   }
   .timeline-item {
      position: relative;
      padding: 11px 12px;
      border: 1px solid #efe4d3;
      border-left: 4px solid var(--profile-accent);
      border-radius: 13px;
      background: #fdfaf5;
   }
   .timeline-item-top {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 4px;
   }
   .timeline-item-top strong {
      font-size: 14px;
      color: var(--profile-ink);
      font-weight: 800;
   }
   .timeline-icon {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid transparent;
      font-size: var(--profile-micro-text);
      flex-shrink: 0;
   }
   .timeline-icon.new {
      background: #fbe8cd;
      color: #8a520a;
      border-color: #eec288;
   }
   .timeline-icon.done {
      background: #e4f2e8;
      color: #3f7355;
      border-color: #c3ddca;
   }
   .timeline-icon.neutral {
      background: #eaeef2;
      color: #5b6b7c;
      border-color: #d2dae3;
   }
   .timeline-count {
      min-width: 22px;
      height: 22px;
      border-radius: 999px;
      background: var(--profile-accent);
      color: var(--profile-accent-contrast);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: var(--profile-micro-text);
      font-weight: 800;
      padding: 0 6px;
      margin-left: auto;
   }
   .timeline-link {
      display: inline-block;
      font-size: 14.5px;
      color: var(--profile-ink);
      font-weight: 700;
      text-decoration: none;
      line-height: 1.25;
   }
   .timeline-link:hover {
      color: var(--profile-accent);
      text-decoration: underline;
   }
   .timeline-time {
      margin: 3px 0 0;
      color: var(--profile-muted);
      font-size: var(--profile-small-text);
      line-height: 1.35;
   }

   /* ---------- Profile summary card ---------- */
   .profile-summary {
      text-align: center;
      padding: 22px 16px 20px !important;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
   }
   /* Override the global panel theme so this card matches the other white cards. */
   .contact-section.account-page .profile-main .profile-summary {
      background: var(--profile-card) !important;
      border: 1px solid var(--profile-line) !important;
      box-shadow: 0 10px 26px rgba(64, 46, 22, 0.08) !important;
   }
   .profile-avatar-wrap {
      width: 92px;
      height: 92px;
      margin: 0 auto 12px;
      position: relative;
   }
   .profile-summary img {
      width: 92px;
      height: 92px;
      border-radius: 50%;
      border: 4px solid #fff;
      box-shadow: 0 10px 22px rgba(30, 23, 13, 0.24);
      object-fit: cover;
      background: #fff;
   }
   .profile-edit-dot {
      position: absolute;
      right: -2px;
      bottom: 2px;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: var(--profile-accent);
      color: var(--profile-accent-contrast);
      border: 3px solid #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      cursor: pointer;
      padding: 0;
      line-height: 1;
      box-shadow: 0 4px 10px rgba(64, 46, 22, 0.28);
      transition: transform 0.14s ease;
   }
   .profile-edit-dot:hover {
      transform: scale(1.08);
   }
   .profile-edit-dot:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.14);
   }
   .profile-summary h4 {
      margin: 0;
      color: var(--profile-ink);
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.3px;
   }
   .profile-summary .member-since {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin: 8px 0 0;
      padding: 4px 12px;
      border-radius: 999px;
      background: #f4ede2;
      color: #6f6049;
      font-size: var(--profile-small-text);
      font-weight: 700;
   }
   .profile-summary .member-since i {
      color: var(--profile-accent);
   }

   /* ---------- Actions ---------- */
   .profile-side-actions {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 12px;
      justify-content: flex-end;
      margin-top: 0;
      width: 100%;
      z-index: 2;
      padding: 12px 14px;
      border-radius: 16px;
      background: #ffffff;
      border: 1px solid var(--profile-line);
      box-shadow: 0 10px 26px rgba(64, 46, 22, 0.08);
   }
   .profile-side-actions .save-btn {
      border: 0;
      border-radius: 14px;
      min-height: 50px;
      width: auto;
      min-width: 230px;
      padding: 0 22px;
      font-size: 17px;
      font-weight: 800;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
      background: var(--profile-accent) !important;
      box-shadow: 0 10px 20px rgba(70, 43, 12, 0.24);
   }
   .profile-side-actions .save-btn:hover {
      filter: brightness(0.97);
      transform: translateY(-1px);
   }
   .security-help {
      font-size: var(--profile-small-text);
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--profile-muted);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
   }
   .security-help:hover {
      color: var(--profile-accent);
   }
   #account-success {
      margin: 0 0 8px;
      font-size: var(--profile-small-text);
      color: #2f7a45;
      font-weight: 700;
   }
   #account-error {
      margin: 0 0 8px;
      font-size: var(--profile-small-text);
      color: #c23d28;
      font-weight: 700;
   }
   .alert {
      border-radius: 12px;
   }

   /* ---------- Responsive ---------- */
   @media (min-width: 1600px) {
      .profile-grid {
         grid-template-columns: minmax(0, 1.8fr) minmax(360px, 0.9fr);
         gap: 18px;
      }
   }
   @media (min-width: 992px) and (max-width: 1320px) {
      .profile-grid {
         grid-template-columns: minmax(0, 1.5fr) minmax(290px, 1fr);
      }
   }
   @media (max-width: 1199px) {
      .profile-heading h2 {
         font-size: 40px;
      }
      .profile-grid {
         grid-template-columns: minmax(0, 1fr) minmax(300px, 0.9fr);
      }
   }
   @media (max-width: 991px) {
      .contact-section.account-page .column.pull-left {
         overflow: visible;
      }
      .profile-shell,
      .profile-main,
      .profile-grid,
      .profile-left-stack,
      .profile-right-stack,
      .card-soft,
      .personal-card,
      .visual-card,
      .timeline-card,
      .profile-summary,
      .profile-side-actions {
         width: 100%;
         max-width: 100%;
         min-width: 0;
         box-sizing: border-box;
      }
      .profile-grid {
         grid-template-columns: 1fr;
      }
      .profile-main {
         height: auto;
         overflow-x: hidden;
         overflow-y: visible;
      }
      .field-grid {
         grid-template-columns: minmax(0, 1fr);
      }
      .visual-row {
         grid-template-columns: 1fr;
         align-items: start;
      }
      .color-row {
         flex-wrap: wrap;
         max-width: 100%;
         gap: 8px;
      }
      .profile-heading h2 {
         font-size: 34px;
      }
   }
   @media (max-width: 767px) {
      .profile-heading {
         padding: 20px;
      }
      .profile-heading p {
         font-size: 14px;
      }
      .hero-avatar {
         display: none;
      }
      .profile-side-actions .save-btn {
         width: 100%;
         min-width: 0;
      }
      .profile-side-actions {
         justify-content: center;
      }
      .profile-heading h2 {
         font-size: 30px;
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
                     @php
                        $profileImageRelativePath = 'front/images/user_images/profile-'.Auth::user()->id.'.jpg';
                        $profileImageAbsolutePath = public_path($profileImageRelativePath);
                        $profileImageUrl = file_exists($profileImageAbsolutePath)
                           ? asset($profileImageRelativePath).'?v='.filemtime($profileImageAbsolutePath)
                           : asset('front/images/profile.png');
                     @endphp
                     <div class="profile-heading">
                        <span class="hero-eyebrow"><i class="fa fa-user-circle" aria-hidden="true"></i> Min konto</span>
                        <h2>Min Profil</h2>
                        <p class="profile-note">{{ $profileNoteMessage ?? 'Velkommen tilbake! Klar for å planlegge noe hyggelig?' }}</p>
                        <img class="hero-avatar" src="{{ $profileImageUrl }}" alt="Profil" onerror="this.onerror=null;this.src='{{ asset('front/images/profile.png') }}';">
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
                                       <input type="text" value="{{ Auth::user()->email }}" readonly class="readonly-email" aria-readonly="true">
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
                                 <div class="visual-row">
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
                                       <div class="timeline-item-top">
                                          <span class="timeline-icon neutral"><i class="fa fa-info"></i></span>
                                          <strong>Ingen nye meldinger</strong>
                                       </div>
                                       <p class="timeline-time">Vi gir deg beskjed her så snart en leverandør svarer.</p>
                                    </div>
                                 @endforelse
                              </div>
                           </div>

                           <div class="card-soft profile-summary">
                              <div class="profile-avatar-wrap">
                                 <img id="profileAvatarImage" src="{{ $profileImageUrl }}" alt="Profil">
                                 <button type="button" class="profile-edit-dot" id="profileImageTrigger" aria-label="Endre profilbilde"><i class="fa fa-pencil"></i></button>
                                 <input type="file" id="profileImageInput" accept="image/jpeg,image/jpg,image/png,image/webp" style="display:none;">
                              </div>
                              <h4>{{ Auth::user()->name }}</h4>
                              <p class="member-since"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Medlem siden {{ date('Y', strtotime(Auth::user()->created_at ?? now())) }}</p>
                           </div>

                           <div class="profile-side-actions">
                              <button class="save-btn" type="submit" form="accountForm"><i class="fa fa-save"></i> Lagre endringer</button>
                              <a class="security-help" href="{{ url('user/update-password') }}"><i class="fa fa-key" aria-hidden="true"></i> Glemt passord?</a>
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
      var visualCard = document.querySelector('.visual-card');
      var summaryCard = document.querySelector('.profile-summary');
      var leftStack = document.querySelector('.profile-left-stack');
      var rightStack = document.querySelector('.profile-right-stack');

      if (!timelineCard || !leftStack || !rightStack) {
         return;
      }

      function syncRowAlignment() {
         var isMobile = window.matchMedia('(max-width: 767px)').matches;
         if (isMobile || !personalCard || timelineCard.parentNode !== rightStack) {
            timelineCard.style.minHeight = '';
            if (summaryCard) {
               summaryCard.style.minHeight = '';
            }
            return;
         }

         timelineCard.style.minHeight = Math.ceil(personalCard.getBoundingClientRect().height) + 'px';

         if (visualCard && summaryCard) {
            summaryCard.style.minHeight = '';
            var visualHeight = Math.ceil(visualCard.getBoundingClientRect().height);
            var summaryHeight = Math.ceil(summaryCard.getBoundingClientRect().height);
            summaryCard.style.minHeight = Math.max(visualHeight, summaryHeight) + 'px';
         }
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
