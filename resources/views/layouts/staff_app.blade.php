<!DOCTYPE html>
<html lang="en">

<head>
    <title>မြန်မာ့လယ်ယာဖွံ့ဖြိုးရေးဘဏ် (MADB) | Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind, FontAwesome & Essential JS Frameworks -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');

        body {
            font-family: 'Pyidaungsu', sans-serif;
            background-color: #f8fafc;
        }

        #modalContent {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .scale-up {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .scale-down {
            transform: scale(0.9) translateY(20px);
            opacity: 0;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #059669;
            border-radius: 10px;
        }
    </style>
</head>

<body class="antialiased text-slate-800">

    <!-- Top Navigation Bar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="relative w-14 h-14 rounded-full flex items-center justify-center shadow-lg border-2 border-yellow-400 overflow-hidden transition-transform group-hover:scale-110">
                <img src="http://127.0.0.1:8000/assets/img/logo.png" alt="MADB Logo" class="absolute inset-0 w-full h-full object-contain">
                <div class="absolute inset-0 bg-gradient-to-tr from-green-800 to-transparent opacity-50 z-10"></div>
            </div>
            <div>
                <h1 class="text-green-800 font-bold text-lg leading-tight">MADB</h1>
                <p class="text-xs text-yellow-600 font-semibold tracking-tighter">မြန်မာ့လယ်ယာဖွံ့ဖြိုးရေးဘဏ်</p>
            </div>
        </div>

        <!-- Right Side: Profile Info & Modal Trigger -->
        <div class="flex items-center gap-4">
            <div class="hidden md:block text-right">
                <p class="text-sm font-bold text-slate-800 leading-none">{{ auth()->user()->name }}</p>
                <p class="text-[9px] font-black text-emerald-600 uppercase mt-1 tracking-widest">
                    {{ auth()->user()->position }}
                </p>
            </div>

            <button onclick="openUserModal({
                name: '{{ auth()->user()->name }}',
                position: '{{ auth()->user()->position }}',
                eid: '{{ auth()->user()->eid }}',
                email: '{{ auth()->user()->email }}',
                phone: '{{ auth()->user()->phone ?? '' }}',
                address: '{{ auth()->user()->address ?? '' }}',
                image_path: '{{ auth()->user()->image_path ? asset('storage/' . auth()->user()->image_path) : asset('assets/img/default_profile.png') }}'
            })" class="relative group outline-none">
                <img id="navAvatar"
                    src="{{ auth()->user()->image_path ? asset('storage/' . auth()->user()->image_path) : asset('assets/img/default_profile.png') }}"
                    class="w-10 h-10 rounded-full object-cover ring-2 ring-emerald-50 group-hover:ring-emerald-500 transition-all shadow-md">
            </button>
        </div>
    </nav>

    <!-- App Body Layout -->
    <div class="flex min-h-screen">

        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-white hidden lg:block border-r border-slate-100 p-4 shrink-0">
            <nav class="space-y-1.5">
                <a href="{{ route('staff.dashboard') }}"
                    class="flex items-center p-3.5 {{ Request::is('staff.dashboard') ? 'bg-emerald-700 text-white shadow-xl shadow-emerald-100 font-bold' : 'text-slate-600 hover:bg-slate-50 font-semibold' }} rounded-2xl transition-all">
                    <i class="fas fa-chart-pie me-3 w-5 text-lg"></i> ပင်မစာမျက်နှာ
                </a>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('staff.list') }}"
                        class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all">
                        <i class="fas fa-hand-holding-dollar me-3 w-5 text-lg text-emerald-600"></i> ၀န်ထမ်းအကောင့်
                    </a>
                @endif

                <a href="{{ route('borrowers.list') }}" class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all">
                    <i class="fas fa-hand-holding-dollar me-3 w-5 text-lg text-emerald-600"></i> ငွေစုစာရင်းအကောင့်
                </a>

                <a href="{{ route('loans.index') }}" class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all">
                    <i class="fas fa-piggy-bank me-3 w-5 text-lg text-emerald-600"></i> ချေးငွေလျှောက်လွှာ
                </a>

                <a href="{{ route('loans.repayments') }}" class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all">
                    <i class="fas fa-file-shield me-3 w-5 text-lg text-emerald-600"></i> တောင်သူချေးငွေ ပြန်ဆပ်စာရင်း
                </a>

                @if(auth()->check() && auth()->user()->role === 'admin')

                <a href="{{ route('staff.complaints.index') }}"
                    class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all {{ request()->routeIs('staff.complaints.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                    <i class="fas fa-headset me-3 w-5 text-lg text-emerald-600"></i> တိုင်ကြားစာများ စာရင်း
                </a>
                @endif

                <div class="pt-4 mt-4 border-t border-slate-100">
                    <form action="{{ route('staff.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center p-3.5 text-blue-500 hover:bg-blue-50 rounded-2xl font-bold transition-all outline-none">
                            <i class="fas fa-sign-out-alt me-3 w-5 text-lg"></i> စနစ်မှထွက်ရန်
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Dynamic Content Panel -->
        <main class="flex-1 overflow-x-hidden bg-slate-50/50">
            @yield('content')
        </main>
    </div>

    <!-- Editable Profile Info / Photo Upload Modal -->
    <div id="userModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal()"></div>

        <div id="modalContent" class="relative bg-white w-full max-w-[450px] rounded-[32px] shadow-2xl overflow-hidden scale-down transition-all">
            <!-- Modern Gradient Header Banner -->
            <div class="h-28 bg-gradient-to-br from-emerald-800 via-emerald-950 to-slate-900 relative">
                <button onclick="closeModal()" class="absolute top-4 right-4 w-8 h-8 bg-white/10 text-white rounded-full flex items-center justify-center hover:bg-white/20 transition outline-none">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <!-- Profile Info Content Section -->
            <div class="px-6 pb-6 -mt-12 relative text-center">
                <!-- Avatar Upload -->
                <div class="inline-block relative">
                    <div class="w-24 h-24 rounded-full border-4 border-white shadow-xl overflow-hidden bg-slate-100 mx-auto">
                        <img id="modalImg" src="" class="w-full h-full object-cover">
                    </div>
                    <button onclick="document.getElementById('profileInput').click()" type="button"
                        class="absolute bottom-0 right-0 bg-emerald-600 text-white w-8 h-8 rounded-full border-2 border-white shadow-lg flex items-center justify-center hover:scale-110 active:scale-95 transition-all outline-none">
                        <i class="fas fa-camera text-xs"></i>
                    </button>
                    <input type="file" id="profileInput" class="hidden" accept="image/*" onchange="previewPhoto(this)">
                </div>

                <!-- EID & Position Badge -->
                <div class="mt-2">
                    <span id="modalPosition" class="inline-block bg-emerald-50 text-emerald-700 font-bold uppercase tracking-wider text-[10px] px-2.5 py-1 rounded-md"></span>
                    <p class="text-[11px] font-semibold text-slate-400 mt-1">ဝန်ထမ်းအမှတ်: <span id="modalEid" class="font-bold text-slate-700"></span></p>
                </div>

                <!-- Edit Form Fields -->
                <div class="mt-4 space-y-3 text-left max-h-[50vh] overflow-y-auto px-1">
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">အမည်</label>
                        <input type="text" id="edit_name" class="w-full text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">ဆက်သွယ်ရန်ဖုန်း</label>
                        <input type="text" id="edit_phone" class="w-full text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">အီးမေးလ်လိပ်စာ</label>
                        <input type="email" id="edit_email" class="w-full text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">တာဝန်ကျရုံးခွဲလိပ်စာ</label>
                        <input type="text" id="edit_address" class="w-full text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">စကားဝှက်အသစ် (မပြောင်းလဲပါက လွတ်ထားပါ)</label>
                        <input type="password" id="edit_password" placeholder="••••••••" class="w-full text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <!-- Submit Button -->
                <button id="confirmBtn" onclick="confirmUpload()"
                    class="w-full mt-5 bg-emerald-700 text-white py-3 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-emerald-800 transition-all shadow-lg shadow-emerald-100 active:scale-[0.98] outline-none">
                    အချက်အလက်ပြင်ဆင်မှု အတည်ပြုမည်
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        let selectedFile = null;

        function openUserModal(data) {
            selectedFile = null;
            document.getElementById('edit_name').value = data.name || '';
            document.getElementById('edit_email').value = data.email || '';
            document.getElementById('edit_phone').value = data.phone || '';
            document.getElementById('edit_address').value = data.address || '';
            document.getElementById('edit_password').value = '';

            document.getElementById('modalPosition').innerText = data.position || '';
            document.getElementById('modalEid').innerText = data.eid || '';
            document.getElementById('modalImg').src = data.image_path;
            document.getElementById('modalImg').style.opacity = "1";

            document.getElementById('confirmBtn').innerText = "အချက်အလက်ပြင်ဆင်မှု အတည်ပြုမည်";
            document.getElementById('confirmBtn').disabled = false;

            const modal = document.getElementById('userModal');
            const content = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            setTimeout(() => content.classList.replace('scale-down', 'scale-up'), 10);
        }

        function closeModal() {
            const modal = document.getElementById('userModal');
            const content = document.getElementById('modalContent');
            content.classList.replace('scale-up', 'scale-down');
            setTimeout(() => modal.classList.add('hidden'), 400);
        }

        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                selectedFile = input.files[0];
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('modalImg');
                    img.src = e.target.result;
                    img.style.opacity = "0.7";
                }
                reader.readAsDataURL(selectedFile);
            }
        }

        function confirmUpload() {
            const formData = new FormData();
            formData.append('name', document.getElementById('edit_name').value);
            formData.append('email', document.getElementById('edit_email').value);
            formData.append('phone', document.getElementById('edit_phone').value);
            formData.append('address', document.getElementById('edit_address').value);

            const password = document.getElementById('edit_password').value;
            if (password) {
                formData.append('password', password);
            }

            if (selectedFile) {
                formData.append('profile_image', selectedFile);
            }

            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            const btn = document.getElementById('confirmBtn');
            btn.innerText = "ပြင်ဆင်နေပါသည်...";
            btn.disabled = true;

            fetch("{{ route('staff.profile.update') }}", {
                method: "POST",
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json();
                if (res.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'အောင်မြင်ပါသည်',
                        text: data.message || 'ပရိုဖိုင် အချက်အလက်များ ပြောင်းလဲပြီးပါပြီ။',
                        confirmButtonColor: '#047857'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    let errorMessage = data.message || 'လုပ်ဆောင်ချက် မအောင်မြင်ပါ။';
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('<br>');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'ပြင်ဆင်မှု မအောင်မြင်ပါ',
                        html: errorMessage
                    });
                    btn.innerText = "အချက်အလက်ပြင်ဆင်မှု အတည်ပြုမည်";
                    btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'အမှားအယွင်းရှိပါသည်',
                    text: 'စနစ်တွင် အမှားတစ်ခု ဖြစ်ပေါ်နေပါသည်။'
                });
                btn.innerText = "အချက်အလက်ပြင်ဆင်မှု အတည်ပြုမည်";
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>
