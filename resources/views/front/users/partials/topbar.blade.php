@php
   $activeTopTab = $activeTopTab ?? 'assignments';
   $topbarProfileImageRelativePath = 'front/images/user_images/profile-'.(Auth::id() ?? 0).'.jpg';
   $topbarProfileImageAbsolutePath = public_path($topbarProfileImageRelativePath);
   $topbarProfileImageUrl = (Auth::check() && file_exists($topbarProfileImageAbsolutePath))
      ? asset($topbarProfileImageRelativePath).'?v='.filemtime($topbarProfileImageAbsolutePath)
      : asset('front/images/profile.png');
@endphp

<style>
   .customer-topbar {
       border-bottom: none;
       background: linear-gradient(180deg, rgba(244, 239, 231, 0.95), rgba(246, 242, 235, 0.9));
      margin-bottom: 14px;
      position: relative;
      z-index: 40;
   }
   .customer-topbar .topbar-inner {
      max-width: 1180px;
      margin: 0 auto;
      padding: 10px 16px;
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      gap: 10px;
   }
   .customer-topbar .brand {
      display: inline-flex;
      align-items: center;
      margin: 0;
   }
   .customer-topbar .brand a {
      text-decoration: none !important;
      display: inline-flex;
      align-items: center;
   }
   .customer-topbar .brand img {
      width: 170px;
      height: auto;
      display: block;
   }
   .customer-topbar .center-nav {
      display: inline-flex;
      align-items: center;
      gap: 20px;
      justify-self: center;
   }
   .customer-topbar .center-nav a {
      font-size: 15px;
      font-weight: 600;
      color: #000;
      text-decoration: none !important;
      border-bottom: 2px solid transparent;
      padding-bottom: 4px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s ease, border-color 0.2s ease;
   }
   .customer-topbar .center-nav a i {
      font-size: 13px;
      line-height: 1;
      opacity: 0.88;
   }
   .customer-topbar .center-nav a.is-active,
   .customer-topbar .center-nav a:hover {
      color: #000;
      border-color: #b26407;
   }
   .customer-topbar .right-actions {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      justify-self: end;
   }
   .customer-topbar .right-actions a,
   .customer-topbar .right-actions button {
      color: #6a6258;
      text-decoration: none !important;
      position: relative;
   }
   .customer-topbar .avatar {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
      border: 1px solid rgba(211, 191, 162, 0.72);
   }
   .customer-topbar .profile-menu {
      position: relative;
      display: inline-flex;
      align-items: center;
   }
   .customer-topbar .profile-menu-toggle {
      border: 0;
      background: transparent;
      padding: 0;
      display: inline-flex;
      align-items: center;
      cursor: pointer;
   }
   .customer-topbar .profile-menu-toggle:focus {
      outline: none;
   }
   .customer-topbar .profile-dropdown {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      min-width: 130px;
       border: none;
       border-radius: 10px;
       background: linear-gradient(180deg, rgba(255, 255, 255, 0.97), rgba(251, 252, 255, 0.95));
       box-shadow: 0 10px 28px rgba(78, 58, 30, 0.12);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-4px);
      transition: opacity 0.16s ease, transform 0.16s ease, visibility 0.16s ease;
      z-index: 30;
      overflow: hidden;
   }
   .customer-topbar .profile-menu.is-open .profile-dropdown {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
   }
   .customer-topbar .profile-dropdown a {
      display: block;
      padding: 10px 14px;
      font-size: 14px;
      font-weight: 600;
      color: #5d5246;
      line-height: 1.2;
      text-decoration: none !important;
   }
   .customer-topbar .profile-dropdown a:hover {
      background: #f7efe2;
      color: #b26407;
   }
   .contact-section.account-page.customer-panel-switch-out {
      opacity: 0;
      transform: translateY(6px) scale(0.995);
      transition: opacity 0.18s cubic-bezier(0.22, 1, 0.36, 1), transform 0.18s cubic-bezier(0.22, 1, 0.36, 1);
      will-change: opacity, transform;
   }
   .contact-section.account-page.customer-panel-switch-in {
      opacity: 0;
      transform: translateY(6px) scale(0.995);
      will-change: opacity, transform;
   }
   .contact-section.account-page.customer-panel-switch-in.customer-panel-switch-ready {
      opacity: 1;
      transform: translateY(0);
      transition: opacity 0.26s cubic-bezier(0.22, 1, 0.36, 1), transform 0.26s cubic-bezier(0.22, 1, 0.36, 1);
   }
   .contact-section.account-page.customer-panel-switch-out-lite {
      opacity: 0;
      transition: opacity 0.14s ease-out;
      will-change: opacity;
   }
   .contact-section.account-page.customer-panel-switch-in-lite {
      opacity: 0;
      will-change: opacity;
   }
   .contact-section.account-page.customer-panel-switch-in-lite.customer-panel-switch-ready {
      opacity: 1;
      transition: opacity 0.18s ease-out;
   }
   .contact-section.account-page.customer-panel-loading {
      pointer-events: none;
   }
   @media (prefers-reduced-motion: reduce) {
      .contact-section.account-page.customer-panel-switch-out,
      .contact-section.account-page.customer-panel-switch-in,
      .contact-section.account-page.customer-panel-switch-in.customer-panel-switch-ready,
      .contact-section.account-page.customer-panel-switch-out-lite,
      .contact-section.account-page.customer-panel-switch-in-lite,
      .contact-section.account-page.customer-panel-switch-in-lite.customer-panel-switch-ready {
         transition: none !important;
         transform: none !important;
      }
   }
   @media (max-width: 991px) {
      .customer-topbar .topbar-inner {
         grid-template-columns: 1fr;
         justify-items: center;
         gap: 8px;
      }

      .customer-topbar .center-nav {
         width: 100%;
         justify-content: center;
         gap: 10px;
         flex-wrap: wrap;
         overflow: visible;
         white-space: normal;
         padding-bottom: 0;
      }

      .customer-topbar .center-nav a {
         flex: 0 0 auto;
         min-height: 38px;
         display: inline-flex;
         align-items: center;
         gap: 6px;
         font-size: 14px;
      }

      .customer-topbar .right-actions {
         justify-self: center;
      }
   }
   @media (max-width: 767px) {
      .customer-topbar {
         position: sticky;
         top: 0;
         margin-bottom: 8px;
         border-bottom: none;
         background: rgba(244, 239, 231, 0.92);
         backdrop-filter: blur(8px);
         -webkit-backdrop-filter: blur(8px);
      }

      .customer-topbar .topbar-inner {
         position: relative;
         grid-template-columns: 1fr;
         padding: 10px 12px 12px;
         row-gap: 8px;
      }

      .customer-topbar .brand img {
         width: 138px;
      }

      .customer-topbar .brand {
         justify-self: center;
         width: 100%;
      }

      .customer-topbar .center-nav {
         display: inline-flex;
         grid-column: 1;
         width: 100%;
         gap: 6px;
         justify-content: center;
         flex-wrap: nowrap;
         overflow-x: auto;
         overflow-y: hidden;
         white-space: nowrap;
         padding-bottom: 0;
         -webkit-overflow-scrolling: touch;
         scrollbar-width: none;
      }

      .customer-topbar .center-nav::-webkit-scrollbar {
         display: none;
      }

      .customer-topbar .center-nav a {
         flex: 0 0 auto;
         min-width: 0;
         min-height: 34px;
         padding: 7px 6px;
         border-radius: 999px;
         border: none;
         border-bottom: none;
         background: rgba(255, 250, 244, 0.85);
         box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
         font-size: 12px;
         line-height: 1;
         justify-content: center;
         gap: 4px;
      }
      .customer-topbar .center-nav a i {
         font-size: 12px;
      }

      .customer-topbar .center-nav a.is-active {
         border: none;
         background: var(--customer-panel-accent, #a65f03);
         color: var(--customer-panel-accent-contrast, #ffffff) !important;
         box-shadow: 0 4px 12px rgba(166, 93, 4, 0.18);
      }

      .customer-topbar .center-nav a:hover {
         color: #000;
         border: none;
      }

      .customer-topbar .right-actions {
         position: absolute;
         top: 10px;
         right: 12px;
         justify-self: auto;
      }

      .customer-topbar .avatar {
         width: 34px;
         height: 34px;
      }

      .customer-topbar .profile-dropdown {
         min-width: 150px;
         top: calc(100% + 8px);
      }
   }
</style>

<div class="customer-topbar">
   <div class="topbar-inner">
      <h1 class="brand"><a href="{{ url('/') }}"><img src="{{ asset('front/images/logo5.png') }}" alt="Samling.no"></a></h1>
      <nav class="center-nav">
         <a href="{{ url('user/wishlist') }}" class="js-customer-panel-link {{ $activeTopTab === 'favorites' ? 'is-active' : '' }}"><i class="fa fa-heart" aria-hidden="true"></i>Favoritter</a>
         <a href="{{ url('user/enquiries?message_type=assignment') }}" class="js-customer-panel-link {{ $activeTopTab === 'assignments' ? 'is-active' : '' }}"><i class="fa fa-briefcase" aria-hidden="true"></i>Oppdrag</a>
         <a href="{{ url('user/enquiries') }}" class="js-customer-panel-link {{ $activeTopTab === 'messages' ? 'is-active' : '' }}"><i class="fa fa-comments" aria-hidden="true"></i>Meldinger</a>
         <a href="{{ url('user/account') }}" class="js-customer-panel-link {{ $activeTopTab === 'profile' ? 'is-active' : '' }}"><i class="fa fa-user" aria-hidden="true"></i>Profil</a>
      </nav>
      <div class="right-actions">
         <div class="profile-menu" id="topbarProfileMenu">
            <button
               type="button"
               class="profile-menu-toggle"
               id="topbarProfileMenuToggle"
               aria-haspopup="true"
               aria-expanded="false"
               aria-controls="topbarProfileDropdown"
               title="Profilmeny"
            >
               <img id="topbarAvatarImage" class="avatar" src="{{ $topbarProfileImageUrl }}" alt="Profil">
            </button>
            <div class="profile-dropdown" id="topbarProfileDropdown" role="menu" aria-hidden="true">
               <a href="{{ url('user/logout') }}" role="menuitem">Logg ut</a>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   (function () {
      var menu = document.getElementById('topbarProfileMenu');
      var toggle = document.getElementById('topbarProfileMenuToggle');
      var dropdown = document.getElementById('topbarProfileDropdown');

      if (!menu || !toggle || !dropdown) {
         return;
      }

      function setMenuState(isOpen) {
         if (isOpen) {
            menu.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
            dropdown.setAttribute('aria-hidden', 'false');
         } else {
            menu.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            dropdown.setAttribute('aria-hidden', 'true');
         }
      }

      toggle.addEventListener('click', function (event) {
         event.preventDefault();
         event.stopPropagation();
         setMenuState(!menu.classList.contains('is-open'));
      });

      document.addEventListener('click', function (event) {
         if (!menu.contains(event.target)) {
            setMenuState(false);
         }
      });

      document.addEventListener('keydown', function (event) {
         if (event.key === 'Escape') {
            setMenuState(false);
         }
      });
   })();

   (function () {
      if (window.__customerPanelNavigationBound) {
         return;
      }
      window.__customerPanelNavigationBound = true;

      var isNavigating = false;
      var panelHtmlCache = new Map();
      var panelRequestCache = new Map();

      function getPanelCacheKey(urlValue) {
         try {
            return new URL(urlValue, window.location.origin).toString();
         } catch (error) {
            return String(urlValue || '');
         }
      }

      function shouldBypassPanelCache(urlValue) {
         try {
            var parsedUrl = new URL(urlValue, window.location.origin);
            var normalizedPath = normalizePath(parsedUrl.pathname);
            return normalizedPath === '/user/enquiries' || normalizedPath === '/user/wishlist';
         } catch (error) {
            return false;
         }
      }

      function normalizePath(path) {
         var nextPath = String(path || '/');
         if (nextPath.length > 1 && nextPath.charAt(nextPath.length - 1) === '/') {
            nextPath = nextPath.slice(0, -1);
         }
         return nextPath;
      }

      function getTabTypeFromUrl(urlValue) {
         var parsedUrl;
         try {
            parsedUrl = new URL(urlValue, window.location.origin);
         } catch (error) {
            return '';
         }

         var normalizedPath = normalizePath(parsedUrl.pathname);
         if (normalizedPath === '/user/account') {
            return 'profile';
         }
         if (normalizedPath === '/user/wishlist') {
            return 'favorites';
         }
         if (normalizedPath === '/user/enquiries') {
            return parsedUrl.searchParams.get('message_type') === 'assignment' ? 'assignments' : 'messages';
         }

         return '';
      }

      function enforceTopbarLinkOrder() {
         var nav = document.querySelector('.customer-topbar .center-nav');
         if (!nav) {
            return;
         }

         var preferredOrder = ['favorites', 'assignments', 'messages', 'profile'];
         var topLinks = nav.querySelectorAll('.js-customer-panel-link');
         if (!topLinks.length) {
            return;
         }

         var linkByType = {};
         for (var i = 0; i < topLinks.length; i++) {
            var link = topLinks[i];
            var type = getTabTypeFromUrl(link.href || '');
            if (type && !linkByType[type]) {
               linkByType[type] = link;
            }
         }

         for (var j = 0; j < preferredOrder.length; j++) {
            var tabType = preferredOrder[j];
            if (linkByType[tabType]) {
               nav.appendChild(linkByType[tabType]);
            }
         }
      }

      function getCurrentPanelTabType() {
         var activeTopLink = document.querySelector('.customer-topbar .js-customer-panel-link.is-active');
         if (activeTopLink && activeTopLink.href) {
            var activeTabType = getTabTypeFromUrl(activeTopLink.href);
            if (activeTabType) {
               return activeTabType;
            }
         }

         var currentPanel = document.querySelector('.contact-section.account-page');
         if (currentPanel && currentPanel.querySelector('.favorites-grid, .favorite-card')) {
            return 'favorites';
         }

         return getTabTypeFromUrl(window.location.href);
      }

      function samePanelUrl(urlValue) {
         var currentUrl = new URL(window.location.href);
         var nextUrl = new URL(urlValue, window.location.origin);
         return normalizePath(currentUrl.pathname) === normalizePath(nextUrl.pathname) && currentUrl.search === nextUrl.search;
      }

      function fetchPanelHtml(urlValue) {
         var cacheKey = getPanelCacheKey(urlValue);
         var bypassCache = shouldBypassPanelCache(urlValue);

         if (bypassCache) {
            return fetch(urlValue, {
               method: 'GET',
               headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'Cache-Control': 'no-cache'
               },
               cache: 'no-store',
               credentials: 'same-origin'
            }).then(function (response) {
               if (!response.ok) {
                  throw new Error('HTTP ' + response.status);
               }
               return response.text();
            });
         }

         if (panelHtmlCache.has(cacheKey)) {
            return Promise.resolve(panelHtmlCache.get(cacheKey));
         }

         if (panelRequestCache.has(cacheKey)) {
            return panelRequestCache.get(cacheKey);
         }

         var request = fetch(urlValue, {
            method: 'GET',
            headers: {
               'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
         })
            .then(function (response) {
               if (!response.ok) {
                  throw new Error('HTTP ' + response.status);
               }
               return response.text();
            })
            .then(function (html) {
               panelHtmlCache.set(cacheKey, html);
               panelRequestCache.delete(cacheKey);
               return html;
            })
            .catch(function (error) {
               panelRequestCache.delete(cacheKey);
               throw error;
            });

         panelRequestCache.set(cacheKey, request);
         return request;
      }

      function warmPanelCache(urlValue) {
         var tabType = getTabTypeFromUrl(urlValue);
         if (!tabType) {
            return;
         }

         fetchPanelHtml(urlValue).catch(function () {
            return null;
         });
      }

      function invalidatePanelCacheForTab(tabType) {
         if (!tabType) {
            return;
         }

         var cacheKeys = Array.from(panelHtmlCache.keys());
         for (var i = 0; i < cacheKeys.length; i++) {
            var key = cacheKeys[i];
            if (getTabTypeFromUrl(key) === tabType) {
               panelHtmlCache.delete(key);
            }
         }
      }

      function setActiveNavigation(tabType) {
         if (!tabType) {
            return;
         }

         enforceTopbarLinkOrder();

         var topLinks = document.querySelectorAll('.customer-topbar .js-customer-panel-link');
         for (var i = 0; i < topLinks.length; i++) {
            var topLink = topLinks[i];
            var isActiveTop = getTabTypeFromUrl(topLink.href) === tabType;
            topLink.classList.toggle('is-active', isActiveTop);
         }

         var sideLinks = document.querySelectorAll('.customer-panel-sidebar .js-customer-tab-link');
         for (var j = 0; j < sideLinks.length; j++) {
            var sideLink = sideLinks[j];
            var isActiveSide = getTabTypeFromUrl(sideLink.href) === tabType;
            sideLink.classList.toggle('is-active', isActiveSide);

            var sideLabel = sideLink.querySelector('p');
            if (sideLabel) {
               sideLabel.classList.toggle('active-list', isActiveSide);
            }
         }
      }

      function syncAccountTimelinePosition() {
         var timelineCard = document.querySelector('.timeline-card');
         var leftStack = document.querySelector('.profile-left-stack');
         var rightStack = document.querySelector('.profile-right-stack');
         if (!timelineCard || !leftStack || !rightStack) {
            return;
         }

         var isMobile = window.matchMedia('(max-width: 767px)').matches;
         if (isMobile) {
            if (timelineCard.parentNode !== leftStack) {
               leftStack.insertBefore(timelineCard, leftStack.firstChild);
            }
            timelineCard.classList.add('is-mobile-top');
            return;
         }

         if (timelineCard.parentNode !== rightStack) {
            rightStack.appendChild(timelineCard);
         }
         timelineCard.classList.remove('is-mobile-top');
      }

      function initAccountColorPreview() {
         var bgInput = document.getElementById('user-panel-bg-color');
         var accentInput = document.getElementById('user-panel-accent-color');
         if (!bgInput || !accentInput) {
            return;
         }

         function getAccentContrastColor(hexColor) {
            var safeHex = (hexColor || '#e78002').replace('#', '');
            if (!/^[0-9a-fA-F]{6}$/.test(safeHex)) {
               safeHex = 'e78002';
            }
            var red = parseInt(safeHex.substring(0, 2), 16);
            var green = parseInt(safeHex.substring(2, 4), 16);
            var blue = parseInt(safeHex.substring(4, 6), 16);
            var yiq = ((red * 299) + (green * 587) + (blue * 114)) / 1000;
            return yiq >= 160 ? '#111111' : '#f8fafc';
         }

         function applyPanelColors() {
            document.documentElement.style.setProperty('--customer-panel-bg', bgInput.value || '#f8f4ed');
            document.documentElement.style.setProperty('--customer-panel-accent', accentInput.value || '#e78002');
            document.documentElement.style.setProperty('--customer-panel-accent-contrast', getAccentContrastColor(accentInput.value));
         }

         if (bgInput.dataset.panelPreviewBound !== '1') {
            bgInput.dataset.panelPreviewBound = '1';
            bgInput.addEventListener('input', applyPanelColors);
            bgInput.addEventListener('change', applyPanelColors);
         }

         if (accentInput.dataset.panelPreviewBound !== '1') {
            accentInput.dataset.panelPreviewBound = '1';
            accentInput.addEventListener('input', applyPanelColors);
            accentInput.addEventListener('change', applyPanelColors);
         }

         var dots = document.querySelectorAll('.preset-dot');
         for (var i = 0; i < dots.length; i++) {
            var dot = dots[i];
            if (dot.dataset.presetBound === '1') {
               continue;
            }

            dot.dataset.presetBound = '1';
            dot.addEventListener('click', function () {
               var target = this.getAttribute('data-target');
               var value = this.getAttribute('data-value');
               if (!value) {
                  return;
               }

               if (target === 'bg') {
                  bgInput.value = value;
               } else if (target === 'accent') {
                  accentInput.value = value;
               }

               applyPanelColors();
            });
         }

         applyPanelColors();
      }

      function initReplyModalFix() {
         if (!window.jQuery || window.__customerReplyModalFixBound) {
            return;
         }

         window.__customerReplyModalFixBound = true;
         window.jQuery(document).on('show.bs.modal', '.replymodal', function () {
            var $modal = window.jQuery(this);
            if (!$modal.parent().is('body')) {
               $modal.appendTo('body');
            }
         });
      }

      function initFavoriteRemoveHandler() {
         if (window.__customerFavoriteRemoveBound) {
            return;
         }

         window.__customerFavoriteRemoveBound = true;
         var lastFavoriteTouchAt = 0;
         var syntheticFavoriteClickWindowMs = 550;

         function resolveFavoriteButton(event) {
            var target = event && event.target;
            if (!target || typeof target.closest !== 'function') {
               return null;
            }

            return target.closest('.favorite-remove');
         }

         function setFavoriteButtonState(button, isHollow) {
            var isFavorite = !isHollow;
            button.classList.toggle('is-hollow', isHollow);
            button.setAttribute('aria-pressed', isFavorite ? 'true' : 'false');
            button.setAttribute('title', isFavorite ? 'Fjern favoritt' : 'Legg til favoritt');

            var icon = button.querySelector('i');
            if (!icon) {
               return;
            }

            icon.classList.toggle('fa-heart', !isHollow);
            icon.classList.toggle('fa-heart-o', isHollow);
         }

         function requestFavoriteToggle(button) {
            var productId = parseInt(button.getAttribute('data-product-id') || '0', 10) || 0;
            if (productId <= 0) {
               return Promise.reject(new Error('Missing product id'));
            }

            var toggleUrl = button.getAttribute('data-toggle-url') || '/add-to-wishlist';
            var csrfMeta = document.querySelector('meta[name="csrf-token"]');
            var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
            var payload = new URLSearchParams();
            if (csrfToken) {
               payload.append('_token', csrfToken);
            }
            payload.append('proid', String(productId));

            return fetch(toggleUrl, {
               method: 'POST',
               credentials: 'same-origin',
               headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'Accept': 'application/json',
                  'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
               },
               body: payload.toString()
            }).then(function (response) {
               if (!response.ok) {
                  throw new Error('Request failed');
               }

               return response.json();
            });
         }

         function removeFavorite(button) {
            if (!button || button.classList.contains('is-processing')) {
               return;
            }

            var wasHollow = button.classList.contains('is-hollow');

            button.classList.add('is-processing');
            setFavoriteButtonState(button, !wasHollow);

            requestFavoriteToggle(button)
               .then(function (response) {
                  if (!response || response.status !== true) {
                     throw new Error('Request failed');
                  }

                  if (response.message === 'set') {
                     setFavoriteButtonState(button, false);
                  } else if (response.message === 'unset') {
                     setFavoriteButtonState(button, true);
                  }

                  button.classList.remove('is-processing');
                  invalidatePanelCacheForTab('favorites');
               })
               .catch(function () {
                  button.classList.remove('is-processing');
                  setFavoriteButtonState(button, wasHollow);
               });
         }

         document.addEventListener('touchend', function (event) {
            var button = resolveFavoriteButton(event);
            if (!button) {
               return;
            }

            lastFavoriteTouchAt = Date.now();
            event.preventDefault();
            event.stopPropagation();
            removeFavorite(button);
         }, { passive: false });

         document.addEventListener('click', function (event) {
            var button = resolveFavoriteButton(event);
            if (!button) {
               return;
            }

            event.preventDefault();
            event.stopPropagation();

            if ((Date.now() - lastFavoriteTouchAt) < syntheticFavoriteClickWindowMs) {
               return;
            }

            removeFavorite(button);
         }, { passive: false });
      }

      function initPanelEnhancements() {
         initReplyModalFix();
         initAccountColorPreview();
         initFavoriteRemoveHandler();
         syncAccountTimelinePosition();
      }

      function shouldUseLightweightTransition(currentPanel, fromTabType, toTabType) {
         if (!currentPanel || !toTabType) {
            return false;
         }

         if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return true;
         }

         if (fromTabType === 'favorites' && toTabType !== 'favorites') {
            return true;
         }

         var favoriteCardCount = currentPanel.querySelectorAll('.favorite-card').length;
         if (favoriteCardCount >= 6) {
            return true;
         }

         var imageCount = currentPanel.querySelectorAll('img').length;
         return imageCount >= 18 && currentPanel.scrollHeight > 1800;
      }

      function replaceDynamicPanelStyles(nextDocument) {
         var wrapper = nextDocument.querySelector('.page-wrapper');
         if (!wrapper) {
            return;
         }

         var styleSources = [];
         var previousNode = wrapper.previousElementSibling;

         while (previousNode && previousNode.tagName === 'STYLE') {
            styleSources.unshift(previousNode.textContent || '');
            previousNode = previousNode.previousElementSibling;
         }

         var oldDynamicStyles = document.querySelectorAll('style[data-customer-panel-style="1"]');
         for (var i = 0; i < oldDynamicStyles.length; i++) {
            oldDynamicStyles[i].parentNode.removeChild(oldDynamicStyles[i]);
         }

         for (var j = 0; j < styleSources.length; j++) {
            var cssText = styleSources[j];
            if (!cssText || !cssText.trim()) {
               continue;
            }

            var styleEl = document.createElement('style');
            styleEl.setAttribute('data-customer-panel-style', '1');
            styleEl.textContent = cssText;
            document.head.appendChild(styleEl);
         }
      }

      function swapPanelWithTransition(nextPanel, options, done) {
         if (typeof options === 'function') {
            done = options;
            options = {};
         }

         options = options || {};
         var useLightweightTransition = !!options.lightweight;
         var beforeSwap = typeof options.beforeSwap === 'function' ? options.beforeSwap : null;

         function runBeforeSwap() {
            if (beforeSwap) {
               beforeSwap();
               beforeSwap = null;
            }
         }

         var currentPanel = document.querySelector('.contact-section.account-page');
         if (!currentPanel || !currentPanel.parentNode) {
            runBeforeSwap();
            if (typeof done === 'function') {
               done();
            }
            return;
         }

         var panelParent = currentPanel.parentNode;
         var panelHeight = currentPanel.getBoundingClientRect().height;
         if (panelHeight > 0) {
            nextPanel.style.minHeight = panelHeight + 'px';
         }

         function completeSwap() {
            nextPanel.style.minHeight = '';
            if (typeof done === 'function') {
               done();
            }
         }

         if (!useLightweightTransition && typeof document.startViewTransition === 'function') {
            var viewTransition = document.startViewTransition(function () {
               runBeforeSwap();
               panelParent.replaceChild(nextPanel, currentPanel);
            });

            viewTransition.finished.then(completeSwap).catch(completeSwap);
            return;
         }

         var swapped = false;
         function startInTransition() {
            if (swapped) {
               return;
            }
            swapped = true;

            runBeforeSwap();
            panelParent.replaceChild(nextPanel, currentPanel);
            nextPanel.classList.add(useLightweightTransition ? 'customer-panel-switch-in-lite' : 'customer-panel-switch-in');

            window.requestAnimationFrame(function () {
               window.requestAnimationFrame(function () {
                  nextPanel.classList.add('customer-panel-switch-ready');
               });
            });

            var inDone = false;
            function finishInTransition() {
               if (inDone) {
                  return;
               }
               inDone = true;
               if (useLightweightTransition) {
                  nextPanel.classList.remove('customer-panel-switch-in-lite', 'customer-panel-switch-ready');
               } else {
                  nextPanel.classList.remove('customer-panel-switch-in', 'customer-panel-switch-ready');
               }
               completeSwap();
            }

            nextPanel.addEventListener('transitionend', function onInEnd(event) {
               if (event.target !== nextPanel) {
                  return;
               }
               nextPanel.removeEventListener('transitionend', onInEnd);
               finishInTransition();
            });

            window.setTimeout(finishInTransition, useLightweightTransition ? 240 : 340);
         }

         currentPanel.classList.add(useLightweightTransition ? 'customer-panel-switch-out-lite' : 'customer-panel-switch-out');
         currentPanel.addEventListener('transitionend', function onOutEnd(event) {
            if (event.target !== currentPanel) {
               return;
            }
            currentPanel.removeEventListener('transitionend', onOutEnd);
            startInTransition();
         });

         window.setTimeout(startInTransition, useLightweightTransition ? 150 : 220);
      }

      function navigatePanel(urlValue, pushHistory) {
         var tabType = getTabTypeFromUrl(urlValue);
         if (!tabType) {
            window.location.href = urlValue;
            return;
         }

         if (samePanelUrl(urlValue)) {
            setActiveNavigation(tabType);
            return;
         }

         if (isNavigating) {
            return;
         }

         var currentTabType = getCurrentPanelTabType();

         isNavigating = true;
         setActiveNavigation(tabType);

         var panelBeforeLoad = document.querySelector('.contact-section.account-page');
         var useLightweightTransition = shouldUseLightweightTransition(panelBeforeLoad, currentTabType, tabType);
         if (panelBeforeLoad) {
            panelBeforeLoad.classList.add('customer-panel-loading');
         }

         fetchPanelHtml(urlValue)
            .then(function (html) {
               var parser = new DOMParser();
               var nextDocument = parser.parseFromString(html, 'text/html');
               var nextPanel = nextDocument.querySelector('.contact-section.account-page');
               var nextTitle = nextDocument.querySelector('title');

               if (!nextPanel) {
                  window.location.href = urlValue;
                  return;
               }

               var importedPanel = document.importNode(nextPanel, true);
               swapPanelWithTransition(importedPanel, {
                  lightweight: useLightweightTransition,
                  beforeSwap: function () {
                     replaceDynamicPanelStyles(nextDocument);
                  }
               }, function () {
                  if (pushHistory) {
                     window.history.pushState({ customerPanel: true }, '', urlValue);
                  }

                  if (tabType === 'assignments') {
                     window.currentMessageType = 'assignment';
                  } else if (tabType === 'messages') {
                     window.currentMessageType = '';
                  }

                  if (nextTitle) {
                     document.title = nextTitle.textContent;
                  }

                  setActiveNavigation(tabType);
                  initPanelEnhancements();
                  window.scrollTo(0, 0);
                  isNavigating = false;
               });
            })
            .catch(function () {
               isNavigating = false;
               var currentPanel = document.querySelector('.contact-section.account-page');
               if (currentPanel) {
                  currentPanel.classList.remove('customer-panel-loading');
               }
               window.location.href = urlValue;
            });
      }

      document.addEventListener('click', function (event) {
         var link = event.target.closest('.customer-topbar .js-customer-panel-link, .customer-panel-sidebar .js-customer-tab-link');
         if (!link) {
            return;
         }

         if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
         }

         var href = link.getAttribute('href');
         if (!href || href.indexOf('javascript:') === 0 || href.charAt(0) === '#') {
            return;
         }

         var tabType = getTabTypeFromUrl(href);
         if (!tabType) {
            return;
         }

         event.preventDefault();
         navigatePanel(href, true);
      });

      document.addEventListener('mouseover', function (event) {
         var link = event.target.closest('.customer-topbar .js-customer-panel-link, .customer-panel-sidebar .js-customer-tab-link');
         if (!link) {
            return;
         }

         warmPanelCache(link.href);
      });

      document.addEventListener('focusin', function (event) {
         var link = event.target.closest('.customer-topbar .js-customer-panel-link, .customer-panel-sidebar .js-customer-tab-link');
         if (!link) {
            return;
         }

         warmPanelCache(link.href);
      });

      document.addEventListener('touchstart', function (event) {
         var link = event.target.closest('.customer-topbar .js-customer-panel-link, .customer-panel-sidebar .js-customer-tab-link');
         if (!link) {
            return;
         }

         warmPanelCache(link.href);
      }, { passive: true });

      window.addEventListener('popstate', function () {
         var tabType = getTabTypeFromUrl(window.location.href);
         if (!tabType) {
            return;
         }

         navigatePanel(window.location.href, false);
      });

      if (!window.__customerPanelResizeBound) {
         window.__customerPanelResizeBound = true;
         window.addEventListener('resize', syncAccountTimelinePosition);
      }

      setActiveNavigation(getTabTypeFromUrl(window.location.href));
      initPanelEnhancements();
   })();
</script>
