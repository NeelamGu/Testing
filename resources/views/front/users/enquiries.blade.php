<?php 
?>
@extends('front.layout.layout')
@section('content')
<style>
   .modal-backdrop {
      z-index: 999;
   }
   .messages-shell {
      background: transparent;
      border: none;
      border-radius: 0;
      padding: 0;
      margin-top: 4px;
      height: calc(100% - 4px);
   }
   .messages-panel {
      background: #fff;
      border-radius: 12px;
      border: none;
      box-shadow: 0 10px 26px rgba(67, 47, 20, 0.08);
      overflow: hidden;
      height: 100%;
      display: flex;
      flex-direction: column;
   }
   .messages-panel-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 16px 18px;
      background: linear-gradient(120deg, #fff6e8, #fff);
      border-bottom: none;
   }
   .messages-panel-head-content {
      min-width: 0;
   }
   .messages-panel-title {
      margin: 0;
      font-size: 19px;
      font-weight: 700;
      color: #2b2418;
   }
   .messages-panel-subtitle {
      margin: 4px 0 0;
      font-size: 13px;
      color: #746652;
   }
   .messages-filter-menu {
      position: relative;
      flex: 0 0 auto;
      align-self: flex-start;
   }
   .messages-filter-trigger {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      min-height: 38px;
      padding: 8px 14px;
      border-radius: 999px;
      border: 1px solid var(--customer-panel-accent);
      background: rgba(255, 255, 255, 0.96);
      color: #4f4435;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 8px 18px rgba(39, 31, 20, 0.12);
      user-select: none;
   }
   .messages-filter-trigger i:first-child {
      color: var(--customer-panel-accent);
   }
   .messages-filter-menu.is-open .messages-filter-trigger {
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
   }
   .messages-filter-menu.is-open .messages-filter-trigger i:first-child,
   .messages-filter-menu.is-open .messages-filter-trigger i:last-child {
      color: var(--customer-panel-accent-contrast, #ffffff);
   }
   .messages-filter-dropdown {
      display: none;
      position: absolute;
      top: calc(100% + 8px);
      right: 0;
      min-width: 190px;
      border-radius: 14px;
      border: 1px solid #eadbc7;
      background: rgba(255, 255, 255, 0.98);
      box-shadow: 0 12px 28px rgba(67, 47, 20, 0.12);
      padding: 6px;
      z-index: 20;
    }
   .messages-filter-menu.is-open .messages-filter-dropdown {
      display: block;
   }
   .messages-filter-dropdown a {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 9px 12px;
      border-radius: 10px;
      color: #4f4435;
      text-decoration: none !important;
      font-size: 13px;
      font-weight: 600;
    }
   .messages-filter-dropdown a:hover {
      background: #f6efe4;
      color: #2f2516;
   }
   .messages-filter-dropdown a.is-active {
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
    }
   .message-item.is-filter-hidden {
      display: none !important;
   }
   .message-empty.js-filter-empty {
      display: none;
   }
   .messages-panel-body {
      padding: 12px;
      flex: 1;
      min-height: 0;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      gap: 0;
   }
   .contact-section.account-page .column.pull-left {
      overflow: hidden;
   }
   .messages-main {
      flex: 1;
      min-height: 0;
   }
   .messages-main .table-data {
      margin-bottom: 0;
      height: 100%;
      overflow: hidden;
   }
   .messages-main #loadEnqueries {
      height: 100%;
   }
   .account-tab-area .info-box {
      border: 1px solid #eddac0;
      border-radius: 12px;
      background: #fff;
      box-shadow: 0 8px 20px rgba(67, 47, 20, 0.06);
   }
   .account-sidebar li a {
      border-radius: 8px;
      transition: background-color 0.2s ease, transform 0.2s ease;
   }
   .account-sidebar li a:hover {
      background-color: #fbf2e6;
      transform: translateX(2px);
   }
   .replymodal {
      z-index: 9999;
      background-color: transparent;
   }
   .replymodal .modal-dialog {
      margin: 0 auto;
      width: 92%;
      max-width: 760px;
      min-height: calc(100vh - 32px);
      display: flex;
      align-items: center;
   }
   .replymodal .modal-content {
      border-radius: 12px;
      overflow: hidden;
   }
   .replymodal .modal-body {
      padding-bottom: 0;
      padding-top: 5px;
   }
   .replymodal .close {
      z-index: 999;
      position: relative;
   }
   .info-pop-table td {
      text-align: left;
   }
   @media (max-width: 767px) {
      .messages-shell {
         padding: 8px;
         margin-top: 6px;
         height: auto;
         overflow: visible;
      }

      .messages-panel {
         border-radius: 14px;
         min-height: calc(100dvh - 168px);
         overflow: visible;
      }

      .messages-panel-head {
         padding: 12px;
      }

      .messages-panel-title {
         font-size: 18px;
      }

      .messages-panel-body,
      .messages-main,
      .messages-main .table-data,
      .messages-main #loadEnqueries {
         min-height: 0;
         height: auto;
         overflow: visible !important;
      }

      .replymodal .modal-dialog {
         margin: 0 auto;
         width: calc(100% - 24px);
         min-height: calc(100vh - 24px);
      }
   }
</style>
<div class="page-wrapper">
   @php $activeTopTab = (isset($message_type) && $message_type==='assignment') ? 'assignments' : 'messages'; @endphp
   @php $isAssignmentTab = (isset($message_type) && $message_type==='assignment'); @endphp
   @php $currentMessageType = isset($message_type) ? $message_type : ''; @endphp
   @include('front.users.partials.topbar', ['activeTopTab' => $activeTopTab])
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'enquiries'])
            </div>
            <!--Content Side-->
            <div class="col-md-12 col-sm-12 col-xs-12 column pull-left">
               <div class="messages-shell">
                  <div class="messages-panel">
                     <div class="messages-panel-head">
                        <div class="messages-panel-head-content">
                           <h3 class="messages-panel-title">{{ $isAssignmentTab ? 'Oppdrag' : 'Meldinger' }}</h3>
                        </div>
                        <div class="messages-filter-menu" data-messages-filter-menu>
                           <button type="button" class="messages-filter-trigger" data-filter-trigger aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-filter"></i>
                              <span data-filter-label>Filter</span>
                              <i class="fa fa-chevron-down" style="font-size:10px;"></i>
                           </button>
                           <div class="messages-filter-dropdown" role="menu" aria-label="Filtrer meldinger">
                              <a href="javascript:void(0)" class="{{ $currentMessageType === '' ? 'is-active' : '' }}" data-message-filter-option data-filter-value="all" role="menuitem">Alle meldinger <span><i class="fa fa-th-large"></i></span></a>
                              <a href="javascript:void(0)" class="{{ $currentMessageType === 'direct' ? 'is-active' : '' }}" data-message-filter-option data-filter-value="direct" role="menuitem">Direkte <span><i class="fa fa-comment-o"></i></span></a>
                              <a href="javascript:void(0)" class="{{ $currentMessageType === 'assignment' ? 'is-active' : '' }}" data-message-filter-option data-filter-value="assignment" role="menuitem">Oppdrag <span><i class="fa fa-briefcase"></i></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="messages-panel-body">
                        <div class="messages-main">
                           <div class="table-responsive table-data">
                              <div id="loadEnqueries">
                                 @include('front.users.load_enquiries')
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
      var menu = document.querySelector('[data-messages-filter-menu]');
      var trigger = menu ? menu.querySelector('[data-filter-trigger]') : null;
      var label = menu ? menu.querySelector('[data-filter-label]') : null;
      var options = menu ? menu.querySelectorAll('[data-message-filter-option]') : [];

      if (!menu || !trigger || !label || !options.length) {
         return;
      }

      function getMessageItems() {
         return document.querySelectorAll('#loadEnqueries .message-item');
      }

      function getEmptyState() {
         return document.querySelector('#loadEnqueries .js-filter-empty');
      }

      function getItemType(item) {
         return item.getAttribute('data-message-kind') || 'direct';
      }

      function closeMenu() {
         menu.classList.remove('is-open');
         trigger.setAttribute('aria-expanded', 'false');
      }

      function openMenu() {
         menu.classList.add('is-open');
         trigger.setAttribute('aria-expanded', 'true');
      }

      function setActiveOption(filterValue) {
         for (var i = 0; i < options.length; i++) {
            options[i].classList.toggle('is-active', options[i].getAttribute('data-filter-value') === filterValue);
         }
      }

      function setFilter(filterValue) {
         var messageItems = getMessageItems();
         var emptyState = getEmptyState();
         var visibleCount = 0;
         var currentLabel = 'Filter';

         if (filterValue === 'direct') {
            currentLabel = 'Direkte';
         } else if (filterValue === 'assignment') {
            currentLabel = 'Oppdrag';
         } else {
            currentLabel = 'Alle meldinger';
            filterValue = 'all';
         }

         for (var i = 0; i < messageItems.length; i++) {
            var item = messageItems[i];
            var itemType = getItemType(item);
            var shouldShow = filterValue === 'all' || itemType === filterValue;
            item.classList.toggle('is-filter-hidden', !shouldShow);
            if (shouldShow) {
               visibleCount += 1;
            }
         }

         if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
         }

         label.textContent = currentLabel;
         setActiveOption(filterValue);
      }

      trigger.addEventListener('click', function (event) {
         event.preventDefault();
         event.stopPropagation();
         if (menu.classList.contains('is-open')) {
            closeMenu();
         } else {
            openMenu();
         }
      });

      for (var j = 0; j < options.length; j++) {
         options[j].addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            setFilter(this.getAttribute('data-filter-value'));
            closeMenu();
         });
      }

      document.addEventListener('click', function (event) {
         if (!menu.contains(event.target)) {
            closeMenu();
         }
      });

      document.addEventListener('keydown', function (event) {
         if (event.key === 'Escape') {
            closeMenu();
         }
      });

      setFilter('all');
   })();

   $(document).on('show.bs.modal', '.replymodal', function () {
      var $modal = $(this);
      if (!$modal.parent().is('body')) {
         $modal.appendTo('body');
      }
   });
</script>
@endsection
        