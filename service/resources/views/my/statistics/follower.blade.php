@extends('layouts.app')
@section('title', "数据统计")
@section('content')
    <h3>数据统计</h3>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{route('my.statistics.index')}}" class="list-group-item">总体概览</a>
                <a href="{{route('my.statistics.video')}}" class="list-group-item">播放数详情</a>
                <a href="javascript:void(0)" class="list-group-item active">粉丝数详情</a>
            </div>

        </div>
        <div class="col-md-9">
            <div class="col-md-4">
                <div class="jumbotron">
                    <h4>视频今日播放数</h4>
                    <p>1092</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jumbotron">
                    <h4>今日新增粉丝数</h4>
                    <p>2903</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="jumbotron">
                    <h4>视频累计播放数</h4>
                    <p>10323r45</p>
                </div>
            </div>
            <table class="table table-bordered¬">
                <tr>
                    <th>日期</th>
                    <th>视频播放数</th>
                    <th>粉丝数</th>
                    <th>发视频数</th>
                </tr>
                <tr>
                    <td>12.09</td>
                    <td>12310</td>
                    <td>1211</td>
                    <td>12</td>

                </tr>
                <tr>
                    <td>12.09</td>
                    <td>12210</td>
                    <td>12711</td>
                    <td>1212</td>

                </tr>
                <tr>
                    <td>12.09</td>
                    <td>110</td>
                    <td>1111</td>
                    <td>112</td>

                </tr>
                <tr>
                    <td>12.09</td>
                    <td>120</td>
                    <td>121</td>
                    <td>1222</td>

                </tr>
                <tr>
                    <td>12.14</td>
                    <td>1210</td>
                    <td>1211</td>
                    <td>1212</td>
                </tr>
            </table>
        </div>
    </div>
@endsection