 <!-- Menu -->
 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="" class="app-brand-link">
             <span class="app-brand-logo demo">
                 <img src="{{ asset('icon.png') }}" width="30px" alt="icon">
             </span>
             {{-- <span class="app-brand-text demo menu-text fw-bold ms-2">SAG</span> --}}
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
             <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
             <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-divider mt-0"></div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1">
         <!-- Dashboard -->
         <li class="menu-header small text-uppercase"><span class="menu-header-text">@lang('nav.dashboard')</span></li>
         <li class="menu-item">
             <a href="{{ route('client.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                 <div data-i18n="@lang('nav.dashboard')">@lang('nav.dashboard')</div>
             </a>
         </li>


         <li class="menu-header small text-uppercase"><span class="menu-header-text">{{ __('tickets') }}</span></li>
         <li class="menu-item" style="">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon tf-icons bx bx-support"></i>
                 <div data-i18n="{{ __('tickets') }}">{{ __('tickets') }}</div>
             </a>
             <ul class="menu-sub">
                 <li class="menu-item">
                     <a href="{{ route('client.tickets.index') }}" class="menu-link">
                         <div data-i18n="{{ __('tickets list') }}">{{ __('tickets list') }}</div>
                     </a>
                 </li>
                 <li class="menu-item">
                     <a href="{{ route('client.tickets.create') }}" class="menu-link">
                         <div data-i18n="{{ __('submit new ticket') }}">{{ __('submit new ticket') }}</div>
                     </a>
                 </li>
             </ul>
         </li>
     </ul>
 </aside>
 <!-- / Menu -->
