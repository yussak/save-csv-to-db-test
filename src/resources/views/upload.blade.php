<h2>upload page</h2>
<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">upload</button>
</form>

@if(session("message"))
<p>{{session("message")}}</p>
@endif