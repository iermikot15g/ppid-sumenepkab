<?php
namespace App\Http\Controllers\Dashboard\Utama;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('dashboard.utama.cms.hero.index', compact('slides'));
    }

    public function create()
    {
        return view('dashboard.utama.cms.hero.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('hero', 'public');

        $slide = HeroSlide::create([
            'image_path' => $imagePath,
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'updated_by' => auth()->id(),
        ]);

        $this->logActivity('create_hero_slide', 'Menambahkan slide hero: ' . ($slide->title ?? 'Slide baru'), $slide);

        return redirect()->route('utama.cms.hero.index')
            ->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('dashboard.utama.cms.hero.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'updated_by' => auth()->id(),
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($heroSlide->image_path);
            $data['image_path'] = $request->file('image')->store('hero', 'public');
        }

        $heroSlide->update($data);

        $this->logActivity('update_hero_slide', 'Memperbarui slide hero: ' . ($heroSlide->title ?? 'Slide'), $heroSlide);

        return redirect()->route('utama.cms.hero.index')
            ->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $this->logActivity('delete_hero_slide', 'Menghapus slide hero: ' . ($heroSlide->title ?? 'Slide'), $heroSlide);
        
        Storage::disk('public')->delete($heroSlide->image_path);
        $heroSlide->delete();

        return redirect()->route('utama.cms.hero.index')
            ->with('success', 'Slide berhasil dihapus.');
    }

    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => !$heroSlide->is_active]);
        
        return response()->json(['success' => true]);
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->orders as $order) {
            HeroSlide::where('id', $order['id'])->update(['sort_order' => $order['position']]);
        }
        
        return response()->json(['success' => true]);
    }
}