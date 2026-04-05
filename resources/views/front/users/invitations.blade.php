@extends('front.layout.layout')
@section('content')
<style>
   .customer-panel-shell {
      border: none;
      border-radius: 14px;
      padding: 16px;
      margin-top: 12px;
   }
   .customer-panel-main {
      background: #fff;
      border: 1px solid #efe1ce;
      border-radius: 12px;
      box-shadow: 0 12px 28px rgba(67, 47, 20, 0.08);
      overflow: hidden;
   }
   .customer-panel-header {
      padding: 16px 18px;
      border-bottom: 1px solid #f0e4d3;
      background: linear-gradient(120deg, #fff6e8, #fff);
   }
   .customer-panel-header h3 {
      margin: 0;
      font-size: 20px;
      color: #2f2516;
      font-weight: 700;
   }
   .customer-panel-header p {
      margin: 6px 0 0;
      color: #746652;
      font-size: 13px;
   }
   .customer-panel-body {
      padding: 16px;
   }
   .invite-layout {
      display: grid;
      grid-template-columns: 1.3fr 1fr;
      gap: 14px;
   }
   .invite-card {
      border: 1px solid #eedfca;
      border-radius: 10px;
      padding: 14px;
      background: #fff;
   }
   .invite-card h4 {
      margin: 0 0 12px;
      color: #2f2516;
      font-weight: 700;
   }
   .invite-card .field-label {
      font-size: 12px;
      text-transform: uppercase;
      color: #7b6852;
      margin-bottom: 6px;
      letter-spacing: 0.4px;
   }
   .invite-card input,
   .invite-card textarea {
      border: 1px solid #dbc4a3;
      border-radius: 8px;
      padding: 8px 10px;
      width: 100%;
   }
   .invite-card textarea {
      min-height: 100px;
      resize: vertical;
   }
   .invite-list-item {
      border-bottom: 1px solid #f1e5d4;
      padding: 10px 0;
   }
   .invite-list-item:last-child {
      border-bottom: 0;
      padding-bottom: 0;
   }
   .invite-meta {
      color: #756650;
      font-size: 12px;
      margin-top: 4px;
   }
   .invite-status {
      display: inline-flex;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 9px;
      background: #f5f5f5;
      border: 1px solid #d3d3d3;
      color: #666;
      margin-top: 6px;
   }
   .invite-status.sent {
      background: #eaf8ef;
      border-color: #9ad6ad;
      color: #1f6f39;
   }
   .delete-link {
      color: #9b1e1e !important;
      font-size: 12px;
      text-decoration: underline;
   }
   .invite-submit-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 42px;
      padding: 9px 16px;
      border-radius: 999px;
      border: 1px solid var(--customer-panel-accent);
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.32), rgba(255, 255, 255, 0.05)), var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      font-size: 13px;
      font-weight: 700;
      text-decoration: none !important;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.45), 0 8px 18px rgba(39, 31, 20, 0.16);
      transition: transform 0.16s ease, filter 0.16s ease, box-shadow 0.16s ease;
   }
   .invite-submit-btn:hover,
   .invite-submit-btn:focus {
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      text-decoration: none !important;
      transform: translateY(-1px);
      filter: brightness(0.96);
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.45), 0 12px 22px rgba(39, 31, 20, 0.2);
      outline: none;
   }
   @media (max-width: 991px) {
      .invite-layout {
         grid-template-columns: 1fr;
      }
   }
</style>

<div class="page-wrapper">
   @include('front.users.partials.topbar', ['activeTopTab' => 'assignments'])
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'invitations'])
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="customer-panel-shell">
                  <div class="customer-panel-main">
                     <div class="customer-panel-header">
                        <h3>Invitasjoner</h3>
                     </div>
                     <div class="customer-panel-body">
                        @if(Session::has('success_message'))
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                              {{ Session::get('success_message') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                        @endif

                        @if(Session::has('error_message'))
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {{ Session::get('error_message') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                        @endif

                        @if($errors->any())
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {!! implode('', $errors->all('<div>:message</div>')) !!}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                        @endif

                        <div class="invite-layout">
                           <div class="invite-card">
                              <h4>Ny invitasjon</h4>
                              <form method="post" action="{{ url('user/invitations') }}">@csrf
                                 <div class="row clearfix">
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                       <div class="field-label">Gjest navn</div>
                                       <input type="text" name="guest_name" value="{{ old('guest_name') }}" required>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                       <div class="field-label">Gjest e-post</div>
                                       <input type="email" name="guest_email" value="{{ old('guest_email') }}" placeholder="valgfritt men anbefalt">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                       <div class="field-label">Gjest telefon</div>
                                       <input type="text" name="guest_phone" value="{{ old('guest_phone') }}" placeholder="valgfritt">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                       <div class="field-label">Arrangement</div>
                                       <input type="text" name="event_title" value="{{ old('event_title') }}" required>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                       <div class="field-label">Dato og tid</div>
                                       <input type="datetime-local" name="event_date" value="{{ old('event_date') }}">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                       <div class="field-label">Sted</div>
                                       <input type="text" name="event_location" value="{{ old('event_location') }}">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                       <div class="field-label">Invitasjonstekst</div>
                                       <textarea name="message" required>{{ old('message') }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                       <button class="invite-submit-btn" type="submit">Send invitasjon</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                           <div class="invite-card">
                              <h4>Sendte invitasjoner</h4>
                              @forelse($invitations as $invitation)
                                 <div class="invite-list-item">
                                    <strong>{{ $invitation->guest_name }}</strong>
                                    <div class="invite-meta">{{ $invitation->event_title }}</div>
                                    @if(!empty($invitation->event_date))
                                       <div class="invite-meta">{{ date('d.m.Y H:i', strtotime($invitation->event_date)) }}</div>
                                    @endif
                                    @if(!empty($invitation->guest_email))
                                       <div class="invite-meta">{{ $invitation->guest_email }}</div>
                                    @endif
                                    <span class="invite-status {{ $invitation->status === 'sent' ? 'sent' : '' }}">
                                       {{ $invitation->status === 'sent' ? 'Sendt' : 'Lagret' }}
                                    </span>
                                    <div>
                                       <a class="delete-link" onclick="return confirm('Er du sikker?')" href="{{ url('user/invitations/delete/'.$invitation->id) }}">Slett</a>
                                    </div>
                                 </div>
                              @empty
                                 <p>Ingen invitasjoner enda.</p>
                              @endforelse
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
