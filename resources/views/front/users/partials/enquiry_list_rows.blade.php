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
      $categoryName = $enquiry['product']['category']['category_name'] ?? 'Kategori';
      $categoryImage = !empty($enquiry['product']['category_id']) ? \App\Models\Category::getCategoryImage($enquiry['product']['category_id']) : '';
      $categoryImageUrl = !empty($categoryImage) ? asset('front/images/category_images/'.$categoryImage) : asset('front/images/profile.png');
      $previewSource = !empty($enquiry['response']) ? $enquiry['response'] : 'Ingen ny melding ennå, åpne dialogen for detaljer.';
      $previewText = \Illuminate\Support\Str::limit(strip_tags($previewSource), 95);
      $vendorResponseCount = (int)($enquiry['vendorResponseCount'] ?? 0);
      $rowTitle = $enquiry['groupTitle'] ?? ($enquiry['product']['product_name'] ?? 'Ukjent leverandør');
      $isSelected = !$isMobileList && (int)($selectedEnquiryId ?? 0) === (int)($enquiry['id'] ?? 0);
      $isCompleted = (int)($enquiry['status'] ?? 0) === 0;
      $unreadCount = (int)($enquiry['unreadCount'] ?? 0);
   @endphp

   <a href="{{ $cardPrimaryUrl }}" class="enquiry-row-link {{ $isAssignment ? 'is-assignment' : 'is-direct' }} {{ $isCompleted ? 'is-completed' : '' }} {{ $isSelected ? 'is-selected' : '' }}">
      <div class="enquiry-row-avatar">
         <img src="{{ $categoryImageUrl }}" alt="{{ $categoryName }}" class="enquiry-avatar-image">
      </div>

      <div class="enquiry-row-main">
         <div class="enquiry-row-top">
            <h5 class="enquiry-row-title">{{ $rowTitle }}</h5>
            @if(!empty($displayDate))
               <span class="enquiry-row-date">{{ $displayDate }}</span>
            @endif
         </div>

         <p class="enquiry-row-preview">{{ $previewText }}</p>

         @if($isAssignment)
            <p class="enquiry-row-submeta">{{ $vendorResponseCount }} samtaler</p>
         @endif

         <div class="enquiry-row-meta">
            <span class="meta-item">
               @if(!empty($categoryImage))
                  <img class="message-category-icon" src="{{ asset('front/images/category_images/'.$categoryImage) }}" alt="{{ $categoryName }}">
               @else
                  <i class="fa fa-tag"></i>
               @endif
               {{ $categoryName }}
            </span>
         </div>
      </div>

      <div class="enquiry-row-side">
         @if($isAssignment)
            <span class="type-chip assignment">Oppdrag</span>
         @else
            <span class="type-chip direct">Direkte</span>
         @endif

         @if($isCompleted)
            <span class="badge-fullfort">Fullført</span>
         @endif

         @if($unreadCount > 0)
            <span class="badge-unread">{{ $unreadCount }}</span>
         @endif
      </div>
   </a>
@empty
   <div class="enquiry-empty-state">Ingen meldinger funnet med valgt filter.</div>
@endforelse
