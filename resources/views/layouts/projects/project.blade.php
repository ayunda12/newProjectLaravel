@extends('layouts.appdashboard')

@section('title', 'Dashboard')

@section('content')
<div
    class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageTitle: 'Projects' }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Projects
            </h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a
                            class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                            href="{{ route('dashboard') }}">
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

    <div class="space-y-5 sm:space-y-6">
        <!-- Data Table 1 -->
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Data Projects
                    </h3>
                </div>

                <button
                    type="button" id="openAddModal" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Tambah Project
                </button>
            </div>
            @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
            @endif
            <div class="space-y-5 border-t border-gray-100 p-4 sm:p-6 dark:border-gray-800">
                {{-- Tabel --}}
                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800">
                    <table id="projectTable" class="w-full text-left text-sm">

                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr class="border-b border-gray-200 dark:border-gray-800">
                                <th class="whitespace-nowrap px-5 py-4 font-semibold text-gray-600 dark:text-gray-300">
                                    No
                                </th>
                                <th class="whitespace-nowrap px-5 py-4 font-semibold text-gray-600 dark:text-gray-300">
                                    Nama Project
                                </th>
                                <th class="whitespace-nowrap px-5 py-4 font-semibold text-gray-600 dark:text-gray-300">
                                    Tahun
                                </th>
                                <th class="px-5 py-4 font-semibold text-gray-600 dark:text-gray-300">
                                    Deskripsi
                                </th>
                                <th class="whitespace-nowrap px-5 py-4 font-semibold text-gray-600 dark:text-gray-300">
                                    Gambar
                                </th>
                                <th class="whitespace-nowrap px-5 py-4 font-semibold text-gray-600 dark:text-gray-300">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($projects as $project)
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                                {{-- Nomor --}}
                                <td class="whitespace-nowrap px-5 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Nama --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $project->nama }}
                                    </span>
                                </td>

                                {{-- Tahun --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="inline-flex rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                        {{ $project->tahun }}
                                    </span>
                                </td>

                                {{-- Deskripsi --}}
                                <td class="px-5 py-4">
                                    <p class="max-w-xs text-gray-500 dark:text-gray-400"
                                        title="{{ $project->deskripsi }}">
                                        {{ \Illuminate\Support\Str::limit($project->deskripsi, 100) }}
                                    </p>
                                </td>

                                {{-- Gambar --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if ($project->gambar)
                                    <img
                                        src="{{ asset('storage/' . $project->gambar) }}"
                                        alt="{{ $project->nama }}"
                                        class="h-14 w-20 rounded-lg border border-gray-200 object-cover dark:border-gray-700">
                                    @else
                                    <span class="text-gray-400">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">

                                        <!-- View -->
                                        <button
                                            type="button"
                                            onclick="viewProject(this)"
                                            data-nama="{{ $project->nama }}"
                                            data-kategori="{{ $project->kategori }}"
                                            data-tahun="{{ $project->tahun }}"
                                            data-deskripsi="{{ $project->deskripsi }}"
                                            data-gambar="{{ $project->gambar ? asset('storage/' . $project->gambar) : '' }}"
                                            data-link="{{ $project->link }}"
                                            title="Lihat Project"
                                            class="flex size-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:hover:bg-blue-500/20">

                                            <svg width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 5C7 5 2.73 8.11 1 12C2.73 15.89 7 19 12 19C17 19 21.27 15.89 23 12C21.27 8.11 17 5 12 5Z"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                    stroke="currentColor" stroke-width="1.5" />
                                            </svg>
                                        </button>

                                        <!-- Edit -->
                                        <button
                                            type="button"
                                            onclick="editProject(this)"
                                            data-action="{{ route('projects.update', $project->id) }}"
                                            data-nama="{{ $project->nama }}"
                                            data-kategori="{{ $project->kategori }}"
                                            data-tahun="{{ $project->tahun }}"
                                            data-deskripsi="{{ $project->deskripsi }}"
                                            data-gambar="{{ $project->gambar ? asset('storage/' . $project->gambar) : '' }}"
                                            data-link="{{ $project->link }}"
                                            title="Edit Project"
                                            class="flex size-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:bg-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:hover:bg-amber-500/20">

                                            <svg width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 4H7C5.89543 4 5 4.89543 5 6V18C5 19.1046 5.89543 20 7 20H18C19.1046 20 20 19.1046 20 18V14"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                                <path d="M19.5 2.5L21.5 4.5L12 14L9 15L10 12L19.5 2.5Z"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>

                                        <!-- Delete -->
                                        <button
                                            type="button"
                                            onclick="deleteProject(this)"
                                            data-action="{{ route('projects.destroy', $project->id) }}"
                                            data-nama="{{ $project->nama }}"
                                            title="Hapus Project"
                                            class="flex size-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20">

                                            <svg width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 6H21"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                                <path d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                                <path d="M19 6L18 20H6L5 6"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10 11V16M14 11V16"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Modal Tambah Project -->
            <div
                id="addProjectModal"
                class="fixed inset-0 hidden overflow-y-auto bg-gray-900/50"
                style="z-index: 2147483647;">

                <!-- Pembungkus: dialog di tengah, halaman scroll kalau konten tinggi -->
                <div class="flex min-h-full items-center justify-center p-4">

                    <!-- Modal Dialog -->
                    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl dark:bg-gray-900">

                        <!-- Header (ikut scroll) -->
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    Tambah Project
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Silakan lengkapi informasi project berikut.
                                </p>
                            </div>

                            <button
                                type="button"
                                id="closeAddModal"
                                class="flex size-9 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-100 hover:text-red-500 dark:text-gray-400 dark:hover:bg-gray-800">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-6">

                            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                                    <!-- Nama Project -->
                                    <div>
                                        <label for="nama"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Nama <span class="text-red-500">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="nama"
                                            name="nama"
                                            placeholder="Masukkan nama project"
                                            required
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    </div>

                                    <!-- Tahun -->
                                    <div>
                                        <label for="tahun"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Tahun <span class="text-red-500">*</span>
                                        </label>

                                        <input
                                            type="number"
                                            id="tahun"
                                            name="tahun"
                                            placeholder="Contoh: 2026"
                                            min="1900"
                                            max="2100"
                                            required
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    </div>
                                    <!-- Gambar -->
                                    <div>
                                        <label for="gambar"
                                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Upload Gambar
                                        </label>

                                        <input
                                            type="file"
                                            id="gambar"
                                            name="gambar"
                                            accept=".jpg,.jpeg,.png,.webp"
                                            class="h-11 w-full min-w-0 cursor-pointer overflow-hidden rounded-[10px] border border-gray-300 bg-transparent text-sm text-gray-500 shadow-theme-xs transition-colors file:me-4 file:h-full file:cursor-pointer file:border-0 file:border-e file:border-solid file:border-gray-200 file:bg-gray-50 file:px-3.5 file:py-2.5 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-100 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/5 dark:file:text-gray-300 dark:hover:file:bg-white/10 dark:focus:border-brand-500/40" />

                                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                            Accepted: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                                        </p>

                                        <!-- Preview Gambar -->
                                        <div id="previewContainer" class="mt-3 hidden">
                                            <p class="mb-2 text-xs font-medium text-gray-600 dark:text-gray-400">
                                                Preview Gambar
                                            </p>

                                            <div class="relative inline-block">
                                                <img
                                                    id="previewGambar"
                                                    src=""
                                                    alt="Preview Project"
                                                    class="max-h-40 max-w-full rounded-lg border border-gray-200 object-contain dark:border-gray-700">

                                                <button
                                                    type="button"
                                                    id="hapusPreview"
                                                    class="absolute -right-2 -top-2 flex size-7 items-center justify-center rounded-full bg-red-500 text-white shadow-md transition hover:bg-red-600"
                                                    title="Hapus gambar">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        width="15" height="15"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M18 6 6 18" />
                                                        <path d="m6 6 12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <p id="namaFile" class="mt-1 text-xs text-gray-500 dark:text-gray-400"></p>
                                        </div>
                                    </div>

                                    <!-- Link Project -->
                                    <div>
                                        <label for="link"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Link
                                        </label>

                                        <input
                                            type="url"
                                            id="link"
                                            name="link"
                                            placeholder="https://example.com"
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    </div>
                                    <!-- kategori -->
                                    <div>
                                        <label for="kategori"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Kategori <span class="text-red-500">*</span>
                                        </label>

                                        <select
                                            id="kategori"
                                            name="kategori"
                                            required
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            <option value="Aplikasi">Aplikasi</option>
                                            <option value="Poster">Poster</option>

                                        </select>
                                    </div>


                                    <!-- Deskripsi -->
                                    <div class="sm:col-span-2">
                                        <label for="deskripsi"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Deskripsi <span class="text-red-500">*</span>
                                        </label>

                                        <textarea
                                            id="deskripsi"
                                            name="deskripsi"
                                            rows="4"
                                            placeholder="Masukkan deskripsi project"
                                            required
                                            class="w-full resize-y rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
                                    </div>

                                </div>

                                <!-- Footer -->
                                <div class="mt-7 flex justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-800">

                                    <button
                                        type="button"
                                        onclick="document.getElementById('closeAddModal').click()"
                                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Simpan Project
                                    </button>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Modal View Project -->
            <div
                id="viewProjectModal"
                class="fixed inset-0 hidden overflow-y-auto bg-gray-900/50"
                style="z-index: 2147483647;">

                <!-- Pembungkus: dialog di tengah, halaman scroll kalau konten tinggi -->
                <div class="flex min-h-full items-center justify-center p-4">

                    <!-- Modal Dialog -->
                    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl dark:bg-gray-900">

                        <!-- Header (ikut scroll) -->
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    Detail Project
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Informasi lengkap project.
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="closeViewModal()"
                                class="flex size-9 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-100 hover:text-red-500 dark:text-gray-400 dark:hover:bg-gray-800">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-6">

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                                <!-- Nama -->
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nama
                                    </label>
                                    <p id="viewNama"
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></p>
                                </div>

                                <!-- Tahun -->
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tahun
                                    </label>
                                    <p id="viewTahun"
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></p>
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Kategori
                                    </label>
                                    <p id="viewKategori"
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></p>
                                </div>

                                <!-- Link -->
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Link
                                    </label>
                                    <div class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-800">
                                        <a id="viewLink" href="#" target="_blank" rel="noopener noreferrer"
                                            class="hidden break-all text-brand-600 hover:underline dark:text-brand-400">
                                            Lihat Project
                                        </a>
                                        <span id="viewNoLink" class="hidden text-gray-400">-</span>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="sm:col-span-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Deskripsi
                                    </label>
                                    <p id="viewDeskripsi"
                                        class="w-full whitespace-pre-line rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></p>
                                </div>

                                <!-- Gambar -->
                                <div class="sm:col-span-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Gambar
                                    </label>
                                    <img id="viewGambar"
                                        src=""
                                        alt="Gambar Project"
                                        class="hidden max-h-72 w-full rounded-lg border border-gray-200 object-contain dark:border-gray-700">
                                    <p id="viewNoGambar" class="hidden text-sm text-gray-400">
                                        Tidak ada gambar.
                                    </p>
                                </div>

                            </div>

                            <!-- Footer -->
                            <div class="mt-7 flex justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-800">
                                <button
                                    type="button"
                                    onclick="closeViewModal()"
                                    class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                    Tutup
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Project -->
            <div
                id="editProjectModal"
                class="fixed inset-0 hidden overflow-y-auto bg-gray-900/50"
                style="z-index: 2147483647;">

                <div class="flex min-h-full items-center justify-center p-4">

                    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl dark:bg-gray-900">

                        <!-- Header -->
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    Edit Project
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Perbarui informasi project berikut.
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="closeEditModal()"
                                class="flex size-9 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-100 hover:text-red-500 dark:text-gray-400 dark:hover:bg-gray-800">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-6">

                            <form id="editProjectForm" action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                                    <!-- Nama -->
                                    <div>
                                        <label for="edit_nama"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Nama <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            id="edit_nama"
                                            name="nama"
                                            required
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    </div>

                                    <!-- Tahun -->
                                    <div>
                                        <label for="edit_tahun"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Tahun <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            id="edit_tahun"
                                            name="tahun"
                                            min="1900"
                                            max="2100"
                                            required
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    </div>

                                    <!-- Gambar -->
                                    <div>
                                        <label for="edit_gambar"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Gambar
                                        </label>
                                        <input
                                            type="file"
                                            id="edit_gambar"
                                            name="gambar"
                                            accept="image/*"
                                            class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-white text-sm text-gray-600 file:mr-3 file:cursor-pointer file:border-0 file:bg-gray-100 file:px-3 file:py-2.5 file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-gray-200">
                                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                            Kosongkan jika tidak ingin mengganti gambar.
                                        </p>
                                    </div>

                                    <!-- Link -->
                                    <div>
                                        <label for="edit_link"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Link
                                        </label>
                                        <input
                                            type="url"
                                            id="edit_link"
                                            name="link"
                                            placeholder="https://example.com"
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    </div>

                                    <!-- Kategori -->
                                    <div>
                                        <label for="edit_kategori"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Kategori <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            id="edit_kategori"
                                            name="kategori"
                                            required
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                            <option value="" disabled>-- Pilih Kategori --</option>
                                            <option value="Aplikasi">Aplikasi</option>
                                            <option value="Poster">Poster</option>
                                        </select>
                                    </div>

                                    <!-- Preview gambar saat ini -->
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Gambar Saat Ini
                                        </label>
                                        <img id="edit_preview" src="" alt="Gambar saat ini"
                                            class="hidden h-24 w-full rounded-lg border border-gray-200 object-cover dark:border-gray-700">
                                        <p id="edit_no_preview" class="text-sm text-gray-400">Tidak ada gambar.</p>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="sm:col-span-2">
                                        <label for="edit_deskripsi"
                                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Deskripsi <span class="text-red-500">*</span>
                                        </label>
                                        <textarea
                                            id="edit_deskripsi"
                                            name="deskripsi"
                                            rows="4"
                                            required
                                            class="w-full resize-y rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
                                    </div>

                                </div>

                                <!-- Footer -->
                                <div class="mt-7 flex justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-800">
                                    <button
                                        type="button"
                                        onclick="closeEditModal()"
                                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Update Project
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Form Hapus Project -->
            <form id="deleteProjectForm" action="" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // DataTables
        new DataTable('#projectTable', {
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            ordering: true,
            searching: true,
            columnDefs: [{
                    orderable: false,
                    targets: 5
                } // kolom Aksi tidak perlu sorting
            ],
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data project',
                paginate: {
                    previous: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12.5 5L7.5 10L12.5 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    next: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                }
            }
        });

        // ===== Modal Tambah Project =====
        const modal = document.getElementById('addProjectModal');
        const openButton = document.getElementById('openAddModal');
        const closeButton = document.getElementById('closeAddModal');

        // Pindahkan modal ke body agar tidak tertutup elemen dashboard
        document.body.appendChild(modal);

        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openButton.addEventListener('click', openModal);
        closeButton.addEventListener('click', closeModal);

        // Klik area gelap di luar dialog putih untuk menutup
        modal.addEventListener('click', function(event) {
            if (!event.target.closest('.max-w-2xl')) {
                closeModal();
            }
        });



        // ===== Modal View Project =====
        const viewModal = document.getElementById('viewProjectModal');

        // Pindahkan modal ke body agar tidak tertutup elemen dashboard
        document.body.appendChild(viewModal);

        window.viewProject = function(button) {
            const data = button.dataset;

            document.getElementById('viewNama').textContent = data.nama;
            document.getElementById('viewKategori').textContent = data.kategori || '-';
            document.getElementById('viewTahun').textContent = data.tahun;
            document.getElementById('viewDeskripsi').textContent = data.deskripsi;

            // Gambar
            const gambar = document.getElementById('viewGambar');
            const noGambar = document.getElementById('viewNoGambar');

            if (data.gambar) {
                gambar.src = data.gambar;
                gambar.classList.remove('hidden');
                noGambar.classList.add('hidden');
            } else {
                gambar.removeAttribute('src');
                gambar.classList.add('hidden');
                noGambar.classList.remove('hidden');
            }

            // Link
            const link = document.getElementById('viewLink');
            const noLink = document.getElementById('viewNoLink');

            if (data.link) {
                link.href = data.link;
                link.classList.remove('hidden');
                noLink.classList.add('hidden');
            } else {
                link.removeAttribute('href');
                link.classList.add('hidden');
                noLink.classList.remove('hidden');
            }

            viewModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        window.closeViewModal = function() {
            viewModal.classList.add('hidden');
            document.body.style.overflow = '';
        };

        // Klik area gelap di luar dialog putih untuk menutup
        viewModal.addEventListener('click', function(event) {
            if (!event.target.closest('.max-w-2xl')) {
                window.closeViewModal();
            }
        });

        // Tombol ESC untuk menutup modal yang sedang terbuka
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (!modal.classList.contains('hidden')) closeModal();
                if (!viewModal.classList.contains('hidden')) window.closeViewModal();
                if (!editModal.classList.contains('hidden')) window.closeEditModal();
            }
        });



        // ===== Modal Edit Project =====
        const editModal = document.getElementById('editProjectModal');
        const editForm = document.getElementById('editProjectForm');

        document.body.appendChild(editModal);

        window.editProject = function(button) {
            const data = button.dataset;

            // Arahkan form ke route update project ini
            editForm.action = data.action;

            document.getElementById('edit_nama').value = data.nama;
            document.getElementById('edit_tahun').value = data.tahun;
            document.getElementById('edit_kategori').value = data.kategori;
            document.getElementById('edit_link').value = data.link || '';
            document.getElementById('edit_deskripsi').value = data.deskripsi;
            document.getElementById('edit_gambar').value = ''; // reset input file

            // Preview gambar saat ini
            const preview = document.getElementById('edit_preview');
            const noPreview = document.getElementById('edit_no_preview');

            if (data.gambar) {
                preview.src = data.gambar;
                preview.classList.remove('hidden');
                noPreview.classList.add('hidden');
            } else {
                preview.removeAttribute('src');
                preview.classList.add('hidden');
                noPreview.classList.remove('hidden');
            }

            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        window.closeEditModal = function() {
            editModal.classList.add('hidden');
            document.body.style.overflow = '';
        };

        // Klik area gelap di luar dialog putih untuk menutup
        editModal.addEventListener('click', function(event) {
            if (!event.target.closest('.max-w-2xl')) {
                window.closeEditModal();
            }
        });

        // ===== Hapus Project =====
        window.deleteProject = function(button) {
            const {
                action,
                nama
            } = button.dataset;

            Swal.fire({
                title: 'Hapus project?',
                text: `Project "${nama}" akan dihapus permanen dan tidak bisa dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteProjectForm');
                    form.action = action;
                    form.submit();
                }
            });
        };

    });
</script>

@if (session('status'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Project berhasil ditambahkan!',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#16a34a'
        });
    });
</script>
@endif

@if (session('successEdit'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Project berhasil diperbarui!',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#16a34a'
        });
    });
</script>
@endif

@if (session('successDelete'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Project berhasil dihapus!',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#16a34a'
        });
    });
</script>
@endif
@endpush


@push('styles')
<style>
    #addProjectModal,
    #viewProjectModal,
    #editProjectModal {
        overscroll-behavior: contain;
    }

    /* Container DataTables */
    #projectTable_wrapper {
        width: 100%;
        color: #667085;
        font-size: 14px;
    }

    /* Hilangkan jarak antar baris layout DataTables (penyebab garis kolom tidak menyambung) */
    #projectTable_wrapper .dt-layout-row {
        margin: 0 !important;
    }

    #projectTable_wrapper .dt-layout-row.dt-layout-table .dt-layout-cell {
        padding: 0 !important;
    }

    #projectTable_wrapper .dt-layout-cell {
        padding-top: 0;
        padding-bottom: 0;
    }

    /* Toolbar Search dan Show Entries */
    #projectTable_wrapper .dt-layout-row:first-child {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        margin: 0;
        border-bottom: 1px solid #e5e7eb;
    }

    #projectTable_wrapper .dt-length,
    #projectTable_wrapper .dt-search {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #667085;
        font-weight: 500;
    }

    /* Dropdown Show Entries */
    #projectTable_wrapper .dt-length select {
        min-width: 65px;
        padding: 7px 24px 7px 10px;
        border: 1px solid #d0d5dd;
        border-radius: 8px;
        background-color: white;
        color: #344054;
        outline: none;
        cursor: pointer;
    }

    /* Search Input */
    #projectTable_wrapper .dt-search input {
        width: 220px;
        padding: 9px 12px;
        border: 1px solid #d0d5dd;
        border-radius: 8px;
        background-color: white;
        color: #344054;
        outline: none;
        margin-left: 0;
    }

    #projectTable_wrapper .dt-search input:focus,
    #projectTable_wrapper .dt-length select:focus {
        border-color: #465fff;
        box-shadow: 0 0 0 2px rgba(70, 95, 255, 0.1);
    }

    /* Tabel Utama */
    #projectTable {
        width: 100% !important;
        table-layout: auto !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    /* Rata kiri semua kolom (supaya ikon sorting tidak pindah ke kiri) */
    #projectTable thead th,
    #projectTable tbody td {
        text-align: left !important;
    }

    /* Header */
    #projectTable thead th {
        padding: 14px 16px !important;
        background-color: #f9fafb;
        color: #667085;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb !important;
        border-right: 1px solid #e5e7eb !important;
    }

    #projectTable thead th:last-child {
        border-right: none !important;
    }

    /* Hilangkan kotak abu-abu tebal saat kolom diklik/difokus */
    #projectTable thead th:focus,
    #projectTable thead th:focus-visible {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Ikon sorting hanya di kanan */
    #projectTable thead th.dt-orderable-asc,
    #projectTable thead th.dt-orderable-desc,
    #projectTable thead th.dt-ordering-asc,
    #projectTable thead th.dt-ordering-desc {
        padding-right: 28px !important;
    }

    #projectTable thead th .dt-column-order {
        right: 10px;
    }

    /* Isi Tabel */
    #projectTable tbody td {
        padding: 14px 16px !important;
        color: #475467;
        font-size: 13px;
        border-bottom: 1px solid #e5e7eb !important;
        border-right: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    #projectTable tbody td:last-child {
        border-right: none;
    }

    /* Deskripsi */
    #projectTable tbody td:nth-child(4) {
        min-width: 180px;
        max-width: 300px;
        white-space: normal;
        overflow-wrap: break-word;
    }

    /* Gambar */
    #projectTable tbody td img {
        width: 64px;
        height: 48px;
        object-fit: cover;
        border-radius: 7px;
    }

    /* Hover Baris */
    #projectTable tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Footer: info + pagination */
    #projectTable_wrapper .dt-layout-row:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 24px 20px;
        margin: 0;
    }

    #projectTable_wrapper .dt-info {
        padding: 8px 0 8px 12px;
        font-size: 14px;
        font-weight: 500;
        color: #667085;
    }

    /* Susunan tombol pagination */
    #projectTable_wrapper .dt-paging nav {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 0;
    }

    /* Tombol pagination (kotak, border, rounded) */
    #projectTable_wrapper .dt-paging-button {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        margin: 0 !important;
        padding: 0 12px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        background: #ffffff !important;
        color: #344054 !important;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    /* Sembunyikan tombol « dan » */
    #projectTable_wrapper .dt-paging-button.first,
    #projectTable_wrapper .dt-paging-button.last {
        display: none !important;
    }

    /* Halaman aktif */
    #projectTable_wrapper .dt-paging-button.current {
        background: #465fff !important;
        border-color: #465fff !important;
        color: #ffffff !important;
    }

    /* Hover */
    #projectTable_wrapper .dt-paging-button:hover:not(.current):not(.disabled) {
        background: #f2f4f7 !important;
        border-color: #d0d5dd !important;
        color: #344054 !important;
    }

    /* Tombol nonaktif (prev di halaman 1, next di halaman terakhir) */
    #projectTable_wrapper .dt-paging-button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        color: #98a2b3 !important;
    }

    /* Responsive */
    @media (max-width: 640px) {

        #projectTable_wrapper .dt-layout-row:first-child,
        #projectTable_wrapper .dt-layout-row:last-child {
            flex-wrap: wrap;
            padding: 14px;
        }

        #projectTable_wrapper .dt-search input {
            width: 170px;
        }
    }

    /* Dark Mode */
    .dark #projectTable_wrapper {
        color: #98a2b3;
    }

    .dark #projectTable_wrapper .dt-layout-row:first-child {
        border-color: #344054;
    }

    .dark #projectTable thead th {
        background-color: #1d2939;
        color: #d0d5dd;
        border-color: #344054 !important;
    }

    .dark #projectTable tbody td {
        color: #d0d5dd;
        border-color: #344054 !important;
    }

    .dark #projectTable tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }

    .dark #projectTable_wrapper .dt-search input,
    .dark #projectTable_wrapper .dt-length select {
        background-color: #101828;
        color: #f2f4f7;
        border-color: #344054;
    }

    .dark #projectTable_wrapper .dt-info {
        color: #98a2b3;
    }

    .dark #projectTable_wrapper .dt-paging-button {
        background: #101828 !important;
        border-color: #344054 !important;
        color: #d0d5dd !important;
    }

    .dark #projectTable_wrapper .dt-paging-button.current {
        background: #465fff !important;
        border-color: #465fff !important;
        color: #ffffff !important;
    }

    .dark #projectTable_wrapper .dt-paging-button:hover:not(.current):not(.disabled) {
        background: rgba(255, 255, 255, 0.05) !important;
    }
</style>
@endpush