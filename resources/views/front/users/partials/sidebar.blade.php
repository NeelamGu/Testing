@php
   $messagesCountCustomer = messagesCountCustomer();
   $activeTab = $activeTab ?? '';
   $panelBgColor = Auth::check() && !empty(Auth::user()->panel_bg_color) ? Auth::user()->panel_bg_color : '#f8f4ed';
   $panelAccentColor = Auth::check() && !empty(Auth::user()->panel_accent_color) ? Auth::user()->panel_accent_color : '#e78002';
   $assignmentTabActive =
      $activeTab === 'assignments' ||
      request()->is('user/enquiries/*/overview') ||
      (request()->is('user/enquiries*') && request()->query('message_type') === 'assignment');
   $messagesTabActive =
      $activeTab === 'enquiries' ||
      (request()->is('user/enquiries*') && !$assignmentTabActive);
@endphp

<style>
   :root {
      --customer-panel-bg: {{ $panelBgColor }};
      --customer-panel-accent: {{ $panelAccentColor }};
   }
   html,
   body {
      height: 100%;
   }
   body {
      overflow: hidden;
   }
   .page-wrapper {
      min-height: 100vh;
      height: 100vh;
      overflow: hidden;
   }
   .main-header,
   .header-top,
   .header-lower,
   #main-header,
   .main-footer,
   #translator,
   .footer-area,
   .enquery-form {
      display: none !important;
   }
   .scroll-to-top {
      display: none !important;
   }
   .contact-section.account-page .auto-container {
      width: calc(100% - 36px);
      max-width: 1480px;
   }
   .contact-section.account-page {
      height: calc(100dvh - 74px);
      min-height: calc(100dvh - 74px);
      overflow: hidden;
      padding-top: 10px;
      padding-bottom: 10px;
   }
   .contact-section.account-page .account-tab-area,
   .contact-section.account-page .customer-panel-sidebar {
      display: none !important;
   }
   .contact-section.account-page .column.pull-left {
      width: 100% !important;
      left: 0 !important;
      height: 100%;
      overflow-y: auto;
      padding-right: 4px;
      padding-bottom: 6px;
   }
   .contact-section.account-page .auto-container,
   .contact-section.account-page .row.clearfix {
      height: 100%;
   }
   .customer-mobile-nav {
      display: none;
   }
   body,
   .page-wrapper,
   .contact-section.account-page {
      background: linear-gradient(155deg, rgba(255, 255, 255, 0.55), rgba(255, 255, 255, 0.08)), var(--customer-panel-bg) !important;
   }
   .customer-panel-shell,
   .messages-shell,
   .conversation-shell {
      background: linear-gradient(160deg, rgba(255, 255, 255, 0.46), rgba(255, 255, 255, 0.12)), var(--customer-panel-bg) !important;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.68), 0 12px 30px rgba(64, 46, 22, 0.08);
   }
   .contact-section.account-page a,
   .contact-section.account-page .theme-link {
      color: var(--customer-panel-accent);
   }
   .save-btn,
   .favorite-link,
   .message-action-btn.open,
   .reply-back-btn,
   .send-reply .r-btn,
   .contact-section.account-page button[type="submit"],
   .contact-section.account-page .theme-btn,
   .contact-section.account-page .view-icon {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.32), rgba(255, 255, 255, 0.04)), var(--customer-panel-accent) !important;
      border-color: var(--customer-panel-accent) !important;
      color: #fff !important;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.45), 0 8px 18px rgba(39, 31, 20, 0.15);
   }
   .contact-section.account-page .profile-form-shell input:focus,
   .contact-section.account-page .profile-form-shell textarea:focus,
   .contact-section.account-page .profile-form-shell select:focus {
      border-color: var(--customer-panel-accent) !important;
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.08);
   }
   .contact-section.account-page .chip.reply,
   .contact-section.account-page .count-number {
      background-color: var(--customer-panel-accent) !important;
      border-color: var(--customer-panel-accent) !important;
      color: #fff !important;
   }
   .conversation-title a,
   .messages-panel-title,
   .customer-panel-header h3 {
      color: #2f2516;
   }
   .customer-panel-sidebar .account-sidebar li a.is-active,
   .customer-panel-sidebar .account-sidebar li a:hover {
      border-left: 3px solid var(--customer-panel-accent);
   }
   @media (max-width: 991px) {
      .customer-panel-shell,
      .messages-shell,
      .conversation-shell {
         border-radius: 16px;
         padding: 12px;
      }
      .customer-panel-main,
      .messages-panel,
      .conversation-card {
         border-radius: 14px;
      }
      .contact-section.account-page input,
      .contact-section.account-page select,
      .contact-section.account-page textarea,
      .contact-section.account-page button,
      .contact-section.account-page a {
         min-height: 42px;
      }
   }
   @media (max-width: 767px) {
      html,
      body {
         height: auto;
         min-height: 100%;
      }

      body {
         overflow: auto;
      }

      .page-wrapper {
         height: auto;
         min-height: 100dvh;
         overflow: visible;
      }

      .contact-section.account-page {
         height: auto;
         min-height: calc(100dvh - 66px);
         overflow: visible;
         padding-top: 8px;
         padding-bottom: calc(16px + env(safe-area-inset-bottom));
         -webkit-tap-highlight-color: rgba(0, 0, 0, 0.06);
      }

      .contact-section.account-page .auto-container {
         width: 100%;
         max-width: 100%;
         padding-left: 10px;
         padding-right: 10px;
      }

      .contact-section.account-page .row.clearfix {
         margin-left: 0;
         margin-right: 0;
      }

      .contact-section.account-page .row.clearfix > [class*="col-"] {
         padding-left: 0;
         padding-right: 0;
      }

      .contact-section.account-page .row.clearfix,
      .contact-section.account-page .column.pull-left {
         height: auto;
      }

      .contact-section.account-page .column.pull-left {
         overflow: visible;
         padding-right: 0;
         padding-bottom: calc(16px + env(safe-area-inset-bottom));
      }

      .contact-section.account-page .account-tab-area {
         display: none !important;
      }

      .customer-panel-sidebar {
         display: none;
      }
      .customer-panel-shell,
      .messages-shell,
      .conversation-shell {
         padding: 10px;
         border-radius: 14px;
         margin-top: 8px;
      }
      .customer-panel-header,
      .messages-panel-head,
      .conversation-head {
         padding: 12px 12px;
      }
      .customer-panel-body,
      .messages-panel-body,
      .chat-area-sec.enquiries-reply-area {
         padding: 10px;
      }
   }
</style>

<div class="info-box p-xs-15 customer-panel-sidebar">
   <ul class="account-sidebar">
      <li>
         <a href="{{ url('user/account') }}" class="js-customer-tab-link {{ $activeTab === 'account' ? 'is-active' : '' }}">
            <span class="fa fa-user"></span>
            <p class="{{ $activeTab === 'account' ? 'active-list' : '' }}">Profil</p>
         </a>
      </li>
      <li>
         <a href="{{ url('user/enquiries') }}" class="js-customer-tab-link {{ $messagesTabActive ? 'is-active' : '' }}">
            <span class="fa fa-comment"></span>
            <p class="{{ $messagesTabActive ? 'active-list' : '' }}">
               @if(isset($messagesCountCustomer) && $messagesCountCustomer > 0)
                  <span class="count-number">{{ $messagesCountCustomer }}</span>
               @endif
               Meldinger
            </p>
         </a>
      </li>
      <li>
         <a href="{{ url('user/wishlist') }}" class="js-customer-tab-link {{ $activeTab === 'wishlist' ? 'is-active' : '' }}">
            <span class="fa fa-heart"></span>
            <p class="{{ $activeTab === 'wishlist' ? 'active-list' : '' }}">Favoritter</p>
         </a>
      </li>
      <li>
         <a href="{{ url('user/enquiries?message_type=assignment') }}" class="js-customer-tab-link {{ $assignmentTabActive ? 'is-active' : '' }}">
            <span class="fa fa-plus"></span>
            <p class="{{ $assignmentTabActive ? 'active-list' : '' }}">Oppdrag</p>
         </a>
      </li>
   </ul>
</div>
