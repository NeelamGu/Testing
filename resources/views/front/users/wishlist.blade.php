<?php
use App\Models\Product;
use App\Models\Category;
?>
@extends('front.layout.layout')
@section('content')
<style>
   .customer-panel-shell {
      background: transparent;
      border: none;
      border-radius: 0;
      padding: 0;
      margin-top: 4px;
   }
   .customer-panel-main {
      background: #fff;
      border: 1px solid #efe1ce;
      border-radius: 12px;
      box-shadow: 0 12px 28px rgba(67, 47, 20, 0.08);
      overflow: hidden;
   }
   .customer-panel-header {
      padding: 18px 20px;
      border-bottom: 1px solid #f0e4d3;
      background: linear-gradient(120deg, #fff6e8, #fff);
      display: block;
   }
   .customer-panel-header h3 {
      margin: 0;
      font-size: 24px;
      color: #2f2516;
      font-weight: 700;
      line-height: 1.1;
   }
   .customer-panel-header p {
      margin: 8px 0 0;
      color: #746652;
      font-size: 13px;
      line-height: 1.35;
      max-width: 520px;
   }
   .customer-panel-body {
      padding: 16px;
   }
   .favorites-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 240px));
      justify-content: flex-start;
      gap: 16px;
   }
   .favorite-card {
      border: 1px solid #efdfca;
      border-radius: 22px;
      overflow: hidden;
      background: #fbf7f1;
      box-shadow: 0 8px 18px rgba(52, 35, 12, 0.08);
      width: 100%;
      max-width: 240px;
      transition: transform 0.16s ease, box-shadow 0.16s ease;
   }
   .favorite-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(52, 35, 12, 0.12);
   }
   .favorite-thumb {
      position: relative;
      height: 152px;
      overflow: hidden;
      background: #e9e1d5;
   }
   .favorite-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }
   .favorite-thumb > a:not(.favorite-remove) {
      display: block;
      width: 100%;
      height: 100%;
   }
   .favorite-chip {
      position: absolute;
      left: 10px;
      bottom: 10px;
      display: inline-flex;
      align-items: center;
      min-height: 24px;
      padding: 3px 11px;
      border-radius: 999px;
      background: rgba(255, 251, 245, 0.94);
      border: 1px solid #eadbc7;
      color: #9d6a20;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
   }
   .favorite-remove {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: var(--customer-panel-accent, #d84c4c);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      border: 1px solid var(--customer-panel-accent, #d84c4c);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 3;
      touch-action: manipulation;
      -webkit-tap-highlight-color: transparent;
      transition: background-color 0.16s ease, color 0.16s ease, border-color 0.16s ease, transform 0.16s ease;
   }
   .favorite-remove i {
      pointer-events: none;
   }
   .favorite-remove:hover {
      transform: scale(1.03);
   }
   .favorite-remove.is-hollow {
      background: #fff;
      color: var(--customer-panel-accent, #d84c4c) !important;
      border-color: var(--customer-panel-accent, #d84c4c);
   }
   .favorite-card-body {
      padding: 14px 14px 12px;
   }
   .favorite-card-title {
      margin: 0 0 6px;
      font-size: 16px;
      font-weight: 700;
      color: #2f2516;
      line-height: 1.2;
      min-height: 38px;
   }
   .favorite-card-meta {
      font-size: 13px;
      color: #7d6e5b;
      margin-bottom: 12px;
      font-weight: 600;
   }
   .favorite-category {
      display: none;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      color: #675744;
      margin-bottom: 10px;
   }
   .favorite-category img {
      width: 16px;
      height: 16px;
      object-fit: contain;
   }
   .customer-panel-body .favorite-link {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      min-height: 44px;
      border-radius: 12px;
      padding: 8px 12px;
      background: #ede6dc !important;
      border: 1px solid #e2d6c6 !important;
      color: #4f4435 !important;
      font-weight: 700;
      font-size: 14px;
      text-decoration: none !important;
   }
   .customer-panel-body .favorite-link i {
      margin-left: 8px;
      font-size: 11px;
   }
   .customer-panel-body .favorite-link:hover {
      background: #e5ddd2 !important;
      color: #3f3528 !important;
   }
   .empty-favorites {
      border: 1px dashed #dcc5a4;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      color: #746652;
      background: #fffaf3;
   }
   @media (max-width: 991px) {
      .favorites-grid {
         grid-template-columns: repeat(auto-fill, minmax(205px, 1fr));
      }
      .customer-panel-header h3 {
         font-size: 22px;
      }
      .customer-panel-header p {
         font-size: 13px;
      }
   }
   @media (max-width: 767px) {
      .customer-panel-shell {
         padding: 10px;
      }
      .favorites-grid {
         grid-template-columns: 1fr;
      }
      .favorite-card {
         max-width: 100%;
      }
      .customer-panel-header {
         padding: 14px;
      }
      .customer-panel-header h3 {
         font-size: 20px;
      }
      .customer-panel-header p {
         font-size: 13px;
      }
   }
</style>

<div class="page-wrapper">
   @include('front.users.partials.topbar', ['activeTopTab' => 'favorites'])
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'wishlist'])
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="customer-panel-shell">
                  <div class="customer-panel-main">
                     <div class="customer-panel-header">
                        <h3>Favoritter</h3>
                     </div>
                     <div class="customer-panel-body">
                        @if(Session::has('flash_message_success'))
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                              {{ Session::get('flash_message_success') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                        @endif

                        @if(Session::has('flash_message_error'))
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {{ Session::get('flash_message_error') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                        @endif

                        @if(count($wishlists) > 0)
                           <div class="favorites-grid">
                              @foreach($wishlists as $wishlist)
                                 @php
                                    $productName = $wishlist['product']['product_name'] ?? '';
                                    $productId = $wishlist['product']['id'] ?? 0;
                                    $getProductURL = $productName ? Product::productURL($productName) : '';
                                    $productImage = $wishlist['product']['product_image'] ?? '';
                                    $productImagePath = 'front/images/product_images/small/'.$productImage;
                                    $categoryImage = isset($wishlist['product']['category_id']) ? Category::getCategoryImage($wishlist['product']['category_id']) : '';
                                    $categoryName = isset($wishlist['product']['category_id']) ? Category::getCategoryName($wishlist['product']['category_id']) : '';
                                 @endphp
                                 <div class="favorite-card">
                                    <div class="favorite-thumb">
                                       @if($productId > 0)
                                          <a href="{{ url('product/'.$getProductURL.'/'.$productId) }}">
                                             @if(!empty($productImage) && file_exists($productImagePath))
                                                <img src="{{ asset('front/images/product_images/large/'.$productImage) }}" alt="{{ $productName }}">
                                             @else
                                                <img src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="{{ $productName }}">
                                             @endif
                                          </a>
                                       @endif
                                       @if(!empty($categoryName))
                                          <span class="favorite-chip">{{ $categoryName }}</span>
                                       @endif
                                       <a href="{{ url('user/remove-wishlist/'.$wishlist['id']) }}" class="favorite-remove" data-remove-url="{{ url('user/remove-wishlist/'.$wishlist['id']) }}" title="Favoritt" aria-pressed="false">
                                          <i class="fa fa-heart" aria-hidden="true"></i>
                                       </a>
                                    </div>
                                    <div class="favorite-card-body">
                                       <h4 class="favorite-card-title">{{ $productName }}</h4>
                                       <div class="favorite-card-meta">
                                          <i class="fa fa-map-marker"></i>
                                          {{ ucfirst(strtolower($wishlist['product']['city'] ?? 'Ukjent sted')) }}
                                       </div>
                                       <div class="favorite-category">
                                          @if(!empty($categoryImage))
                                             <img src="{{ asset('front/images/category_images/'.$categoryImage) }}" alt="{{ $categoryName }}">
                                          @else
                                             <img src="{{ asset('front/images/icons/curtains.png') }}" alt="Kategori">
                                          @endif
                                          <span>{{ $categoryName }}</span>
                                       </div>
                                       @if($productId > 0)
                                          <a class="favorite-link" href="{{ url('product/'.$getProductURL.'/'.$productId) }}">Se leverandør <i class="fa fa-arrow-right"></i></a>
                                       @endif
                                    </div>
                                 </div>
                              @endforeach
                           </div>
                        @else
                           <div class="empty-favorites">
                              Ingen favoritter ennå. Utforsk leverandører og klikk på hjertet for å lagre dem her.
                           </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   document.addEventListener('click', function (event) {
      var button = event.target.closest('.favorite-remove');
      if (!button) {
         return;
      }

      event.preventDefault();
      event.stopPropagation();

      if (button.classList.contains('is-processing') || button.classList.contains('is-hollow')) {
         return;
      }

      var removeUrl = button.getAttribute('data-remove-url') || button.getAttribute('href');
      if (!removeUrl || removeUrl === '#') {
         return;
      }

      button.classList.add('is-processing', 'is-hollow');
      button.setAttribute('aria-pressed', 'true');
      button.setAttribute('title', 'Ikke favoritt');

      var icon = button.querySelector('i');
      if (icon) {
         icon.classList.remove('fa-heart');
         icon.classList.add('fa-heart-o');
      }

      fetch(removeUrl, {
         method: 'GET',
         credentials: 'same-origin',
         headers: {
            'X-Requested-With': 'XMLHttpRequest'
         }
      })
         .then(function (response) {
            if (!response.ok) {
               throw new Error('Request failed');
            }
            button.classList.remove('is-processing');
         })
         .catch(function () {
            button.classList.remove('is-processing', 'is-hollow');
            button.setAttribute('aria-pressed', 'false');
            button.setAttribute('title', 'Favoritt');
            if (icon) {
               icon.classList.remove('fa-heart-o');
               icon.classList.add('fa-heart');
            }
         });
   }, { passive: false });
</script>
@endsection
