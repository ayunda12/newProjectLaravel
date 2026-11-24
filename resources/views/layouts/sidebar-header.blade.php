<!-- SIDEBAR HEADER -->
<div
    :class="sidebarToggle ? 'xl:justify-center' : 'justify-between'"
    class="sidebar-header flex items-center gap-2 pt-5 pb-8">
    <a href="index.html">
        <span class="sr-only">homepage</span>
        <span class="logo" :class="sidebarToggle ? 'xl:hidden' : ''">
            <!-- <img
                class="h-10 w-37.5 dark:hidden"
                src="./images/logo/logo.svg"
                alt="Logo" /> -->
            <span class="flex items-center gap-2 text-2xl font-bold text-gray-800 dark:text-white">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="26"
                    height="26"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#3371d4"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9" rx="1" />
                    <rect x="14" y="3" width="7" height="5" rx="1" />
                    <rect x="14" y="12" width="7" height="9" rx="1" />
                    <rect x="3" y="16" width="7" height="5" rx="1" />
                </svg>
                Dashboard
            </span>
        </span>
    </a>
</div>
<!-- SIDEBAR HEADER -->