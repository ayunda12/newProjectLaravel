@extends('layouts.appdashboard')

@section('title', 'Dashboard')

@section('content')
<div
    class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageTitle: 'Profile' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2
                class="text-xl font-semibold text-gray-800 dark:text-white/90"
                x-text="pageTitle || pageName"></h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a
                            class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                            href="{{route ('dashboard')}}">
                            Home
                            <svg
                                class="stroke-current rtl:rotate-180"
                                width="17"
                                height="16"
                                viewBox="0 0 17 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                                    stroke=""
                                    stroke-width="1.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                    <li
                        class="text-sm text-gray-800 dark:text-white/90"
                        x-text="pageTitle || pageName"></li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="space-y-6">
        <div
            x-data="{
                    profileData: {
                      avatarUrl: @js(auth()->user()->image
                                ? asset('images/' . auth()->user()->image)
                                : asset('images/user/owner.png')),
                      fullName: @js(auth()->user()->name ?? ''),
                      email: @js(auth()->user()->email ?? ''),
                      phone: @js(auth()->user()->phone ?? ''),
                      bio: 'Team Manager',
                      socialLinks: {
                        facebook: @js(auth()->user()->fb ?? ''),
                        x: @js(auth()->user()->tiktok ?? ''),
                        linkedin: @js(auth()->user()->linkedn ?? ''),
                        instagram: @js(auth()->user()->ig ?? ''),
                      }
                    },
                    isDialogOpen: false,
                    editForm: {
                      fullName: '',
                      email: '',
                      phone: '',
                      socialLinks: {
                        facebook: '',
                        x: '',
                        linkedin: '',
                        instagram: ''
                      }
                    },
                    avatarPreview: null,
                    init() {
                      this.resetEditForm();
                    },
                    resetEditForm() {
                      this.editForm = JSON.parse(JSON.stringify(this.profileData));
                      this.avatarPreview = this.profileData.avatarUrl;
                    },
                    openEditDialog() {
                      this.resetEditForm();
                      this.isDialogOpen = true;
                    },
                    handleAvatarChange(event) {
                      const file = event.target.files[0];
                      if (file) {
                        this.avatarPreview = URL.createObjectURL(file);
                      }
                    },
                  }"
            class="relative space-y-6 overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 lg:p-7 dark:border-gray-800 dark:bg-white/3">
            <!-- Top Header Row: Title & Edit Button -->
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90">
                    Personal Information
                </h2>

                <button
                    type="button"
                    @click="openEditDialog()"
                    class="inline-flex h-9 shrink-0 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-transparent px-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">
                    <svg
                        class="size-4.5"
                        width="21"
                        height="21"
                        viewBox="0 0 21 21"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
                            fill="currentColor" />
                    </svg>
                    <span>Edit</span>
                </button>
            </div>

            <!-- Profile Pic & Basic Meta -->
            <div class="flex items-center gap-4 sm:gap-6">
                <div
                    class="relative flex size-16 shrink-0 rounded-full select-none sm:size-20">
                    <template x-if="profileData.avatarUrl">
                        <img
                            :src="profileData.avatarUrl"
                            :alt="profileData.fullName || 'User profile'"
                            class="aspect-square size-full rounded-full object-cover" />
                    </template>
                    <template x-if="!profileData.avatarUrl">
                        <div
                            class="flex size-full items-center justify-center rounded-full bg-brand-400 text-xl font-medium text-white sm:text-2xl dark:bg-brand-400 dark:text-white"
                            x-text="profileData.firstName?.trim() ? profileData.firstName.trim()[0].toUpperCase() : 'M'"></div>
                    </template>
                </div>

                <div class="flex flex-col gap-1">
                    <h3
                        class="text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90"
                        x-text="profileData.fullName?.trim() || 'N/A'">
                    </h3>
                </div>
            </div>

            <!-- Details & Social Links Grid -->
            <div class="mb-0 grid grid-cols-1 gap-6 sm:grid-cols-3">

                <!-- Email -->
                <div class="min-w-0 flex flex-col gap-6">
                    <div class="flex flex-col gap-1 sm:gap-2">
                        <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
                            Email address
                        </p>
                        <p
                            class="min-w-0 break-all text-sm font-medium text-gray-800 sm:text-base dark:text-white/90"
                            x-text="profileData.email?.trim() || 'N/A'">
                        </p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="min-w-0 flex flex-col gap-6">
                    <div class="flex flex-col gap-1 sm:gap-2">
                        <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
                            Phone
                        </p>

                        <p
                            class="text-sm font-medium text-gray-800 sm:text-base dark:text-white/90"
                            x-text="profileData.phone?.trim() || 'N/A'">
                        </p>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="min-w-0 flex flex-col gap-6">
                    <div class="flex flex-col gap-2 sm:gap-3">
                        <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
                            Social links
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Facebook -->
                            <a
                                :href="profileData.socialLinks.facebook || '#'"
                                target="_blank"
                                rel="noreferrer"
                                aria-label="Facebook"
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">
                                <svg class="size-5 fill-current" viewBox="0 0 20 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.667 11.25h2.083l.833-3.333h-2.916V6.25c0-.857 0-1.666 1.666-1.666h1.25v-2.8a23.397 23.397 0 00-2.38-.117c-2.263 0-3.87 1.38-3.87 3.916v2.334h-2.5v3.333h2.5v7.084h3.334V11.25z"
                                        fill="currentColor" />
                                </svg>
                            </a>

                            <!-- TikTok -->
                            <a
                                :href="profileData.socialLinks.tiktok || '#'"
                                target="_blank"
                                rel="noreferrer"
                                aria-label="TikTok"
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">

                                <svg class="size-5 fill-current" viewBox="0 0 24 24"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.589 6.686a4.793 4.793 0 0 1-3.77-4.245V2h-3.677v13.672a2.896 2.896 0 0 1-2.893 2.829 2.9 2.9 0 0 1-2.9-2.9 2.9 2.9 0 0 1 2.9-2.9c.298 0 .59.046.87.133V9.085a6.7 6.7 0 0 0-.87-.058 6.577 6.577 0 0 0-6.577 6.574 6.577 6.577 0 0 0 6.577 6.577 6.577 6.577 0 0 0 6.577-6.577V8.61a8.4 8.4 0 0 0 4.914 1.58V6.52a4.8 4.8 0 0 1-1.151.166z" />
                                </svg>
                            </a>
                            <!-- LinkedIn -->
                            <a
                                :href="profileData.socialLinks.linkedin || '#'"
                                target="_blank"
                                rel="noreferrer"
                                aria-label="LinkedIn"
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">
                                <svg class="size-5 fill-current" viewBox="0 0 20 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.969 7.523a4.14 4.14 0 012.167-.226c.726.124 1.393.454 1.878 1.018.482.56.82 1.39.82 2.577V17h-2.292v-4.975c0-.934-.28-1.673-.758-2.178a2.276 2.276 0 00-1.748-.716c-1.282.046-2.468 1.12-2.469 2.894V17H8.283V7.567h2.306l-.022.887.939.253c.276-.503.796-.923 1.463-1.184zm-7.635.044V17H3V7.567h2.334zM4.152 3a1.166 1.166 0 11-.07 2.331 1.166 1.166 0 01.07-2.33z"
                                        fill="currentColor" stroke="currentColor" />
                                </svg>
                            </a>

                            <!-- Instagram -->
                            <a
                                :href="profileData.socialLinks.instagram || '#'"
                                target="_blank"
                                rel="noreferrer"
                                aria-label="Instagram"
                                class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">
                                <svg class="size-5 fill-current" viewBox="0 0 20 20"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.857 1.667c.938.002 1.413.007 1.824.019l.161.005.594.025c.886.041 1.491.182 2.023.388a4.06 4.06 0 011.476.961c.462.463.749.928.961 1.476.206.531.346 1.137.388 2.023.01.223.018.407.024.594l.005.161c.013.411.018.886.02 1.824v1.713a65.505 65.505 0 01-.019 1.824l-.005.162-.025.593c-.041.887-.182 1.492-.388 2.023a4.07 4.07 0 01-.961 1.476c-.463.463-.93.75-1.476.961-.532.206-1.137.346-2.023.388l-.594.025-.162.005c-.41.012-.885.018-1.823.02H9.144a65.1 65.1 0 01-1.824-.02l-.162-.005a53.705 53.705 0 01-.593-.025c-.887-.04-1.491-.182-2.023-.388a4.073 4.073 0 01-1.476-.96 4.086 4.086 0 01-.962-1.477c-.206-.531-.345-1.136-.387-2.023l-.025-.593-.005-.162c-.012-.41-.018-.886-.02-1.824V9.143c.002-.938.007-1.413.02-1.824l.005-.161c.006-.187.014-.371.025-.594.04-.887.181-1.491.387-2.023a4.066 4.066 0 01.962-1.476 4.08 4.08 0 011.476-.961c.531-.206 1.135-.346 2.023-.388.222-.01.406-.018.593-.024l.162-.005c.41-.013.886-.018 1.824-.02h1.713zM10 5.833a4.166 4.166 0 100 8.333 4.166 4.166 0 000-8.333zM10 7.5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm4.375-2.917a1.042 1.042 0 10.001 2.084 1.042 1.042 0 000-2.084z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Edit Personal Information Modal -->
            <div
                x-show="isDialogOpen"
                x-cloak
                @keydown.escape.window="isDialogOpen = false"
                class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-4 sm:p-5"
                style="display: none">
                <!-- Backdrop -->
                <div
                    @click="isDialogOpen = false"
                    x-show="isDialogOpen"
                    x-transition.opacity
                    class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px] dark:bg-black/80"></div>

                <!-- Modal Dialog -->
                <div
                    x-show="isDialogOpen"
                    x-transition
                    @click.outside="isDialogOpen = false"
                    class="relative no-scrollbar flex max-h-[90vh] w-full max-w-2xl flex-col overflow-y-auto rounded-3xl bg-white p-6 sm:p-8 dark:bg-gray-900">
                    <!-- Close Button -->
                    <button
                        @click="isDialogOpen = false"
                        type="button"
                        class="absolute top-5 right-5 z-20 flex size-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-600 dark:bg-white/5 dark:text-gray-400 dark:hover:bg-white/10 dark:hover:text-gray-300"
                        aria-label="Close">
                        <svg
                            class="size-5 fill-current"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z" />
                        </svg>
                    </button>

                    <div class="pe-10">
                        <h3
                            class="text-xl font-semibold text-gray-800 sm:text-2xl dark:text-white/90">
                            Edit Personal Information
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Update your details to keep your profile up-to-date.
                        </p>
                    </div>

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-4 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Change Profile Picture -->
                        <div class="space-y-4">
                            <h4 class="text-base font-medium text-gray-800 dark:text-white/90">
                                Change Profile Picture
                            </h4>

                            <div class="flex items-center gap-4 sm:gap-6">
                                <div class="relative">
                                    <div
                                        class="size-20 shrink-0 overflow-hidden rounded-full sm:size-24">
                                        <img
                                            :src="avatarPreview || profileData.avatarUrl"
                                            :alt="profileData.fullName"
                                            class="size-full object-cover" />
                                    </div>

                                    <!-- Overlaid Camera Button -->
                                    <label
                                        for="profile-avatar-file-input"
                                        class="absolute inset-e-0 bottom-0 flex size-8 cursor-pointer items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                                        aria-label="Upload profile picture">
                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="size-4.5">
                                            <path
                                                d="M12.6732 3.41872C12.4373 3.10275 12.066 2.91667 11.6717 2.91667H8.32825C7.93391 2.91667 7.56268 3.10275 7.32672 3.41872L6.83189 4.08131C6.59593 4.39727 6.2247 4.58336 5.83036 4.58336H3.54167C2.85131 4.58336 2.29167 5.14301 2.29167 5.83336V14.375C2.29167 15.0654 2.85131 15.625 3.54167 15.625H16.4583C17.1487 15.625 17.7083 15.0654 17.7083 14.375V5.83336C17.7083 5.14301 17.1487 4.58336 16.4583 4.58336H14.1696C13.7752 4.58336 13.404 4.39727 13.1681 4.08131L12.6732 3.41872Z"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M13.3333 9.79329C13.3333 11.6342 11.8409 13.1266 10 13.1266C8.15905 13.1266 6.66667 11.6342 6.66667 9.79329C6.66667 7.95234 8.15905 6.45996 10 6.45996C11.8409 6.45996 13.3333 7.95234 13.3333 9.79329Z"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </label>

                                    <input
                                        type="file"
                                        id="profile-avatar-file-input"
                                        name="image"
                                        accept="image/png,image/jpeg,image/webp"
                                        @change="handleAvatarChange($event)"
                                        class="hidden" />
                                </div>

                                <div
                                    class="flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                                    <p class="font-normal">Upload a square image (200×200 px)</p>
                                    <p class="font-normal">in JPEG or PNG format.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information Fields -->
                        <div class="space-y-4">
                            <h4 class="text-base font-medium text-gray-800 dark:text-white/90">
                                Personal Information
                            </h4>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        x-model="editForm.fullName"
                                        value="{{ old('name', auth()->user()->name ?? '') }}"
                                        placeholder="Enter Full Name"
                                        required
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        x-model="editForm.email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}"
                                        placeholder="info@example.com"
                                        required
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Phone <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="phone"
                                        x-model="editForm.phone"
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                        placeholder="+09 363 398 46"
                                        required
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>
                            </div>
                        </div>

                        <!-- Social Links Fields -->
                        <div class="space-y-4">
                            <h4 class="text-base font-medium text-gray-800 dark:text-white/90">
                                Social Links
                            </h4>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Facebook
                                    </label>
                                    <input
                                        type="url"
                                        name="fb"
                                        x-model="editForm.socialLinks.facebook"
                                        value="{{ old('fb', auth()->user()->fb ?? '') }}"
                                        placeholder="https://facebook.com/username"
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>

                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Tiktok
                                    </label>
                                    <input
                                        type="url"
                                        name="tiktok"
                                        x-model="editForm.socialLinks.x"
                                        value="{{ old('tiktok', auth()->user()->tiktok ?? '') }}"
                                        placeholder="https://tiktok.com/@username"
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>

                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Linkedin
                                    </label>
                                    <input
                                        type="url"
                                        name="linkedn"
                                        x-model="editForm.socialLinks.linkedin"
                                        value="{{ old('linkedn', auth()->user()->linkedn ?? '') }}"
                                        placeholder="https://linkedin.com/in/username"
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>

                                <div>
                                    <label
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Instagram
                                    </label>
                                    <input
                                        type="url"
                                        name="ig"
                                        x-model="editForm.socialLinks.instagram"
                                        value="{{ old('ig', auth()->user()->ig ?? '') }}"
                                        placeholder="https://instagram.com/username"
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex flex-col-reverse justify-end gap-3 pt-3 sm:flex-row">
                            <button
                                type="button"
                                @click="isDialogOpen = false"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3">
                                Close
                            </button>
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div
            x-data="{
                isPasswordModalOpen: @json($errors->updatePassword->isNotEmpty()),
                twoFactorEnabled: false,
                passwordForm: {
                  currentPassword: '',
                  newPassword: '',
                  confirmPassword: ''
                },
                openPasswordModal() {
                  this.passwordForm = {
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: ''
                  };
                  this.isPasswordModalOpen = true;
                },
              }"
            class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/3">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Security
            </h4>
            @if (session('status') === 'password-updated')
            <div class="mt-3 rounded-lg bg-green-50 p-3 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-400">
                Password berhasil diperbarui.
            </div>
            @endif
            <div class="mt-1">
                <!-- Change Password -->
                <div
                    class="flex flex-col justify-between gap-4 border-b border-gray-200 py-4 first:pt-0 sm:flex-row sm:items-center dark:border-gray-800">
                    <div>
                        <h4 class="mb-1 text-base font-medium text-gray-800 dark:text-white/90">
                            Change Password
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Receive real-time notifications and team alerts.
                        </p>
                    </div>
                    <div class="flex shrink-0 items-center">
                        <button
                            type="button"
                            @click="openPasswordModal()"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">
                            <svg
                                class="size-5"
                                width="21"
                                height="21"
                                viewBox="0 0 21 21"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
                                    fill="currentColor" />
                            </svg>
                            <span>Change Password</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Change Password Modal -->
            <div
                x-show="isPasswordModalOpen"
                x-cloak
                @keydown.escape.window="isPasswordModalOpen = false"
                class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-4 sm:p-5"
                style="display: none">
                <!-- Backdrop -->
                <div
                    @click="isPasswordModalOpen = false"
                    x-show="isPasswordModalOpen"
                    x-transition.opacity
                    class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px] dark:bg-black/80"></div>

                <!-- Modal Dialog -->
                <div
                    x-show="isPasswordModalOpen"
                    x-transition
                    @click.outside="isPasswordModalOpen = false"
                    class="relative no-scrollbar flex max-h-[90vh] w-full max-w-[calc(100%-2rem)] flex-col overflow-y-auto rounded-3xl bg-white p-6 sm:max-w-146 sm:p-10 dark:bg-gray-900">
                    <!-- Close Button -->
                    <button
                        @click="isPasswordModalOpen = false"
                        type="button"
                        class="absolute top-5 right-5 z-20 flex size-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-600 sm:top-7 sm:right-7 dark:bg-white/5 dark:text-gray-400 dark:hover:bg-white/10 dark:hover:text-gray-300"
                        aria-label="Close">
                        <svg
                            class="size-5 fill-current"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z" />
                        </svg>
                    </button>

                    <div class="pe-14 text-start">
                        <h3
                            class="text-xl font-semibold text-gray-800 sm:text-2xl dark:text-white/90">
                            Change Password
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Use a strong password to protect your account
                        </p>
                    </div>

                    <form
                        action="{{ route('profile.password.update') }}"
                        method="POST"
                        class="mt-6 space-y-5">
                        @csrf
                        @method('PUT')

                        @if ($errors->updatePassword->any())
                        <div class="rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-500/10 dark:text-red-400">
                            <ul class="list-disc space-y-1 ps-5">
                                @foreach ($errors->updatePassword->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Current Password
                            </label>
                            <input
                                type="password"
                                name="current_password"
                                x-model="passwordForm.currentPassword"
                                placeholder="Enter current password"
                                class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                New Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                x-model="passwordForm.newPassword"
                                placeholder="Enter new password"
                                class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Confirm Password
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                x-model="passwordForm.confirmPassword"
                                placeholder="Confirm new password"
                                class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex flex-col-reverse justify-end gap-3 pt-2 sm:flex-row">
                            <button
                                type="button"
                                @click="isPasswordModalOpen = false"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3">
                                Close
                            </button>
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection