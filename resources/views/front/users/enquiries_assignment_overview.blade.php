@extends('front.layout.layout')
@section('content')
<style>
   .assignment-shell {
      background: #f8f4ed;
      border: none;
      border-radius: 14px;
      padding: 14px;
      margin-top: 12px;
   }
   .assignment-card {
      background: #fff;
      border-radius: 12px;
      border: 1px solid #efe1ce;
      box-shadow: 0 12px 28px rgba(67, 47, 20, 0.08);
      overflow: hidden;
      display: flex;
      flex-direction: column;
   }
   .assignment-head {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 12px;
      border-bottom: 1px solid #f0e4d3;
      background: linear-gradient(120deg, #fff6e8, #fff);
      padding: 16px 18px;
   }
   .assignment-kicker {
      margin: 0 0 4px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: #b37a2f;
   }
   .assignment-title {
      margin: 0;
      color: #2f2516;
      font-size: 22px;
      font-weight: 700;
      line-height: 1.2;
   }
   .assignment-subtitle {
      margin: 6px 0 0;
      color: #746652;
      font-size: 13px;
   }
   .assignment-back-link {
      border: 1px solid var(--customer-panel-accent);
      border-radius: 10px;
      padding: 8px 12px;
      font-weight: 700;
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      text-decoration: none !important;
      background: var(--customer-panel-accent);
      white-space: nowrap;
   }
   .assignment-back-link:hover {
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      opacity: 0.94;
   }
   .assignment-body {
      padding: 12px;
   }
   .assignment-layout {
      display: grid;
      grid-template-columns: 280px minmax(0, 1fr);
      gap: 10px;
      align-items: start;
   }
   .assignment-sidebar {
      position: sticky;
      top: 0;
      align-self: start;
   }
   .assignment-threads {
      display: grid;
      gap: 10px;
      min-width: 0;
   }
   .assignment-info {
      border: 1px solid #d9c3a2;
      border-radius: 14px;
      background: #f7f1e8;
      padding: 12px;
   }
   .assignment-info-title {
      margin: 0 0 6px;
      font-size: 20px;
      font-weight: 700;
      color: #2f2416;
   }
   .assignment-info-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 6px;
   }
   .assignment-info-item {
      border: 1px solid #d9c3a1;
      border-radius: 10px;
      background: #fffdf9;
      padding: 10px 12px;
   }
   .assignment-info-label {
      margin: 0 0 6px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #745431;
   }
   .assignment-info-value {
      margin: 0;
      color: #2b2115;
      font-size: 18px;
      line-height: 1.45;
      font-weight: 600;
      word-break: break-word;
   }
   .assignment-description {
      margin-top: 6px;
      border: 1px solid #d9c3a1;
      border-radius: 10px;
      background: #fffdf9;
      padding: 10px 12px;
   }
   .assignment-description .assignment-info-value {
      white-space: pre-wrap;
      font-size: 16px;
      line-height: 1.5;
      font-weight: 500;
   }
   .thread-item {
      border: 1px solid #ece3d7;
      border-radius: 12px;
      background: #f7f3ec;
      padding: 12px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
   }
   .thread-item.is-completed {
      background: #edf7ef;
      border-color: #bcdcc3;
   }
   .thread-main {
      min-width: 0;
      flex: 1;
   }
   .thread-head {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 5px;
   }
   .thread-title {
      margin: 0;
      font-size: 24px;
      font-weight: 700;
      color: #2f2516;
      line-height: 1.2;
   }
   .thread-status {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      padding: 4px 8px;
      border: 1px solid transparent;
   }
   .thread-status.open {
      background: #edf4ff;
      border-color: #d5e4f6;
      color: #5e7397;
   }
   .thread-status.closed {
      background: #f3efea;
      border-color: #e4d8c8;
      color: #877766;
   }
   .thread-unread {
      min-width: 20px;
      height: 20px;
      border-radius: 999px;
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
   }
   .thread-preview {
      margin: 0;
      font-size: 15px;
      color: #615443;
      line-height: 1.35;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 760px;
   }
   .thread-meta {
      margin-top: 7px;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
      font-size: 12px;
      color: #978675;
   }
   .thread-open-link {
      min-height: 40px;
      border-radius: 10px;
      padding: 9px 16px;
      border: 1px solid var(--customer-panel-accent);
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      text-decoration: none !important;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      white-space: nowrap;
   }
   .thread-open-link:hover {
      opacity: 0.95;
      transform: translateY(-1px);
   }
   .overview-empty {
      border: 1px dashed #dcc5a4;
      border-radius: 10px;
      padding: 22px;
      text-align: center;
      color: #746652;
      background: #fffaf3;
   }
   @media (max-width: 767px) {
      .assignment-shell {
         padding: 10px;
         margin-top: 6px;
      }

      .assignment-head {
         flex-direction: column;
         align-items: flex-start;
         padding: 12px;
      }

      .assignment-title {
         font-size: 20px;
      }

      .assignment-back-link {
         width: 100%;
         justify-content: center;
         display: inline-flex;
      }

      .assignment-layout {
         grid-template-columns: 1fr;
         gap: 10px;
      }

      .assignment-sidebar {
         position: static;
      }

      .assignment-info {
         padding: 9px;
      }

      .assignment-info-title {
         font-size: 18px;
      }

      .assignment-info-item {
         padding: 9px 10px;
      }

      .assignment-info-label {
         font-size: 10px;
         margin-bottom: 5px;
      }

      .assignment-info-value {
         font-size: 16px;
      }

      .assignment-description .assignment-info-value {
         font-size: 15px;
      }

      .thread-item {
         flex-direction: column;
         align-items: flex-start;
         gap: 8px;
         padding: 10px;
      }

      .thread-title {
         font-size: 18px;
      }

      .thread-preview {
         white-space: normal;
         font-size: 13px;
      }

      .thread-open-link {
         width: 100%;
         min-height: 38px;
         padding: 8px 12px;
      }
   }
</style>

<div class="page-wrapper">
   @include('front.users.partials.topbar', ['activeTopTab' => 'assignments'])
   @php
      $assignmentDetails = $baseEnquiry->enquiryDetail ?? null;
      $assignmentText = trim((string) data_get($assignmentDetails, 'description', ''));
      $assignmentPrice = data_get($assignmentDetails, 'desired_price');
   @endphp
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'enquiries'])
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="assignment-shell">
                  <div class="assignment-card">
                     <div class="assignment-head">
                        <div>
                           <h3 class="assignment-title">{{ $assignmentTitle }}</h3>
                        </div>
                        <a class="assignment-back-link" href="{{ url('user/enquiries?message_type=assignment') }}"><i class="fa fa-arrow-left" style="margin-right:6px;"></i>Tilbake til oversikt</a>
                     </div>
                     <div class="assignment-body">
                        <div class="assignment-layout">
                           <aside class="assignment-sidebar">
                              <div class="assignment-info">
                                 <h4 class="assignment-info-title">Oppdragsinformasjon</h4>
                                 <div class="assignment-info-grid">
                                    @if(!empty(data_get($assignmentDetails, 'title')))
                                       <div class="assignment-info-item">
                                          <p class="assignment-info-label">Tittel</p>
                                          <p class="assignment-info-value">{{ data_get($assignmentDetails, 'title') }}</p>
                                       </div>
                                    @endif
                                    @if(!empty(data_get($assignmentDetails, 'assignment_date')))
                                       <div class="assignment-info-item">
                                          <p class="assignment-info-label">Oppdragsdato</p>
                                          <p class="assignment-info-value">{{ data_get($assignmentDetails, 'assignment_date') }}</p>
                                       </div>
                                    @endif
                                    @if(!empty(data_get($assignmentDetails, 'address')) || !empty(data_get($assignmentDetails, 'city')))
                                       <div class="assignment-info-item">
                                          <p class="assignment-info-label">Sted</p>
                                          <p class="assignment-info-value">
                                             {{ data_get($assignmentDetails, 'address', '') }}
                                             @if(!empty(data_get($assignmentDetails, 'address')) && !empty(data_get($assignmentDetails, 'city'))), @endif
                                             {{ data_get($assignmentDetails, 'city', '') }}
                                             @if(!empty(data_get($assignmentDetails, 'pincode')))
                                                ({{ data_get($assignmentDetails, 'pincode') }})
                                             @endif
                                          </p>
                                       </div>
                                    @endif
                                    @if(!empty($assignmentPrice) && (float)$assignmentPrice > 0)
                                       <div class="assignment-info-item">
                                          <p class="assignment-info-label">Ønsket pris</p>
                                          <p class="assignment-info-value">{{ $assignmentPrice }}</p>
                                       </div>
                                    @endif
                                 </div>
                                 <div class="assignment-description">
                                    <p class="assignment-info-label">Det du skrev i oppdraget</p>
                                    <p class="assignment-info-value">{{ !empty($assignmentText) ? $assignmentText : 'Ingen beskrivelse registrert på dette oppdraget.' }}</p>
                                 </div>
                              </div>
                           </aside>

                           <div class="assignment-threads">
                              @if(!empty($threads) && count($threads) > 0)
                                 @foreach($threads as $thread)
                                    <div class="thread-item {{ ($thread['status'] ?? 0) == 0 ? 'is-completed' : '' }}">
                                       <div class="thread-main">
                                          <div class="thread-head">
                                             <h4 class="thread-title">{{ $thread['title'] ?? 'Ukjent leverandør' }}</h4>
                                             <span class="thread-status {{ ($thread['status'] ?? 0) == 1 ? 'open' : 'closed' }}">{{ ($thread['status'] ?? 0) == 1 ? 'Aktiv' : 'Lukket' }}</span>
                                             @if(!empty($thread['unread_count']) && (int)$thread['unread_count'] > 0)
                                                <span class="thread-unread">{{ (int)$thread['unread_count'] }}</span>
                                             @endif
                                          </div>
                                          <p class="thread-preview">{{ $thread['preview'] ?? '' }}</p>
                                          <div class="thread-meta">
                                             @if(!empty($thread['city']))
                                                <span><i class="fa fa-map-marker"></i> {{ ucfirst(strtolower($thread['city'])) }}</span>
                                             @endif
                                             <span><i class="fa fa-calendar"></i> {{ $thread['last_date'] ?? '-' }}</span>
                                          </div>
                                       </div>
                                       <a class="thread-open-link" href="{{ $thread['message_url'] ?? '#' }}">Se melding</a>
                                    </div>
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
@endsection
