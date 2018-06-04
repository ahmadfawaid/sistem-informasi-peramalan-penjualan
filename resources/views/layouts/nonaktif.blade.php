akun anda telah dinonaktifkan! <a href="{{ route('logout') }}"
onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">keluar
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
@csrf
</form>