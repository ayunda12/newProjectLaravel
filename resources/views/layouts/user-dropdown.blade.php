<!-- User Dropdown -->
<div
  class="relative"
  x-data="dropdown({
    placement: 'bottom-end',
    offset: 8,
    subPlacement: 'left-start',
    subOffset: 4,

    getMainItems() {
      return Array.from(this.$refs.menu?.querySelectorAll('[role=menuitem]:not([data-submenu-item])') || []);
    },

    openMenu(focusFirst = true) {
      this.open = true;
      this.subOpen = false;
      this.$nextTick(() => {
        const items = this.getMainItems();
        if (items.length) {
          (focusFirst ? items[0] : items[items.length - 1]).focus();
        }
      });
    },

    closeMenu(returnFocus = true) {
      if (!this.open) return;
      this.open = false;
      this.subOpen = false;
      if (returnFocus) {
        this.$nextTick(() => this.$refs.trigger?.focus());
      }
    },

    toggleMenu() {
      if (this.open) {
        this.closeMenu(false);
      } else {
        this.openMenu(true);
      }
    },

    navigate(e) {
      const items = this.getMainItems();
      const index = items.indexOf(document.activeElement);
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        const next = index < items.length - 1 ? index + 1 : 0;
        items[next]?.focus();
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        const prev = index > 0 ? index - 1 : items.length - 1;
        items[prev]?.focus();
      } else if (e.key === 'Home') {
        e.preventDefault();
        items[0]?.focus();
      } else if (e.key === 'End') {
        e.preventDefault();
        items[items.length - 1]?.focus();
      }
    },

    openSubmenu() {
      this.subOpen = true;
      this.$nextTick(() => {
        const subItems = Array.from(this.$refs.submenu?.querySelectorAll('[role=menuitem]') || []);
        if (subItems.length) subItems[0].focus();
      });
    },

    closeSubmenu() {
      this.subOpen = false;
      this.$nextTick(() => this.$refs.subTrigger?.focus());
    },

    navigateSub(e) {
      const subItems = Array.from(this.$refs.submenu?.querySelectorAll('[role=menuitem]') || []);
      const index = subItems.indexOf(document.activeElement);
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        const next = index < subItems.length - 1 ? index + 1 : 0;
        subItems[next]?.focus();
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        const prev = index > 0 ? index - 1 : subItems.length - 1;
        subItems[prev]?.focus();
      } else if (e.key === 'Home') {
        e.preventDefault();
        subItems[0]?.focus();
      } else if (e.key === 'End') {
        e.preventDefault();
        subItems[subItems.length - 1]?.focus();
      }
    }
  })"
  @click.outside="closeMenu(false)"
  @keydown.escape.window="closeMenu(true)">
  <!-- Trigger Button -->
  <button
    type="button"
    x-ref="trigger"
    id="user-menu-button"
    aria-haspopup="menu"
    :aria-expanded="open.toString()"
    aria-controls="user-menu"
    aria-label="User menu"
    @click="toggleMenu()"
    @keydown.down.prevent="openMenu(true)"
    @keydown.up.prevent="openMenu(false)"
    class="dropdown-toggle flex items-center text-gray-700 dark:text-gray-400">
    <span class="me-3 h-11 w-11 overflow-hidden rounded-lg">
      <img src="{{ asset('images/' . Auth::user()->image)}}" alt="User" class="size-11" />
    </span>

    <span class="me-1 block text-sm font-medium"> {{ Auth::user()->name }}</span>

    <svg
      class="size-5 text-gray-500 transition-transform duration-200 dark:text-gray-400"
      :class="open ? 'rotate-180' : 'rotate-0'"
      width="20"
      height="20"
      viewBox="0 0 20 20"
      fill="none"
      xmlns="http://www.w3.org/2000/svg">
      <path
        d="M4.792 7.396L10 12.604l5.208-5.208"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round" />
    </svg>
  </button>

  <!-- Dropdown Menu Content -->
  <div
    x-cloak
    x-show="open"
    x-ref="menu"
    id="user-menu"
    role="menu"
    aria-orientation="vertical"
    aria-labelledby="user-menu-button"
    tabindex="-1"
    @keydown.tab="open = false; subOpen = false"
    @keydown.escape.stop="closeMenu(true)"
    @keydown="navigate($event)"
    x-transition:enter="animate-in fade-in-0 zoom-in-95 duration-100"
    x-transition:leave="animate-out fade-out-0 zoom-out-95 fill-mode-forwards duration-75"
    class="fixed z-50 flex w-65 flex-col gap-1 rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg outline-none dark:border-gray-800 dark:bg-[#1E2635]">
    <!-- User Info Header -->
    <div class="px-3 py-2">
      <span class="block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ Auth::user()->name }}
      </span>
      <span class="mt-0.5 block text-xs text-gray-500 dark:text-gray-400">
        {{ Auth::user()->email }}
      </span>
    </div>

    <div class="-mx-3 my-1.5 h-px bg-gray-100 dark:bg-gray-700"></div>

    <!-- Edit Profile -->
    <a href="{{ route('profile') }}"
      role="menuitem"
      tabindex="-1"
      class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        class="size-6 text-gray-500 group-hover/dropdown-menu-item:text-gray-700 dark:text-gray-400 dark:group-hover/dropdown-menu-item:text-gray-300">
        <path
          d="M17.775 19.107v-.261a4.5 4.5 0 00-4.5-4.5h-2.55a4.5 4.5 0 00-4.5 4.5v.261M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0zm-6.483-2.732a2.768 2.768 0 11-5.536 0 2.768 2.768 0 015.536 0z"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round" />
      </svg>
      <span x-text="$t('userDropdown.editProfile')">Edit profile</span>
    </a>
    <div class="-mx-3 my-1.5 h-px bg-gray-100 dark:bg-gray-700"></div>

    <!-- Sign Out (Destructive) -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}">
      @csrf

      <button
        type="button"
        onclick="confirmLogout()"
        role="menuitem"
        class="group/dropdown-menu-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium text-red-500 outline-hidden transition-colors duration-200 select-none hover:bg-red-50 hover:text-red-600 focus:bg-red-50 focus:text-red-600 dark:text-red-400 dark:hover:bg-red-500/10 dark:hover:text-red-400 dark:focus:bg-red-500/10 dark:focus:text-red-400">

        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          class="size-5 text-red-500 dark:text-red-400">
          <path
            d="M4 12h7.75M8 8l-3.998 4 3.997 4M9.75 4.996V4.25a1.5 1.5 0 011.5-1.5h6a1.5 1.5 0 011.5 1.5v15.5a1.5 1.5 0 01-1.5 1.5V19"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>

        <span x-text="$t('userDropdown.signOut')">Sign out</span>
      </button>
    </form>

    <script>
      function confirmLogout() {
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: 'Anda akan keluar dari akun ini.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Ya, Logout!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
          }
        });
      }
    </script>
  </div>
</div>