@include('layouts.users.header')

@error('projectName')
<div class="mt-5 error-notification">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  {{ $message }}
</div>
@enderror

<div class="project-header"></div>
<h4 class="projects-heading">Your Certify projects</h4>
<div class="container row project-container">
    <div class="col-lg-4 col-md-6 new-project project-card"><div>
        <button id='newProject' type="submit" data-bs-toggle="modal" data-bs-target="#projectNameInputModal">Initiate new project</button>
    </div></div>
    <div class="modal" tabindex="-1" id="projectNameInputModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Project!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="project-form" action="{{url('/project')}}" method="POST">
              @csrf
              <div class="modal-body">
                <input type="text" name="projectName" placeholder="Enter project name" >
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
          </form>
        </div>
      </div>
    </div>




    @foreach($project_names as $project)
    <div class="col-lg-4 col-md-6 project-card">
      <div>
        <h5>{{$project->project_name}}</h5>
        <section>
          <a href="{{url('/template').'/'.$project->id}}"><p class="certificateTemlate"><i class="bi bi-image"></i> Certificate Template</p></a>
          <a href="{{url('/show-data').'/'.$project->id}}"><p class="reciversData"><i class="bi bi-clipboard-data"></i> Recivers Data</p></a>
          <a href="{{url('/mail-certificate').'/'.$project->id}}"><p class="emailDesgin"><i class="bi bi-envelope"></i> Email Desgin</p></a>
          <a href="#"><p class="generatedCertificate"><i class="bi bi-collection-fill"></i> Genrated Certificates</p></a>
        </section>
      </div>
    </div>
    @endforeach


</div>

@include('layouts.users.footer')