{{-- Delt bildekomponist for chatten i kundepanelet. Inlines direkte i siden slik
     at den alltid er tilgjengelig (ingen ekstern fil som kan mangle/caches feil). --}}
<script>
(function (window, document) {
   'use strict';

   if (window.ChatImageComposer) {
      return; // allerede definert (unngaa dobbel-definering ved flere inkluderinger)
   }

   var DEFAULTS = {
      maxFiles: 8,          // maks antall bilder per melding
      maxDimension: 1600,   // maks bredde/høyde i piksler etter nedskalering
      quality: 0.82,        // JPEG-kvalitet ved komprimering
      keepThreshold: 500 * 1024, // behold originalen hvis den allerede er liten nok
      maxBytes: 5 * 1024 * 1024, // avvis bilder som fortsatt er større enn dette etter komprimering
      allowPaste: true
   };

   function isDecodableImage(file) {
      return !!file && /^image\/(jpeg|jpg|png|webp|bmp)$/i.test(file.type || '');
   }

   function loadImage(file) {
      return new Promise(function (resolve, reject) {
         var url = URL.createObjectURL(file);
         var img = new Image();
         img.onload = function () { resolve({ img: img, url: url }); };
         img.onerror = function () { URL.revokeObjectURL(url); reject(new Error('decode-failed')); };
         img.src = url;
      });
   }

   function canvasToBlob(canvas, quality) {
      return new Promise(function (resolve) {
         if (canvas.toBlob) {
            canvas.toBlob(function (blob) { resolve(blob); }, 'image/jpeg', quality);
         } else {
            // Eldre nettlesere: fall tilbake til dataURL.
            try {
               var dataUrl = canvas.toDataURL('image/jpeg', quality);
               var parts = dataUrl.split(',');
               var binary = atob(parts[1]);
               var array = new Uint8Array(binary.length);
               for (var i = 0; i < binary.length; i++) { array[i] = binary.charCodeAt(i); }
               resolve(new Blob([array], { type: 'image/jpeg' }));
            } catch (e) {
               resolve(null);
            }
         }
      });
   }

   /**
    * Komprimerer/nedskalerer ett bilde. Returnerer alltid et File-objekt
    * (originalen hvis komprimering ikke gir gevinst eller ikke er mulig).
    */
   function compressImage(file, opts) {
      if (!isDecodableImage(file)) {
         return Promise.resolve(file);
      }

      return loadImage(file).then(function (loaded) {
         var img = loaded.img;
         var w = img.naturalWidth || img.width;
         var h = img.naturalHeight || img.height;

         if (!w || !h) {
            URL.revokeObjectURL(loaded.url);
            return file;
         }

         var scale = Math.min(1, opts.maxDimension / Math.max(w, h));
         var needsResize = scale < 1;
         var alreadySmall = file.size <= opts.keepThreshold;

         if (!needsResize && alreadySmall) {
            URL.revokeObjectURL(loaded.url);
            return file;
         }

         var tw = Math.max(1, Math.round(w * scale));
         var th = Math.max(1, Math.round(h * scale));
         var canvas = document.createElement('canvas');
         canvas.width = tw;
         canvas.height = th;

         var ctx = canvas.getContext('2d');
         // Hvit bakgrunn slik at gjennomsiktige PNG-er ikke blir svarte som JPEG.
         ctx.fillStyle = '#ffffff';
         ctx.fillRect(0, 0, tw, th);
         ctx.drawImage(img, 0, 0, tw, th);
         URL.revokeObjectURL(loaded.url);

         return canvasToBlob(canvas, opts.quality).then(function (blob) {
            if (!blob) {
               return file;
            }
            // Behold originalen hvis komprimering ikke gir mindre fil og vi ikke nedskalerte.
            if (!needsResize && blob.size >= file.size) {
               return file;
            }
            var baseName = (file.name || 'bilde').replace(/\.[^.]+$/, '');
            return new File([blob], baseName + '.jpg', {
               type: 'image/jpeg',
               lastModified: Date.now()
            });
         });
      }).catch(function () {
         return file;
      });
   }

   function ChatImageComposer(options) {
      var opts = {};
      var key;
      for (key in DEFAULTS) { if (DEFAULTS.hasOwnProperty(key)) { opts[key] = DEFAULTS[key]; } }
      for (key in options) { if (options.hasOwnProperty(key)) { opts[key] = options[key]; } }

      var fileInput = typeof opts.fileInput === 'string' ? document.querySelector(opts.fileInput) : opts.fileInput;
      var attachBtn = typeof opts.attachBtn === 'string' ? document.querySelector(opts.attachBtn) : opts.attachBtn;
      var previewWrap = typeof opts.previewWrap === 'string' ? document.querySelector(opts.previewWrap) : opts.previewWrap;
      var previewList = typeof opts.previewList === 'string' ? document.querySelector(opts.previewList) : opts.previewList;
      var submitBtn = typeof opts.submitBtn === 'string' ? document.querySelector(opts.submitBtn) : opts.submitBtn;

      if (!fileInput || !previewList || !previewWrap) {
         return null;
      }

      var store = [];       // File[] – ferdig komprimerte bilder (fasit for utvalget)
      var objectUrls = [];  // for opprydding
      var busyCount = 0;    // antall bilder som komprimeres akkurat nå
      var pending = 0;      // bilder i kø/komprimering (for maks-grensen)
      var statusEl = null;

      function ensureStatusEl() {
         if (statusEl) { return statusEl; }
         statusEl = document.createElement('div');
         statusEl.className = 'image-preview-status';
         statusEl.setAttribute('aria-live', 'polite');
         previewWrap.insertBefore(statusEl, previewList);
         return statusEl;
      }

      function setBusy(delta) {
         busyCount = Math.max(0, busyCount + delta);
         var busy = busyCount > 0;
         if (busy) {
            ensureStatusEl().textContent = 'Optimaliserer bilder …';
            statusEl.style.display = 'block';
            previewWrap.style.display = 'block';
         } else if (statusEl) {
            statusEl.style.display = 'none';
         }
         if (submitBtn) {
            submitBtn.disabled = busy;
         }
      }

      function syncInput() {
         try {
            var dt = new DataTransfer();
            store.forEach(function (file) { dt.items.add(file); });
            fileInput.files = dt.files;
         } catch (e) {
            // DataTransfer støttes i alle moderne nettlesere; hvis ikke faller vi
            // tilbake til det opprinnelige utvalget i input-feltet.
         }
      }

      function revokeUrls() {
         objectUrls.forEach(function (url) { URL.revokeObjectURL(url); });
         objectUrls = [];
      }

      function formatSize(bytes) {
         if (bytes >= 1024 * 1024) {
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
         }
         return Math.max(1, Math.round(bytes / 1024)) + ' KB';
      }

      function render() {
         revokeUrls();
         previewList.innerHTML = '';

         store.forEach(function (file, index) {
            var url = URL.createObjectURL(file);
            objectUrls.push(url);

            var item = document.createElement('div');
            item.className = 'image-preview-item';

            var img = document.createElement('img');
            img.src = url;
            img.alt = 'Forhåndsvisning';

            var remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'image-preview-remove';
            remove.setAttribute('aria-label', 'Fjern bilde');
            remove.innerHTML = '&times;';
            remove.addEventListener('click', function () {
               store.splice(index, 1);
               render();
            });

            var meta = document.createElement('span');
            meta.className = 'image-preview-meta';
            meta.textContent = formatSize(file.size);

            item.appendChild(img);
            item.appendChild(remove);
            item.appendChild(meta);
            previewList.appendChild(item);
         });

         previewWrap.style.display = store.length > 0 || busyCount > 0 ? 'block' : 'none';
      }

      function sourceSignature(file) {
         return (file.name || '') + '|' + (file.size || 0) + '|' + (file.lastModified || 0);
      }

      function hasSource(sig) {
         return store.some(function (existing) { return existing._srcSig === sig; });
      }

      function addFiles(fileList) {
         var files = Array.prototype.slice.call(fileList || []);
         if (!files.length) { return; }

         var reachedLimit = false;

         files.forEach(function (file) {
            if (!file || !/^image\//.test(file.type || '')) {
               return;
            }
            var sig = sourceSignature(file);
            // Ikke legg til samme bilde to ganger (men lar deg legge det til igjen
            // etter at det er fjernet fra listen).
            if (hasSource(sig)) {
               return;
            }
            if (store.length + pending >= opts.maxFiles) {
               reachedLimit = true;
               return;
            }

            pending++;
            setBusy(1);
            compressImage(file, opts).then(function (result) {
               if (store.length >= opts.maxFiles || hasSource(sig)) {
                  return;
               }
               if (result.size > opts.maxBytes) {
                  window.alert('Bildet «' + (file.name || 'bilde') + '» er for stort til å sendes. Prøv et mindre bilde.');
                  return;
               }
               try { result._srcSig = sig; } catch (e) { /* File tillater egne felt */ }
               store.push(result);
               render();
            }).catch(function () {
               // Ignorer enkeltbilder som feiler; resten sendes.
            }).then(function () {
               pending = Math.max(0, pending - 1);
               setBusy(-1);
               render();
            });
         });

         if (reachedLimit) {
            window.alert('Du kan sende inntil ' + opts.maxFiles + ' bilder per melding.');
         }
      }

      // ---- Hendelser ----
      if (attachBtn) {
         attachBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fileInput.click();
         });
      }

      fileInput.addEventListener('change', function () {
         // addFiles kopierer FileList-en synkront og legger bildene til i `store`.
         // Deretter tømmes selve input-feltet slik at du kan trykke på bilde-knappen
         // igjen og legge til flere bilder (også nøyaktig samme fil) uten at et nytt
         // valg overskriver de forrige. Utvalget skrives tilbake til feltet først når
         // skjemaet sendes (se submit-lytteren under).
         addFiles(fileInput.files);
         try { fileInput.value = ''; } catch (e) { /* noop */ }
      });

      // Skriv det akkumulerte utvalget tilbake til fil-feltet rett før skjemaet
      // sendes, slik at FormData får med alle bildene. Capture-lytteren på skjemaet
      // kjører før de eksisterende submit-håndtererne, og forsvinner sammen med
      // skjemaet når panelet lastes på nytt.
      var ownerForm = fileInput.form || (fileInput.closest ? fileInput.closest('form') : null);
      if (ownerForm) {
         ownerForm.addEventListener('submit', function () {
            syncInput();
         }, true);
      }

      if (opts.allowPaste) {
         var pasteTarget = opts.pasteTarget
            ? (typeof opts.pasteTarget === 'string' ? document.querySelector(opts.pasteTarget) : opts.pasteTarget)
            : document;
         if (pasteTarget) {
            pasteTarget.addEventListener('paste', function (e) {
               var items = (e.clipboardData && e.clipboardData.items) || [];
               var images = [];
               Array.prototype.forEach.call(items, function (item) {
                  if (item.kind === 'file' && /^image\//.test(item.type)) {
                     var file = item.getAsFile();
                     if (file) { images.push(file); }
                  }
               });
               if (images.length) {
                  e.preventDefault();
                  addFiles(images);
               }
            });
         }
      }

      function clear() {
         store = [];
         pending = 0;
         busyCount = 0;
         revokeUrls();
         previewList.innerHTML = '';
         previewWrap.style.display = 'none';
         if (statusEl) { statusEl.style.display = 'none'; }
         try { fileInput.value = ''; } catch (e) { /* noop */ }
         syncInput();
         if (submitBtn) { submitBtn.disabled = false; }
      }

      return {
         clear: clear,
         count: function () { return store.length; },
         isBusy: function () { return busyCount > 0; }
      };
   }

   window.ChatImageComposer = {
      init: function (options) { return ChatImageComposer(options); },
      compressImage: compressImage
   };
})(window, document);
</script>
