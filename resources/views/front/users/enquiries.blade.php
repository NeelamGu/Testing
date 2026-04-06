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
      display: block;
      padding: 16px 18px;
      background: linear-gradient(120deg, #fff6e8, #fff);
      border-bottom: none;
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
   .messages-main-split {
      display: grid;
      grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.35fr);
      gap: 12px;
      height: 100%;
      min-height: 0;
   }
   .messages-left-pane {
      min-height: 0;
      overflow: hidden;
   }
   .messages-right-pane {
      min-height: 0;
      overflow: hidden;
      border: 1px solid #e8dece;
      border-radius: 12px;
      background: linear-gradient(180deg, #f6f9fd, #f2f7fc);
      display: flex;
      flex-direction: column;
   }
   .split-chat-shell {
      height: 100%;
      min-height: 0;
      display: flex;
      flex-direction: column;
   }
   .split-chat-empty {
      margin: auto;
      text-align: center;
      color: #6e6658;
      padding: 18px;
   }
   .split-chat-empty h4 {
      margin: 0 0 8px;
      color: #2d2519;
      font-size: 18px;
      font-weight: 700;
   }
   .split-chat-empty p {
      margin: 0;
      font-size: 13px;
   }
   .split-chat-card {
      height: 100%;
      min-height: 0;
      display: flex;
      flex-direction: column;
   }
   .split-chat-head {
      display: block;
      padding: 12px;
      border-bottom: 1px solid #e5dfd4;
      background: rgba(255, 255, 255, 0.8);
   }
   .split-chat-title {
      margin: 0;
      font-size: 16px;
      font-weight: 700;
      color: #2d2519;
      line-height: 1.25;
   }
   .split-chat-title a {
      color: #c96900;
      text-decoration: underline;
   }
   .split-chat-subtitle {
      margin: 2px 0 0;
      font-size: 11px;
      color: #7f7261;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      font-weight: 700;
   }
   .split-chat-meta {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
   }
   .split-chat-overview-link {
      color: #2f80ed;
      text-decoration: none;
      font-size: 12px;
      font-weight: 600;
   }
   .split-chat-overview-link:hover {
      text-decoration: underline;
   }
   .split-chat-messages {
      flex: 1;
      min-height: 0;
      overflow-y: auto;
      padding: 12px;
      background:
         radial-gradient(circle at 1px 1px, rgba(72, 96, 123, 0.028) 1px, transparent 0) 0 0/16px 16px,
         linear-gradient(180deg, rgba(244, 248, 252, 0.85) 0%, rgba(238, 244, 251, 0.8) 100%);
   }
   .split-chat-messages .chat-item {
      margin-bottom: 10px;
      display: flex;
      width: 100%;
   }
   .split-chat-messages .chat-item.vendor {
      justify-content: flex-start;
   }
   .split-chat-messages .chat-item.customer {
      justify-content: flex-end;
   }
   .split-chat-messages .chat-bubble {
      width: fit-content;
      max-width: min(78%, 690px);
      border-radius: 14px;
      padding: 9px 12px 7px;
      background: #fff;
      border: 1px solid #e2d9cb;
      box-shadow: 0 2px 8px rgba(40, 35, 26, 0.07);
   }
   .split-chat-messages .chat-item.vendor .chat-bubble {
      border-top-left-radius: 5px;
   }
   .split-chat-messages .chat-item.customer .chat-bubble {
      background: #cfe2ff;
      border-color: #b7d0f4;
      border-top-right-radius: 5px;
   }
   .split-chat-messages .chat-author {
      display: block;
      font-size: 11px;
      font-weight: 700;
      color: #3b6ea8;
      margin-bottom: 4px;
   }
   .split-chat-messages .chat-text {
      font-size: 15px;
      line-height: 1.42;
      color: #222;
      white-space: pre-wrap;
      word-break: break-word;
   }
   .split-chat-messages .chat-time {
      display: block;
      margin-top: 4px;
      text-align: right;
      font-size: 11px;
      color: #6f6f6f;
      font-weight: 600;
   }
   .split-chat-messages .msg-reply-img {
      max-width: 160px;
      border-radius: 9px;
      border: 1px solid #cfdae6;
      display: block;
   }
   .split-chat-messages .chat-media-list {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-top: 6px;
   }
   .chat-date-separator {
      display: flex;
      justify-content: center;
      margin: 7px 0 9px;
   }
   .chat-date-separator span {
      display: inline-block;
      padding: 2px 10px;
      border-radius: 999px;
      background: #e9eff7;
      color: #5d6f84;
      font-size: 11px;
      font-weight: 700;
   }
   .split-chat-composer {
      border-top: 1px solid #e5dfd4;
      background: rgba(255, 255, 255, 0.9);
      padding: 10px;
      flex-shrink: 0;
   }
   .split-chat-input-row {
      display: flex;
      align-items: flex-end;
      gap: 8px;
   }
   .split-chat-attach {
      width: 34px;
      height: 34px;
      border-radius: 999px;
      border: 1px solid #d6c9b6;
      background: #fff;
      color: #5e503c;
   }
   .split-chat-input {
      flex: 1;
      min-height: 36px;
      max-height: 110px;
      border: 1px solid #ddd2c1;
      border-radius: 18px;
      padding: 8px 12px;
      resize: none;
      line-height: 1.35;
      background: #fff;
      font-size: 14px;
   }
   .split-chat-send {
      min-height: 36px;
      border-radius: 999px;
      border: 1px solid #1b8c4f;
      background: linear-gradient(135deg, #23b364, #1e9f5a);
      color: #fff;
      font-size: 12px;
      font-weight: 700;
      padding: 0 16px;
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

      .messages-main-split {
         display: block;
      }

      .messages-right-pane {
         display: none;
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
                        <div>
                           <h3 class="messages-panel-title">{{ $isAssignmentTab ? 'Oppdrag' : 'Meldinger' }}</h3>
                        </div>
                     </div>
                     <div class="messages-panel-body">
                        <div class="messages-main">
                           <div class="messages-main-split">
                              <div class="messages-left-pane table-responsive table-data">
                                 <div id="loadEnqueries">
                                    @include('front.users.load_enquiries')
                                 </div>
                              </div>
                              <div class="messages-right-pane">
                                 <div id="splitChatPane">
                                    @include('front.users.partials.enquiry_split_chat', ['selectedConversation' => ($selectedConversation ?? null)])
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

   (function(){
      var splitPollingTimer = null;

      function autoResizeSplitInput() {
         var $input = $("#splitReplyEnquiryForm textarea[name='message']");
         if (!$input.length) {
            return;
         }
         var el = $input.get(0);
         el.style.height = 'auto';
         var nextHeight = Math.min(el.scrollHeight, 110);
         el.style.height = nextHeight + 'px';
      }

      function scrollSplitChatBottom(force) {
         var $messages = $("#splitChatMessages");
         if (!$messages.length) {
            return;
         }
         var el = $messages.get(0);
         if (force) {
            el.scrollTop = el.scrollHeight;
            return;
         }
         var nearBottom = (el.scrollHeight - (el.scrollTop + el.clientHeight)) < 140;
         if (nearBottom) {
            el.scrollTop = el.scrollHeight;
         }
      }

      function renderDateSeparators() {
         var $messages = $("#splitChatMessages");
         if (!$messages.length) {
            return;
         }

         $messages.find('.chat-date-separator').remove();

         var lastDayKey = '';
         $messages.children('.chat-item').each(function(){
            var $item = $(this);
            var dayKey = String($item.data('day-key') || '');
            if (!dayKey) {
               return;
            }

            if (dayKey !== lastDayKey) {
               var dayLabel = String($item.data('day-label') || dayKey);
               var $separator = $('<div class="chat-date-separator"><span></span></div>');
               $separator.find('span').text(dayLabel);
               $separator.insertBefore($item);
               lastDayKey = dayKey;
            }
         });
      }

      function appendSplitMessages(messageHtml, lastId) {
         var $messages = $("#splitChatMessages");
         if (!$messages.length) {
            return;
         }
         if (messageHtml && $.trim(messageHtml) !== '') {
            $messages.append(messageHtml);
            renderDateSeparators();
            scrollSplitChatBottom(false);
         }
         if (lastId) {
            $messages.attr('data-last-id', parseInt(lastId, 10) || 0);
         }
      }

      function stopSplitChatPolling() {
         if (splitPollingTimer) {
            clearInterval(splitPollingTimer);
            splitPollingTimer = null;
         }
      }

      function startSplitChatPolling() {
         stopSplitChatPolling();

         var $card = $('.split-chat-card');
         if (!$card.length) {
            return;
         }

         var pollUrl = String($card.data('poll-url') || '');
         if (!pollUrl) {
            return;
         }

         splitPollingTimer = setInterval(function(){
            var $messages = $("#splitChatMessages");
            if (!$messages.length) {
               return;
            }
            var lastId = parseInt($messages.attr('data-last-id'), 10) || 0;
            $.ajax({
               url: pollUrl,
               type: 'GET',
               dataType: 'json',
               data: { after_id: lastId },
               success: function(resp){
                  if (resp && resp.status) {
                     appendSplitMessages(resp.message_html || '', resp.last_id || lastId);
                  }
               }
            });
         }, 4000);
      }

      function loadSplitChatPane(url, shouldPushState) {
         var $pane = $('#splitChatPane');
         if (!$pane.length) {
            return;
         }

         stopSplitChatPolling();

         $.get(url, function(html){
            var $doc = $('<div>').append($.parseHTML(html, document, true));
            var $nextPane = $doc.find('#splitChatPane').first();
            if (!$nextPane.length) {
               window.location.href = url;
               return;
            }

            $pane.replaceWith($nextPane);

            var selectedId = 0;
            try {
               selectedId = parseInt((new URL(url, window.location.origin)).searchParams.get('selected_enquiry_id') || '0', 10) || 0;
            } catch (e) {
               selectedId = 0;
            }

            $('#selectedEnquiryId').val(selectedId);
            $('.message-list-desktop .js-thread-link').removeClass('is-selected');
            if (selectedId > 0) {
               $('.message-list-desktop .js-thread-link[data-enquiry-id="' + selectedId + '"]').addClass('is-selected');
            }

            renderDateSeparators();
            autoResizeSplitInput();
            scrollSplitChatBottom(true);
            startSplitChatPolling();

            if (shouldPushState) {
               window.history.pushState({ splitChatUrl: url }, '', url);
            }
         }).fail(function(){
            window.location.href = url;
         });
      }

      $(document).on('click', '.message-list-desktop .js-thread-link', function(e){
         if (window.matchMedia('(max-width: 767px)').matches) {
            return;
         }

         e.preventDefault();
         var nextUrl = $(this).attr('href');
         if (!nextUrl) {
            return;
         }

         $('.message-list-desktop .js-thread-link').removeClass('is-selected');
         $(this).addClass('is-selected');
         $('#selectedEnquiryId').val(parseInt($(this).attr('data-enquiry-id') || '0', 10) || 0);

         loadSplitChatPane(nextUrl, true);
      });

      window.addEventListener('popstate', function(){
         if (window.matchMedia('(max-width: 767px)').matches) {
            return;
         }
         loadSplitChatPane(window.location.href, false);
      });

      $(document).on('input', "#splitReplyEnquiryForm textarea[name='message']", function(){
         autoResizeSplitInput();
      });

      $(document).on('click', '#splitComposerAttachBtn', function(){
         $('#splitComposerFileInput').trigger('click');
      });

      $(document).on('change', '#splitComposerFileInput', function(){
         var $previewWrap = $('#splitImagePreviewWrap');
         var $previewList = $('#splitImagePreviewList');
         $previewList.empty();
         var files = this.files || [];
         if (!files.length) {
            $previewWrap.hide();
            return;
         }

         Array.prototype.forEach.call(files, function(file){
            if (!file || !file.type || file.type.indexOf('image/') !== 0) {
               return;
            }
            var url = URL.createObjectURL(file);
            var $item = $('<div class="image-preview-item"></div>');
            $item.append($('<img>').attr('src', url).attr('alt', 'Bildepreview'));
            $item.append($('<span class="image-preview-meta"></span>').text(file.name || 'Bilde'));
            $previewList.append($item);
         });

         if ($previewList.children().length > 0) {
            $previewWrap.show();
         } else {
            $previewWrap.hide();
         }
      });

      $(document).on('submit', '#splitReplyEnquiryForm', function(e){
         e.preventDefault();
         var form = this;
         var $form = $(form);
         var $messageInput = $form.find("textarea[name='message']");
         var messageText = $.trim($messageInput.val() || '');
         var $fileInput = $('#splitComposerFileInput');
         var hasImage = !!($fileInput.get(0) && $fileInput.get(0).files && $fileInput.get(0).files.length > 0);
         if (messageText === '' && !hasImage) {
            alert('Skriv en melding eller velg minst ett bilde.');
            return;
         }

         var formData = new FormData(form);
         var $submitBtn = $form.find("button[type='submit']");
         $submitBtn.prop('disabled', true).text('Sender...');

         $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(resp){
               if (resp && resp.status) {
                  form.reset();
                  $('#splitImagePreviewList').empty();
                  $('#splitImagePreviewWrap').hide();
                  appendSplitMessages(resp.message_html || '', resp.message_id || 0);
                  autoResizeSplitInput();
                  scrollSplitChatBottom(true);
               }
            },
            error: function(xhr){
               var msg = 'Noe gikk galt. Prøv igjen.';
               if (xhr.responseJSON && xhr.responseJSON.errors) {
                  var firstKey = Object.keys(xhr.responseJSON.errors)[0];
                  if (firstKey) {
                     msg = xhr.responseJSON.errors[firstKey][0];
                  }
               }
               alert(msg);
            },
            complete: function(){
               $submitBtn.prop('disabled', false).text('Send');
            }
         });
      });

      renderDateSeparators();
      autoResizeSplitInput();
      scrollSplitChatBottom(true);
      startSplitChatPolling();
   })();
</script>
@endsection
        