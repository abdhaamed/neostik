<!-- Profile -->
<div class="mt-auto border-t border-gray-200 pt-2">
    <div class="flex items-center gap-3 justify-between flex-row-reverse">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
            {{ auth()->user()->initials }}
        </div>
        <div>
            <p class="font-medium text-gray-700">{{ auth()->user()->name }}</p>
            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
        </div>
    </div>
    <ul class="mt-3 space-y-1 text-sm text-gray-600">
        <li>
            <a href="{{ route('admin.profile') }}" class="block hover:text-orange-500 cursor-pointer">
                Profile Detail
            </a>
        </li>
        <li>
            <a href="{{ route('admin.profile') }}" class="block hover:text-orange-500 cursor-pointer">
                Setting
            </a>
        </li>
        <li class="hover:text-orange-500 cursor-pointer">Help Center</li>
        <!-- LOGOUT -->
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full text-left text-red-500 hover:underline cursor-pointer">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>