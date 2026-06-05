@php
   $senderType = data_get($enquiry, 'sender_type');
   $message = data_get($enquiry, 'message');
   $images = data_get($enquiry, 'images');
   $createdAt = data_get($enquiry, 'created_at');
   $messageId = (int) data_get($enquiry, 'id');
   $timestamp = $createdAt ? strtotime($createdAt) : time();
   $dayKey = date('Y-m-d', $timestamp);
   $weekdayLabels = [
      1 => 'Mandag',
      2 => 'Tirsdag',
      3 => 'Onsdag',
      4 => 'Torsdag',
      5 => 'Fredag',
      6 => 'Lørdag',
      7 => 'Søndag',
   ];
   $todayStart = strtotime(date('Y-m-d'));
   $messageDayStart = strtotime(date('Y-m-d', $timestamp));
   $daysAgo = (int) floor(($todayStart - $messageDayStart) / 86400);
   if($daysAgo >= 0 && $daysAgo < 7){
      $weekdayNumber = (int) date('N', $timestamp);
      $dayLabel = $weekdayLabels[$weekdayNumber] ?? date('j.n.Y', $timestamp);
   }else{
      $dayLabel = date('j.n.Y', $timestamp);
   }
   $timeLabel = date('H:i', $timestamp);
   $messageText = trim((string)$message);
   $isCustomer = $senderType === 'Customer';
   $roleClass = $isCustomer ? 'customer' : 'vendor';
   $vendorNameLabel = trim((string)($vendorLabel ?? ''));
   if($vendorNameLabel === ''){
      $vendorNameLabel = 'Leverandør';
   }
@endphp

<div class="chat-item {{ $roleClass }}" data-message-id="{{ $messageId }}" data-day-key="{{ $dayKey }}" data-day-label="{{ $dayLabel }}">
   <div class="chat-bubble">
      @if(!$isCustomer)
         <span class="chat-author">{{ $vendorNameLabel }}</span>
      @endif
      @if($messageText !== '')
         <div class="chat-text">{{ $message }}</div>
      @endif

      @if($images!="")
         @php $imagesArr = explode(',', $images); @endphp
         <div class="chat-media-list">
            @foreach($imagesArr as $image)
               @if($image!="")
                  <a href="{{ url('front/images/enquiries_images/'.$image) }}" target="_blank">
                     <img class="msg-reply-img" src="{{ asset('front/images/enquiries_images/'.$image) }}" alt="Vedlegg">
                  </a>
               @endif
            @endforeach
         </div>
      @endif

      <span class="chat-time">{{ $timeLabel }}</span>
   </div>
</div>
