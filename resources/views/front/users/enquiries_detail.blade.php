<?php 
$messagesCountCustomer = messagesCountCustomer();
?>
@extends('front.layout.layout')
@section('content')
<style>
   .modal-backdrop {
      z-index: 999;
   }
   .contact-section.account-page .column.pull-left {
      overflow: hidden;
   }
   .conversation-shell {
         background: transparent;
         border: none;
         border-radius: 0;
         padding: 0;
       margin-top: 4px;
       height: calc(100% - 4px);
       box-shadow: none;
   }
   .conversation-card {
       background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(252, 254, 255, 0.94));
       border-radius: 12px;
       border: none;
       box-shadow: 0 12px 32px rgba(67, 47, 20, 0.08);
      overflow: hidden;
      height: 100%;
      display: flex;
      flex-direction: column;
      min-height: 0;
   }
   .sec-title.account-heading.reply-table-section {
      margin: 0;
      padding: 0;
      flex-shrink: 0;
   }
   .conversation-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      border-bottom: 1px solid rgba(225, 214, 196, 0.4);
      background: linear-gradient(120deg, rgba(242, 255, 244, 0.72), rgba(246, 251, 255, 0.72));
      padding: 12px 16px;
   }
   .conversation-title {
      margin: 0;
      font-size: 18px;
      font-weight: 700;
      color: #2f2516;
   }
   .conversation-title a {
      color: #c96900;
      text-decoration: underline;
   }
   .conversation-actions {
      display: flex;
      gap: 8px;
   }
   .conversation-content {
      display: flex;
      flex-direction: column;
      flex: 1;
      min-height: 0;
      overflow: hidden;
   }
   .reply-back-btn,
   .reply-ref-btn {
      border-radius: 8px;
      font-weight: 600;
      padding: 8px 13px;
      font-size: 14px;
      line-height: 1.1;
      transition: transform 0.2s ease, opacity 0.2s ease;
   }
   .reply-back-btn:hover,
   .reply-ref-btn:hover {
      transform: translateY(-1px);
      opacity: 0.95;
   }
   .chat-area-sec.enquiries-reply-area {
      background:
         radial-gradient(circle at 1px 1px, rgba(72, 96, 123, 0.028) 1px, transparent 0) 0 0/16px 16px,
         linear-gradient(180deg, rgba(244, 248, 252, 0.85) 0%, rgba(238, 244, 251, 0.8) 100%);
      padding: 10px 12px;
      margin-top: 0;
      flex: 1;
      min-height: 0;
      overflow-y: auto;
      overflow-x: hidden;
      -webkit-overflow-scrolling: touch;
      overscroll-behavior-y: contain;
      touch-action: pan-y;
   }
   .chat-messages {
      display: flex;
      flex-direction: column;
      gap: 6px;
      padding-bottom: 2px;
   }
   .chat-date-separator {
      display: flex;
      justify-content: center;
      margin: 1px 0;
   }
   .chat-date-separator span {
      display: inline-block;
      padding: 2px 9px;
      border-radius: 999px;
       border: none;
       background: rgba(237, 242, 248, 0.8);
      color: #66798b;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.2px;
   }
   .chat-item {
      display: flex;
      width: 100%;
   }
   .chat-item.vendor {
      justify-content: flex-start;
   }
   .chat-item.customer {
      justify-content: flex-end;
   }
   .chat-bubble {
      width: fit-content;
      max-width: min(72%, 700px);
      border-radius: 16px;
      padding: 8px 12px 6px;
      box-shadow: 0 3px 12px rgba(42, 58, 79, 0.12);
      border: none;
   }
   .chat-item.vendor .chat-bubble {
      background: rgba(255, 255, 255, 0.94);
      border-color: transparent;
      border-top-left-radius: 5px;
   }
   .chat-item.customer .chat-bubble {
      background: var(--customer-panel-accent, #e78002);
      border-color: transparent;
      border-top-right-radius: 5px;
   }
   .chat-author {
      display: block;
      font-size: 10px;
      font-weight: 700;
      margin-bottom: 3px;
      color: #60758f;
      text-transform: uppercase;
      letter-spacing: 0.35px;
   }
   .chat-item.customer .chat-author {
      color: var(--customer-panel-accent-contrast, #ffffff);
      text-align: right;
   }
   .chat-item.customer .chat-text {
      color: var(--customer-panel-accent-contrast, #ffffff);
   }
   .chat-item.customer .chat-time {
      color: var(--customer-panel-accent-contrast, #ffffff);
   }
   .chat-text {
      font-size: 15px;
      line-height: 1.33;
      color: #1d2a38;
      white-space: pre-wrap;
      word-break: break-word;
   }
   .chat-media-list {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-top: 6px;
   }
   .chat-time {
      display: block;
      margin-top: 3px;
      text-align: right;
      font-size: 10px;
      color: #627587;
      font-weight: 600;
   }
   .msg-reply-img {
      max-width: 128px !important;
      border-radius: 10px;
      border: 1px solid #cfdae6;
      display: block;
   }
   .composer-wrap {
       border-top: none;
       background: linear-gradient(180deg, rgba(248, 252, 255, 0.92), rgba(244, 249, 254, 0.9));
      padding: 6px 8px;
      flex-shrink: 0;
      position: relative;
      z-index: 2;
   }
   .composer-form {
      margin: 0;
   }
   .composer-input-row {
      display: flex;
      align-items: flex-end;
      gap: 8px;
   }
   .composer-input {
      flex: 1;
      min-height: 38px;
      max-height: 112px;
       border: none;
       border-radius: 16px;
       padding: 8px 12px;
       resize: none;
       background: rgba(255, 255, 255, 0.98);
       box-shadow: 0 2px 8px rgba(42, 58, 79, 0.1);
      overflow-y: auto;
      line-height: 1.35;
   }
   .composer-input:focus {
      outline: none;
      border-color: #2f81f7;
      box-shadow: 0 0 0 3px rgba(47, 129, 247, 0.12);
   }
   .composer-attach-btn {
      width: 36px;
      height: 36px;
      min-height: 0 !important;
       border: none;
       border-radius: 999px;
       background: rgba(255, 255, 255, 0.97);
       box-shadow: 0 2px 6px rgba(42, 58, 79, 0.08);
      color: #4f647b;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      padding: 0;
   }
   .composer-attach-btn:hover,
   .composer-attach-btn:focus {
      color: #2f81f7;
      border-color: #2f81f7;
      background: #f8fbff;
   }
   .image-preview-wrap {
      margin-top: 8px;
      display: none;
      border: 1px solid #d5e0ec;
      border-radius: 12px;
      padding: 8px;
      background: #f3f8fd;
   }
   .image-preview-list {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
   }
   .image-preview-item {
      width: 74px;
      text-align: center;
   }
   .image-preview-item img {
      width: 74px;
      height: 74px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid #c7d6e6;
      display: block;
      background: #fff;
   }
   .image-preview-meta {
      display: block;
      margin-top: 4px;
      font-size: 10px;
      color: #54687d;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }
   .upload-file-area {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: 0;
      padding: 0;
      border: 0;
      opacity: 0;
      pointer-events: none;
   }
   .send-reply .r-btn {
      margin-left: 0;
      border-radius: 999px;
      font-weight: 700;
      min-width: 84px;
      min-height: 0 !important;
      width: auto !important;
      height: 36px;
      padding: 0 14px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #23b364, #1e9f5a);
      border: 1px solid #1b8c4f;
      color: #fff;
   }
   .send-reply .r-btn:hover,
   .send-reply .r-btn:focus {
      color: #fff;
   }
   @media (max-width: 767px) {
      .contact-section.account-page .column.pull-left {
         overflow: visible;
      }

      .conversation-shell {
         padding: 8px;
         margin-top: 4px;
         height: auto;
         overflow: visible;
      }

      .conversation-card {
         height: calc(100dvh - 126px);
         min-height: 0;
         max-height: calc(100dvh - 126px);
      }

      .conversation-head {
         align-items: center;
         flex-direction: row;
         gap: 6px;
         padding: 7px 9px;
      }

      .conversation-title {
         font-size: 16px;
      }

      .conversation-actions {
         width: auto;
         flex-shrink: 0;
      }

      .reply-back-btn {
         width: auto;
         padding: 5px 10px;
         font-size: 12px;
         justify-content: flex-start;
      }

      .chat-area-sec.enquiries-reply-area {
         padding: 7px;
         min-height: 0;
      }

      .chat-messages {
         gap: 5px;
      }

      .chat-date-separator span {
         font-size: 9px;
         padding: 1px 8px;
      }

      .chat-bubble {
         max-width: 93%;
         padding: 7px 10px 5px;
         border-radius: 14px;
      }

      .chat-author {
         font-size: 9px;
         margin-bottom: 2px;
      }

      .chat-text {
         font-size: 14px;
         line-height: 1.3;
      }

      .chat-time {
         font-size: 9px;
         margin-top: 2px;
      }

      .composer-wrap {
         padding: 6px;
         padding-bottom: calc(6px + env(safe-area-inset-bottom));
      }

      .composer-input-row {
         gap: 6px;
      }

      .composer-input {
         min-height: 36px;
         max-height: 96px;
         font-size: 15px;
         border-radius: 14px;
         padding: 7px 11px;
      }

      .composer-attach-btn {
         width: 34px;
         height: 34px;
      }

      .image-preview-item {
         width: 64px;
      }

      .image-preview-item img {
         width: 64px;
         height: 64px;
      }

      .upload-file-area {
         width: 1px !important;
      }

      .send-reply .r-btn {
         min-width: 0;
         width: auto !important;
         height: 34px;
         padding: 0 14px;
      }
   }
</style>

<div class="page-wrapper">
   @include('front.users.partials.topbar', ['activeTopTab' => ($activeTopTab ?? 'messages')])
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'enquiries'])
            </div>
            <!--Content Side-->
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="conversation-shell">
               <div class="conversation-card">
               <div class="sec-title account-heading reply-table-section">
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert" style="margin-top:20px;">
                     <strong>Success: </strong> {{ Session::get('success_message')}}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <span style="font-weight: bold; float:left;"> </span> {{ $errors->response->first('message') }}<br>
                  {{ $errors->response->first('image') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(count($errors) > 0 )
                  <div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin-top:20px;">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      <ul class="p-0 m-0" style="list-style: none;">
                          @foreach($errors->all() as $error)
                          <li>{{$error}}</li>
                          @endforeach
                      </ul>
                  </div>
               @endif
                <div class="conversation-head">
                   <div>
                      <h3 class="conversation-title">
                         Samtale med
                         @if(!empty($conversationVendorUrl))
                            <a href="{{ $conversationVendorUrl }}">{{ $conversationVendorName ?? 'Leverandør' }}</a>
                         @else
                            <span>{{ $conversationVendorName ?? 'Leverandør' }}</span>
                         @endif
                      </h3>
                   </div>
                   <div class="conversation-actions">
                      <a href="{{ $backUrl ?? url('user/enquiries/') }}" class="reply-back-btn">
                      <i class="fa fa-arrow-left" aria-hidden="true"></i> Tilbake
                      </a>
                   </div>
                </div>
               </div>
               <div class="conversation-content">
                  <div class="chat-area-sec enquiries-reply-area">
                     @php $lastMessageId = count($enquiries)>0 ? (int)$enquiries[count($enquiries)-1]['id'] : 0; @endphp
                     <div id="chatMessages" class="chat-messages" data-last-id="{{ $lastMessageId }}">
                        @foreach($enquiries as $enquiry)
                           @include('front.users.partials.enquiry_message', ['enquiry' => $enquiry, 'customerLabel' => ($customerLabel ?? ''), 'vendorLabel' => ($vendorLabel ?? '')])
                        @endforeach
                     </div>
                  </div>
                  <div class="send-reply composer-wrap">
                     <form id="replyEnquiryForm" class="composer-form" method="post" action="{{ url('user/enquiry/response') }}" enctype="multipart/form-data">@csrf
                        <input type="hidden" name="enquiry_id" value="{{ $enquiry_id }}">
                        <div class="composer-input-row">
                           <button type="button" id="composerAttachBtn" class="composer-attach-btn" aria-label="Legg til bilder">
                              <i class="fa fa-image" aria-hidden="true"></i>
                           </button>
                           <textarea class="composer-input" name="message" rows="1" placeholder="Skriv melding til leverandøren"></textarea>
                           <input id="composerFileInput" class="upload-file-area" type="file" name="images[]" accept="image/*" multiple>
                           <button type="submit" class="r-btn">Send</button>
                        </div>
                        <div class="image-preview-wrap" id="imagePreviewWrap">
                           <div class="image-preview-list" id="imagePreviewList"></div>
                        </div>
                     </form>
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
    $(document).ready(function () {
      var enquiryId = "{{ $enquiry_id }}";
      var $chatContainer = $(".enquiries-reply-area");
      var $chatMessages = $("#chatMessages");
      var $conversationCard = $(".conversation-card");
      var $replyForm = $("#replyEnquiryForm");
      var $messageInput = $replyForm.find("textarea[name='message']");
      var $fileInput = $replyForm.find("input[name='images[]']");
      var $attachBtn = $("#composerAttachBtn");
      var $imagePreviewWrap = $("#imagePreviewWrap");
      var $imagePreviewList = $("#imagePreviewList");
      var previewObjectUrls = [];
      var pollingTimer = null;
      var isSending = false;
      var lastMessageId = parseInt($chatMessages.data("last-id"), 10) || 0;
      var shouldStickToBottom = true;

      function clearImagePreview() {
         previewObjectUrls.forEach(function (url) {
            URL.revokeObjectURL(url);
         });
         previewObjectUrls = [];
         $imagePreviewList.empty();
         $imagePreviewWrap.hide();
      }

      function hasSelectedImage() {
         var input = $fileInput.get(0);
         return !!(input && input.files && input.files.length > 0);
      }

      function renderImagePreview() {
         clearImagePreview();

         var input = $fileInput.get(0);
         if (!input || !input.files || !input.files.length) {
            return;
         }

         Array.prototype.forEach.call(input.files, function (file) {
            if (!file || !file.type || file.type.indexOf("image/") !== 0) {
               return;
            }

            var previewUrl = URL.createObjectURL(file);
            previewObjectUrls.push(previewUrl);

            var $item = $('<div class="image-preview-item"></div>');
            var $img = $("<img>").attr("src", previewUrl).attr("alt", "Bildepreview");
            var $meta = $('<span class="image-preview-meta"></span>').text(file.name || "Bilde");

            $item.append($img).append($meta);
            $imagePreviewList.append($item);
         });

         if ($imagePreviewList.children().length > 0) {
            $imagePreviewWrap.show();
         }
      }

      function autoResizeMessageInput() {
         if (!$messageInput.length) {
            return;
         }

         var el = $messageInput.get(0);
         el.style.height = "auto";

         var maxHeight = window.matchMedia("(max-width: 767px)").matches ? 96 : 112;
         var nextHeight = Math.min(el.scrollHeight, maxHeight);

         el.style.height = nextHeight + "px";
         el.style.overflowY = el.scrollHeight > maxHeight ? "auto" : "hidden";
      }

      function getDistanceFromBottom() {
         if (!$chatContainer.length) {
            return 0;
         }

         var container = $chatContainer[0];
         return container.scrollHeight - (container.scrollTop + container.clientHeight);
      }

      function updateStickToBottomState() {
         shouldStickToBottom = getDistanceFromBottom() < 140;
      }

      function bindChatImageLoadHandlers() {
         $chatMessages.find("img").each(function () {
            if (this.dataset && this.dataset.chatScrollBound === "1") {
               return;
            }

            if (this.dataset) {
               this.dataset.chatScrollBound = "1";
            }

            if (!this.complete) {
               $(this).one("load.chatScroll error.chatScroll", function () {
                  scrollChatToBottom(false);
               });
            }
         });
      }

      function scrollChatToBottom(force) {
         if (!$chatContainer.length) {
            return;
         }

         var container = $chatContainer[0];

         if (force || shouldStickToBottom) {
            container.scrollTop = container.scrollHeight;

            window.requestAnimationFrame(function () {
               container.scrollTop = container.scrollHeight;
            });

            setTimeout(function () {
               container.scrollTop = container.scrollHeight;
            }, 90);
         }
      }

      function appendNewMessages(html, nextLastId) {
         if (html && html.trim() !== "") {
            $chatMessages.append(html);
            renderDateSeparators();
            bindChatImageLoadHandlers();
            scrollChatToBottom(false);
         }
         if (nextLastId) {
            lastMessageId = parseInt(nextLastId, 10) || lastMessageId;
            $chatMessages.attr("data-last-id", lastMessageId);
         }
      }

      function renderDateSeparators() {
         if (!$chatMessages.length) {
            return;
         }

         $chatMessages.find(".chat-date-separator").remove();

         var lastDayKey = "";
         $chatMessages.children(".chat-item").each(function () {
            var $item = $(this);
            var dayKey = String($item.data("day-key") || "");

            if (!dayKey) {
               return;
            }

            if (dayKey !== lastDayKey) {
               var dayLabel = String($item.data("day-label") || dayKey);
               var $separator = $('<div class="chat-date-separator"><span></span></div>');
               $separator.find("span").text(dayLabel);
               $separator.insertBefore($item);
               lastDayKey = dayKey;
            }
         });
      }

      function pollNewMessages(forceScroll) {
         $.ajax({
            url: "/user/enquiries/" + enquiryId + "/messages",
            type: "GET",
            dataType: "json",
            data: { after_id: lastMessageId },
            success: function (resp) {
               if (resp && resp.status) {
                  appendNewMessages(resp.message_html || "", resp.last_id || lastMessageId);
                  if (forceScroll) {
                     scrollChatToBottom(true);
                  }
               }
            }
         });
      }

      function sizeConversationCardForViewport() {
         if (!$conversationCard.length) {
            return;
         }

         var isMobile = window.matchMedia("(max-width: 767px)").matches;
         if (!isMobile) {
            $conversationCard.css({
               height: "100%",
               minHeight: "0",
               maxHeight: ""
            });
            return;
         }

         var cardEl = $conversationCard.get(0);
         var rect = cardEl.getBoundingClientRect();
         var availableHeight = window.innerHeight - rect.top - 8;

         if (availableHeight < 360) {
            availableHeight = 360;
         }

         var nextHeight = availableHeight + "px";
         $conversationCard.css({
            height: nextHeight,
            minHeight: nextHeight,
            maxHeight: nextHeight
         });
      }

      sizeConversationCardForViewport();
      renderDateSeparators();
      bindChatImageLoadHandlers();
      updateStickToBottomState();
      scrollChatToBottom(true);
      setTimeout(function () {
         scrollChatToBottom(true);
      }, 180);

      $chatContainer.on("scroll", function () {
         updateStickToBottomState();
      });

      $(window).on("load", function () {
         sizeConversationCardForViewport();
         scrollChatToBottom(true);
      });

      $(window).on("resize orientationchange", function () {
         sizeConversationCardForViewport();
         autoResizeMessageInput();
         scrollChatToBottom(true);
      });

      pollingTimer = setInterval(function () {
         if (!isSending) {
            pollNewMessages(false);
         }
      }, 4000);

       $attachBtn.on("click", function () {
          $fileInput.trigger("click");
       });

       $fileInput.on("change", function () {
          renderImagePreview();
          autoResizeMessageInput();
       });

       $messageInput.on("input", function () {
          autoResizeMessageInput();
       });

       autoResizeMessageInput();

       $replyForm.submit(function (event) {
           event.preventDefault(); // Prevent default form submission

           var form = $(this);
           var messageText = $.trim($messageInput.val() || "");
           if (messageText === "" && !hasSelectedImage()) {
              alert("Skriv en melding eller velg minst ett bilde.");
              return;
           }

           var formData = new FormData(this);
           var submitBtn = form.find("button[type='submit']");
           isSending = true;
           submitBtn.prop("disabled", true).text("Sender...");

           $.ajax({
               url: form.attr("action"),
               type: form.attr("method"),
               data: formData,
               processData: false,
               contentType: false,
               dataType: "json",
               success: function (response) {
                  if (response && response.status) {
                     form[0].reset();
                     clearImagePreview();
                     autoResizeMessageInput();
                     appendNewMessages(response.message_html || "", response.message_id || lastMessageId);
                     scrollChatToBottom(true);
                  }
               },
               error: function (xhr) {
                  var msg = "Noe gikk galt. Prøv igjen.";
                  if (xhr.responseJSON && xhr.responseJSON.errors) {
                     var firstKey = Object.keys(xhr.responseJSON.errors)[0];
                     if (firstKey) {
                        msg = xhr.responseJSON.errors[firstKey][0];
                     }
                  } else if (xhr.responseJSON && xhr.responseJSON.message) {
                     msg = xhr.responseJSON.message;
                  }
                  alert(msg);
               },
               complete: function () {
                  isSending = false;
                  submitBtn.prop("disabled", false).text("Send");
               }
           });
       });

       $(window).on("beforeunload", function () {
             clearImagePreview();
         if (pollingTimer) {
            clearInterval(pollingTimer);
         }
       });
   });
</script>
@endsection         