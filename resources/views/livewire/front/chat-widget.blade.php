<div>
    <div id="chat-data" data-conversation-id="{{ $conversationId ?? '' }}" data-admin-last-activity="{{ $adminLastActivity ?? '' }}" class="d-none"></div>

    <style>
        .chat-fab {
            position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px;
            background-color: #A47E1B; color: #FFF; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px; box-shadow: 0 4px 15px rgba(164,126,27,0.4);
            cursor: pointer; z-index: 999999; transition: all 0.3s ease; border: none;
        }
        .chat-fab:hover { background-color: #8B6A15; transform: scale(1.05); }
        .chat-window {
            position: fixed; bottom: 100px; right: 30px; width: 380px; height: 550px;
            background: #FFF; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            display: flex; flex-direction: column; z-index: 999998; overflow: hidden;
            transition: all 0.3s ease;
        }
        .chat-window.chat-expanded { width: 600px; height: 700px; }
        .chat-header { background-color: #1A1A1A; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; }
        .chat-body { flex: 1; padding: 20px; overflow-y: auto; background-color: #FAFAFA; }
        .msg-admin-wrapper { display: flex; align-items: flex-end; margin-bottom: 20px; }
        .msg-admin {
            background-color: #F9F6F0; color: #1A1A1A; padding: 12px 18px;
            border-radius: 20px 20px 20px 0; max-width: 75%; font-size: 0.9rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02); border: 1px solid #EFEFEF;
        }
        .msg-user-wrapper { display: flex; justify-content: flex-end; align-items: flex-end; margin-bottom: 20px; }
        .msg-user {
            background-color: #A47E1B; color: #FFF; padding: 12px 18px;
            border-radius: 20px 20px 0 20px; max-width: 75%; font-size: 0.9rem;
            box-shadow: 0 2px 5px rgba(164,126,27,0.2);
        }
        .chat-footer { padding: 15px; background: #FFF; border-top: 1px solid #EEE; display: flex; align-items: center; gap: 10px; }
        .chat-input-wrapper {
            flex: 1; background-color: #F5F5F5; border-radius: 30px;
            padding: 5px 15px; display: flex; align-items: center;
        }
        .chat-input { border: none; background: transparent; width: 100%; padding: 10px 5px; font-size: 0.9rem; outline: none; }
        .btn-send {
            background-color: #A47E1B; color: #FFF; border: none; width: 45px; height: 45px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 20px; transition: 0.2s;
        }
        .btn-send:hover { background-color: #8B6A15; }
        .typing-indicator {
            font-size: 0.75rem; color: #A47E1B; font-style: italic; padding: 5px 20px;
            min-height: 24px; display: none;
        }
        .online-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 4px; }
        .online-dot.active { background-color: #22c55e; box-shadow: 0 0 6px #22c55e; }
        .online-dot.inactive { background-color: #94a3b8; }
        @media (max-width: 768px) {
            .chat-window { bottom: 0; right: 0; width: 100%; height: 100vh; border-radius: 0; }
            .chat-fab { bottom: 20px; right: 20px; }
            .chat-expanded { width: 100%; height: 100vh; }
        }
    </style>

    @if(!$isOpen)
        <button wire:click="toggleChat" class="chat-fab">
            <i class='bx bx-message-dots'></i>
        </button>
    @endif

    @if($isOpen)
        <div class="chat-window {{ $isExpanded ? 'chat-expanded' : '' }}">

            <div class="chat-header">
                <div class="d-flex align-items-center">
                    <div class="position-relative">
                        <img src="{{ asset('themes/gallerypuan/assets/img/logo.jpg') }}" class="rounded-circle me-3" width="45" height="45" style="object-fit: cover; border: 2px solid #A47E1B;">
                        <span id="admin-status-dot" class="position-absolute bottom-0 end-0 p-1 bg-secondary border border-light rounded-circle" style="margin-right: 12px; margin-bottom: 2px;"></span>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white fw-bold">Admin Puan</h6>
                        <small class="text-light" style="font-size: 0.75rem;">
                            <span id="admin-status-text-dot" class="online-dot inactive"></span>
                            <span id="admin-status-text">Offline</span>
                            <span id="admin-last-seen" class="d-none" style="font-size: 0.65rem;"></span>
                        </small>
                    </div>
                </div>
                <div>
                    <button wire:click="toggleSize" class="btn btn-sm text-white d-none d-md-inline-block p-1">
                        <i class='bx {{ $isExpanded ? "bx-collapse" : "bx-expand" }} fs-4'></i>
                    </button>
                    <button wire:click="toggleChat" class="btn btn-sm text-white p-1 ms-1">
                        <i class='bx bx-x fs-3'></i>
                    </button>
                </div>
            </div>

            <div class="chat-body" id="chatContainer">
                <div class="text-center mb-4">
                    <small class="text-muted bg-white px-3 py-1 rounded-pill border" style="font-size: 0.7rem;">Obrolan Dimulai</small>
                </div>

                @forelse($messages as $msg)
                    @if($msg->type === 'suggested_options')
                        @php $msgOptions = json_decode($msg->body, true) ?: $suggestedOptions ?? []; @endphp
                        <div class="msg-admin-wrapper">
                            <img src="{{ asset('themes/gallerypuan/assets/img/logo.jpg') }}" class="rounded-circle me-2 mb-1" width="28" height="28" style="object-fit: cover;">
                            <div class="d-flex flex-column" style="max-width: 85%;">
                                <small class="text-muted mb-2 d-block" style="font-size: 0.78rem; font-weight: 500;">Pesona sejatimu berhak bersinar hari ini! ✨ Puan hadir khusus untuk merangkai keanggunanmu. Yuk, bisikkan apa yang sedang kamu cari dengan memilih opsi cantik di bawah ini, ya! 🌹👇</small>
                                <div class="d-flex flex-column gap-2">
                                    @foreach($msgOptions as $opt)
                                        <button wire:click="sendSuggestedReply('{{ addslashes($opt) }}')"
                                            class="btn text-start border rounded-3 py-2 px-3 shadow-sm"
                                            style="background-color: #FFF; color: #1A1A1A; border-color: #E0E0E0 !important; font-size: 13px; font-weight: 500; transition: all 0.15s;"
                                            onmouseover="this.style.backgroundColor='#F9F6F0'; this.style.borderColor='#A47E1B'"
                                            onmouseout="this.style.backgroundColor='#FFF'; this.style.borderColor='#E0E0E0'">
                                            <i class='bx bx-chevron-right me-1' style="color: #A47E1B; font-size: 14px;"></i>
                                            {{ $opt }}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="text-end mt-1 text-muted" style="font-size: 0.65rem;">{{ $msg->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @elseif($msg->is_admin)
                        <div class="msg-admin-wrapper">
                            <img src="{{ asset('themes/gallerypuan/assets/img/logo.jpg') }}" class="rounded-circle me-2 mb-1" width="28" height="28" style="object-fit: cover;">
                            <div class="msg-admin">
                            @if($msg->image)
                                <div class="mb-2">
                                    <img src="{{ asset($msg->image) }}" wire:click="$set('zoomedImage', '{{ asset($msg->image) }}')" class="img-fluid rounded shadow-sm" style="max-height: 150px; border: 1px solid rgba(0,0,0,0.05); cursor: pointer;">
                                </div>
                            @endif
                            {{ $msg->body }}
                            <div class="text-end mt-1 text-muted" style="font-size: 0.65rem;">{{ $msg->created_at->format('H:i') }}</div>
                        </div>
                        </div>
                    @else
                        <div class="msg-user-wrapper">
                            <div class="msg-user">
                                {{ $msg->body }}
                                @if($msg->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($msg->image) }}" wire:click="$set('zoomedImage', '{{ asset($msg->image) }}')" class="img-fluid rounded shadow-sm" style="max-height: 150px; cursor: pointer;">
                                    </div>
                                @endif
                                <div class="text-end mt-1 text-light opacity-75" style="font-size: 0.65rem;">
                                    {{ $msg->created_at->format('H:i') }}
                                    @if($msg->is_read)
                                        <i class='bx bx-check-double' style="color: #53BDEB;"></i>
                                    @elseif($msg->is_delivered)
                                        <i class='bx bx-check-double' style="color: #90A4AE;"></i>
                                    @else
                                        <i class='bx bx-check' style="color: #90A4AE;"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center text-muted mt-5">
                        <i class='bx bx-message-rounded-dots fs-1 mb-2 opacity-50'></i>
                        <p>Belum ada pesan.<br>Silakan tanya apa saja ke Admin!</p>
                    </div>
                @endforelse

                <div id="typing-indicator" class="typing-indicator"></div>
            </div>

            @if($imagePreview || $image)
            <div class="p-2 border-top bg-light position-relative">
                <img src="{{ $image ? $image->temporaryUrl() : $imagePreview }}" style="height: 60px; border-radius: 8px; object-fit: cover;">
                <button type="button" wire:click="$set('{{ $image ? 'image' : 'imagePreview' }}', null)" class="btn btn-sm btn-danger position-absolute rounded-circle" style="top: 5px; left: 65px; padding: 2px 6px;">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            @endif

            <form wire:submit.prevent="sendMessage" class="chat-footer">
                <input type="file" wire:model="image" id="fileInput" class="d-none" accept="image/*">
                <label for="fileInput" style="cursor: pointer;">
                    <i class='bx bx-image-add text-muted fs-4'></i>
                </label>
                <div class="chat-input-wrapper">
                    <input type="text" wire:model.live="body" class="chat-input" placeholder="Ketik pesan...">
                </div>
                <button type="submit" class="btn-send"><i class='bx bx-send'></i></button>
            </form>

            @if($zoomedImage)
            <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.85); z-index: 9999999; display: flex; justify-content: center; align-items: center; backdrop-filter: blur(3px);">
                <button wire:click="$set('zoomedImage', null)" style="position: absolute; top: 20px; right: 30px; font-size: 50px; color: white; background: none; border: none; cursor: pointer;">&times;</button>
                <img src="{{ $zoomedImage }}" style="max-width: 90vw; max-height: 90vh; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
            </div>
            @endif

        </div>
    @endif

    <script>
    (function() {
        var inited = false;

        function initChat() {
            if (inited) return;
            inited = true;

            try {
                Livewire.hook('morph.updated', function(el, component) {
                    var chatBox = document.getElementById('chatContainer');
                    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
                });

                Livewire.hook('commit', function(data) {
                    data.succeed(function() {
                        subscribeChat();
                    });
                });

                subscribePresence();
                subscribeChat();
            } catch(e) {}
        }

        function subscribeChat() {
            try {
                if (!window.Echo) return;
                var el = document.getElementById('chat-data');
                if (!el) return;
                var convId = el.dataset.conversationId;
                if (!convId) return;
                if (window._chatSubId === convId) return;
                window._chatSubId = convId;

                if (window._chatChan) {
                    Echo.leave('chat.' + window._chatChan.name.split('.').pop());
                }

                window._chatChan = Echo.private('chat.' + convId);

                window._chatChan
                    .listen('.message-sent', function(e) {
                        Livewire.dispatch('messageReceived');
                    })
                    .listen('.chat-typing', function(e) {
                        var el2 = document.getElementById('typing-indicator');
                        if (!el2) return;
                        if (e.is_admin && e.is_typing) {
                            el2.textContent = 'Admin sedang mengetik...';
                            el2.style.display = 'block';
                            clearTimeout(window._chatTyping);
                            window._chatTyping = setTimeout(function() {
                                el2.style.display = 'none';
                                el2.textContent = '';
                            }, 3000);
                        } else if (e.is_admin && !e.is_typing) {
                            el2.style.display = 'none';
                            el2.textContent = '';
                        }
                    })
                    .listen('.messages-read', function(e) {
                        Livewire.dispatch('messageReceived');
                    });
            } catch(e) {}
        }

        function subscribePresence() {
            try {
                if (!window.Echo) return;
                if (window._chatPres) return;
                window._chatPres = Echo.join('online.admins');
                window._chatPres.here(function(members) {
                    setOnline(members.length > 0);
                });
                window._chatPres.joining(function() {
                    setOnline(true);
                });
                window._chatPres.leaving(function() {
                    Echo.join('online.admins').here(function(members) {
                        setOnline(members.length > 0);
                    });
                });
            } catch(e) {}
        }

        function setOnline(online) {
            var dot = document.getElementById('admin-status-dot');
            var td = document.getElementById('admin-status-text-dot');
            var tx = document.getElementById('admin-status-text');
            var ls = document.getElementById('admin-last-seen');
            if (dot) {
                dot.className = 'position-absolute bottom-0 end-0 p-1 border border-light rounded-circle';
                dot.classList.add(online ? 'bg-success' : 'bg-secondary');
            }
            if (td) td.className = 'online-dot ' + (online ? 'active' : 'inactive');
            if (tx) {
                if (online) {
                    tx.textContent = 'Online';
                    if (ls) { ls.classList.add('d-none'); ls.textContent = ''; }
                } else {
                    tx.textContent = 'Offline';
                    var el = document.getElementById('chat-data');
                    var lastAct = el ? el.dataset.adminLastActivity : '';
                    if (lastAct && ls) {
                        var d = new Date(parseInt(lastAct) * 1000);
                        if (!isNaN(d.getTime())) {
                            var diff = Math.floor((Date.now() - d.getTime()) / 1000);
                            var text = '';
                            if (diff < 60) text = 'baru saja';
                            else if (diff < 3600) text = Math.floor(diff / 60) + ' menit lalu';
                            else if (diff < 86400) text = Math.floor(diff / 3600) + ' jam lalu';
                            else text = Math.floor(diff / 86400) + ' hari lalu';
                            ls.textContent = 'Terakhir dilihat ' + text;
                            ls.classList.remove('d-none');
                        }
                    }
                }
            }
        }

        if (typeof Livewire !== 'undefined') {
            if (document.readyState === 'complete') {
                initChat();
            } else {
                window.addEventListener('load', initChat);
            }
        } else {
            var waitLW = setInterval(function() {
                if (typeof Livewire !== 'undefined') {
                    clearInterval(waitLW);
                    window.addEventListener('load', initChat);
                }
            }, 200);
            setTimeout(function() { clearInterval(waitLW); }, 30000);
        }
    })();
    </script>
</div>
