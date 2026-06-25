<div>
    <div id="admin-chat-data" data-selected-id="{{ $selectedConversationId ?? '' }}" class="d-none"></div>

    <style>
        .chat-container { border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border: 1px solid #eaeaea; background: #fff;}
        .bg-sidebar { background-color: #1A1A1A; color: #fff; }
        .sidebar-header { background-color: #111111; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .bg-chat { background-color: #FAFAFA; color: #1e293b; }
        .bg-chat-header { background-color: #FFFFFF; border-bottom: 1px solid #F0F0F0; color: #1A1A1A; z-index: 10; }
        .chat-list-item { background: transparent; border: none; border-left: 4px solid transparent; color: #94a3b8; padding: 15px 20px; transition: all 0.2s; cursor: pointer; text-align: left; position: relative;}
        .chat-list-item:hover { background-color: rgba(255,255,255,0.03); }
        .chat-list-item.active { border-left-color: #A47E1B; background-color: rgba(164,126,27,0.1); color: #fff; }
        .msg-received { background-color: #FFFFFF; color: #1A1A1A; border-radius: 0 20px 20px 20px; padding: 14px 20px; max-width: 75%; font-size: 14.5px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #EFEFEF; }
        .msg-sent { background-color: #A47E1B; color: #FFF; border-radius: 20px 0 20px 20px; padding: 14px 20px; max-width: 75%; font-size: 14.5px; box-shadow: 0 4px 15px rgba(164,126,27,0.2); }
        .chat-input-wrapper { background-color: #FFFFFF; padding: 20px; border-top: 1px solid #F0F0F0; }
        .chat-input-box { background-color: #F5F5F5; border-radius: 30px; padding: 8px 10px 8px 20px; display: flex; align-items: center; border: 1px solid transparent; transition: 0.3s;}
        .chat-input-box:focus-within { border-color: #A47E1B; background-color: #FFF;}
        .chat-input { background: transparent; border: none; color: #1A1A1A; width: 100%; padding: 8px 0; outline: none; box-shadow: none !important; font-size: 15px;}
        .chat-input::placeholder { color: #A0A0A0; }
        .btn-send { background-color: #A47E1B; color: white; border-radius: 50%; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; font-weight: 500; transition: background 0.2s; border: none; }
        .btn-send:hover { background-color: #8B6A15; transform: scale(1.05); }
        .badge-unread { background-color: #A47E1B; color: #FFF; font-size: 11px; padding: 4px 7px; border-radius: 50%; min-width: 22px; text-align: center; font-weight: bold;}
        .scroll-area::-webkit-scrollbar { width: 6px; }
        .scroll-area::-webkit-scrollbar-track { background: transparent; }
        .scroll-area::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,0.1); border-radius: 10px; }
        .bg-sidebar .scroll-area::-webkit-scrollbar-thumb { background-color: rgba(255,255,255,0.1); }
        .msg-action-btns { opacity: 0; transition: 0.2s; display: flex; flex-direction: column; gap: 5px; margin: 0 10px; }
        .message-row:hover .msg-action-btns { opacity: 1; }
        .typing-indicator-admin {
            font-size: 0.75rem; color: #A47E1B; font-style: italic; padding: 2px 20px 8px;
            min-height: 20px; display: none;
        }
    </style>

    <div class="page-body mt-4 mb-4">
        <div class="container-xl">
            <div class="card chat-container border-0" style="height: 80vh; min-height: 600px;">
                <div class="row g-0 h-100">

                    <div class="col-12 col-lg-4 bg-sidebar d-flex flex-column h-100">
                        <div class="p-4 sidebar-header d-flex justify-content-between align-items-center">
                            <h3 class="m-0 d-flex align-items-center text-white fw-bold">
                                <i class='bx bx-message-square-dots fs-3 me-2' style="color: #A47E1B;"></i>
                                Pesan Masuk
                            </h3>
                        </div>

                        <div class="scroll-area flex-fill mt-2" style="overflow-y: auto;">
                            @forelse($conversations as $conv)
                                @php
                                    $lastMsg = $conv->messages->last();
                                    $isActive = $selectedConversationId == $conv->id;
                                    $unreadCount = $conv->messages->where('is_admin', false)->where('is_read', false)->count();

                                    $displayName = 'Tamu (Guest)';
                                    if($conv->user) {
                                        $displayName = $conv->user->username ?? $conv->user->name ?? $conv->user->email ?? 'Pelanggan';
                                    } elseif($conv->uuid) {
                                        $displayName = 'Guest #' . substr($conv->uuid, 0, 5);
                                    }
                                @endphp

                                <div class="position-relative">
                                    <button wire:click="selectConversation({{ $conv->id }})" class="w-100 chat-list-item {{ $isActive ? 'active' : '' }}">
                                        <div class="d-flex align-items-center pe-4">
                                            <div class="avatar text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="min-width: 45px; height: 45px; background: {{ $isActive ? '#A47E1B' : '#2A2A2A' }}; font-size: 16px;">
                                                {{ strtoupper(substr($displayName, 0, 1)) }}
                                            </div>

                                            <div class="flex-fill overflow-hidden">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="text-truncate" style="font-size: 15px; {{ $isActive ? 'color: #FFF;' : 'color: #E2E8F0;' }}">
                                                        {{ $displayName }}
                                                    </strong>
                                                    <small style="font-size: 11px; {{ $unreadCount > 0 ? 'color: #A47E1B; font-weight: bold;' : 'color: #64748b;' }}">
                                                        {{ $lastMsg ? $lastMsg->created_at->format('H:i') : '' }}
                                                    </small>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="text-truncate pe-2" style="font-size: 13px; {{ $unreadCount > 0 ? 'color: #FFF !important; font-weight: 500;' : 'color: #94A3B8;' }}">
                                                        @if($lastMsg && $lastMsg->is_admin)
                                                            <i class='bx bx-check-double text-primary'></i> Anda:
                                                        @endif
                                                        {{ $lastMsg ? $lastMsg->body : 'Belum ada pesan...' }}
                                                    </div>

                                                    @if($unreadCount > 0)
                                                        <span class="badge-unread shadow-sm">{{ $unreadCount }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </button>

                                    <button wire:click.stop="deleteConversation({{ $conv->id }})" wire:confirm="Yakin ingin menghapus seluruh obrolan ini secara permanen?" class="btn btn-link text-danger p-1 position-absolute top-50 translate-middle-y end-0 me-3" style="z-index: 5;" title="Hapus Obrolan">
                                        <i class='bx bx-trash fs-5'></i>
                                    </button>
                                </div>
                            @empty
                                <div class="p-5 text-center text-muted">
                                    <i class='bx bx-message-alt-x fs-1 mb-2 opacity-50'></i>
                                    <p>Belum ada obrolan masuk.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="col-12 col-lg-8 bg-chat d-flex flex-column h-100 position-relative">
                        @if($selectedConversationId)
                            @php
                                $selConv = \App\Models\Conversation::find($selectedConversationId);
                                $selDisplayName = 'Tamu (Guest)';
                                if($selConv && $selConv->user) {
                                    $selDisplayName = $selConv->user->username ?? $selConv->user->name ?? $selConv->user->email ?? 'Pelanggan';
                                } elseif($selConv && $selConv->uuid) {
                                    $selDisplayName = 'Guest #' . substr($selConv->uuid, 0, 5);
                                }
                            @endphp

                            <div class="p-3 bg-chat-header d-flex justify-content-between align-items-center position-absolute w-100 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <div class="avatar text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="background: #1A1A1A; width: 42px; height: 42px;">
                                        {{ $selConv ? strtoupper(substr($selDisplayName, 0, 1)) : '' }}
                                    </div>
                                    <div>
                                        <h4 class="m-0 fw-bold" style="color: #1A1A1A;">{{ $selDisplayName }}</h4>
                                        <small class="text-success d-flex align-items-center" style="font-size: 12px;">
                                            <span class="bg-success rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block;"></span> Sedang aktif
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div id="ruang-chat-admin" class="p-4 scroll-area d-flex flex-column" style="overflow-y: auto; flex: 1; padding-top: 90px !important;">
                                <div class="text-center mb-4">
                                    <span class="bg-light text-muted px-3 py-1 rounded-pill" style="font-size: 12px;">Percakapan Dimulai</span>
                                </div>

                                @foreach($messages as $msg)
                                    <div class="d-flex mb-3 message-row {{ $msg['is_admin'] ? 'justify-content-end' : 'justify-content-start' }}">

                                        @if($msg['is_admin'])
                                            <div class="msg-action-btns justify-content-center">
                                                <button wire:click="editMessage({{ $msg['id'] }})" class="btn btn-sm btn-link p-0 text-muted" title="Edit Pesan"><i class='bx bx-pencil fs-5'></i></button>
                                                <button wire:click="deleteMessage({{ $msg['id'] }})" wire:confirm="Hapus pesan admin ini?" class="btn btn-sm btn-link p-0 text-danger mt-1" title="Hapus Pesan"><i class='bx bx-trash fs-5'></i></button>
                                            </div>
                                        @endif

                                        @if(!$msg['is_admin'])
                                            <div class="avatar text-white rounded-circle me-2 mt-auto align-self-end d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px; background: #1A1A1A;">
                                                {{ strtoupper(substr($selDisplayName, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="{{ $msg['is_admin'] ? 'msg-sent' : 'msg-received' }}">
                                            @if(!empty($msg['image']))
                                                <div style="margin-bottom: 8px;">
                                                    <img src="{{ asset($msg['image']) }}" wire:click="$set('zoomedImage', '{{ asset($msg['image']) }}')" style="max-width: 220px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.05); cursor: pointer;">
                                                </div>
                                            @endif

                                            {{ $msg['body'] }}

                                            <div style="font-size: 10px; opacity: 0.7; margin-top: 6px; {{ $msg['is_admin'] ? 'text-align: right; color: #FFF;' : 'text-align: right; color: #888;' }}">
                                                {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
                                                @if($msg['is_admin'])
                                                    <i class='bx bx-check ms-1'></i>
                                                @else
                                                    @if($msg['is_read'])
                                                        <i class='bx bx-check-double ms-1' style="color: #53BDEB;"></i>
                                                    @elseif($msg['is_delivered'])
                                                        <i class='bx bx-check-double ms-1' style="color: #90A4AE;"></i>
                                                    @else
                                                        <i class='bx bx-check ms-1' style="color: #90A4AE;"></i>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        @if(!$msg['is_admin'])
                                            <div class="msg-action-btns justify-content-center">
                                                <button wire:click="deleteMessage({{ $msg['id'] }})" wire:confirm="Hapus pesan dari pelanggan ini?" class="btn btn-sm btn-link p-0 text-danger" title="Hapus Pesan"><i class='bx bx-trash fs-5'></i></button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                <div id="admin-typing-indicator" class="typing-indicator-admin"></div>
                            </div>

                            <div class="chat-input-wrapper" style="display: flex; flex-direction: column;">
                                @if($image)
                                <div class="position-relative mb-2 align-self-start bg-light p-2 rounded shadow-sm border" style="width: max-content;">
                                    <img src="{{ $image->temporaryUrl() }}" style="height: 60px; border-radius: 6px; object-fit: cover;">
                                    <button type="button" wire:click="$set('image', null)" class="btn btn-sm btn-danger position-absolute rounded-circle shadow" style="top: -8px; right: -8px; padding: 2px 6px;">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </div>
                                @endif

                                @if($showQuickReplies)
                                <div class="mb-2 p-2 rounded border bg-white shadow-sm" style="max-height: 200px; overflow-y: auto;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="fw-bold" style="color: #A47E1B;">
                                            <i class='bx bx-time-five me-1'></i>Balasan Cepat
                                        </small>
                                        <button wire:click="toggleQuickReplies" class="btn btn-sm btn-link text-muted p-0">
                                            <i class='bx bx-x fs-5'></i>
                                        </button>
                                    </div>
                                    @if(count($quickReplies) > 0)
                                        @foreach($quickReplies as $qr)
                                        <button wire:click="sendQuickReply('{{ addslashes($qr['text']) }}')" 
                                            class="btn btn-sm w-100 text-start border-0 mb-1 rounded py-2"
                                            style="background-color: #F5F5F5; transition: 0.2s;"
                                            onmouseover="this.style.backgroundColor='#EDEDED'" 
                                            onmouseout="this.style.backgroundColor='#F5F5F5'">
                                            <strong class="d-block text-dark" style="font-size: 12px;">{{ $qr['label'] }}</strong>
                                            <span class="text-muted" style="font-size: 11px;">{{ Str::limit($qr['text'], 60) }}</span>
                                        </button>
                                        @endforeach
                                    @else
                                        <div class="text-center py-3 text-muted">
                                            <small>
                                                <i class='bx bx-info-circle me-1'></i>
                                                Belum ada balasan cepat. 
                                                <a href="/admin/chat/settings" class="text-decoration-none fw-bold" style="color: #A47E1B;">Atur di sini</a>
                                            </small>
                                        </div>
                                    @endif
                                </div>
                                @endif

                                <form wire:submit.prevent="sendReply" class="w-100">
                                    <div class="chat-input-box">
                                        @if(isset($editingMessageId) && $editingMessageId != null)
                                            <span class="badge bg-warning text-dark me-2">Mode Edit</span>
                                            <button type="button" wire:click="$set('editingMessageId', null)" wire:click="$set('replyBody', '')" class="btn btn-sm btn-light rounded-circle me-2 p-1"><i class='bx bx-x'></i></button>
                                        @else
                                            <input type="file" wire:model="image" id="adminFileInput" style="display: none;" accept="image/*">
                                            <label for="adminFileInput" style="cursor: pointer; margin: 0 15px 0 10px; display: flex; align-items: center;" title="Lampirkan Gambar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </label>
                                            <button type="button" wire:click="toggleQuickReplies" class="btn btn-sm p-1 me-2" 
                                                style="background: none; border: none; color: #A47E1B;" title="Balasan Cepat">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                                    <line x1="9" y1="10" x2="15" y2="10"/><line x1="12" y1="7" x2="12" y2="13"/>
                                                </svg>
                                            </button>
                                        @endif

                                        <input wire:model.live="replyBody" type="text" class="chat-input" placeholder="{{ (isset($editingMessageId) && $editingMessageId) ? 'Edit pesan admin...' : 'Ketik pesan balasan Anda...' }}" autocomplete="off">

                                        <button type="submit" class="btn-send ms-2">
                                            @if(isset($editingMessageId) && $editingMessageId != null)
                                                <i class='bx bx-check fs-4'></i>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: -2px;"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                            @endif
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 text-center" style="background-color: #FAFAFA;">
                                <div class="opacity-50">
                                    <i class='bx bx-message-square-dots mb-3' style="font-size: 80px; color: #A47E1B;"></i>
                                    <h3 style="color: #1A1A1A;">Pilih Pesan</h3>
                                    <p class="text-muted">Klik salah satu pelanggan di sebelah kiri<br>untuk mulai mengobrol.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($zoomedImage)
        <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.85); z-index: 999999; display: flex; justify-content: center; align-items: center; backdrop-filter: blur(3px);">
            <button wire:click="$set('zoomedImage', null)" class="btn btn-link text-white position-absolute" style="top: 20px; right: 30px; font-size: 50px; text-decoration: none; padding: 0;">&times;</button>
            <img src="{{ $zoomedImage }}" style="max-width: 90vw; max-height: 90vh; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
        </div>
    @endif
</div>

<script>
    // Load Pusher + Echo via CDN
    (function() {
        if (window.Echo) return;
        var s = document.createElement('script');
        s.src = 'https://js.pusher.com/7.0/pusher.min.js';
        s.onload = function() {
            window.Pusher = Pusher;
            var s2 = document.createElement('script');
            s2.src = 'https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js';
            s2.onload = function() {
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: '{{ config('broadcasting.connections.pusher.key') }}',
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    forceTLS: true,
                    enabledTransports: ['ws', 'wss'],
                });
                initAdminChat();
            };
            document.head.appendChild(s2);
        };
        document.head.appendChild(s);
    })();

    let adminEchoChannels = {};
    let adminSubscribedId = null;
    let adminEchoReady = false;

    function waitEcho(cb) {
        if (window.Echo) { cb(); return; }
        var iv = setInterval(function() {
            if (window.Echo) { clearInterval(iv); cb(); }
        }, 200);
        setTimeout(function() { clearInterval(iv); }, 10000);
    }

    function initAdminChat() {
        adminEchoReady = true;

        // Subscribe awal jika ada percakapan terpilih
        autoSubscribeAdminChannel();

        // Hook Livewire commit
        document.addEventListener('livewire:initialized', function() {
            Livewire.hook('commit', function(data) {
                data.succeed(function() {
                    autoSubscribeAdminChannel();
                });
            });
        });

        // Polling sidebar tiap 15 detik
        setInterval(function() {
            Livewire.dispatch('refreshSidebar');
        }, 15000);
    }

    function turunKeBawah() {
        var kotakChat = document.getElementById('ruang-chat-admin');
        if (kotakChat) kotakChat.scrollTop = kotakChat.scrollHeight;
    }
    document.addEventListener('scroll-ke-bawah', function() {
        setTimeout(turunKeBawah, 50);
    });

    function getAdminSelectedId() {
        var el = document.getElementById('admin-chat-data');
        return el ? el.dataset.selectedId : '';
    }

    function autoSubscribeAdminChannel() {
        if (!adminEchoReady || !window.Echo) return;

        var selectedId = getAdminSelectedId();
        if (!selectedId) return;
        if (selectedId === adminSubscribedId) return;
        adminSubscribedId = selectedId;

        Object.keys(adminEchoChannels).forEach(function(id) {
            if (id !== selectedId) {
                Echo.leave('chat.' + id);
                delete adminEchoChannels[id];
            }
        });

        if (adminEchoChannels[selectedId]) return;

        adminEchoChannels[selectedId] = Echo.private('chat.' + selectedId);

        adminEchoChannels[selectedId]
            .listen('.message-sent', function(e) {
                if (String(e.conversation_id) === selectedId) {
                    Livewire.dispatch('messageReceived');
                    playNotifSound();
                    turunKeBawah();
                }
            })
            .listen('.messages-read', function(e) {
                Livewire.dispatch('messageReceived');
            })
            .listen('.chat-typing', function(e) {
                if (String(e.conversation_id) === selectedId && !e.is_admin) {
                    var el = document.getElementById('admin-typing-indicator');
                    if (!el) return;
                    if (e.is_typing) {
                        el.textContent = e.sender_name + ' sedang mengetik...';
                        el.style.display = 'block';
                        clearTimeout(window.adminTypingTimer);
                        window.adminTypingTimer = setTimeout(function() {
                            el.style.display = 'none';
                            el.textContent = '';
                        }, 3000);
                    } else {
                        el.style.display = 'none';
                        el.textContent = '';
                    }
                }
            });
    }

    function playNotifSound() {
        try {
            var ctx = new (window.AudioContext || window.webkitAudioContext)();
            var osc = ctx.createOscillator();
            var gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.frequency.value = 800;
            osc.type = 'sine';
            gain.gain.setValueAtTime(0.3, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.2);
        } catch(e) {}
    }
</script>
