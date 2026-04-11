@if(session('success'))
   <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
      <div class="hide_alert bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-bounce">
         <span>✅</span>
         <span>{{ session('success') }}</span>
         <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white font-bold">✖</button>
      </div>
   </div>
@endif

@if(session('error'))
   <div class="hide_alert fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
      <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-bounce">
         <span>❌</span>
         <span>{{ session('error') }}</span>
         <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white font-bold">✖</button>
      </div>
   </div>
@endif

@if($errors->any())
    <div class="hide_alert fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
        <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="mt-2">❌ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


<script>
    document.addEventListener("DOMContentLoaded", () => {
        setTimeout(() => {
            let alert = document.getElementsByClassName("hide_alert");
            for (let i = 0; i < alert.length; i++) {
                alert[i].style.display = "none";
            }
        }, 2000);
    });
</script>