<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('layouts.projects.project', compact('projects'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama' => 'string',
            'tahun' => 'integer',
            'deskripsi' => 'string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link' => 'url|nullable',
            'kategori' => 'string',

        ]);

        //upload gambar jika ada
        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('projects', 'public');
        }

        // Simpan data project
        Project::create([
            'nama' => $request->nama,
            'tahun' => $request->tahun,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'kategori' => $request->kategori,
            'link' => $request->link,
        ]);

        return redirect()->route('projects')->with('status', true);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'nama' => 'string',
            'tahun' => 'integer',
            'deskripsi' => 'string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link' => 'url|nullable',
            'kategori' => 'string',

        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama kalau ada
            if ($project->gambar) {
                Storage::disk('public')->delete($project->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect()->route('projects')->with('successEdit', true);
    }

    public function destroy(Project $project)
    {
        // Hapus file gambar dari storage kalau ada
        if ($project->gambar) {
            Storage::disk('public')->delete($project->gambar);
        }

        $project->delete();

        return redirect()->route('projects')->with('successDelete', 'Project berhasil dihapus!');
    }
}
