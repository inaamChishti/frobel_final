@extends("layouts.auth")

@section("styles")
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    #foo {
    position: fixed;
    bottom: 12px;
    right: 5px;
  }
  body, html {


}
.card{
    min-height: 150px !important;
    padding: 25px 50px 50px 50px !important;
    width: 294px !important;
    height: 150px !important;
    background-color: #337ab7;
    text-align: center;
    color: #fff !important;
    font-size: 17px !important;
    font-style: italic !important;
    line-height: 21px !important;
    font-weight: 700 !important;
    -webkit-transition-delay: 1500ms !important;
}
.background{
    background-image: url('/img/backg.jpg') ;
    background-repeat: no-repeat;
    background-size: auto 110%; / set width to auto and height to 100% /
    background-attachment: fixed;
    background-position: center center;
    background-position: 200px -30px;
    height: 900px;
    margin-top: 0 !important;
}
        / Media queries for adjusting canvas size based on screen size /
        @media only screen and (min-width: 768px) {
            #studentChart {
                max-width: 500px !important;
                height: 350px !important;
            }
            #myChart {
                max-width: 400px !important;
                height: 200px !important;
            }
        }

        @media only screen and (max-width: 767px) {
            #studentChart {
                max-width: 100% !important;
                height: auto !important;
                min-height: 400px !important;
            }
            #myChart {
                max-width: 100% !important;
                height: auto !important;
                min-height: 200px !important;
            }
        }

</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section("content")
{{-- style="background-image: url({{asset('img/wallpaper/bg.jpeg')}})" --}}
{{-- <div class="container-fluid flex-grow-1 container-p-y" style="background-image: url('../img/11-Plus.jpeg'); background-size: cover;height: 720px"> --}}
  {{-- <div class="container-fluid flex-grow-1 container-p-y" style="background-image: url('../img/istockphoto-539953664-612x612.jpg'); background-size: cover;height: 720px;"> --}}
    <div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-4" id="admin-heading" style=" font-size: 1px !important;
    font-style: italic !important;">
    Admin Dashboard
    </h4>

    {{-- <div style="display: flex;justify-content:space-between; margin: 0 auto;">

        <div style=" flex-basis:32%;flex-shrink:1; flex-grow:1;">
              {{-- chart --}}
            {{-- <canvas id="studentChart"
             style="max-width:500px !important;height:350px;" >
            </canvas>
        </div>

        <div style="  flex-basis:30%;flex-shrink:1; flex-grow:1; "> --}}
            {{-- <h1>Doughnut Chart Example</h1> --}}
            {{-- <canvas id="myChart"
                style="display: block;
                margin: 0 auto;
                height: 200px !important;">
            </canvas>
        </div>


    </div> --}}
    <div style="display: flex;justify-content:space-between; margin: 0 auto;">

        <div style="flex-basis:32%;flex-shrink:1; flex-grow:1;">
            {{-- chart --}}
            <canvas id="studentChart"
                style="max-width:100%;height:auto;min-height:200px;">
            </canvas>
        </div>

        <div style="flex-basis:30%;flex-shrink:1; flex-grow:1;">
            {{-- <h1>Doughnut Chart Example</h1> --}}
            <canvas id="myChart"
                style="max-width:100%;height:auto;min-height:400px;">
            </canvas>
        </div>
    </div>
    <div id="foo" class="toast" data-autohide="false" style="background-color:white;border-radius: 20px 20px 20px 20px">
        <div class="toast-header" style="padding: 10px" >
            <img src="{{ asset('img/logo4-img.png') }}" width="30px" alt="Frobel Logo" style="margin-right:10px">
          <strong class="mr-auto" style="color: #337ab7">
            @if (auth()->user())
              {{-- @foreach (auth()->user()->roles as $role)
                  @if ($role->name == 'Super Admin')
                    Super Admin
                  @elseif ($role->name == 'Admin')
                    Admin
                  @elseif ($role->name == 'Supervisor')
                    Supervisor
                  @else
                    User
                  @endif
              @endforeach --}}
              @if (Auth::user()->usertype == 'Master-User')
                Master Admin
            @endif

            @endif
            Dashboard!</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="toast-body mr-auto card" style=" color:white">
          Welcome to Frobel School Management System.!!
        </div>
      </div>




  </div>
  <script>
    const ctx = document.getElementById('myChart').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['English', 'Science', 'Physics', 'Chemistry', 'Mathematics', 'E.Language', 'E.Literature', 'Psychology', 'Business', 'Geography', 'History', 'Biology', 'Politics', 'Law', 'Computer Science'],
            datasets: [{
              data: [
        <?php echo $engCount; ?>,
        <?php echo $scienceCount; ?>,
        <?php echo $physicsCount; ?>,
        <?php echo $chemistryCount; ?>,
        <?php echo $mathematicsCount; ?>,
        <?php echo $eLanguageCount; ?>,
        <?php echo $eLiteratureCount; ?>,
        <?php echo $psychologyCount; ?>,
        <?php echo $businessCount; ?>,
        <?php echo $geographyCount; ?>,
        <?php echo $historyCount; ?>,
        <?php echo $biologyCount; ?>,
        <?php echo $politicsCount; ?>,
        <?php echo $lawCount; ?>,
        <?php echo $computerScienceCount; ?>
      ],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#4CAF50', '#CDDC39', '#FFEB3B', '#9C27B0', '#607D8B', '#E91E63', '#03A9F4', '#795548', '#8BC34A'],
      hoverBackgroundColor: ['#FF4F6A', '#208BE6', '#FFB133', '#27AEA6', '#764CFF', '#FF8C26', '#449D44', '#AFB42B', '#FFD33A', '#7B1FA2', '#546E7A', '#D81B60', '#0277BD', '#5D4037', '#689F38']
            }]
        },

    });
    const studentChart = document.getElementById('studentChart').getContext('2d');

// Create the chart
const chart = new Chart(studentChart, {
    type: 'bar',
    data: {
        labels: ['Total Students'],
        datasets: [{
            label: 'Total Students',
            data: [{{ $studentz }}],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>
@endsection

@section("scripts")
<script>
    $('.toast').toast('show')
</script>
@endsection

