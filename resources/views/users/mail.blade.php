@include('layouts.users.header')



<main class="mail-page">
    <form action="{{url('/save-mail').'/'.$id}}" method="POST" class="row">
        @csrf
        <div class="mail-attrib-box col col-lg-4 col-md-4 col-sm-12">
            <h3>Sender's mail details</h3>
            <input type="text" name="name" placeholder="Name" value="@isset($mail[0]){{$mail[0]->name}}@endisset">
            <input type="email" name="email" placeholder="Email" value="@isset($mail[0]){{$mail[0]->email}}@endisset">
            <input type="password" name="password" placeholder="Password" value="@isset($mail[0]){{'#################'}}@endisset">
            <input type="text" name="subject" placeholder="Mail Subject" value="@isset($mail[0]){{$mail[0]->subject}}@endisset">
            <div>
                <button type="submit" class="btn btn-danger" formaction="{{url('/mail-certificate').'/'.$id}}">Mail</button>
                <button class="btn btn-primary" type="submit" formaction="{{url('/save-mail').'/'.$id}}">Save as Draft</button>
                <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
        </div>
        <div class="textarea-box col col-lg-7 col-md-7 col-sm-12">
            <textarea name="body" placeholder="Email Content">@isset($mail[0]){{$mail[0]->body}}@endisset</textarea>
        </div>
    </form>
</main>



@include('layouts.users.footer')