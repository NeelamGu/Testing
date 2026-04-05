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
   .messages-filter-summary {
      list-style: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      min-height: 38px;
      padding: 8px 14px;
      border-radius: 999px;
      border: 1px solid var(--customer-panel-accent);
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 8px 18px rgba(39, 31, 20, 0.12);
      user-select: none;
   }
   .messages-filter-menu summary::-webkit-details-marker {
      display: none;
   }
   .messages-filter-menu[open] .messages-filter-summary {
      filter: brightness(0.97);
   }
   .messages-filter-dropdown {
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
                        <details class="messages-filter-menu">
                           <summary class="messages-filter-summary"><i class="fa fa-filter"></i> Filter <i class="fa fa-chevron-down" style="font-size:10px;"></i></summary>
                           <div class="messages-filter-dropdown" role="menu" aria-label="Filtrer meldinger">
                              <a href="{{ url('user/enquiries') }}" class="{{ $currentMessageType === '' ? 'is-active' : '' }}" role="menuitem">Alle meldinger <span><i class="fa fa-th-large"></i></span></a>
                              <a href="{{ url('user/enquiries?message_type=direct') }}" class="{{ $currentMessageType === 'direct' ? 'is-active' : '' }}" role="menuitem">Direkte <span><i class="fa fa-comment-o"></i></span></a>
                              <a href="{{ url('user/enquiries?message_type=assignment') }}" class="{{ $currentMessageType === 'assignment' ? 'is-active' : '' }}" role="menuitem">Oppdrag <span><i class="fa fa-briefcase"></i></span></a>
                           </div>
                        </details>
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
   $(document).on('show.bs.modal', '.replymodal', function () {
      var $modal = $(this);
      if (!$modal.parent().is('body')) {
         $modal.appendTo('body');
      }
   });
</script>
@endsection
        