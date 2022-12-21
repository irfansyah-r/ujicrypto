<div class="w-full">
    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-4">
        <div class="grid flex-col w-full bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="w-full mb-4 grid justify-items-center items-center m-auto h-16">
                <span class="text-7xl">{{ $assets->count() }}</span>
            </div>
            <span>Assets Monitored</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="w-full mb-4 grid justify-items-center items-center m-auto h-16">
                <span class="text-7xl">{{ $users->filter(function ($user) { return ($user->role === 'Member' && $user->updated_at > $user->created_at); })->count() }}</span>
            </div>
            <span>Active Members</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="w-full mb-4 grid justify-items-center items-center m-auto h-16">
                <span class="text-7xl">{{ $users->count() }}</span>
            </div>
            <span>Total Members</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="w-full mb-4 grid justify-items-center items-center m-auto h-16">
                <span class="text-7xl">{{ $users->filter(function ($user) { return (isset($user->telegram_chat_id) && $user->telegram_chat_id !== '' && strpos($user->email, 'group') === FALSE); })->count() }}</span>
            </div>
            <span>Members Telegram Connected</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="w-full mb-4 grid justify-items-center items-center m-auto h-16">
                <p class="text-3xl xl:text-4xl">{{ $favorite }}</p>
            </div>
            <span>Favorite Asset</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="w-full mb-4 grid justify-items-center items-center m-auto h-16">
                <span class="text-7xl">{{ $memberships->count() }}</span>
            </div>
            <span>Membership Levels</span>
        </div>
    </div>
    <div class="hidden grid grid-rows-4 grid-flow-col gap-4">
        <div class="row-span-4 grid flex-col w-full bg-white p-6 rounded-lg shadow-lg h-96">
            <span>Panduan</span>
        </div>
        <div class="row-span-2 grid flex-col w-full bg-white p-6 rounded-lg shadow-lg">
            <span>Panduan Admin</span>
        </div>
        <div class="row-span-2 grid flex-col w-full bg-white p-6 rounded-lg shadow-lg">
            <span>Panduan Member</span>
        </div>
    </div>
</div>
