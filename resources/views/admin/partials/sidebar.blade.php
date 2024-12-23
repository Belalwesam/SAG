 <!-- Menu -->
 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="{{ route('admin.index') }}" class="app-brand-link">
             <span class="app-brand-logo demo">
                 <img src="{{ asset('icon.png') }}" width="30px" alt="icon">
             </span>
             {{-- <span class="app-brand-text demo menu-text fw-bold ms-2">SAG</span> --}}
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
             <i class="bx bx-left-arrow-alt d-none d-xl-block fs-4 align-middle"></i>
             {{-- <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i> --}}
         </a>
     </div>

     <div class="menu-divider mt-0"></div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1">
         <!-- Dashboard -->
         <li class="menu-header small text-uppercase"><span class="menu-header-text">@lang('nav.dashboard')</span></li>
         <li class="menu-item">
             <a href="{{ route('admin.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                 <div data-i18n="@lang('nav.dashboard')">@lang('nav.dashboard')</div>
             </a>
         </li>


         @if (auth('admin')->user()->hasAbilityTo('see roles'))
             <!-- Roles & Permissions -->
             <li class="menu-header small text-uppercase"><span class="menu-header-text">@lang('nav.roles_and_permissions')</span></li>
             <li class="menu-item">
                 <a href="{{ route('admin.roles.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-check-shield"></i>
                     <div data-i18n="@lang('nav.roles_and_permissions')">@lang('nav.roles_and_permissions')</div>
                 </a>
             </li>
         @endif

         @if (auth('admin')->user()->hasAbilityTo('see admins'))
             <!-- Adminstrators -->
             <li class="menu-header small text-uppercase"><span class="menu-header-text">@lang('nav.adminstrators')</span></li>
             <li class="menu-item">
                 <a href="{{ route('admin.admins.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-user-circle"></i>
                     <div data-i18n="@lang('nav.admins')">@lang('nav.admins')</div>
                 </a>
             </li>
         @endif

         @if (auth('admin')->user()->hasAbilityTo('see clients'))
             <!-- Adminstrators -->
             <li class="menu-header small text-uppercase"><span class="menu-header-text">{{ __('clients') }}</span></li>
             <li class="menu-item">
                 <a href="{{ route('admin.clients.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-group"></i>
                     <div data-i18n="{{ __('clients') }}">{{ __('clients') }}</div>
                 </a>
             </li>
         @endif

         @if (auth('admin')->user()->hasAbilityTo('see projects'))
             <!-- Adminstrators -->
             <li class="menu-header small text-uppercase"><span class="menu-header-text">{{ __('projects') }}</span>
             </li>
             <li class="menu-item">
                 <a href="{{ route('admin.projects.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-cog"></i>
                     <div data-i18n="{{ __('projects') }}">{{ __('projects') }}</div>
                 </a>
             </li>
         @endif

         @if (auth('admin')->user()->hasAbilityTo('see tickets'))
             <!-- Adminstrators -->
             <li class="menu-header small text-uppercase"><span class="menu-header-text">{{ __('tickets') }}</span>
             </li>
             <li class="menu-item">
                 <a href="{{ route('admin.tickets.index') }}" class="menu-link">
                     <i class="menu-icon tf-icons bx bx-support"></i>
                     <div data-i18n="{{ __('tickets') }}">{{ __('tickets') }}</div>
                 </a>
             </li>
         @endif


         {{-- @if (auth()->user()->hasAbilityTo('see clients'))
             <li class="menu-header small text-uppercase"><span class="menu-header-text">{{ __('clients') }}</span></li>
             <li class="menu-item" style="">
                 <a href="javascript:void(0)" class="menu-link menu-toggle">
                     <i class="menu-icon tf-icons bx bx-group"></i>
                     <div data-i18n="{{ __('clients') }}">{{ __('clients') }}</div>
                 </a>
                 <ul class="menu-sub">
                     <li class="menu-item">
                         <a href="icons-boxicons.html" class="menu-link">
                             <div data-i18n="{{ __('clients list') }}">{{ __('clients list') }}</div>
                         </a>
                     </li>
                     <li class="menu-item">
                         <a href="{{ route('admin.clients') }}" class="menu-link">
                             <div data-i18n="{{ __('add new client') }}">{{ __('add new client') }}</div>
                         </a>
                     </li>
                 </ul>
             </li>
         @endif --}}
     </ul>
 </aside>
 <!-- / Menu -->
