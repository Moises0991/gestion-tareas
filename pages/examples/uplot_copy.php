<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | uPlot</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/uplot/uPlot.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <div class="content-wrapper" style="background: white;">
      <section class="content">
        <div class="container-fluid">

          <!-- LINE CHART -->
          <div class="card card-info">
            <div class="card-body">
              <div class="chart">
                <div id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
              </div>
            </div>
          </div>

          <!-- AREA CHART -->
          <div class="card card-primary" style="display:none">
            <div class="card-header">
              <h3 class="card-title">Area Chart</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <div id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>
  </div>



  <script src="../../plugins/jquery/jquery.min.js"></script>
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../plugins/uplot/uPlot.iife.min.js"></script>
  <script src="../../dist/js/adminlte.min.js"></script>
  <script src="../../dist/js/demo.js"></script>
  <script>
    $(function () {
      /* uPlot
      * -------
      * Here we will create a few charts using uPlot
      */

      function getSize(elementId) {
        return {
          width: document.getElementById(elementId).offsetWidth,
          height: document.getElementById(elementId).offsetHeight,
        }
      }

      let data = [
        [0, 1, 2, 3, 4, 5, 6],
        [28, 48, 40, 19, 86, 27, 90],
        // [65, 59, 80, 81, 56, 55, 40],
        []
      ];

      //--------------
      //- AREA CHART -
      //--------------

      const optsAreaChart = {
        ... getSize('areaChart'),
        scales: {
          x: {
            time: false,
          },
          y: {
            range: [0, 100],
          },
        },
        series: [
          {},
          {
            fill: 'rgba(60,141,188,0.7)',
            stroke: 'rgba(60,141,188,1)',
          },
          {
            stroke: '#c1c7d1',
            fill: 'rgba(210, 214, 222, .7)',
          },
        ],
      };

      let areaChart = new uPlot(optsAreaChart, data, document.getElementById('areaChart'));

      const optsLineChart = {
        ... getSize('lineChart'),
        scales: {
          x: {
            time: false,
          },
          y: {
            range: [0, 100],
          },
        },
        series: [
          {},
          {
            fill: 'transparent',
            width: 5,
            stroke: 'rgba(60,141,188,1)',
          },
          {
            stroke: '#c1c7d1',
            width: 5,
            fill: 'transparent',
          },
        ],
      };

      let lineChart = new uPlot(optsLineChart, data, document.getElementById('lineChart'));

      window.addEventListener("resize", e => {
        areaChart.setSize(getSize('areaChart'));
        lineChart.setSize(getSize('lineChart'));
      });
    })
  </script>
</body>
</html>