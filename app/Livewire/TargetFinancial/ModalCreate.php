<?php

namespace App\Livewire\TargetFinancial;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GoalFinancial;
use Illuminate\Validation\Rule;

class ModalCreate extends Component
{
    use WithFileUploads;

    public $name;
    public $target_amount;
    public $start_date;
    public $end_date;
    public $image;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'target_amount' => ['required', 'numeric', 'min:1000'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'image' => ['nullable', 'image', 'max:2048'], // 2MB
        ];
    }

    protected $messages = [
        'name.required' => 'Nama target wajib diisi',
        'target_amount.required' => 'Jumlah target wajib diisi',
        'target_amount.min' => 'Minimal target Rp 1.000',
        'end_date.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai',
        'image.image' => 'File harus berupa gambar',
        'image.max' => 'Ukuran gambar maksimal 2MB',
    ];

    public function createTarget()
    {
        $this->validate();

        // Upload image jika ada
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('goal-financials', 'public');
        }

        GoalFinancial::create([
            'name' => $this->name,
            'target_amount' => $this->target_amount,
            'image' => $imagePath,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => 'active',
        ]);

        // Reset form
        $this->reset(['name', 'target_amount', 'start_date', 'end_date', 'image']);
        
        // Optional: flash message
        return session()->flash('success', 'Target tabungan berhasil dibuat 🎯');
    }

    public function render()
    {
        return view('livewire.target-financial.modal-create');
    }
}
