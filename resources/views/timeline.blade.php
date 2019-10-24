<html>
<head>
    <title>Timeline v0.91</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['timeline']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({ type: 'string', id: 'Term' });
            dataTable.addColumn({ type: 'string', id: 'Name' });
            dataTable.addColumn({ type: 'date', id: 'Start' });
            dataTable.addColumn({ type: 'date', id: 'End' });

            dataTable.addRows([
                @foreach($events as $index=>$event)
                    @if(isset($event['start'][2]))
                        [ '{{$index}}', '{{$event['name'] . ': ' . $event['start'][0] . ' - ' .  $event['end'][0]  }}', new Date( {{ $event['start'][0]}}, {{$event['start'][1]}}, {{$event['start'][2]}}), new Date( {{$event['end'][0]}} , {{$event['end'][1]}},{{$event['end'][2]}}) ],
                    @endif
                @endforeach
            ]);

            var options = {
                timeline: { showRowLabels: false }
            };

            chart.draw(dataTable, options);
        }
    </script>
</head>
<body>
<div id="timeline" style="height: 1800px;"></div>
</body>
</html>
