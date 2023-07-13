<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>txt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2>Pie Chart</h2>
                <canvas id="pie" class="col-me-12"></canvas>
            </div>
            <div class="col-md-4">
                <h2>Barchart</h2>
                <canvas id="bar" class="col-me-12"></canvas>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
</body>


</html>


<script type="text/javascript">
    $(document).ready(function(e) {
        load_chart();

        function load_chart() {
            $.ajax({
                url: "{{ route('report-marketing-track-all') }}",
                type: "GET",
                data: {},
                success: function(data) {
                    /* var value = JSON.parse(data);
                    var xValues = value.xvalues;
                    var yValues = value.yvalues; */
                    var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
                    var yValues = [55, 49, 44, 24, 15];

                    var barColors = ["red", "green", "blue", "orange", "brown", "red", "green",
                        "blue",
                        "orange", "brown"
                    ];

                    new Chart("bar", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "World Wine Production 2018"
                            }
                        }
                    });
                }
            })
        }
    })
</script>
