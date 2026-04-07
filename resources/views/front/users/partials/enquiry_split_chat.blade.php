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
         $assignmentDetails = $conversation['assignment_details'] ?? [];
         $assignmentTitle = trim((string)($assignmentDetails['title'] ?? ''));
         $assignmentDate = trim((string)($assignmentDetails['assignment_date'] ?? ''));
         $assignmentAddress = trim((string)($assignmentDetails['address'] ?? ''));
         $assignmentCity = trim((string)($assignmentDetails['city'] ?? ''));
         $assignmentPincode = trim((string)($assignmentDetails['pincode'] ?? ''));
         $assignmentPrice = trim((string)($assignmentDetails['desired_price'] ?? ''));
         $assignmentDescription = trim((string)($assignmentDetails['assignment_text'] ?? ($assignmentDetails['description'] ?? '')));
         $assignmentThreadCount = (int)($conversation['thread_count'] ?? 0);
         $assignmentInfoLines = [];
         if($assignmentTitle !== ''){
            $assignmentInfoLines[] = ['label' => 'Tittel', 'value' => $assignmentTitle];
         }
         if($assignmentDate !== ''){
            $assignmentInfoLines[] = ['label' => 'Oppdragsdato', 'value' => $assignmentDate];
         }
         if($assignmentAddress !== '' || $assignmentCity !== ''){
            $locationValue = $assignmentAddress;
            if($assignmentAddress !== '' && $assignmentCity !== ''){
               $locationValue .= ', ';
            }
            $locationValue .= $assignmentCity;
            if($assignmentPincode !== ''){
               $locationValue .= ' (' . $assignmentPincode . ')';
            }
            $assignmentInfoLines[] = ['label' => 'Sted', 'value' => $locationValue];
         }
         if($assignmentPrice !== ''){
            $assignmentInfoLines[] = ['label' => 'Ønsket pris', 'value' => $assignmentPrice];
         }
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
                  @if(!empty($conversation['is_assignment']))
                     <p class="split-chat-subtitle">Oppdrag · {{ !empty($conversation['thread_count']) ? $conversation['thread_count'] . ' samtale' . ($conversation['thread_count'] != 1 ? 'r' : '') : 'samtale' }}</p>
                  @else
                     <p class="split-chat-subtitle">Direkte melding</p>
                  @endif
               </div>
            </div>
            @if(empty($conversation['is_assignment']) && (int)($conversation['thread_status'] ?? 1) === 1)
               <div class="split-chat-head-actions">
                  <a href="javascript:void(0)" class="split-chat-close-link" data-thread-id="{{ (int)($conversation['thread_id'] ?? 0) }}" data-item-type="conversation" data-current-status="Active">Avslutt samtale</a>
               </div>
            @endif
         </div>

         @if(!empty($conversation['is_assignment']))
            <div style="padding:12px 12px 0;">
               <div style="border:1px solid #efe1ce;border-radius:14px;background:#f7f1e8;padding:12px;">
                  <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                     <div>
                        <h4 style="margin:0 0 6px;font-size:20px;font-weight:700;color:#2f2416;">Oppdragsinformasjon</h4>
                        @if($assignmentTitle !== '')
                           <p style="margin:0;color:#2b2115;font-size:16px;font-weight:600;">{{ $assignmentTitle }}</p>
                        @endif
                     </div>
                     @if($assignmentThreadCount > 0)
                        <div style="font-size:11px;font-weight:700;color:#8b7c6c;letter-spacing:.04em;text-transform:uppercase;">{{ $assignmentThreadCount }} samtale{{ $assignmentThreadCount !== 1 ? 'r' : '' }}</div>
                     @endif
                  </div>

                  <div style="display:grid;grid-template-columns:1fr;gap:6px;margin-top:10px;">
                     @foreach($assignmentInfoLines as $assignmentInfoLine)
                        <div style="border:1px solid #d9c3a1;border-radius:10px;background:#fffdf9;padding:10px 12px;">
                           <p style="margin:0 0 6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#745431;">{{ $assignmentInfoLine['label'] }}</p>
                           <p style="margin:0;color:#2b2115;font-size:18px;line-height:1.45;font-weight:600;word-break:break-word;">{{ $assignmentInfoLine['value'] }}</p>
                        </div>
                     @endforeach

                     <div style="border:1px solid #d9c3a1;border-radius:10px;background:#fffdf9;padding:10px 12px;">
                        <p style="margin:0 0 6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#745431;">Det du skrev i oppdraget</p>
                        <p style="margin:0;color:#2b2115;font-size:16px;line-height:1.5;font-weight:500;white-space:pre-wrap;">{{ !empty($assignmentDescription) ? $assignmentDescription : 'Ingen beskrivelse registrert på dette oppdraget.' }}</p>
                     </div>
                  </div>
               </div>
            </div>
         @endif

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
