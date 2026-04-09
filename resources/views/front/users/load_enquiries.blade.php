<?php
use App\Models\Enquiry;
use App\Models\EnquiriesResponse;
use App\Models\Category;
?>
<style>
   .message-hub {
      border: none;
      border-radius: 14px;
      background: #fff;
      overflow: hidden;
      height: 100%;
   }
   .message-filters {
      display: none;
   }
   .message-body-layout {
      display: grid;
      grid-template-columns: 220px minmax(0, 1fr);
      gap: 10px;
      padding: 10px;
      height: 100%;
      min-height: 0;
   }
   .message-filter-shell {
      position: static;
      align-self: start;
   }
   .status-filter-panel {
      width: 210px;
      max-width: 100%;
      border: 1px solid #ebddca;
      border-radius: 12px;
      background: #fbf7f1;
      padding: 9px;
   }
   .status-filter-toggle {
      display: none;
      width: 100%;
      border: 0;
      background: transparent;
      padding: 0;
      margin: 0;
      color: #9f927f;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      font-weight: 700;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      cursor: pointer;
    }
   .status-filter-toggle i {
      font-size: 12px;
      transition: transform 0.16s ease;
   }
   .status-filter-panel.is-open .status-filter-toggle i {
      transform: rotate(180deg);
   }
   .status-filter-content {
      display: block;
   }
   .status-filter-title {
      margin: 0 0 8px;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: #9f927f;
      font-weight: 700;
   }
   .status-filter-list {
      display: grid;
      gap: 5px;
   }
   .status-filter-actions {
      margin-top: 10px;
   }
   .new-assignment-btn {
      width: 100%;
      min-height: 38px;
      border-radius: 11px;
      border: 1px solid var(--customer-panel-accent);
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      text-decoration: none !important;
      font-size: 13px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 8px 12px;
      transition: transform 0.14s ease, opacity 0.14s ease;
   }
   .new-assignment-btn:hover {
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
      transform: translateY(-1px);
      opacity: 0.96;
   }
   .status-filter-btn {
      border: 1px solid transparent;
      border-radius: 10px;
      background: transparent;
      color: #5b4d3c;
      font-weight: 700;
      font-size: 13px;
      min-height: 32px;
      padding: 5px 8px;
      text-decoration: none !important;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
   }
   .status-filter-btn:hover {
      background: #f1e9de;
   }
   .contact-section.account-page .status-filter-btn.is-active {
      background: var(--customer-panel-accent) !important;
      border-color: var(--customer-panel-accent) !important;
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
   }
   .status-filter-btn .count {
      min-width: 20px;
      height: 20px;
      border-radius: 999px;
      background: #ece3d6;
      color: #6f604c;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: 700;
   }
   .contact-section.account-page .status-filter-btn.is-active .count {
      background: rgba(255, 255, 255, 0.34);
      color: var(--customer-panel-accent-contrast, #ffffff);
   }
   .filter-hidden {
      display: none !important;
   }
   .message-list {
      padding: 0;
      display: grid;
      gap: 12px;
      min-height: 0;
      overflow-y: auto;
      padding-right: 6px;
      align-content: start;
   }
   .message-list-desktop {
      display: grid;
   }
   .message-list-mobile {
      display: none;
   }
   .message-item {
      border: 1px solid #ece3d7;
      border-radius: 14px;
      background: #f7f3ec;
      padding: 14px;
      box-shadow: none;
      display: grid;
      grid-template-columns: 54px minmax(0, 1.7fr) minmax(0, 1fr) minmax(0, 1.2fr);
      gap: 12px;
      align-items: center;
   }
   .message-item.is-selected {
      border-color: var(--customer-panel-accent);
      box-shadow: 0 0 0 2px rgba(231, 128, 2, 0.2);
      background: #fff9ef;
   }
   .message-item > div {
      min-width: 0;
   }
   .message-item.is-completed {
      background: #e8f5ea;
      border-color: #9fceaa;
      box-shadow: inset 0 0 0 1px rgba(157, 204, 168, 0.35);
   }
   .message-item.is-assignment::before {
      background: #e78002;
   }
   .message-item.is-direct::before {
      background: #2f4f98;
   }
   .message-item.is-completed .message-vendor-title a,
   .message-item.is-completed .message-preview,
   .message-item.is-completed .message-type-note {
      color: #2e5f3a !important;
   }
   .message-brand {
      width: 54px;
      height: 54px;
      border-radius: 11px;
      object-fit: cover;
      border: 1px solid #d8c8b0;
      background: #fff;
      box-shadow: 0 4px 10px rgba(46, 32, 15, 0.12);
   }
   .message-vendor-head {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 6px;
   }
   .message-vendor-title {
      margin: 0;
      font-size: 28px;
      line-height: 1.2;
   }
   .message-vendor-title a {
      color: #2f2516 !important;
      text-decoration: none;
      font-weight: 700;
   }
   .message-vendor-title a:hover {
      color: #2f2516 !important;
   }
   .message-status-chip {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      padding: 4px 8px;
      border: 1px solid transparent;
      margin-top: 2px;
   }
   .message-status-chip.open {
      background: #e7f7eb;
      border-color: #b6dfc1;
      color: #1f6a3f;
   }
   .message-status-chip.closed {
      background: #f3efea;
      border-color: #e4d8c8;
      color: #877766;
   }
   .message-preview {
      margin: 0;
      color: #615443;
      font-size: 17px;
      line-height: 1.35;
   }
   .assignment-summary {
      margin: 0;
      display: grid;
      gap: 3px;
      color: #615443;
      font-size: 14px;
      line-height: 1.3;
   }
   .assignment-summary strong {
      color: #2f2516;
      font-size: 15px;
   }
   .assignment-alerts {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin-top: 1px;
   }
   .assignment-alert {
      display: inline-flex;
      align-items: center;
      min-height: 22px;
      padding: 2px 8px;
      border-radius: 999px;
      border: 1px solid #d3dfef;
      background: #edf3fb;
      color: #204974;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.02em;
   }
   .assignment-alert.new-vendor {
      border-color: #c6decf;
      background: #e9f6ee;
      color: #1e5a34;
   }
   .assignment-alert.new-message {
      border-color: #d5d8f0;
      background: #f0f2fb;
      color: #2f4f98;
   }
   .message-flags {
      margin: 0;
      display: flex;
      align-items: center;
      gap: 6px;
      min-height: 22px;
   }
   .message-status-badge {
      display: inline-flex;
      align-items: center;
      min-height: 22px;
      padding: 2px 8px;
      border-radius: 999px;
      border: 1px solid var(--customer-panel-accent);
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.02em;
   }
   .message-vendor-meta {
      margin-top: 9px;
      color: #988877;
      font-size: 12px;
      display: flex;
      gap: 12px;
      align-items: center;
      flex-wrap: wrap;
   }
   .message-vendor-meta .meta-item {
      display: inline-flex;
      align-items: center;
      gap: 5px;
   }
   .message-category-icon {
      width: 14px;
      height: 14px;
      object-fit: contain;
      display: inline-block;
   }
   .message-vendor-meta i {
      margin-right: 5px;
      color: var(--customer-panel-accent, #e78002);
   }
   .message-type-cell {
      display: flex;
      align-items: center;
      gap: 7px;
      flex-wrap: wrap;
      justify-content: flex-start;
   }
   .type-chip {
      display: inline-flex;
      align-items: center;
      border-radius: 999px;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 9px;
      border: 1px solid transparent;
      letter-spacing: 0.06em;
      text-transform: uppercase;
   }
   .type-chip.assignment {
      background: #ffe5be;
      color: #8f4200;
      border-color: #f3b974;
   }
   .type-chip.direct {
      background: #e8edff;
      color: #2f4f98;
      border-color: #becaf3;
   }
   .message-type-note {
      display: none;
   }
   .message-unread {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 6px;
      min-width: 20px;
      height: 20px;
      border-radius: 999px;
      background: var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff);
      font-size: 11px;
      font-weight: 700;
      border: 1px solid #fff;
   }
   .message-actions {
      display: flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
      justify-content: flex-end;
      margin-bottom: 6px;
   }
   .message-open-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 42px;
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 15px;
      font-weight: 700;
      text-decoration: none !important;
      color: #fff !important;
      transition: transform 0.16s ease, opacity 0.16s ease;
   }
   .message-open-link.assignment,
   .message-open-link.direct {
      background: var(--customer-panel-accent);
      border: 1px solid var(--customer-panel-accent);
      color: var(--customer-panel-accent-contrast, #ffffff) !important;
   }
   .message-open-link.view {
      background: #ece6dc;
      border: 1px solid #dfd3c1;
      color: #6b5c4a !important;
      box-shadow: none;
   }
   .message-open-link:hover {
      transform: translateY(-1px);
      opacity: 0.95;
   }
   .status-marker {
      display: none;
   }
   .message-toggles {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      justify-content: flex-end;
   }
   .toggle-chip {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      min-width: 110px;
      padding: 7px 11px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      border: 1px solid transparent;
      transition: transform 0.16s ease, opacity 0.16s ease;
   }
   .toggle-chip.is-open {
      background: #edf7ef;
      color: #2f7a45;
      border-color: #b8ddbf;
   }
   .toggle-chip.is-closed {
      background: #f2efea;
      color: #766758;
      border-color: #dfd4c4;
   }
   .updateEnquiryStatus {
      text-decoration: none !important;
   }
   .enquiry-complete-btn,
   .delete-enquiry-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 34px;
      border-radius: 999px;
      padding: 7px 14px;
      font-size: 12px;
      font-weight: 700;
      text-decoration: none !important;
      border: 1px solid transparent;
      transition: transform 0.14s ease, opacity 0.14s ease;
   }
   .enquiry-complete-btn {
      background: #edf8ef;
      border-color: #a7d5b0;
      color: #2f7443 !important;
   }
   .delete-enquiry-btn {
      background: #fff1ef;
      border-color: #f1c2ba;
      color: #9e3a2b !important;
   }
   .enquiry-complete-btn:hover,
   .delete-enquiry-btn:hover {
      transform: translateY(-1px);
      opacity: 0.95;
   }
   .updateEnquiryStatus:hover .toggle-chip {
      transform: translateY(-1px);
      opacity: 0.95;
   }
   .message-empty {
      border: 1px dashed #dcc5a4;
      border-radius: 10px;
      padding: 26px;
      text-align: center;
      color: #746652;
      background: #fffaf3;
      font-size: 14px;
   }
   @media (max-width: 1199px) {
      .enquiry-row-link {
         align-items: start;
      }

      .message-item {
         grid-template-columns: 54px 1fr;
      }

      .enquiry-row-top {
         display: grid;
      }

      .enquiry-row-date {
         display: block;
         margin-top: 2px;
      }

      .enquiry-row-side {
         justify-items: start;
         align-content: start;
      }

      .enquiry-row-menu-wrap {
         top: 10px;
         right: 10px;
      }

      .message-vendor-title {
         font-size: 22px;
      }

      .message-preview {
         font-size: 14px;
      }

      .message-type-cell,
      .message-actions,
      .message-toggles {
         justify-content: flex-start;
      }
   }
   @media (max-width: 767px) {
      .message-hub {
         border: 0;
         background: transparent;
         border-radius: 0;
         overflow: visible;
      }

      .message-body-layout {
         grid-template-columns: 1fr;
         padding: 0;
         gap: 12px;
         height: auto;
      }

      .status-filter-panel {
         width: 100%;
         padding: 12px;
         border-radius: 16px;
         border-color: #e3d5bf;
         background: #f3eee6;
         box-shadow: 0 6px 14px rgba(55, 40, 20, 0.05);
      }

      .status-filter-toggle {
         display: flex;
      }

      .status-filter-content {
         display: none;
         margin-top: 10px;
      }

      .status-filter-panel.is-open .status-filter-content {
         display: block;
      }

      .status-filter-title {
         display: none;
      }

      .status-filter-list {
         display: grid;
      }

      .status-filter-actions {
         margin-top: 10px;
      }

      .new-assignment-btn {
         min-height: 40px;
         font-size: 13px;
         border-radius: 12px;
      }

      .status-filter-btn {
         flex: 0 0 auto;
         min-width: 134px;
         min-height: 36px;
         padding: 7px 11px;
         font-size: 13px;
         border-radius: 999px;
         border: 1px solid #dfd1bb;
         background: #fff9f0;
      }

      .status-filter-btn .count {
         background: #e8dece;
         color: #675947;
      }

      .contact-section.account-page .status-filter-btn.is-active {
         background: var(--customer-panel-accent) !important;
         border-color: var(--customer-panel-accent) !important;
         color: var(--customer-panel-accent-contrast, #ffffff) !important;
      }

      .contact-section.account-page .status-filter-btn.is-active .count {
         background: rgba(255, 255, 255, 0.34);
         color: var(--customer-panel-accent-contrast, #ffffff);
      }

      .message-list {
         gap: 12px;
         padding-right: 0;
         overflow: visible;
         overflow-x: hidden;
      }

      .message-list-desktop {
         display: none;
      }

      .message-list-mobile {
         display: grid;
      }

      .message-item {
         grid-template-columns: 1fr;
         gap: 8px;
         padding: 12px 12px 12px 16px;
         max-width: 100%;
         border-radius: 16px;
         border: 1px solid #e8ddcc;
         background: #f8f4ec;
         position: relative;
         overflow: hidden;
         box-shadow: 0 8px 18px rgba(60, 45, 24, 0.06);
      }

      .message-item::before {
         content: "";
         position: absolute;
         left: 0;
         top: 0;
         bottom: 0;
         width: 5px;
         border-radius: 16px 0 0 16px;
         background: #5f7b66;
         pointer-events: none;
      }

      .message-item.is-direct::before {
         background: #2f4f98;
      }

      .message-item.is-assignment::before {
         background: #e78002;
      }

      .message-item.is-completed.is-direct::before {
         background: #2f4f98;
      }

      .message-item.is-completed.is-assignment::before {
         background: #e78002;
      }

      .message-item > div:first-child {
         display: flex;
         align-items: center;
         justify-content: flex-start;
         margin-bottom: 2px;
      }

      .message-brand {
         width: 40px;
         height: 40px;
         border-radius: 50%;
         box-shadow: none;
         border: 1px solid #ddcfb8;
      }

      .message-vendor-head {
         gap: 6px;
         margin-bottom: 4px;
         align-items: center;
      }

      .message-vendor-title {
         font-size: 20px;
         overflow-wrap: anywhere;
         word-break: break-word;
      }

      .message-status-chip {
         font-size: 9px;
         padding: 4px 8px;
      }

      .message-unread {
         min-width: 18px;
         height: 18px;
         font-size: 10px;
      }

      .message-preview {
         font-size: 14px;
         line-height: 1.4;
      }

      .message-vendor-meta {
         margin-top: 6px;
         font-size: 11px;
         gap: 8px;
      }

      .message-type-cell {
         gap: 6px;
      }

      .type-chip {
         font-size: 10px;
      }

      .message-type-note {
         display: block;
         margin: 0;
         font-size: 11px;
         color: #7a6b58;
      }

      .message-item.is-assignment.is-assignment-tab .message-type-cell {
         display: none;
      }

      .message-item.is-assignment.is-assignment-tab::before {
         background: #e78002;
      }

      .message-actions {
         display: flex;
         flex-direction: column;
         gap: 8px;
         justify-content: flex-start;
         align-items: stretch;
         margin-top: 4px;
         margin-bottom: 0;
      }

      .message-open-link {
         width: 100%;
         flex: 0 0 auto;
         min-width: 0;
         min-height: 40px;
         border-radius: 11px;
         font-size: 13px;
         padding: 8px 12px;
         line-height: 1.25;
         white-space: normal;
      }

      .message-toggles {
         justify-content: flex-start;
         gap: 8px;
         margin-top: 8px;
      }

      .enquiry-complete-btn,
      .delete-enquiry-btn,
      .toggle-chip {
         width: 100%;
         min-height: 36px;
         font-size: 12px;
         padding: 8px 12px;
         justify-content: center;
      }

      .status-filter-btn,
      .new-assignment-btn,
      .message-open-link,
      .updateEnquiryStatus,
      .deleteEnquiry {
         position: relative;
         z-index: 2;
         touch-action: manipulation;
      }

      .message-empty {
         padding: 18px 14px;
         font-size: 13px;
      }
   }

   .message-list {
      gap: 0;
      border: 1px solid #ece7de;
      border-radius: 12px;
      background: #fff;
      padding: 0;
      overflow: auto;
   }

   .enquiry-row-shell {
      position: relative;
   }

   .enquiry-row-shell.has-menu .enquiry-row-link {
      padding-right: 56px;
   }

   .enquiry-row-menu-wrap {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 5;
   }

   .enquiry-row-menu-trigger {
      width: 32px;
      height: 32px;
      border-radius: 999px;
      border: 1px solid #e2d5c2;
      background: #fff7eb;
      color: #7a6347;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(61, 46, 24, 0.08);
      transition: transform 0.14s ease, background-color 0.14s ease, box-shadow 0.14s ease;
   }

   .enquiry-row-menu-trigger:hover {
      transform: translateY(-1px);
      background: #f4eadc;
      box-shadow: 0 6px 12px rgba(61, 46, 24, 0.12);
   }

   .enquiry-row-menu-panel {
      position: absolute;
      top: 38px;
      right: 0;
      min-width: 180px;
      padding: 6px;
      border-radius: 12px;
      border: 1px solid #e2d5c2;
      background: #fff;
      box-shadow: 0 12px 24px rgba(61, 46, 24, 0.16);
      display: none;
   }

   .enquiry-row-menu-panel.is-open {
      display: grid;
      gap: 4px;
   }

   .enquiry-row-menu-item {
      width: 100%;
      border: 0;
      border-radius: 10px;
      background: #fff1ef;
      color: #9e3a2b;
      min-height: 38px;
      padding: 8px 12px;
      font-size: 13px;
      font-weight: 700;
      text-align: left;
      cursor: pointer;
      transition: background-color 0.14s ease, transform 0.14s ease;
   }

   .enquiry-row-menu-item:hover {
      background: #ffe3dd;
      transform: translateY(-1px);
   }

   .enquiry-row-link {
      display: grid;
      grid-template-columns: 52px minmax(0, 2.2fr) minmax(92px, 0.8fr);
      align-items: start;
      gap: 12px;
      padding: 12px;
      border-bottom: 1px solid #f0ebe2;
      text-decoration: none !important;
      color: inherit;
      background: #fff;
      transition: background-color 0.16s ease;
   }

   .enquiry-row-link:last-child {
      border-bottom: none;
   }

   .enquiry-row-link:hover {
      background: #f8f7f4;
   }

   .enquiry-row-link.is-selected {
      background: #eef4ff;
   }

   .enquiry-row-link.is-completed .enquiry-row-title,
   .enquiry-row-link.is-completed .enquiry-row-preview {
      color: #4a6a50;
   }

   .enquiry-row-avatar {
      width: 52px;
      height: 52px;
      border-radius: 10px;
      overflow: hidden;
      background: #f2eee7;
      border: 1px solid #e3d8c9;
   }

   .enquiry-avatar-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
   }

   .enquiry-row-main {
      min-width: 0;
      display: grid;
      gap: 3px;
   }

   .enquiry-row-top {
      display: grid;
      gap: 2px;
      align-items: start;
      min-width: 0;
   }

   .enquiry-row-title {
      margin: 0;
      font-size: 16px;
      font-weight: 700;
      color: #222;
      line-height: 1.25;
      white-space: nowrap;
      word-break: normal;
      overflow-wrap: normal;
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
   }

   .enquiry-row-date {
      flex-shrink: 0;
      font-size: 12px;
      color: #767676;
      font-weight: 600;
   }

   .enquiry-row-preview {
      margin: 0;
      color: #555;
      font-size: 14px;
      line-height: 1.35;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2;
      overflow: hidden;
   }

   .enquiry-row-submeta {
      margin: 0;
      color: #3b3b3b;
      font-size: 13px;
      font-weight: 700;
   }

   .enquiry-row-meta {
      display: flex;
      align-items: center;
      gap: 9px;
      color: #7a7a7a;
      font-size: 12px;
      flex-wrap: wrap;
   }

   .enquiry-row-side {
      display: grid;
      gap: 4px;
      justify-items: end;
      align-content: center;
      min-width: 92px;
   }

   .enquiry-row-side .type-chip {
      font-size: 9px;
      padding: 3px 7px;
      letter-spacing: 0.04em;
   }

   .badge-fullfort {
      display: inline-flex;
      align-items: center;
      height: 22px;
      border-radius: 7px;
      padding: 0 8px;
      background: #b07420;
      color: #fff;
      font-size: 11px;
      font-weight: 700;
      text-transform: none;
   }

   .badge-unread {
      min-width: 20px;
      height: 20px;
      border-radius: 999px;
      background: #2f80ed;
      color: #fff;
      font-size: 11px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0 6px;
   }

   .enquiry-empty-state {
      padding: 24px;
      text-align: center;
      color: #6f6658;
      font-size: 14px;
   }

   .assignment-mode-wrap {
      display: grid;
      gap: 10px;
      padding: 10px;
   }

   .assignment-mode-head {
      display: flex;
      align-items: center;
      gap: 10px;
      border-bottom: 1px solid #ebe6dc;
      padding-bottom: 9px;
   }

   .assignment-back-btn {
      width: 28px;
      height: 28px;
      border: 0;
      border-radius: 999px;
      background: #e8f1ff;
      color: #2563eb;
      font-size: 17px;
      line-height: 1;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
   }

   .assignment-mode-title {
      margin: 0;
      font-size: 15px;
      font-weight: 700;
      color: #1f2937;
      line-height: 1.2;
   }

   .assignment-mode-sub {
      margin: 2px 0 0;
      font-size: 13px;
      color: #4b5563;
   }

   .assignment-thread-list {
      display: grid;
   }

   .assignment-thread-row {
      display: grid;
      grid-template-columns: 42px minmax(0, 1fr) auto;
      gap: 10px;
      align-items: center;
      text-decoration: none !important;
      color: inherit;
      padding: 10px 0;
      border-bottom: 1px solid #ece7de;
   }

   .assignment-thread-row:last-child {
      border-bottom: 0;
   }

   .assignment-thread-row.is-selected {
      background: #eef4ff;
      margin: 0 -10px;
      padding-left: 10px;
      padding-right: 10px;
      border-radius: 8px;
      border-bottom-color: transparent;
   }

   .assignment-thread-avatar {
      width: 42px;
      height: 42px;
      border-radius: 999px;
      overflow: hidden;
      background: #f2eee7;
      border: 1px solid #e3d8c9;
   }

   .assignment-thread-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
   }

   .assignment-thread-name {
      margin: 0;
      font-size: 17px;
      font-weight: 700;
      color: #1f2937;
      line-height: 1.2;
   }

   .assignment-thread-preview {
      margin: 3px 0 0;
      font-size: 14px;
      color: #4b5563;
      line-height: 1.3;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2;
      overflow: hidden;
   }

   .assignment-thread-date {
      font-size: 12px;
      color: #6b7280;
      font-weight: 600;
      white-space: nowrap;
   }

   .message-item,
   .message-actions,
   .message-toggles,
   .message-open-link,
   .message-type-note,
   .message-status-chip,
   .message-unread {
      display: none !important;
   }

   .enquiry-row-shell:last-child .enquiry-row-link {
      border-bottom: none;
   }

   @media (max-width: 767px) {
      .message-list {
         border: none;
         background: transparent;
      }

      .enquiry-row-link {
         grid-template-columns: 44px minmax(0, 1fr) auto;
         gap: 10px;
         border: 1px solid #e8ddcc;
         border-radius: 14px;
         margin-bottom: 10px;
         padding: 11px;
         box-shadow: 0 6px 14px rgba(61, 46, 24, 0.06);
      }

      .enquiry-row-shell.has-menu .enquiry-row-link {
         padding-right: 52px;
      }

      .enquiry-row-menu-wrap {
         top: 10px;
         right: 10px;
      }

      .enquiry-row-menu-panel {
         top: 36px;
         right: 0;
         min-width: 168px;
      }

      .enquiry-row-avatar {
         width: 44px;
         height: 44px;
         border-radius: 50%;
      }

      .enquiry-row-title {
         font-size: 15px;
      }

      .enquiry-row-date {
         font-size: 11px;
      }

      .enquiry-row-preview {
         font-size: 13px;
      }

      .enquiry-row-side {
         gap: 4px;
      }

      .badge-fullfort {
         height: 20px;
         font-size: 10px;
      }
   }
</style>

@php
   $isAssignmentTab = isset($message_type) && $message_type === 'assignment';
   $isMessagesTab = !$isAssignmentTab;
   $allItemsLabel = $isAssignmentTab ? 'Alle oppdrag' : 'Alle meldinger';
   $desktopRows = $desktopEnquiries ?? $enquiries;
   $mobileRows = $enquiries;

   if($isAssignmentTab){
      $desktopRows = array_values(array_filter($desktopRows, function($row){
         return (int)($row['enquiry_detail_id'] ?? 0) > 0;
      }));
      $mobileRows = array_values(array_filter($mobileRows, function($row){
         return (int)($row['enquiry_detail_id'] ?? 0) > 0;
      }));
   }
@endphp

<div class="message-hub">
   <input type="hidden" id="selectedEnquiryId" value="{{ (int)($selectedEnquiryId ?? 0) }}">
   <div class="message-body-layout">
      <div class="message-filter-shell">
         <div class="status-filter-panel">
            <button type="button" class="status-filter-toggle" aria-expanded="false">
               <span>Filter</span>
               <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </button>
            <div class="status-filter-content">
               <p class="status-filter-title">Filter</p>
               <div class="status-filter-list">
                  <a href="javascript:void(0)" class="status-filter-btn {{ ($active_close === '' || $active_close === null) ? 'is-active' : '' }}" data-status="">
                     <span><i class="fa fa-th-large" style="margin-right:8px;"></i>{{ $allItemsLabel }}</span>
                     <span class="count">{{ (int)($totalAssignments ?? 0) }}</span>
                  </a>
                  <a href="javascript:void(0)" class="status-filter-btn {{ (string)$active_close === '1' ? 'is-active' : '' }}" data-status="1">
                     <span><i class="fa fa-play-circle" style="margin-right:8px;"></i>Aktive</span>
                     <span class="count">{{ (int)($activeAssignments ?? 0) }}</span>
                  </a>
                  <a href="javascript:void(0)" class="status-filter-btn {{ (string)$active_close === '0' ? 'is-active' : '' }}" data-status="0">
                     <span><i class="fa fa-check-circle" style="margin-right:8px;"></i>Fullførte</span>
                     <span class="count">{{ (int)($completedAssignments ?? 0) }}</span>
                  </a>
               </div>

               @if($isAssignmentTab)
                  <div class="status-filter-actions">
                     <a href="{{ url('enquire-us') }}" class="new-assignment-btn">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Nytt Oppdrag
                     </a>
                  </div>
               @endif
            </div>
         </div>

         <div class="filter-hidden">
            <select id="seltypeenq" class="seluserenquiries">
               <option value="">Alle meldinger</option>
               <option value="assignment" @if(isset($message_type) && $message_type=="assignment") selected @endif>Oppdrag</option>
               <option value="direct" @if(isset($message_type) && $message_type=="direct") selected @endif>Direkte</option>
            </select>
            <select id="selcatenq" class="seluserenquiries">
               <option value="">Alle kategorier</option>
               @foreach($allcategories as $cat)
                  <option value="{{ $cat }}" @if(isset($enqCat) && $enqCat==$cat) selected @endif>{{ $cat }}</option>
               @endforeach
            </select>
            <select id="selcloseenq" class="seluserenquiries">
               <option value="">Status: Alle</option>
               <option value="1" @if(isset($active_close) && $active_close=="1") selected @endif>Aktiv</option>
               <option value="0" @if(isset($active_close) && $active_close=="0") selected @endif>Avsluttet</option>
            </select>
         </div>
      </div>

      <div class="message-list message-list-desktop">
         @include('front.users.partials.enquiry_list_rows', ['renderEnquiries' => $desktopRows, 'isMobileList' => false])
      </div>
      <div class="message-list message-list-mobile">
         @include('front.users.partials.enquiry_list_rows', ['renderEnquiries' => $mobileRows, 'isMobileList' => true])
      </div>
   </div>
</div>
                           