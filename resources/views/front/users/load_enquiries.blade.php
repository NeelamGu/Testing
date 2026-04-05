<?php
use App\Models\Enquiry;
use App\Models\EnquiriesResponse;
use App\Models\Category;
?>
<style>
   .message-hub {
      border: none;
      border-radius: 14px;
      background: #fff;
      overflow: hidden;
      height: 100%;
   }
   .message-filters {
      display: none;
   }
   .message-body-layout {
      display: grid;
      grid-template-columns: 270px minmax(0, 1fr);
      gap: 12px;
      padding: 12px;
      height: 100%;
      min-height: 0;
   }
   .message-filter-shell {
      position: static;
      align-self: start;
   }
   .status-filter-panel {
      width: 250px;
      max-width: 100%;
      border: 1px solid #ebddca;
      border-radius: 14px;
      background: #fbf7f1;
      padding: 12px;
   }
   .status-filter-title {
      margin: 0 0 8px;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: #9f927f;
      font-weight: 700;
   }
   .status-filter-list {
      display: grid;
      gap: 6px;
   }
   .status-filter-actions {
      margin-top: 10px;
   }
   .new-assignment-btn {
      width: 100%;
      min-height: 38px;
      border-radius: 11px;
      border: 1px solid var(--customer-panel-accent);
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      text-decoration: none !important;
      font-size: 13px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 8px 12px;
      transition: transform 0.14s ease, opacity 0.14s ease;
   }
   .new-assignment-btn:hover {
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      transform: translateY(-1px);
      opacity: 0.96;
   }
   .status-filter-btn {
      border: 1px solid transparent;
      border-radius: 12px;
      background: transparent;
      color: #5b4d3c;
      font-weight: 700;
      font-size: 14px;
      min-height: 36px;
      padding: 6px 10px;
      text-decoration: none !important;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
   }
   .status-filter-btn:hover {
      background: #f1e9de;
   }
   .contact-section.account-page .status-filter-btn.is-active {
      background: var(--customer-panel-accent) !important;
      border-color: var(--customer-panel-accent) !important;
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
   }
   .status-filter-btn .count {
      min-width: 22px;
      height: 22px;
      border-radius: 999px;
      background: #ece3d6;
      color: #6f604c;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 700;
   }
   .contact-section.account-page .status-filter-btn.is-active .count {
      background: rgba(255, 255, 255, 0.34);
      color: var(--customer-panel-accent-contrast, #ffffff);
   }
   .filter-hidden {
      display: none !important;
   }
   .message-list {
      padding: 0;
      display: grid;
      gap: 12px;
      min-height: 0;
      overflow-y: auto;
      padding-right: 6px;
      align-content: start;
   }
   .message-item {
      border: 1px solid #ece3d7;
      border-radius: 14px;
      background: #f7f3ec;
      padding: 14px;
      box-shadow: none;
      display: grid;
      grid-template-columns: 54px minmax(0, 1.7fr) minmax(0, 1fr) minmax(0, 1.2fr);
      gap: 12px;
      align-items: center;
   }
   .message-item > div {
      min-width: 0;
   }
   .message-item.is-completed {
      background: #e8f5ea;
      border-color: #9fceaa;
      box-shadow: inset 0 0 0 1px rgba(157, 204, 168, 0.35);
   }
   .message-item.is-completed .message-vendor-title a,
   .message-item.is-completed .message-preview,
   .message-item.is-completed .message-type-note {
      color: #2e5f3a !important;
   }
   .message-brand {
      width: 54px;
      height: 54px;
      border-radius: 11px;
      object-fit: cover;
      border: 1px solid #d8c8b0;
      background: #fff;
      box-shadow: 0 4px 10px rgba(46, 32, 15, 0.12);
   }
   .message-vendor-head {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 6px;
   }
   .message-vendor-title {
      margin: 0;
      font-size: 28px;
      line-height: 1.2;
   }
   .message-vendor-title a {
      color: #2f2516 !important;
      text-decoration: none;
      font-weight: 700;
   }
   .message-vendor-title a:hover {
      color: #2f2516 !important;
   }
   .message-status-chip {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      padding: 4px 8px;
      border: 1px solid transparent;
      margin-top: 2px;
   }
   .message-status-chip.open {
      background: #e7f7eb;
      border-color: #b6dfc1;
      color: #1f6a3f;
   }
   .message-status-chip.closed {
      background: #f3efea;
      border-color: #e4d8c8;
      color: #877766;
   }
   .message-preview {
      margin: 0;
      color: #615443;
      font-size: 17px;
      line-height: 1.35;
   }
   .assignment-summary {
      margin: 0;
      display: grid;
      gap: 3px;
      color: #615443;
      font-size: 14px;
      line-height: 1.3;
   }
   .assignment-summary strong {
      color: #2f2516;
      font-size: 15px;
   }
   .assignment-alerts {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin-top: 1px;
   }
   .assignment-alert {
      display: inline-flex;
      align-items: center;
      min-height: 22px;
      padding: 2px 8px;
      border-radius: 999px;
      border: 1px solid #d3dfef;
      background: #edf3fb;
      color: #204974;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.02em;
   }
   .assignment-alert.new-vendor {
      border-color: #c6decf;
      background: #e9f6ee;
      color: #1e5a34;
   }
   .assignment-alert.new-message {
      border-color: #d5d8f0;
      background: #f0f2fb;
      color: #2f4f98;
   }
   .message-flags {
      margin: 0;
      display: flex;
      align-items: center;
      gap: 6px;
      min-height: 22px;
   }
   .message-status-badge {
      display: inline-flex;
      align-items: center;
      min-height: 22px;
      padding: 2px 8px;
      border-radius: 999px;
      border: 1px solid var(--customer-panel-accent);
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.02em;
   }
   .message-vendor-meta {
      margin-top: 9px;
      color: #988877;
      font-size: 12px;
      display: flex;
      gap: 12px;
      align-items: center;
      flex-wrap: wrap;
   }
   .message-vendor-meta i {
      margin-right: 5px;
   }
   .message-type-cell {
      display: flex;
      align-items: center;
      gap: 7px;
      flex-wrap: wrap;
      justify-content: flex-start;
   }
   .type-chip {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 9px;
      border: 1px solid transparent;
      letter-spacing: 0.06em;
      text-transform: uppercase;
   }
   .type-chip.assignment {
      background: #ffe5be;
      color: #8f4200;
      border-color: #f3b974;
   }
   .type-chip.direct {
      background: #e8edff;
      color: #2f4f98;
      border-color: #becaf3;
   }
   .message-type-note {
      display: none;
   }
   .message-unread {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 6px;
      min-width: 20px;
      height: 20px;
      border-radius: 999px;
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
      font-size: 11px;
      font-weight: 700;
      border: 1px solid #fff;
   }
   .message-actions {
      display: flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
      justify-content: flex-end;
      margin-bottom: 6px;
   }
   .message-open-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 42px;
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 15px;
      font-weight: 700;
      text-decoration: none !important;
      color: #fff !important;
      transition: transform 0.16s ease, opacity 0.16s ease;
   }
   .message-open-link.assignment,
   .message-open-link.direct {
      background: var(--customer-panel-accent);
      border: 1px solid var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
   }
   .message-open-link.view {
      background: #ece6dc;
      border: 1px solid #dfd3c1;
      color: #6b5c4a !important;
      box-shadow: none;
   }
   .message-open-link:hover {
      transform: translateY(-1px);
      opacity: 0.95;
   }
   .status-marker {
      display: none;
   }
   .message-toggles {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      justify-content: flex-end;
   }
   .toggle-chip {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      min-width: 110px;
      padding: 7px 11px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      border: 1px solid transparent;
      transition: transform 0.16s ease, opacity 0.16s ease;
   }
   .toggle-chip.is-open {
      background: #edf7ef;
      color: #2f7a45;
      border-color: #b8ddbf;
   }
   .toggle-chip.is-closed {
      background: #f2efea;
      color: #766758;
      border-color: #dfd4c4;
   }
   .updateEnquiryStatus {
      text-decoration: none !important;
   }
   .enquiry-complete-btn,
   .delete-enquiry-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 34px;
      border-radius: 999px;
      padding: 7px 14px;
      font-size: 12px;
      font-weight: 700;
      text-decoration: none !important;
      border: 1px solid transparent;
      transition: transform 0.14s ease, opacity 0.14s ease;
   }
   .enquiry-complete-btn {
      background: #edf8ef;
      border-color: #a7d5b0;
      color: #2f7443 !important;
   }
   .delete-enquiry-btn {
      background: #fff1ef;
      border-color: #f1c2ba;
      color: #9e3a2b !important;
   }
   .enquiry-complete-btn:hover,
   .delete-enquiry-btn:hover {
      transform: translateY(-1px);
      opacity: 0.95;
   }
   .updateEnquiryStatus:hover .toggle-chip {
      transform: translateY(-1px);
      opacity: 0.95;
   }
   .message-empty {
      border: 1px dashed #dcc5a4;
      border-radius: 10px;
      padding: 26px;
      text-align: center;
      color: #746652;
      background: #fffaf3;
      font-size: 14px;
   }
   @media (max-width: 1199px) {
      .message-item {
         grid-template-columns: 54px 1fr;
      }

      .message-vendor-title {
         font-size: 22px;
      }

      .message-preview {
         font-size: 14px;
      }

      .message-type-cell,
      .message-actions,
      .message-toggles {
         justify-content: flex-start;
      }
   }
   @media (max-width: 767px) {
      .message-hub {
         border: 0;
         background: transparent;
         border-radius: 0;
         overflow: visible;
      }

      .message-body-layout {
         grid-template-columns: 1fr;
         padding: 0;
         gap: 12px;
         height: auto;
      }

      .status-filter-panel {
         width: 100%;
         padding: 12px;
         border-radius: 16px;
         border-color: #e3d5bf;
         background: #f3eee6;
         box-shadow: 0 6px 14px rgba(55, 40, 20, 0.05);
      }

      .status-filter-title {
         margin-bottom: 8px;
      }

      .status-filter-list {
         display: grid;
      }

      .status-filter-actions {
         margin-top: 10px;
      }

      .new-assignment-btn {
         min-height: 40px;
         font-size: 13px;
         border-radius: 12px;
      }

      .status-filter-btn {
         flex: 0 0 auto;
         min-width: 134px;
         min-height: 36px;
         padding: 7px 11px;
         font-size: 13px;
         border-radius: 999px;
         border: 1px solid #dfd1bb;
         background: #fff9f0;
      }

      .status-filter-btn .count {
         background: #e8dece;
         color: #675947;
      }

      .contact-section.account-page .status-filter-btn.is-active {
         background: var(--customer-panel-accent) !important;
         border-color: var(--customer-panel-accent) !important;
         color: var(--customer-panel-accent-contrast, #ffffff) !important;
      }

      .contact-section.account-page .status-filter-btn.is-active .count {
         background: rgba(255, 255, 255, 0.34);
         color: var(--customer-panel-accent-contrast, #ffffff);
      }

      .message-list {
         gap: 12px;
         padding-right: 0;
         overflow: visible;
         overflow-x: hidden;
      }

      .message-item {
         grid-template-columns: 1fr;
         gap: 8px;
         padding: 12px 12px 12px 16px;
         max-width: 100%;
         border-radius: 16px;
         border: 1px solid #e8ddcc;
         background: #f8f4ec;
         position: relative;
         overflow: hidden;
         box-shadow: 0 8px 18px rgba(60, 45, 24, 0.06);
      }

      .message-item::before {
         content: "";
         position: absolute;
         left: 0;
         top: 0;
         bottom: 0;
         width: 5px;
         border-radius: 16px 0 0 16px;
         background: #5f7b66;
         pointer-events: none;
      }

      .message-item.is-assignment::before {
         background: var(--customer-panel-accent);
      }

      .message-item.is-completed::before {
         background: #8bb69a;
      }

      .message-item > div:first-child {
         display: flex;
         align-items: center;
         justify-content: flex-start;
         margin-bottom: 2px;
      }

      .message-brand {
         width: 40px;
         height: 40px;
         border-radius: 50%;
         box-shadow: none;
         border: 1px solid #ddcfb8;
      }

      .message-vendor-head {
         gap: 6px;
         margin-bottom: 4px;
         align-items: center;
      }

      .message-vendor-title {
         font-size: 20px;
         overflow-wrap: anywhere;
         word-break: break-word;
      }

      .message-status-chip {
         font-size: 9px;
         padding: 4px 8px;
      }

      .message-unread {
         min-width: 18px;
         height: 18px;
         font-size: 10px;
      }

      .message-preview {
         font-size: 14px;
         line-height: 1.4;
      }

      .message-vendor-meta {
         margin-top: 6px;
         font-size: 11px;
         gap: 8px;
      }

      .message-type-cell {
         gap: 6px;
      }

      .type-chip {
         font-size: 10px;
      }

      .message-type-note {
         display: block;
         margin: 0;
         font-size: 11px;
         color: #7a6b58;
      }

      .message-actions {
         display: flex;
         flex-direction: column;
         gap: 8px;
         justify-content: flex-start;
         align-items: stretch;
         margin-top: 4px;
         margin-bottom: 0;
      }

      .message-open-link {
         width: 100%;
         flex: 0 0 auto;
         min-width: 0;
         min-height: 40px;
         border-radius: 11px;
         font-size: 13px;
         padding: 8px 12px;
         line-height: 1.25;
         white-space: normal;
      }

      .message-toggles {
         justify-content: flex-start;
         gap: 8px;
         margin-top: 8px;
      }

      .enquiry-complete-btn,
      .delete-enquiry-btn,
      .toggle-chip {
         width: 100%;
         min-height: 36px;
         font-size: 12px;
         padding: 8px 12px;
         justify-content: center;
      }

      .status-filter-btn,
      .new-assignment-btn,
      .message-open-link,
      .updateEnquiryStatus,
      .deleteEnquiry {
         position: relative;
         z-index: 2;
         touch-action: manipulation;
      }

      .message-empty {
         padding: 18px 14px;
         font-size: 13px;
      }
   }
</style>

@php
   $isAssignmentTab = isset($message_type) && $message_type === 'assignment';
   $isMessagesTab = !$isAssignmentTab;
   $allItemsLabel = $isAssignmentTab ? 'Alle oppdrag' : 'Alle meldinger';
@endphp

<div class="message-hub">
   <div class="message-body-layout">
      <div class="message-filter-shell">
         <div class="status-filter-panel">
            <p class="status-filter-title">Filter</p>
            <div class="status-filter-list">
               <a href="javascript:void(0)" class="status-filter-btn {{ ($active_close === '' || $active_close === null) ? 'is-active' : '' }}" data-status="">
                  <span><i class="fa fa-th-large" style="margin-right:8px;"></i>{{ $allItemsLabel }}</span>
                  <span class="count">{{ (int)($totalAssignments ?? 0) }}</span>
               </a>
               <a href="javascript:void(0)" class="status-filter-btn {{ (string)$active_close === '1' ? 'is-active' : '' }}" data-status="1">
                  <span><i class="fa fa-play-circle" style="margin-right:8px;"></i>Aktive</span>
                  <span class="count">{{ (int)($activeAssignments ?? 0) }}</span>
               </a>
               <a href="javascript:void(0)" class="status-filter-btn {{ (string)$active_close === '0' ? 'is-active' : '' }}" data-status="0">
                  <span><i class="fa fa-check-circle" style="margin-right:8px;"></i>Fullførte</span>
                  <span class="count">{{ (int)($completedAssignments ?? 0) }}</span>
               </a>
            </div>

            @if($isAssignmentTab)
               <div class="status-filter-actions">
                  <a href="{{ url('enquire-us') }}" class="new-assignment-btn">
                     <i class="fa fa-plus-circle" aria-hidden="true"></i>
                     Nytt Oppdrag
                  </a>
               </div>
            @endif
         </div>

         <div class="filter-hidden">
            <select id="seltypeenq" class="seluserenquiries">
               <option value="">Alle meldinger</option>
               <option value="assignment" @if(isset($message_type) && $message_type=="assignment") selected @endif>Oppdrag</option>
               <option value="direct" @if(isset($message_type) && $message_type=="direct") selected @endif>Direkte</option>
            </select>
            <select id="selcatenq" class="seluserenquiries">
               <option value="">Alle kategorier</option>
               @foreach($allcategories as $cat)
                  <option value="{{ $cat }}" @if(isset($enqCat) && $enqCat==$cat) selected @endif>{{ $cat }}</option>
               @endforeach
            </select>
            <select id="selcloseenq" class="seluserenquiries">
               <option value="">Status: Alle</option>
               <option value="1" @if(isset($active_close) && $active_close=="1") selected @endif>Aktiv</option>
               <option value="0" @if(isset($active_close) && $active_close=="0") selected @endif>Avsluttet</option>
            </select>
         </div>
      </div>

      <div class="message-list">
      @forelse($enquiries as $key => $enquiry)
         @if(!isset($enquiry['product']['category']['category_name']))
            @continue
         @endif
         @php
            $messageType = $enquiry['messageType'] ?? 'Direkte';
            $isAssignment = $messageType === 'Oppdrag';
            $lastEnquiryDate = EnquiriesResponse::getlastEnquiryDate($enquiry['id']);
            $displayDate = $lastEnquiryDate != '' ? date('d.m.y, H:i', strtotime($lastEnquiryDate)) : date('d.m.y, H:i', strtotime($enquiry['created_at']));
            $conversationUrl = url('user/enquiries/'.$enquiry['id']);
            $assignmentOverviewUrl = url('user/enquiries/'.$enquiry['id'].'/overview');
            $cardPrimaryUrl = ($isAssignment && $isAssignmentTab) ? $assignmentOverviewUrl : $conversationUrl;
            $showStatusActions = $isAssignmentTab || !$isAssignment;
            $categoryName = $enquiry['product']['category']['category_name'] ?? 'Kategori';
            $categoryImage = !empty($enquiry['product']['category_id']) ? Category::getCategoryImage($enquiry['product']['category_id']) : '';
            $categoryImageUrl = !empty($categoryImage) ? asset('front/images/category_images/'.$categoryImage) : asset('front/images/profile.png');
            $previewText = !empty($enquiry['response']) ? \Illuminate\Support\Str::limit(strip_tags($enquiry['response']), 95) : 'Ingen ny melding ennå, åpne dialogen for detaljer.';
            $vendorResponseCount = (int)($enquiry['vendorResponseCount'] ?? 0);
            $newVendorCount = (int)($enquiry['newVendorCount'] ?? 0);
            $newMessageCount = (int)($enquiry['newMessageCount'] ?? 0);
            $hasNewMessage = (int)($enquiry['unreadCount'] ?? 0) > 0;
         @endphp

         <div class="message-item {{ ($enquiry['status'] ?? 0) == 0 ? 'is-completed' : '' }} {{ $isAssignment ? 'is-assignment' : 'is-direct' }}">
            <div>
               <img class="message-brand" src="{{ $categoryImageUrl }}" alt="{{ $categoryName }}">
            </div>
            <div>
               <div class="message-vendor-head">
                  <h5 class="message-vendor-title">
                     @if(isset($enquiry['product']['product_name']))
                        <a href="{{ $cardPrimaryUrl }}">{{ $enquiry['product']['product_name'] }}</a>
                     @else
                        Ukjent leverandør
                     @endif
                  </h5>
                  <span class="message-status-chip {{ $enquiry['status'] == 1 ? 'open' : 'closed' }}">{{ $enquiry['status'] == 1 ? 'Aktiv' : 'Lukket' }}</span>
                  @if(!empty($enquiry['unreadCount']) && (int)$enquiry['unreadCount'] > 0)
                     <span class="message-unread">{{ (int)$enquiry['unreadCount'] }}</span>
                  @endif
               </div>
               @if($isMessagesTab)
                  @if($hasNewMessage)
                     <div class="message-flags">
                        <span class="message-status-badge">Ny melding</span>
                     </div>
                  @else
                     <p class="message-preview">Ingen nye meldinger</p>
                  @endif
               @elseif($isAssignment)
                  <div class="assignment-summary">
                     <strong>{{ $vendorResponseCount }} Samtaler</strong>
                     @if($newVendorCount > 0 || $newMessageCount > 0)
                        <div class="assignment-alerts">
                           @if($newVendorCount > 0)
                              <span class="assignment-alert new-vendor">Ny leverandør</span>
                           @endif
                           @if($newMessageCount > 0)
                              <span class="assignment-alert new-message">Ny Melding</span>
                           @endif
                        </div>
                     @endif
                  </div>
               @else
                  <p class="message-preview">{{ $previewText }}</p>
               @endif
               <div class="message-vendor-meta"><span><i class="fa fa-tag"></i>{{ $categoryName }}</span><span><i class="fa fa-calendar"></i>{{ $displayDate }}</span></div>
            </div>

            <div>
               <div class="message-type-cell">
                  @if($isAssignment)
                     <span class="type-chip assignment">Oppdrag</span>
                     <span class="message-type-note">Svar på oppdraget ditt</span>
                  @else
                     <span class="type-chip direct">Direkte</span>
                     <span class="message-type-note">Direkte samtale</span>
                  @endif
               </div>
            </div>

            <div>
               <div class="message-actions">
                  @if($isAssignment && $isMessagesTab)
                     <a class="message-open-link view" href="{{ $assignmentOverviewUrl }}">Åpne oppdrag</a>
                     <a class="message-open-link assignment" href="{{ $conversationUrl }}">Åpne melding</a>
                  @else
                     @if($isAssignment)
                        @if($enquiry['status'] == 1)
                           <a class="updateEnquiryStatus enquiry-complete-btn message-open-link view" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" data-item-label="assignment" href="javascript:void(0)"><i class="status-marker" status="Active"></i><i class="fa fa-check-circle" style="margin-right:7px;"></i>Fullfør oppdrag</a>
                           <a class="message-open-link assignment" href="{{ $assignmentOverviewUrl }}">Åpne oppdrag</a>
                        @else
                           <a class="message-open-link view" href="{{ $assignmentOverviewUrl }}">Se oppdragshistorikk</a>
                        @endif
                     @else
                        <a class="message-open-link assignment" href="{{ $conversationUrl }}">Åpne melding</a>
                     @endif
                  @endif
               </div>

               @if($showStatusActions && !$isAssignment)
                  <div class="message-toggles">
                     @if($enquiry['status'] == 1)
                        <a class="updateEnquiryStatus enquiry-complete-btn" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" data-item-label="{{ $isAssignment ? 'assignment' : 'conversation' }}" href="javascript:void(0)"><i class="status-marker" status="Active"></i><i class="fa fa-check-circle" style="margin-right:7px;"></i>{{ $isAssignment ? 'Fullfør oppdrag' : 'Avslutt samtale' }}</a>
                     @else
                        <a class="deleteEnquiry delete-enquiry-btn" enquiry_id="{{ $enquiry['id'] }}" data-item-label="{{ $isAssignment ? 'assignment' : 'conversation' }}" href="javascript:void(0)"><i class="fa fa-trash" style="margin-right:7px;"></i>{{ $isAssignment ? 'Fjern oppdrag' : 'Fjern samtale' }}</a>
                     @endif
                  </div>
               @endif
            </div>
         </div>
      @empty
         <div class="message-empty">Ingen meldinger funnet med valgt filter.</div>
      @endforelse
      </div>
   </div>
</div>
                           