@extends('layouts.layouts')

@section('title', '渠道添加')

@section('content')
    <h2>一周气温展示</h2>
    <form class="form-inline">
        <div class="form-group">
            <label for="exampleInputName2">搜索城市</label>
            <input type="text" class="form-control" id="exampleInputName2" placeholder="请输入..." name="city">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
    </form>






    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    <script>
        var chart = Highcharts.chart('container', {
            chart: {
                type: 'columnrange', // columnrange 依赖 highcharts-more.js
                inverted: true
            },
            title: {
                text: '每月温度变化范围'
            },
            subtitle: {
                text: '2009 挪威某地'
            },
            xAxis: {
                categories: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
            },
            yAxis: {
                title: {
                    text: '温度 ( °C )'
                }
            },
            tooltip: {
                valueSuffix: '°C'
            },
            plotOptions: {
                columnrange: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            return this.y + '°C';
                        }
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: '温度',
                data: [
                    [-9.7, 9.4],
                    [-8.7, 6.5],
                    [-3.5, 9.4],
                    [-1.4, 19.9],
                    [0.0, 22.6],
                    [2.9, 29.5],
                    [9.2, 30.7],
                    [7.3, 26.5],
                    [4.4, 18.0],
                    [-3.1, 11.4],
                    [-5.2, 10.4],
                    [-13.5, 9.8]
                ]
            }]
        });
    </script>




@endsection