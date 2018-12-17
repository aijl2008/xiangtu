@extends('layouts.app')
@section('title', "数据统计")
@section('content')
    <h3>数据统计</h3>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="javascript:void(0);" class="list-group-item active">总体概览</a>
                <a href="{{route('my.statistics.video')}}" class="list-group-item">播放数详情</a>
                <a href="{{route('my.statistics.follower')}}" class="list-group-item">粉丝数详情</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="col-md-4">
                <div class="jumbotron" style="background: rgb(8, 183, 6);">
                    <h4>视频今日播放数</h4>
                    <p>1092</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jumbotron" style="background: rgb(255, 168, 47);">
                    <h4>今日新增粉丝数</h4>
                    <p>2903</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jumbotron" style="background: rgb(74, 144, 226);">
                    <h4>视频累计播放数</h4>
                    <p>10323r45</p>
                </div>
            </div>
            <div class="clearfix"></div>
            <h3>近7天视频播放数</h3>
            <hr/>
            <div id="chart1" style="width: 640px; height: 480px"></div>
            <h3>近7天净增粉丝数</h3>
            <hr/>
            <div id="chart2" style="width: 640px; height: 480px"></div>
            <h3>近7天上传视频数</h3>
            <hr/>
            <div id="chart3" style="width: 640px; height: 480px"></div>
        </div>
    </div>
@endsection
@section("js")
    <script src="/js/echarts.min.js"></script>
    <script type="text/javascript">
        $(function () {
            // var width = $('#chart1').parent().width();
            // var height = width * 2 / 4;
            // $('#chart').css("width", width).css("height", height);
            var char1 = echarts.init(document.getElementById('chart1'));

            var option1 = {
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: [820, 932, 901, 934, 1290, 1330, 1320],
                    type: 'line',
                    areaStyle: {}
                }]
            };
            char1.setOption(option1);

            var char2 = echarts.init(document.getElementById('chart2'));

            var option2 = {
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: [820, 932, 901, 934, 1290, 1330, 1320],
                    type: 'line',
                    areaStyle: {}
                }]
            };
            char2.setOption(option1);

            var char3 = echarts.init(document.getElementById('chart3'));

            var option3 = {
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: [820, 932, 901, 934, 1290, 1330, 1320],
                    type: 'line',
                    areaStyle: {}
                }]
            };
            char3.setOption(option1);
        });
    </script>
@endsection