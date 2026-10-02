<?php

namespace App\Services;

use App\Models\MemoryMessage;
use App\Models\MemoryMessageSetting;
use App\Models\SilentMoment;
use App\Models\FarewellLetter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class MemoryMessageService
{
    /**
     * Get or create page setting.
     */
    public function getSetting(): MemoryMessageSetting
    {
        return MemoryMessageSetting::firstOrCreate(
            ['id' => 1],
            [
                'badge_title' => 'BILIK NOSTALGIA & SUASANA HATI',
                'page_title' => 'Jejak Rasa — Kata yang Belum Sempat Terucap',
                'subtitle' => 'Untuk setiap pelukan perpisahan yang tertahan, rasa terima kasih yang terlambat disampaikan, dan ruang sekretariat yang kini telah sunyi. Di sinilah rasa itu kami abadikan.',
                'audio_title' => 'Alunan Kenangan & Rindu',
                'audio_artist' => 'PIK-R REQUEST',
                'is_audio_active' => true,
            ]
        );
    }

    /**
     * Update page setting.
     */
    public function updateSetting(array $data): MemoryMessageSetting
    {
        $setting = $this->getSetting();

        if (isset($data['audio_file']) && $data['audio_file'] instanceof \Illuminate\Http\UploadedFile) {
            if ($setting->audio_file && File::exists(public_path($setting->audio_file))) {
                @unlink(public_path($setting->audio_file));
            }
            $targetDir = public_path('uploads/memory_messages/audio');
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = 'audio_memory_' . time() . '_' . \Illuminate\Support\Str::random(8) . '.' . $data['audio_file']->getClientOriginalExtension();
            $data['audio_file']->move($targetDir, $filename);
            $data['audio_file'] = 'uploads/memory_messages/audio/' . $filename;
        } elseif (!empty($data['remove_audio'])) {
            if ($setting->audio_file && File::exists(public_path($setting->audio_file))) {
                @unlink(public_path($setting->audio_file));
            }
            $data['audio_file'] = null;
        } else {
            unset($data['audio_file']);
        }

        if (isset($data['banner_image']) && $data['banner_image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($setting->banner_image && File::exists(public_path($setting->banner_image))) {
                @unlink(public_path($setting->banner_image));
            }
            $targetDir = public_path('uploads/memory_messages/banner');
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = 'banner_' . time() . '.' . $data['banner_image']->getClientOriginalExtension();
            $data['banner_image']->move($targetDir, $filename);
            $data['banner_image'] = 'uploads/memory_messages/banner/' . $filename;
        } else {
            unset($data['banner_image']);
        }

        $setting->update($data);
        return $setting;
    }

    /**
     * Get approved public messages with optional category and search filters.
     */
    public function getApprovedMessages(?string $category = null, ?string $generation = null, ?string $search = null): Collection
    {
        $query = MemoryMessage::where('is_approved', true)
            ->orderBy('is_pinned', 'desc')
            ->latest('id');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($generation && $generation !== 'all') {
            $query->where('generation', $generation);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('message', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('sender_name', 'like', "%{$search}%")
                  ->orWhere('sender_role', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    /**
     * Get all unique generations from approved messages.
     */
    public function getAvailableGenerations(): Collection
    {
        return MemoryMessage::where('is_approved', true)
            ->whereNotNull('generation')
            ->where('generation', '!=', '')
            ->pluck('generation')
            ->unique()
            ->values();
    }

    /**
     * Store public unsaid message.
     */
    public function storeMessage(array $data): MemoryMessage
    {
        return MemoryMessage::create([
            'sender_name' => !empty($data['sender_name']) ? trim($data['sender_name']) : 'Anonim',
            'sender_role' => !empty($data['sender_role']) ? trim($data['sender_role']) : null,
            'recipient_name' => trim($data['recipient_name']),
            'generation' => !empty($data['generation']) ? trim($data['generation']) : null,
            'category' => $data['category'] ?? 'terima_kasih',
            'message' => trim($data['message']),
            'paper_theme' => $data['paper_theme'] ?? 'warm',
            'hug_count' => $data['hug_count'] ?? 0,
            'is_pinned' => isset($data['is_pinned']) ? (bool)$data['is_pinned'] : false,
            'is_approved' => isset($data['is_approved']) ? (bool)$data['is_approved'] : true,
        ]);
    }

    /**
     * Update an unsaid message by Admin.
     */
    public function updateMessage(int $id, array $data): MemoryMessage
    {
        $message = MemoryMessage::findOrFail($id);
        $message->update([
            'sender_name' => !empty($data['sender_name']) ? trim($data['sender_name']) : 'Anonim',
            'sender_role' => !empty($data['sender_role']) ? trim($data['sender_role']) : null,
            'recipient_name' => trim($data['recipient_name']),
            'generation' => !empty($data['generation']) ? trim($data['generation']) : null,
            'category' => $data['category'] ?? $message->category,
            'message' => trim($data['message']),
            'paper_theme' => $data['paper_theme'] ?? $message->paper_theme,
            'is_pinned' => isset($data['is_pinned']) ? (bool)$data['is_pinned'] : $message->is_pinned,
            'is_approved' => isset($data['is_approved']) ? (bool)$data['is_approved'] : $message->is_approved,
        ]);
        return $message;
    }

    /**
     * Increment virtual hug reaction.
     */
    public function incrementHug(int $id): int
    {
        $message = MemoryMessage::findOrFail($id);
        $message->increment('hug_count');
        return $message->hug_count;
    }

    /**
     * Get all messages for admin moderation.
     */
    public function getAllMessagesForAdmin(?string $status = null)
    {
        $query = MemoryMessage::latest('id');

        if ($status === 'approved') {
            $query->where('is_approved', true);
        } elseif ($status === 'pending') {
            $query->where('is_approved', false);
        }

        return $query->paginate(20);
    }

    public function toggleApproval(int $id): bool
    {
        $message = MemoryMessage::findOrFail($id);
        $message->is_approved = !$message->is_approved;
        $message->save();
        return $message->is_approved;
    }

    public function togglePin(int $id): bool
    {
        $message = MemoryMessage::findOrFail($id);
        $message->is_pinned = !$message->is_pinned;
        $message->save();
        return $message->is_pinned;
    }

    public function deleteMessage(int $id): void
    {
        $message = MemoryMessage::findOrFail($id);
        $message->delete();
    }

    /**
     * Silent Moments (Ruang yang Kini Sunyi).
     */
    public function getSilentMoments(bool $onlyActive = true): Collection
    {
        $query = SilentMoment::orderBy('order_index', 'asc')->latest('id');
        if ($onlyActive) {
            $query->where('is_active', true);
        }
        return $query->get();
    }

    public function storeSilentMoment(array $data): SilentMoment
    {
        if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
            $targetDir = public_path('uploads/memory_messages/moments');
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = 'moment_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $data['photo']->getClientOriginalExtension();
            $data['photo']->move($targetDir, $filename);
            $data['photo'] = 'uploads/memory_messages/moments/' . $filename;
        }

        return SilentMoment::create($data);
    }

    public function updateSilentMoment(int $id, array $data): SilentMoment
    {
        $moment = SilentMoment::findOrFail($id);

        if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
            if ($moment->photo && File::exists(public_path($moment->photo))) {
                @unlink(public_path($moment->photo));
            }
            $targetDir = public_path('uploads/memory_messages/moments');
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = 'moment_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $data['photo']->getClientOriginalExtension();
            $data['photo']->move($targetDir, $filename);
            $data['photo'] = 'uploads/memory_messages/moments/' . $filename;
        } else {
            unset($data['photo']);
        }

        $moment->update($data);
        return $moment;
    }

    public function deleteSilentMoment(int $id): void
    {
        $moment = SilentMoment::findOrFail($id);
        if ($moment->photo && File::exists(public_path($moment->photo))) {
            @unlink(public_path($moment->photo));
        }
        $moment->delete();
    }

    /**
     * Farewell Letters (Surat Pamit Demisioner).
     */
    public function getFarewellLetters(bool $onlyActive = true): Collection
    {
        $query = FarewellLetter::orderBy('order_index', 'asc')->latest('id');
        if ($onlyActive) {
            $query->where('is_active', true);
        }
        return $query->get();
    }

    public function storeFarewellLetter(array $data): FarewellLetter
    {
        if (isset($data['cover_photo']) && $data['cover_photo'] instanceof \Illuminate\Http\UploadedFile) {
            $targetDir = public_path('uploads/memory_messages/farewells');
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = 'farewell_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $data['cover_photo']->getClientOriginalExtension();
            $data['cover_photo']->move($targetDir, $filename);
            $data['cover_photo'] = 'uploads/memory_messages/farewells/' . $filename;
        }

        return FarewellLetter::create($data);
    }

    public function updateFarewellLetter(int $id, array $data): FarewellLetter
    {
        $letter = FarewellLetter::findOrFail($id);

        if (isset($data['cover_photo']) && $data['cover_photo'] instanceof \Illuminate\Http\UploadedFile) {
            if ($letter->cover_photo && File::exists(public_path($letter->cover_photo))) {
                @unlink(public_path($letter->cover_photo));
            }
            $targetDir = public_path('uploads/memory_messages/farewells');
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = 'farewell_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $data['cover_photo']->getClientOriginalExtension();
            $data['cover_photo']->move($targetDir, $filename);
            $data['cover_photo'] = 'uploads/memory_messages/farewells/' . $filename;
        } else {
            unset($data['cover_photo']);
        }

        $letter->update($data);
        return $letter;
    }

    public function deleteFarewellLetter(int $id): void
    {
        $letter = FarewellLetter::findOrFail($id);
        if ($letter->cover_photo && File::exists(public_path($letter->cover_photo))) {
            @unlink(public_path($letter->cover_photo));
        }
        $letter->delete();
    }
}
