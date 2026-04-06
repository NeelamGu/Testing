@php
   $conversation = $selectedConversation ?? null;
@endphp

<div class="split-chat-shell">
   @if(empty($conversation))
      <div class="split-chat-empty">
         <h4>Ingen tråd valgt</h4>
         <p>Velg en melding fra listen til venstre for å se samtalen her.</p>
      </div>
   @else
      @php
         $messages = $conversation['messages'] ?? [];
         $lastMessageId = count($messages) > 0 ? (int)$messages[count($messages)-1]['id'] : 0;
      @endphp
      <div class="split-chat-card" data-thread-id="{{ (int)($conversation['thread_id'] ?? 0) }}" data-thread-status="{{ (int)($conversation['thread_status'] ?? 1) }}" data-assignment-id="{{ (int)($conversation['assignment_id'] ?? 0) }}" data-poll-url="{{ $conversation['poll_url'] ?? '' }}">
         <div class="split-chat-head">
            <div class="split-chat-title-wrap">
               <h4 class="split-chat-title">
                  @if(!empty($conversation['vendor_url']))
                     <a href="{{ $conversation['vendor_url'] }}">{{ $conversation['vendor_name'] ?? 'Leverandør' }}</a>
                  @else
                     <span>{{ $conversation['vendor_name'] ?? 'Leverandør' }}</span>
                  @endif
               </h4>
               <div class="split-chat-meta">
                  <p class="split-chat-subtitle">{{ !empty($conversation['is_assignment']) ? 'Oppdragstråd' : 'Direkte melding' }}</p>
                  @if(!empty($conversation['is_assignment']) && !empty($conversation['overview_url']))
                     <a href="{{ $conversation['overview_url'] }}" class="split-chat-overview-link">Se alle tråder</a>
                  @endif
                  @if((int)($conversation['thread_status'] ?? 1) === 1)
                     <a href="javascript:void(0)" class="split-chat-close-link" data-thread-id="{{ (int)($conversation['thread_id'] ?? 0) }}" data-current-status="Active">Avslutt tråd</a>
                  @endif
               </div>
            </div>
         </div>

         <div class="split-chat-messages" id="splitChatMessages" data-last-id="{{ $lastMessageId }}">
            @foreach($messages as $enquiry)
               @include('front.users.partials.enquiry_message', ['enquiry' => $enquiry, 'customerLabel' => ($conversation['customer_label'] ?? ''), 'vendorLabel' => ($conversation['vendor_label'] ?? '')])
            @endforeach
         </div>

         <div class="split-chat-composer">
            <form id="splitReplyEnquiryForm" method="post" action="{{ $conversation['send_url'] ?? '' }}" enctype="multipart/form-data">@csrf
               <input type="hidden" name="enquiry_id" value="{{ (int)($conversation['thread_id'] ?? 0) }}">
               <div class="split-chat-input-row">
                  <button type="button" id="splitComposerAttachBtn" class="split-chat-attach" aria-label="Legg til bilder">
                     <i class="fa fa-image" aria-hidden="true"></i>
                  </button>
                  <textarea class="split-chat-input" name="message" rows="1" placeholder="Skriv melding..."></textarea>
                  <input id="splitComposerFileInput" class="upload-file-area" type="file" name="images[]" accept="image/*" multiple>
                  <button type="submit" class="split-chat-send">Send</button>
               </div>
               <div class="image-preview-wrap" id="splitImagePreviewWrap">
                  <div class="image-preview-list" id="splitImagePreviewList"></div>
               </div>
            </form>
         </div>
      </div>
   @endif
</div>
