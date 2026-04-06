@php
   $rows = $renderEnquiries ?? [];
@endphp

@forelse($rows as $key => $enquiry)
   @php
      $messageType = $enquiry['messageType'] ?? 'Direkte';
      $isAssignment = $messageType === 'Oppdrag';
      $isGroupedAssignment = !empty($enquiry['is_grouped_assignment']) && !$isMobileList;
      $lastActivityDate = $enquiry['last_message_at'] ?? ($enquiry['updated_at'] ?? $enquiry['created_at'] ?? null);
      $displayDate = !empty($lastActivityDate) ? date('d.m.y, H:i', strtotime($lastActivityDate)) : '';
      $conversationUrl = url('user/enquiries/'.$enquiry['id']);
      $assignmentOverviewUrl = url('user/enquiries/'.$enquiry['id'].'/overview');
      $selectedParams = [
         'selected_enquiry_id' => (int)($enquiry['id'] ?? 0),
      ];
      if(!empty($message_type)){
         $selectedParams['message_type'] = $message_type;
      }
      if(isset($active_close) && $active_close !== ''){
         $selectedParams['active_close'] = $active_close;
      }
      if(!empty($enqCat)){
         $selectedParams['cat'] = $enqCat;
      }
      $desktopSelectUrl = url('user/enquiries').'?'.http_build_query($selectedParams);
      $cardPrimaryUrl = $isMobileList
         ? (($isAssignment && ($isGroupedAssignment || $isAssignmentTab)) ? $assignmentOverviewUrl : $conversationUrl)
         : $desktopSelectUrl;
      $showStatusActions = $isAssignmentTab || !$isAssignment;
      $categoryName = $enquiry['product']['category']['category_name'] ?? 'Kategori';
      $categoryImage = !empty($enquiry['product']['category_id']) ? \App\Models\Category::getCategoryImage($enquiry['product']['category_id']) : '';
      $categoryImageUrl = !empty($categoryImage) ? asset('front/images/category_images/'.$categoryImage) : asset('front/images/profile.png');
      $previewSource = !empty($enquiry['response']) ? $enquiry['response'] : 'Ingen ny melding ennå, åpne dialogen for detaljer.';
      $previewText = \Illuminate\Support\Str::limit(strip_tags($previewSource), 95);
      $vendorResponseCount = (int)($enquiry['vendorResponseCount'] ?? 0);
      $newVendorCount = (int)($enquiry['newVendorCount'] ?? 0);
      $newMessageCount = (int)($enquiry['newMessageCount'] ?? 0);
      $rowTitle = $enquiry['groupTitle'] ?? ($enquiry['product']['product_name'] ?? 'Ukjent leverandør');
      $isSelected = !$isMobileList && (int)($selectedEnquiryId ?? 0) === (int)($enquiry['id'] ?? 0);
   @endphp

   <div class="message-item {{ ($enquiry['status'] ?? 0) == 0 ? 'is-completed' : '' }} {{ $isAssignment ? 'is-assignment' : 'is-direct' }} {{ $isAssignmentTab ? 'is-assignment-tab' : '' }} {{ $isSelected ? 'is-selected' : '' }}">
      <div>
         <img class="message-brand" src="{{ $categoryImageUrl }}" alt="{{ $categoryName }}">
      </div>
      <div>
         <div class="message-vendor-head">
            <h5 class="message-vendor-title">
               <a href="{{ $cardPrimaryUrl }}">{{ $rowTitle }}</a>
            </h5>
            @if((int)($enquiry['status'] ?? 0) === 0)
               <span class="message-status-chip closed">Fullført</span>
            @endif
            @if(!empty($enquiry['unreadCount']) && (int)$enquiry['unreadCount'] > 0)
               <span class="message-unread">{{ (int)$enquiry['unreadCount'] }}</span>
            @endif
         </div>

         <p class="message-preview">{{ $previewText }}</p>

         @if($isAssignment)
            <div class="assignment-summary">
               <strong>{{ $vendorResponseCount }} samtaler</strong>
               @if($newVendorCount > 0 || $newMessageCount > 0)
                  <div class="assignment-alerts">
                     @if($newVendorCount > 0)
                        <span class="assignment-alert new-vendor">Ny leverandør</span>
                     @endif
                     @if($newMessageCount > 0)
                        <span class="assignment-alert new-message">Ny melding</span>
                     @endif
                  </div>
               @endif
            </div>
         @endif

         <div class="message-vendor-meta">
            <span class="meta-item">
               @if(!empty($categoryImage))
                  <img class="message-category-icon" src="{{ asset('front/images/category_images/'.$categoryImage) }}" alt="{{ $categoryName }}">
               @else
                  <i class="fa fa-tag"></i>
               @endif
               {{ $categoryName }}
            </span>
            @if(!empty($displayDate))
               <span class="meta-item"><i class="fa fa-calendar"></i>{{ $displayDate }}</span>
            @endif
         </div>
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
            @if($isGroupedAssignment)
               @if($isMobileList)
                  <a class="message-open-link assignment" href="{{ $assignmentOverviewUrl }}">Åpne oppdrag</a>
               @else
                  <a class="message-open-link assignment" href="{{ $desktopSelectUrl }}">Åpne chat</a>
                  <a class="message-open-link view" href="{{ $assignmentOverviewUrl }}">Se tråder</a>
               @endif
            @elseif($isAssignment && $isMessagesTab)
               @if($isMobileList)
                  <a class="message-open-link view" href="{{ $assignmentOverviewUrl }}">Åpne oppdrag</a>
                  <a class="message-open-link assignment" href="{{ $conversationUrl }}">Åpne melding</a>
               @else
                  <a class="message-open-link assignment" href="{{ $desktopSelectUrl }}">Åpne chat</a>
                  <a class="message-open-link view" href="{{ $assignmentOverviewUrl }}">Se oppdrag</a>
               @endif
            @else
               @if($isAssignment)
                  @if((int)($enquiry['status'] ?? 0) === 1)
                     <a class="updateEnquiryStatus enquiry-complete-btn message-open-link view" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" data-item-label="assignment" href="javascript:void(0)"><i class="status-marker" status="Active"></i><i class="fa fa-check-circle" style="margin-right:7px;"></i>Fullfør oppdrag</a>
                     <a class="message-open-link assignment" href="{{ $isMobileList ? $assignmentOverviewUrl : $desktopSelectUrl }}">{{ $isMobileList ? 'Åpne oppdrag' : 'Åpne chat' }}</a>
                  @else
                     <a class="message-open-link view" href="{{ $isMobileList ? $assignmentOverviewUrl : $desktopSelectUrl }}">{{ $isMobileList ? 'Se oppdragshistorikk' : 'Se chat' }}</a>
                  @endif
               @else
                  <a class="message-open-link assignment" href="{{ $isMobileList ? $conversationUrl : $desktopSelectUrl }}">{{ $isMobileList ? 'Åpne melding' : 'Åpne chat' }}</a>
               @endif
            @endif
         </div>

         @if($showStatusActions && !$isAssignment)
            <div class="message-toggles">
               @if((int)($enquiry['status'] ?? 0) === 1)
                  <a class="updateEnquiryStatus enquiry-complete-btn" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" data-item-label="conversation" href="javascript:void(0)"><i class="status-marker" status="Active"></i><i class="fa fa-check-circle" style="margin-right:7px;"></i>Avslutt samtale</a>
               @else
                  <a class="deleteEnquiry delete-enquiry-btn" enquiry_id="{{ $enquiry['id'] }}" data-item-label="conversation" href="javascript:void(0)"><i class="fa fa-trash" style="margin-right:7px;"></i>Fjern samtale</a>
               @endif
            </div>
         @endif
      </div>
   </div>
@empty
   <div class="message-empty">Ingen meldinger funnet med valgt filter.</div>
@endforelse
