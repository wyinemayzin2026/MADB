@extends('layouts.staff_app')

@section('content')
    <div class="p-6">
        <!-- Success Alert Message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-100 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-900 font-bold">&times;</button>
            </div>
        @endif

        <!-- Header & Action Button -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">၀န်ထမ်းအကောင့်</h1>

            </div>
            <div>
    @if($staffs->count() < 30)
        <button id="btn-add-staff" type="button"
            class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-xl shadow-sm transition-all duration-200">
            <i class="fas fa-plus me-2"></i> ၀န်ထမ်းသစ်ထည့်မည်
        </button>
    @else
        <span class="text-xs text-amber-600 font-medium">
            ၀န်ထမ်းဦးရေ ၃၀ ပြည့်သွားပါပြီ
        </span>
    @endif
</div>
        </div>

        <!-- Data Table Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="overflow-x-auto">
                <table id="staff-table" class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-emerald-50/50 text-emerald-900 font-semibold border-b border-emerald-100">
                       <tr>
    <th class="p-3">အိုင်ဒီ</th>
    <th class="p-3">နာမည်</th>
    <th class="p-3">အီးမေးလ်</th>
    <th class="p-3">ဖုန်းနံပါတ်</th>
    <th class="p-3">ရာထူး</th>
    <th class="p-3">လုပ်ပိုင်ခွင့်</th>
    <th class="p-3">နေရပ်လိပ်စာ</th>
    <th class="p-3 text-center">လုပ်ဆောင်ချက်များ</th>
</tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($staffs as $staff)
                            <tr>
                                <td class="p-3 font-medium text-slate-800">{{ $staff->eid }}</td>
                                <td class="p-3">
                                    <div class="flex items-center gap-3">
                                        @if($staff->image_path)
                                            <img src="{{ asset('storage/' . $staff->image_path) }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                                {{ mb_substr($staff->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="font-semibold text-slate-700">{{ $staff->name }}</span>
                                    </div>
                                </td>
                                <td class="p-3">{{ $staff->email }}</td>
                                <td class="p-3">{{ $staff->phone ?? '-' }}</td>
                                <td class="p-3">{{ $staff->position }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 bg-emerald-50 text-emerald-700 text-xs font-medium rounded-lg border border-emerald-200/50 capitalize">
                                        {{ $staff->role }}
                                    </span>
                                </td>
                                <td class="p-3 max-w-xs truncate">{{ $staff->address ?? '-' }}</td>
                                <td class="p-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" class="px-2.5 py-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-600 rounded-lg text-xs font-medium transition-all edit-btn" data-id="{{ $staff->id }}">
                                            <i class="fas fa-edit me-1"></i> ပြင်ဆင်မည်
                                        </button>
                                        <button type="button" class="px-2.5 py-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 rounded-lg text-xs font-medium transition-all delete-btn" data-id="{{ $staff->id }}">
                                            <i class="fas fa-trash me-1"></i> ဖျက်မည်
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-4 text-center text-slate-400">၀န်ထမ်းများ မရှိပါ။ (No staff records found)</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form (Create / Edit Staff) -->
    <div id="staffModal"
        class="fixed inset-0 z-50 {{ $errors->any() ? '' : 'hidden' }} overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-emerald-600 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white" id="modalTitle">Add New Staff</h3>
                <button type="button" class="closeModal text-white/80 hover:text-white text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body Form -->
            <form id="staffForm" action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <input type="hidden" id="staff_id" name="staff_id" value="{{ old('staff_id') }}">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- EID Field -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">ဝန်ထမ်း အိုင်ဒီ</label>
                        <input type="number" name="eid" id="eid" value="{{ old('eid') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('eid') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @error('eid')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">အမည်</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('name') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @error('name')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">အီးမေးလ် လိပ်စာ</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @error('email')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">ဖုန်းနံပါတ်</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('phone') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @error('phone')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Position Field -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">ရာထူး</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('position') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @error('position')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">လုပ်ပိုင်ခွင့်</label>
                        <select name="role" id="role"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('role') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white">
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        </select>
                        @error('role')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">စကားဝှက် <span class="text-xs font-normal text-slate-400">(Leave blank to keep)</span></label>
                        <input type="password" name="password" id="password"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('password') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                        @error('password')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Profile Image Field -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">ပရိုဖိုင် ဓာတ်ပုံ</label>

                        <!-- Old Image Preview Container -->
                        <div id="imagePreviewContainer" class="hidden mb-3 flex items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl">
                            <img id="oldImagePreview" src="" alt="Staff Image" class="w-12 h-12 rounded-full object-cover border border-emerald-500">
                            <div>
                                <p class="text-xs font-semibold text-slate-700">Current Profile Photo</p>
                                <p class="text-[10px] text-slate-400">Select a new image below if you want to change it.</p>
                            </div>
                        </div>

                        <input type="file" name="image_path" id="image" accept="image/*"
                            class="w-full px-2 py-1.5 rounded-xl border @error('image') border-rose-500 @else border-slate-200 @enderror focus:outline-none text-sm text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        @error('image')
                            <span class="text-xs text-rose-500 mt-1 block error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address Field -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">နေရပ်လိပ်စာ</label>
                        <textarea name="address" id="address" rows="2"
                            class="w-full px-3.5 py-2.5 rounded-xl border @error('address') border-rose-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button"
                        class="closeModal px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium text-sm transition-all">ဆက်မလုပ်တော့ပါ</button>
                    <button type="submit" id="saveBtn"
                        class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium text-sm transition-all">ဆက်လုပ်မည်</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete Confirmation -->
    <div id="deleteModal"
        class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
      <h3 class="text-lg font-bold text-slate-800 mb-2">ဖျက်ရန် အတည်ပြုပါ</h3>
<p class="text-slate-500 text-sm mb-6">ဤဝန်ထမ်းအချက်အလက်ကို ဖျက်ရန် သေချာပါသလား။ ဤလုပ်ဆောင်ချက်ကို ပြန်လည်ပြင်ဆင်၍ ရမည်မဟုတ်ပါ။<br></p>

            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-3">
                    <button type="button" class="closeDeleteModal px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium text-sm">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-medium text-sm">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {

            // Validation Errors များကို Clear လုပ်ပေးမည့် Function
            function clearValidationErrors() {
                $('#staffForm input, #staffForm select, #staffForm textarea').removeClass('border-rose-500').addClass('border-slate-200');
                $('#staffForm .error-msg, #staffForm .text-rose-500').remove();
            }

            // Open Modal for Create
            $('#btn-add-staff').click(function () {
                $('#staffForm')[0].reset();
                $('#staff_id').val('');
                $('#staffForm').attr('action', "{{ route('staff.store') }}");
                $('#formMethod').val('POST');
                $('#modalTitle').text('Add New Staff');

                // Preview ပုံကို ဖျောက်မည်
                $('#imagePreviewContainer').addClass('hidden');
                $('#oldImagePreview').attr('src', '');

                clearValidationErrors();
                $('#staffModal').removeClass('hidden');
            });

            // Close Modal
            $('.closeModal').click(function () {
                clearValidationErrors();
                $('#staffForm')[0].reset();

                // Preview ပုံကို ဖျောက်မည်
                $('#imagePreviewContainer').addClass('hidden');
                $('#oldImagePreview').attr('src', '');

                $('#staffModal').addClass('hidden');
            });

            // Edit Button Click
            $(document).on('click', '.edit-btn', function () {
                let id = $(this).data('id');
                let updateUrl = "{{ url('staff') }}/" + id;

                clearValidationErrors();

                $.get(updateUrl + "/edit", function (data) {
                    $('#staff_id').val(data.id);
                    $('#staffForm').attr('action', updateUrl);
                    $('#formMethod').val('PUT');
                    $('#eid').val(data.eid);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#position').val(data.position);
                    $('#role').val(data.role);
                    $('#address').val(data.address);

                    // ဓာတ်ပုံဟောင်း ရှိပါက Preview ထုတ်ပြမည်
                    if (data.image_path) {
                        let imageUrl = "{{ asset('storage') }}/" + data.image_path;
                        $('#oldImagePreview').attr('src', imageUrl);
                        $('#imagePreviewContainer').removeClass('hidden');
                    } else {
                        $('#imagePreviewContainer').addClass('hidden');
                        $('#oldImagePreview').attr('src', '');
                    }

                    $('#modalTitle').text('Edit Staff Member');
                    $('#staffModal').removeClass('hidden');
                });
            });

            // File အသစ်ရွေးလိုက်ပါက Live Preview ပြောင်းလဲပြသပေးရန်
            $('#image').change(function () {
                let file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $('#oldImagePreview').attr('src', e.target.result);
                        $('#imagePreviewContainer').removeClass('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // -------------------------------------------------------------
            // DELETE ACTION LOGIC (ဖြည့်စွက်ပေးထားသည့် အပိုင်း)
            // -------------------------------------------------------------

            // Delete Button ကို နှိပ်သည့်အခါ Delete Modal ပွင့်လာစေရန်
            $(document).on('click', '.delete-btn', function () {
                let id = $(this).data('id');
                let deleteUrl = "{{ url('staff') }}/" + id;

                // Delete Form ၏ Action URL ကို သက်ဆိုင်ရာ Staff ID ဖြင့် ပြောင်းပေးခြင်း
                $('#deleteForm').attr('action', deleteUrl);

                // Delete Modal ကို ပြပေးခြင်း
                $('#deleteModal').removeClass('hidden');
            });

            // Delete Modal ကို ပြန်ပိတ်ရန်
            $('.closeDeleteModal').click(function () {
                $('#deleteModal').addClass('hidden');
                $('#deleteForm').attr('action', '');
            });

        });
    </script>
@endsection
