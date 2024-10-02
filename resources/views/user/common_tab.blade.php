<ul class="nav nav-pills flex-column flex-md-row mb-3">
                  <!-- <li class="nav-item">
                      <a class="nav-link " href="{{route('assign-data')}}">
                      <i class="fa fa-info" aria-hidden="true"></i>
                       Assign</a>
                    </li> -->
          @if (ViewPermission(1))
          <li class="nav-item">
          <a class="nav-link" href="{{ route('user-university') }}">
            <i class="fa fa-info" aria-hidden="true"></i> About
          </a>
           </li>
          @endif

                 @if (ViewPermission(2))
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('bord-of-director')}}"
                        ><i class="fa fa-sitemap" aria-hidden="true"></i> Board Of Director</a
                      >
                    </li>
                    @endif

                    @if (ViewPermission(3))
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('gallery')}}"
                        ><i class="fa fa-picture-o" aria-hidden="true"></i> Photo Gallery</a
                      >
                    </li>
                    @endif

                    @if (ViewPermission(4))
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('user-programs')}}"
                        ><i class="fa fa-tasks" aria-hidden="true"></i> Programs</a
                      >
                    </li>
                      @endif

                      @if (ViewPermission(5))
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('facility')}}"
                        ><i class="fa fa-tasks" aria-hidden="true"></i> Facility</a
                      >
                    </li>

                    @endif

                    @if (ViewPermission(6))
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('course')}}"
                        ><i class="fa fa-tasks" aria-hidden="true"></i> Course</a
                      >
                    </li>
                    @endif

                    @if (ViewPermission(7))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('upcoming')}}"
                        ><i class="fa fa-tasks" aria-hidden="true"></i> Events</a
                      >
                    </li>
                    @endif

                    @if (ViewPermission(8))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('addmission')}}"
                        ><i class="fa fa-tasks" aria-hidden="true"></i> Admission</a
                      >
                    </li>
                    @endif

                    @if (ViewPermission(9))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('tbl')}}"
                        ><i class="fa fa-tasks" aria-hidden="true"></i> Training & Placement</a
                      >
                    </li>
                    @endif

                    @if (ViewPermission(10))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('acceditations')}}"
                        >
                        <i class="fa fa-tasks" aria-hidden="true"></i>
                        Accreditations</a
                      >
                    </li>
                    @endif

                  </ul>

                  <script>
   $(document).ready(function() {
    var currentUrl = window.location.href;
    // alert(currentUrl);

    $('ul li a').filter(function() {
        return this.href === currentUrl;
    }).addClass('active');
});


</script>