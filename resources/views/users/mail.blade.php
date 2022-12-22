@include('layouts.users.header')



<main class="mail-page">
    <form action="{{url('/save-mail').'/'.$id}}" method="POST" class="row">
        @csrf
        <div class="mail-attrib-box col col-lg-4 col-md-4 col-sm-12">
            <h3>Set sender's mail</h3>
            <span class="text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </span>
            <input type="text" name="name" placeholder="Name" value="@isset($mail[0]){{$mail[0]->name}}@endisset" required>
            <span class="text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </span>
            <input type="email" name="email" placeholder="Gmail" value="@isset($mail[0]){{$mail[0]->email}}@endisset" required>
            <span class="text-danger">
                @error('password')
                    {{ $message }}
                @enderror
            </span>
            <a href="https://support.google.com/mail/answer/185833?hl=en">
                How to generate gmail app password? Click here!
            </a>
            <input type="password" name="password" placeholder="Gmail App Password" value="@isset($mail[0]){{'################'}}@endisset" required>
            <span class="text-danger">
                @error('subject')
                    {{ $message }}
                @enderror
            </span>
            <input type="text" name="subject" placeholder="Mail Subject" value="@isset($mail[0]){{$mail[0]->subject}}@endisset" required>
            <div>
                <button type="submit" class="btn btn-danger" formaction="{{url('/mail-certificate').'/'.$id}}">Mail</button>
                <button class="btn btn-primary" type="submit">Save as Draft</button>
                <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
        </div>
        <div class="textarea-box col col-lg-7 col-md-7 col-sm-12">
            <div>
                <label for="textmail">Mail Type</label>&emsp;&emsp;
                <label for="textmail" style="color: grey">Text Mail</label>
                <input type="radio" name="mailType" id="textmail" checked>&emsp;
                <label for="htmlmail" style="color: grey">HTML Mail</label>
                <input type="radio" name="mailType" id="htmlmail" disabled>
            </div>
            <span class="text-danger">
                @error('body')
                    {{ $message }}
                @enderror
            </span>
            <textarea name="body" placeholder="Mail Body Content" required>@isset($mail[0]){{$mail[0]->body}}@endisset</textarea>
        </div>
    </form>
</main>



@include('layouts.users.footer')