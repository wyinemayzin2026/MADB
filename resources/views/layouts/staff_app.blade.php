<!DOCTYPE html>
<html lang="en">

<head>
    <title>မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ် (MADB) | Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind, FontAwesome & Essential JS Frameworks -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables CDN (For Advanced Reporting) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');

        body {
            font-family: 'Pyidaungsu', sans-serif;
            background-color: #f8fafc;
        }

        /* Modal Smooth Premium Animation */
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

        /* Custom Scrollbar styled for MADB Emerald Theme */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #059669;
            /* emerald-600 */
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
            /* emerald-700 */
        }
    </style>
</head>

<body class="antialiased text-slate-800">

    <!-- Top Navigation Bar -->
    <nav
        class="bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-3">
            <div
                class="relative w-14 h-14 rounded-full flex items-center justify-center shadow-lg border-2 border-yellow-400 overflow-hidden transition-transform group-hover:scale-110">
                <img src="http://127.0.0.1:8000/assets/img/logo.png" alt="MADB Logo"
                    class="absolute inset-0 w-full h-full object-contain">

                <div class="absolute inset-0 bg-gradient-to-tr from-green-800 to-transparent opacity-50 z-10">
                </div>
            </div>
            <div>
                <h1 class="text-green-800 font-bold text-lg leading-tight">MADB</h1>
                <p class="text-xs text-yellow-600 font-semibold tracking-tighter">မြန်မာလယ်ယာဖွံ့ဖြိုးရေးဘဏ်</p>
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
                phone: '{{ auth()->user()->phone ?? '၀၉---------' }}',
                address: '{{ auth()->user()->address ?? 'နေပြည်တော်' }}',
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
                    <i class="fas fa-chart-pie me-3 w-5 text-lg"></i> ပင်မဒိုင်ခွက်
                </a>

                {{-- <a href="{{ route('taxpayers.list') }}"
                    class="flex items-center p-3.5 {{ Request::is('taxpayers*') ? 'bg-emerald-700 text-white shadow-xl shadow-emerald-100 font-bold' : 'text-slate-600 hover:bg-slate-50 font-semibold' }} rounded-2xl transition-all">
                    <i
                        class="fas fa-users-rectangle me-3 w-5 text-lg {{ Request::is('taxpayers*') ? 'text-white' : 'text-emerald-600' }}"></i>
                    တောင်သူလယ်သမားများ
                </a> --}}

                <a href="#"
                    class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all">
                    <i class="fas fa-hand-holding-dollar me-3 w-5 text-lg text-emerald-600"></i> စရိတ်ချေးငွေစာရင်း
                </a>

                <a href="#"
                    class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all">
                    <i class="fas fa-piggy-bank me-3 w-5 text-lg text-emerald-600"></i> စုဆောင်းငွေစာရင်း
                </a>

                <a href="#"
                    class="flex items-center p-3.5 text-slate-600 hover:bg-slate-50 rounded-2xl font-semibold transition-all">
                    <i class="fas fa-file-shield me-3 w-5 text-lg text-emerald-600"></i> စာရင်းဇယားအစီရင်ခံစာ
                </a>

                <div class="pt-4 mt-4 border-t border-slate-100">
                    <form action="{{ route('staff.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center p-3.5 text-rose-500 hover:bg-rose-50 rounded-2xl font-bold transition-all outline-none">
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

    <!-- Beautiful Profile Info / Photo Upload Modal -->
    <div id="userModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal()"></div>

        <div id="modalContent"
            class="relative bg-white w-full max-w-[400px] rounded-[32px] shadow-2xl overflow-hidden scale-down transition-all">
            <!-- Modern Gradient Header Banner -->
            <div class="h-32 bg-gradient-to-br from-emerald-800 via-emerald-950 to-slate-900 relative">
                <button onclick="closeModal()"
                    class="absolute top-5 right-5 w-8 h-8 bg-white/10 text-white rounded-full flex items-center justify-center hover:bg-white/20 transition outline-none">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <!-- Profile Info Content Section -->
            <div class="px-6 pb-8 -mt-14 relative text-center">
                <div class="inline-block relative">
                    <div class="w-28 h-28 rounded-[80px] border-4 border-white shadow-xl overflow-hidden bg-slate-100">
                        <img id="modalImg" src="" class="w-full h-full object-cover">
                    </div>
                    <button onclick="document.getElementById('profileInput').click()"
                        class="absolute -bottom-1 -right-1 bg-emerald-600 text-white w-9 h-9 rounded-xl border-4 border-white shadow-lg flex items-center justify-center hover:scale-110 active:scale-95 transition-all outline-none">
                        <i class="fas fa-camera text-xs"></i>
                    </button>
                    <input type="file" id="profileInput" class="hidden" accept="image/*" onchange="previewPhoto(this)">
                </div>

                <div class="mt-3">
                    <h3 id="modalName" class="text-xl font-bold text-slate-800 tracking-tight"></h3>
                    <p id="modalPosition"
                        class="text-emerald-600 font-bold uppercase tracking-[1.5px] text-[10px] mt-0.5">
                    </p>
                </div>

                <!-- Info Grid -->
                <div class="mt-6 space-y-2 text-left">
                    <div class="flex items-center gap-3.5 p-3 bg-slate-50 rounded-xl border border-slate-100/80">
                        <div
                            class="w-9 h-9 bg-white rounded-lg flex items-center justify-center text-emerald-600 shadow-sm">
                            <i class="fas fa-id-badge text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-1">
                                ဝန်ထမ်းအမှတ်</p>
                            <p id="modalEid" class="text-xs font-bold text-slate-700"></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5 p-3 bg-slate-50 rounded-xl border border-slate-100/80">
                        <div
                            class="w-9 h-9 bg-white rounded-lg flex items-center justify-center text-emerald-600 shadow-sm">
                            <i class="fas fa-phone text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-1">
                                ဆက်သွယ်ရန်ဖုန်း</p>
                            <p id="modalPhone" class="text-xs font-bold text-slate-700"></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5 p-3 bg-slate-50 rounded-xl border border-slate-100/80">
                        <div
                            class="w-9 h-9 bg-white rounded-lg flex items-center justify-center text-emerald-600 shadow-sm">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <div class="truncate">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-1">
                                အီးမေးလ်လိပ်စာ</p>
                            <p id="modalEmail" class="text-xs font-bold text-slate-700 truncate"></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5 p-3 bg-slate-50 rounded-xl border border-slate-100/80">
                        <div
                            class="w-9 h-9 bg-white rounded-lg flex items-center justify-center text-emerald-600 shadow-sm">
                            <i class="fas fa-map-marker-alt text-sm"></i>
                        </div>
                        <div class="truncate">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-1">
                                တာဝန်ကျရုံးခွဲလိပ်စာ</p>
                            <p id="modalAddress" class="text-xs font-bold text-slate-700 truncate"></p>
                        </div>
                    </div>
                </div>

                <!-- Confirm Upload Button -->
                <button id="confirmBtn" onclick="confirmUpload()"
                    class="w-full mt-6 bg-emerald-700 text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-emerald-800 transition-all shadow-lg shadow-emerald-100 active:scale-[0.98] outline-none">
                    အချက်အလက်ပြင်ဆင်မှု အတည်ပြုမည်
                </button>
            </div>
        </div>
    </div>

    <!-- DataTables & Export Extensions Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- Frontend Core Logic UI Scripts -->
    <script>
        let selectedFile = null;

        // User Details Profile Modal Handler
        function openUserModal(data) {
            selectedFile = null;
            document.getElementById('modalName').innerText = data.name;
            document.getElementById('modalPosition').innerText = data.position;
            document.getElementById('modalEid').innerText = data.eid;
            document.getElementById('modalEmail').innerText = data.email;
            document.getElementById('modalAddress').innerText = data.address;
            document.getElementById('modalPhone').innerText = data.phone;
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

        // Live Profile Image File Previewing
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

        // Ajax Profile Image Upload Controller Trigger
        function confirmUpload() {
            if (!selectedFile) {
                closeModal();
                return;
            }

            const formData = new FormData();
            formData.append('profile_image', selectedFile);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            const btn = document.getElementById('confirmBtn');
            btn.innerText = "ဓါတ်ပုံတင်သွင်းနေပါသည်...";
            btn.disabled = true;

            fetch("{{ route('staff.profile.update') }}", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'အောင်မြင်ပါသည်',
                            text: 'ပရိုဖိုင်ဓါတ်ပုံ ပြောင်းလဲပြီးပါပြီ။',
                            confirmButtonColor: '#047857'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'လုပ်ဆောင်ချက်မအောင်မြင်ပါ',
                            text: data.message
                        });
                        btn.innerText = "အချက်အလက်ပြင်ဆင်မှု အတည်ပြုမည်";
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error(err);
                    btn.innerText = "အခြားပုံတစ်ပုံရွေးချယ်ပေးပါ";
                    btn.disabled = false;
                });
        }
    </script>

</body>

</html>
