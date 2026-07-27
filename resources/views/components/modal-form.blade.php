@props(['id' => '', 'size' => '', 'show' => '', 'title' => ''])
<div id="{{ $id }}" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative w-full {{ $size ? $size : 'max-w-xl' }} bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all modal-dialog">
        <!-- Modal Header -->
        <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
            <h3 class="text-base font-bold modal-title">{{ $title }}</h3>
            <button type="button" onclick="$('#{{ $id }}').addClass('hidden')" class="text-white/80 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <div class="{{ $show }}" id="{{ $show }}"></div>
        </div>
    </div>
</div>
