@extends('front.layout.layout')
@section('content')
<style>
   .assignment-shell {
      background: transparent;
      border: none;
      padding: 0;
      margin-top: 4px;
   }
   .assignment-panel {
      background: #fff;
      border-radius: 12px;
      border: none;
      box-shadow: 0 10px 26px rgba(67, 47, 20, 0.08);
      overflow: hidden;
   }
   .assignment-panel-head {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 16px 18px;
      background: linear-gradient(120deg, #fff6e8, #fff);
   }
   .assignment-back-btn {
      flex-shrink: 0;
      width: 42px;
      height: 42px;
      border-radius: 12px;
      border: 1px solid #e6d8c1;
      background: #fff;
      color: #7a6347;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none !important;
      font-size: 17px;
      transition: background-color 0.14s ease, transform 0.14s ease;
   }
   .assignment-back-btn:hover {
      background: #f4ead9;
      color: #7a6347;
      transform: translateX(-1px);
   }
   .assignment-head-titles {
      min-width: 0;
   }
   .assignment-kicker {
      margin: 0 0 2px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: #b37a2f;
   }
   .assignment-title {
      margin: 0;
      color: #2b2418;
      font-size: 20px;
      font-weight: 700;
      line-height: 1.2;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }
   .assignment-body {
      padding: 14px;
   }
   .assignment-layout {
      display: grid;
      grid-template-columns: 300px minmax(0, 1fr);
      gap: 14px;
      align-items: start;
   }

   /* Oppdragsinfo-kort */
   .assignment-sidebar {
      position: sticky;
      top: 12px;
      align-self: start;
      min-width: 0;
   }
   .assignment-info-card {
      background: #fff;
      border: none;
      border-radius: 16px;
      box-shadow: 0 6px 16px rgba(60, 45, 24, 0.13), 0 2px 5px rgba(60, 45, 24, 0.08);
      padding: 16px;
   }
   .assignment-info-title {
      margin: 0 0 8px;
      font-size: 16px;
      font-weight: 800;
      color: #2b2418;
   }
   .assignment-info-rows {
      display: grid;
   }
   .info-row {
      display: grid;
      gap: 2px;
      padding: 10px 0;
      border-top: 1px solid #f1e8db;
   }
   .info-row:first-child {
      border-top: none;
      padding-top: 2px;
   }
   .info-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: #9a8a72;
   }
   .info-value {
      font-size: 15px;
      color: #2b2418;
      line-height: 1.4;
      font-weight: 600;
      word-break: break-word;
   }
   .info-row-block .info-value {
      font-weight: 500;
      white-space: pre-wrap;
   }

   /* Samtaler (tråder) */
   .assignment-threads-wrap {
      min-width: 0;
   }
   .assignment-threads-title {
      margin: 2px 2px 10px;
      font-size: 12px;
      font-weight: 800;
      color: #6d5f4a;
      text-transform: uppercase;
      letter-spacing: 0.05em;
   }
   .assignment-threads {
      display: grid;
      gap: 13px;
      min-width: 0;
   }
   .thread-card {
      display: grid;
      grid-template-columns: 52px minmax(0, 1fr);
      gap: 13px;
      align-items: center;
      background: #fff;
      border: none;
      border-radius: 16px;
      box-shadow: 0 6px 16px rgba(60, 45, 24, 0.13), 0 2px 5px rgba(60, 45, 24, 0.08);
      padding: 14px;
      text-decoration: none !important;
      color: inherit;
      transition: transform 0.12s ease, box-shadow 0.12s ease;
   }
   .thread-card:hover {
      color: inherit;
   }
   .thread-card:active {
      transform: scale(0.99);
      box-shadow: 0 1px 3px rgba(60, 45, 24, 0.08);
   }
   .thread-card.is-completed {
      background: #f5faf6;
   }
   .thread-avatar {
      width: 52px;
      height: 52px;
      border-radius: 15px;
      object-fit: cover;
      border: 1px solid #e6dccc;
      box-shadow: 0 3px 8px rgba(46, 32, 15, 0.1);
      background: #fff;
   }
   .thread-main {
      min-width: 0;
      display: grid;
      gap: 3px;
   }
   .thread-top {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      gap: 8px;
   }
   .thread-name {
      margin: 0;
      font-size: 16px;
      font-weight: 700;
      color: #2b2418;
      line-height: 1.25;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }
   .thread-card.is-completed .thread-name {
      color: #33613f;
   }
   .thread-date {
      flex-shrink: 0;
      font-size: 11px;
      font-weight: 600;
      color: #a89a86;
   }
   .thread-preview {
      margin: 1px 0 0;
      font-size: 13px;
      line-height: 1.4;
      color: #857866;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2;
      overflow: hidden;
   }
   .thread-chips {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 7px;
      margin-top: 5px;
   }
   .thread-status {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      padding: 4px 9px;
   }
   .thread-status.open {
      background: #e9f2fb;
      color: #3b6ea8;
   }
   .thread-status.closed {
      background: #eef6f0;
      color: #2f7a49;
   }
   .thread-loc {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      color: #9a8a72;
   }
   .thread-loc i {
      color: #b98a3f;
   }
   .thread-unread {
      margin-left: auto;
      min-width: 22px;
      height: 22px;
      border-radius: 999px;
      background: var(--customer-panel-accent, #e78002);
      color: var(--customer-panel-accent-contrast, #ffffff);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
      box-shadow: 0 2px 6px rgba(231, 128, 2, 0.35);
   }
   .overview-empty {
      border: 1px dashed #e0cba6;
      border-radius: 16px;
      padding: 26px 18px;
      text-align: center;
      color: #8a7c68;
      background: #fffaf2;
   }

   @media (max-width: 767px) {
      .assignment-shell {
         padding: 0;
         margin-top: 6px;
      }
      .assignment-panel {
         border-radius: 0;
         box-shadow: none;
         background: #f1eadd;
      }
      .assignment-panel-head {
         padding: 12px;
         background: transparent;
      }
      .assignment-title {
         font-size: 19px;
      }
      .assignment-body {
         padding: 0 12px calc(env(safe-area-inset-bottom) + 12px);
      }
      .assignment-layout {
         grid-template-columns: 1fr;
         gap: 13px;
      }
      .assignment-sidebar {
         position: static;
      }
      .assignment-info-card {
         padding: 14px;
      }
      .thread-card {
         align-items: start;
      }
      .thread-preview {
         -webkit-line-clamp: 3;
      }
   }
</style>

<div class="page-wrapper">
   @include('front.users.partials.topbar', ['activeTopTab' => 'assignments'])
   @php
      $assignmentDetails = $baseEnquiry->enquiryDetail ?? null;
      $assignmentText = trim((string) data_get($assignmentDetails, 'description', ''));
      $assignmentPrice = data_get($assignmentDetails, 'desired_price');
      $addressText = trim((string) data_get($assignmentDetails, 'address', ''));
      $cityText = trim((string) data_get($assignmentDetails, 'city', ''));
      $pincodeText = trim((string) data_get($assignmentDetails, 'pincode', ''));
      $locationParts = array_filter([$addressText, $cityText]);
      $locationText = implode(', ', $locationParts);
      if($locationText !== '' && $pincodeText !== ''){
         $locationText .= ' ('.$pincodeText.')';
      }
      $threadCount = !empty($threads) ? count($threads) : 0;
      $backUrl = $backUrl ?? url('user/enquiries?message_type=assignment');
   @endphp
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'enquiries'])
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="assignment-shell">
                  <div class="assignment-panel">
                     <div class="assignment-panel-head">
                        <a class="assignment-back-btn" href="{{ $backUrl }}" aria-label="Tilbake">
                           <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                        <div class="assignment-head-titles">
                           <p class="assignment-kicker">Oppdrag</p>
                           <h3 class="assignment-title">{{ $assignmentTitle }}</h3>
                        </div>
                     </div>

                     <div class="assignment-body">
                        <div class="assignment-layout">
                           <aside class="assignment-sidebar">
                              <div class="assignment-info-card">
                                 <h4 class="assignment-info-title">Oppdragsinformasjon</h4>
                                 <div class="assignment-info-rows">
                                    @if(!empty(data_get($assignmentDetails, 'title')))
                                       <div class="info-row">
                                          <span class="info-label">Tittel</span>
                                          <span class="info-value">{{ data_get($assignmentDetails, 'title') }}</span>
                                       </div>
                                    @endif

                                    @if(!empty(data_get($assignmentDetails, 'assignment_date')))
                                       <div class="info-row">
                                          <span class="info-label">Oppdragsdato</span>
                                          <span class="info-value">{{ data_get($assignmentDetails, 'assignment_date') }}</span>
                                       </div>
                                    @endif

                                    @if($locationText !== '')
                                       <div class="info-row">
                                          <span class="info-label">Sted</span>
                                          <span class="info-value">{{ $locationText }}</span>
                                       </div>
                                    @endif

                                    @if(!empty($assignmentPrice) && (float)$assignmentPrice > 0)
                                       <div class="info-row">
                                          <span class="info-label">Ønsket pris</span>
                                          <span class="info-value">{{ $assignmentPrice }}</span>
                                       </div>
                                    @endif

                                    <div class="info-row info-row-block">
                                       <span class="info-label">Beskrivelse</span>
                                       <p class="info-value">{{ !empty($assignmentText) ? $assignmentText : 'Ingen beskrivelse registrert på dette oppdraget.' }}</p>
                                    </div>
                                 </div>
                              </div>
                           </aside>

                           <div class="assignment-threads-wrap">
                              <p class="assignment-threads-title">{{ $threadCount > 0 ? 'Samtaler med leverandører ('.$threadCount.')' : 'Samtaler med leverandører' }}</p>
                              <div class="assignment-threads">
                                 @if($threadCount > 0)
                                    @foreach($threads as $thread)
                                       @php $threadCompleted = ($thread['status'] ?? 0) == 0; @endphp
                                       <a class="thread-card thread-open-link {{ $threadCompleted ? 'is-completed' : '' }}" href="{{ $thread['message_url'] ?? '#' }}">
                                          <img src="{{ $thread['vendor_image_url'] ?? asset('front/images/no-image.png') }}" alt="{{ $thread['title'] ?? '' }}" class="thread-avatar" onerror="this.onerror=null;this.src='{{ asset('front/images/no-image.png') }}';">
                                          <div class="thread-main">
                                             <div class="thread-top">
                                                <h4 class="thread-name">{{ $thread['title'] ?? 'Ukjent leverandør' }}</h4>
                                                <span class="thread-date">{{ $thread['last_date'] ?? '' }}</span>
                                             </div>
                                             <p class="thread-preview">{{ $thread['preview'] ?? '' }}</p>
                                             <div class="thread-chips">
                                                <span class="thread-status {{ $threadCompleted ? 'closed' : 'open' }}">{{ $threadCompleted ? 'Fullført' : 'Aktiv' }}</span>
                                                @if(!empty($thread['city']))
                                                   <span class="thread-loc"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ ucfirst(strtolower($thread['city'])) }}</span>
                                                @endif
                                                @if(!empty($thread['unread_count']) && (int)$thread['unread_count'] > 0)
                                                   <span class="thread-unread">{{ (int)$thread['unread_count'] }}</span>
                                                @endif
                                             </div>
                                          </div>
                                       </a>
                                    @endforeach
                                 @else
                                    <div class="overview-empty">Ingen meldinger fra leverandører på dette oppdraget ennå.</div>
                                 @endif
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
</div>
@endsection

@section('javascript')
<script>
   (function () {
      var mobileLinks = document.querySelectorAll('.thread-open-link');
      if (!mobileLinks.length) {
         return;
      }

      function updateMobileThreadLinks() {
         var isMobile = window.matchMedia('(max-width: 767px)').matches;
         for (var i = 0; i < mobileLinks.length; i++) {
            var link = mobileLinks[i];
            var originalHref = link.getAttribute('data-original-href');
            if (!originalHref) {
               originalHref = link.getAttribute('href') || '#';
               link.setAttribute('data-original-href', originalHref);
            }

            if (isMobile) {
               try {
                  var mobileUrl = new URL(originalHref, window.location.origin);
                  mobileUrl.searchParams.set('ui', 'mobile');
                  link.setAttribute('href', mobileUrl.toString());
               } catch (error) {
                  link.setAttribute('href', originalHref);
               }
            } else {
               link.setAttribute('href', originalHref);
            }
         }
      }

      updateMobileThreadLinks();
      window.addEventListener('resize', updateMobileThreadLinks);
      window.addEventListener('orientationchange', updateMobileThreadLinks);
   })();
</script>
@endsection
